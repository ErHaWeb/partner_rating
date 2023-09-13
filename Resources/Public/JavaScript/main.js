/* jshint esversion: 6 */ // JSHint configuration for ES6

// Immediately Invoked Function Expression (IIFE) for the JavaScript code
(function () {
    'use strict'; // Strict mode directive added

    let searchInput, partnerSelect, textareaField, radioButtons; // Variable declarations added
    let emptyOptionSelected = false; // Variable to track the empty option selection

    // Function to perform AJAX request and populate the select field
    function updatePartnerSelect() {
        const searchText = searchInput.value;

        // Create a FormData object to send data via POST
        const formData = new FormData();
        formData.append('searchText', searchText);

        // Perform AJAX request with POST method
        fetch('/', { // Updated server endpoint string
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (partnerSelect && data.length > 0) {
                    // Get the currently selected value as an integer
                    const previouslySelectedValue = parseInt(partnerSelect.value, 10);

                    // Clear existing options except the first empty option
                    while (partnerSelect.options.length > 1) {
                        partnerSelect.remove(1);
                    }

                    // Flag to check if a match was found
                    let matchFound = false;

                    // Add new options based on the AJAX response
                    data.forEach(option => {
                        // Check if the option's value matches the previously selected value
                        if (option.value === previouslySelectedValue) {
                            // Select this option and mark the match as found
                            option.selected = true;
                            matchFound = true;
                        }
                        addOption(option);
                    });

                    // If no match was found, deselect the empty option
                    if (!matchFound) {
                        partnerSelect.options[0].selected = true;
                        emptyOptionSelected = true;
                    }
                }

                // Update textarea status based on selected radio
                updateTextareaStatus();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Function to add an option to the select field
    function addOption(option) {
        const optionElement = document.createElement('option');
        optionElement.value = option.value;
        optionElement.textContent = option.label;
        optionElement.selected = option.selected;
        partnerSelect.appendChild(optionElement);
    }

    // Function to update textarea status based on selected radio
    function updateTextareaStatus() {
        textareaField.disabled = !radioButtons[1].checked;
    }

    // DOMContentLoaded event listener
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.querySelector('.tx_partnerrating');

        if (!container) {
            console.error('DOM elements not found.');
            return; // Early return if container is not found
        }

        radioButtons = container.querySelectorAll('input[name="tx_partnerrating_pi1[reason]"]');
        textareaField = container.querySelector('textarea[name="tx_partnerrating_pi1[reasonText]"]');
        searchInput = container.querySelector('input[name="tx_partnerrating_pi1[partnerSearch]"]');
        partnerSelect = container.querySelector('select[name="tx_partnerrating_pi1[partner]"]');

        // Add input event listener to the search input
        if (searchInput && partnerSelect) {
            searchInput.addEventListener('input', updatePartnerSelect);
        }

        // Add change event listeners to radio buttons only if both radioButtons and textareaField exist
        if (radioButtons && textareaField) {
            radioButtons.forEach(radio => {
                radio.addEventListener('change', updateTextareaStatus);
            });
        }

        // Initially perform AJAX request and populate the select field if the search input is not empty
        if (searchInput.value !== '') {
            updatePartnerSelect();
        }

        // Initially, check the radio buttons and enable/disable textarea accordingly
        updateTextareaStatus();
    });
})();
