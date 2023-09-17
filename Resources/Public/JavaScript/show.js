/* jshint esversion: 6 */ // JSHint configuration for ES6

// Immediately Invoked Function Expression (IIFE) for the JavaScript code
(function () {
    'use strict'; // Enable strict mode

    // Declare variables for DOM elements
    let searchInput, partnerSelect, textareaField, radioReasons, radioRating, savedRatingAlert;

    // Flag to track whether an empty option is selected
    let emptyOptionSelected = false;

    // Function to perform an AJAX request and populate the select field
    function updatePartnerSelect() {
        const searchText = searchInput.value;

        // Create a FormData object to send data via POST
        const formData = new FormData();
        formData.append('searchText', searchText);

        // Perform an AJAX request with the POST method
        fetch('/', {
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

                // Update textarea status based on the selected radio
                updateTextareaStatus();
                handlePartnerSelectChange();
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

    // Function to update textarea status based on the selected radio
    function updateTextareaStatus() {
        textareaField.disabled = !radioReasons[1].checked;
        textareaField.required = radioReasons[1].checked;
    }

    // Function to handle rating select change
    function handleRatingSelectChange() {
        // Get the selected rating value as an integer
        let ratingValue;

        // Validate the selected rating
        radioRating.forEach(radio => {
            if (radio.checked) {
                ratingValue = parseInt(radio.value, 10);
            }
        });

        // Validate the selected reason
        radioReasons.forEach(radio => {
            radio.required = true;
            if (radio.checked && parseInt(radio.value, 10) === 0) {
                const customValidationMessage = radio.getAttribute('data-validation');
                radio.setCustomValidity(customValidationMessage);
            } else {
                radio.setCustomValidity('');
            }
        });

        // Make the radio buttons required if the rating is greater than 3
        if (ratingValue > 3) {
            radioReasons.forEach(radio => {
                radio.required = true;
            });
        } else {
            radioReasons.forEach(radio => {
                radio.required = false;
                radio.setCustomValidity('');
            });
        }
    }

    // Function to handle form submission
    function handleFormSubmit(event) {
        // Check if the form is valid
        if (!event.target.checkValidity()) {
            event.preventDefault(); // Prevent form submission if not valid
        }

        // Check if the partner select value is empty or 0
        const selectedPartnerValue = parseInt(partnerSelect.value, 10);
        if (isNaN(selectedPartnerValue) || selectedPartnerValue === 0) {
            const customValidationMessage = partnerSelect.getAttribute('data-validation');
            partnerSelect.setCustomValidity(customValidationMessage); // Set custom validity message
            event.preventDefault(); // Prevent form submission
        } else {
            partnerSelect.setCustomValidity(''); // Clear custom validity message
        }
    }

    // Function to handle partner select change
    function handlePartnerSelectChange() {
        // Check if the partner select value is 0 and reason select is not 0
        const selectedPartnerValue = parseInt(partnerSelect.value, 10);
        const selectedReasonValue = parseInt(document.querySelector('input[name="tx_partnerrating_pi1[reason]"]:checked').value, 10);
        if (selectedPartnerValue === 0 && selectedReasonValue !== 0) {
            const customValidationMessage = partnerSelect.getAttribute('data-validation');
            partnerSelect.setCustomValidity(customValidationMessage); // Set custom validity message
        } else {
            partnerSelect.setCustomValidity(''); // Clear custom validity message
        }
    }

    // Function to update the URL without reloading the page
    function updateURLWithoutReloading() {
        // Get the current URL
        let currentURL = window.location.href;

        // The path segment to remove
        const segmentToRemove = "/saved/";

        // Check if the path segment exists in the URL
        const index = currentURL.indexOf(segmentToRemove);
        if (index !== -1) {
            // Remove the path segment and all subsequent parts
            const newURL = currentURL.substring(0, index);

            // Update the URL without reloading the page
            history.replaceState(null, "", newURL);
        }
    }

    // Function to hide the alert after a timeout
    function hideAlertTimeout() {
        setTimeout(function () {
            savedRatingAlert.classList.remove("show");
            savedRatingAlert.classList.add("d-none");

            searchInput.focus();
        }, 3000);
    }

    // DOMContentLoaded event listener
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.querySelector('.tx_partnerrating');

        if (!container) {
            console.error('DOM elements not found.');
            return; // Early return if the container is not found
        }

        // Get DOM elements
        radioReasons = container.querySelectorAll('input[name="tx_partnerrating_pi1[reason]"]');
        textareaField = container.querySelector('textarea[name="tx_partnerrating_pi1[reasonText]"]');
        searchInput = container.querySelector('input[name="tx_partnerrating_pi1[partnerSearch]"]');
        partnerSelect = container.querySelector('select[name="tx_partnerrating_pi1[partner]"]');
        radioRating = container.querySelectorAll('input[name="tx_partnerrating_pi1[rating]"]');
        savedRatingAlert = container.querySelector('.saved-rating-alert');
        const form = container.querySelector('form');

        // Add input event listener to the search input
        if (searchInput && partnerSelect) {
            searchInput.addEventListener('input', updatePartnerSelect);

            // Initially perform an AJAX request and populate the select field if the search input is not empty
            if (searchInput.value !== '') {
                updatePartnerSelect();
            }

            // Set focus on the partner search input field
            searchInput.focus();
        }

        // Add change event listener to radio buttons for reasons and text area
        if (radioReasons && textareaField) {
            radioReasons.forEach(radio => {
                radio.addEventListener('change', updateTextareaStatus);
            });

            // Initially, check the radio buttons and enable/disable the textarea accordingly
            updateTextareaStatus();
        }

        // Add change event listener to radio buttons for rating and reasons
        if (radioRating && radioReasons) {
            radioReasons.forEach(radio => {
                radio.addEventListener('change', handleRatingSelectChange);
            });
            radioRating.forEach(radio => {
                radio.addEventListener('change', handleRatingSelectChange);
            });

            // Initially, check the rating select to set the required attribute for radio buttons
            handleRatingSelectChange();
        }

        // Add change event listener to partner select
        if (radioRating && radioReasons && partnerSelect) {
            radioReasons.forEach(radio => {
                radio.addEventListener('change', handlePartnerSelectChange);
            });
        }

        // Add change event listener to partner select
        if (partnerSelect) {
            partnerSelect.addEventListener('change', handlePartnerSelectChange);

            // Initially, check the partner select for immediate validation
            handlePartnerSelectChange();
        }

        // Add form submit event listener to perform additional validation
        if (form) {
            form.addEventListener('submit', handleFormSubmit);
        }

        // Hide the alert after a timeout
        if (searchInput && savedRatingAlert) {
            hideAlertTimeout();
        }

        // Initially remove the path segment "saved" from the URL
        updateURLWithoutReloading();
    });
})();
