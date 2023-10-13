/* jshint esversion: 6 */ // JSHint configuration for ES6

// Immediately Invoked Function Expression (IIFE) for the JavaScript code
(function () {
    'use strict'; // Enable strict mode

    // Declare variables for DOM elements
    let reasonWrapperClass = '.wrapper-reason',
        savedRatingAlertClass = '.saved-rating-alert',
        extensionName = 'tx_partnerrating',
        pluginName = '_pi1',
        partnerSearchName = 'partnerSearch',
        ratingName = 'rating',
        partnerName = 'partner',
        rateValueName = 'rateValue',
        reasonName = 'reason',
        reasonTextName = 'reasonText',
        form = null,
        searchInput = null,
        partnerSelect = null,
        textareaField = null,
        reasonWrapper = null,
        reasonOptions = null,
        radioRating = null,
        savedRatingAlert = null,
        ratingValue = 0,
        emptyOptionSelected = false,
        ratingReasonMinValue = 0,
        keepMinOneSearchResult = false,
        partnerLabelFields = '',
        partnerLabelFieldSplitString = '',
        allowMultipleReasons = false;

    // Function to perform an AJAX request and populate the select field
    function updatePartnerSelect() {
        const searchText = searchInput.value;

        // Create a FormData object to send data via POST
        const formData = new FormData();
        formData.append('searchText', searchText);
        formData.append('partnerLabelFields', partnerLabelFields);

        // Perform an AJAX request with the POST method
        fetch('/', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (partnerSelect && (data.length > 0 || !keepMinOneSearchResult)) {
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
                        if (option.uid === previouslySelectedValue) {
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
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Function to add an option to the select field
    function addOption(option) {
        const optionElement = document.createElement('option');
        optionElement.value = option.uid;
        optionElement.textContent = '';
        partnerLabelFields.split(',').forEach((value, key, array) => {
            optionElement.textContent += option[value];
            if (!Object.is(array.length - 1, key)) {
                optionElement.textContent += ' ' + partnerLabelFieldSplitString + ' ';
            }
        });
        optionElement.selected = option.selected;
        partnerSelect.appendChild(optionElement);
    }

    // Function to update textarea status based on the selected option
    function updateTextareaStatus() {
        textareaField.disabled = true;
        textareaField.required = false;
        reasonOptions.forEach(option => {
            if (option.value === '-1' && option.checked) {
                textareaField.disabled = false;
                textareaField.required = true;
            }
        });
    }

    // Function to handle rating select change
    function handleRatingSelectChange() {
        // Validate the selected rating
        radioRating.forEach(radio => {
            if (radio.checked) {
                ratingValue = parseInt(radio.value, 10);
            }
        });

        // Validate the selected reason
        reasonOptions.forEach(option => {
            if (!allowMultipleReasons) {
                option.required = true;
            }
            if (option.checked && parseInt(option.value, 10) === 0) {
                const customValidationMessage = reasonWrapper.getAttribute('data-validation');
                option.setCustomValidity(customValidationMessage);
            } else {
                option.setCustomValidity('');
            }
        });

        if (!allowMultipleReasons) {
            // Make the options required if the rating is greater than the configured limit value
            if (ratingReasonMinValue !== 0 && ratingValue > ratingReasonMinValue) {
                reasonOptions.forEach(option => {
                    option.required = true;
                });
            } else {
                reasonOptions.forEach(option => {
                    option.required = false;
                    option.setCustomValidity('');
                });
            }
        }
    }

    // Function to handle form submission
    function handleFormSubmit(event) {
        // Check if the form is valid
        if (!event.target.checkValidity()) {
            event.preventDefault(); // Prevent form submission if not valid
        }

        checkSelectedPartner(event);
        checkReasonOptions(event);
    }

    function checkSelectedPartner(event) {
        partnerSelect.setCustomValidity(''); // Clear custom validity message

        // Check if the partner select value is empty or 0
        const selectedPartnerValue = parseInt(partnerSelect.value, 10);
        if (isNaN(selectedPartnerValue) || selectedPartnerValue === 0) {
            const customValidationMessage = partnerSelect.getAttribute('data-validation');
            partnerSelect.setCustomValidity(customValidationMessage); // Set custom validity message
            event.preventDefault(); // Prevent form submission
            form.reportValidity(); // Trigger validation message
        }
    }

    function checkReasonOptions(event) {
        // Check if at least one checkbox is selected
        let checkboxChecked = false;
        reasonOptions.forEach((checkbox) => {
            if (checkbox.checked) {
                checkboxChecked = true;
            }
        });

        // Clear any previous custom validation messages
        reasonOptions.forEach((checkbox) => {
            checkbox.setCustomValidity("");
        });

        if (ratingReasonMinValue !== 0 && ratingValue > ratingReasonMinValue && !checkboxChecked && textareaField.value === '') {
            // Set a custom validation message on the first checkbox
            const customValidationMessage = reasonWrapper.getAttribute('data-validation');
            reasonOptions[0].setCustomValidity(customValidationMessage);
            event.preventDefault(); // Prevent form submission
            form.reportValidity(); // Trigger validation message
        }
    }

    // Function to handle partner select change
    function handlePartnerSelectChange() {
        // Check if the partner select value is 0 and reason select is not 0
        const selectedPartnerValue = parseInt(partnerSelect.value, 10);
        const selectedReasons = document.querySelector('[name="' + extensionName + pluginName + '[' + ratingName + '][' + reasonName + ']"]:checked');
        let selectedReasonValue = 0;
        if (selectedReasons !== null) {
            selectedReasonValue = parseInt(selectedReasons.value, 10);
        }

        if (selectedPartnerValue === 0) {
            const customValidationMessage = partnerSelect.getAttribute('data-validation');
            partnerSelect.setCustomValidity(customValidationMessage); // Set custom validity message
        } else {
            partnerSelect.setCustomValidity(''); // Clear custom validity message
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

    // Listen for the DOM content to be fully loaded
    document.addEventListener('DOMContentLoaded', function () {
        // Select the container with class '.tx_partnerrating'
        const container = document.querySelector('.' + extensionName);

        // Check if the container exists in the DOM
        if (!container) {
            console.error('DOM elements not found.');
            return; // Early return if the container is not found
        }

        // Query the form element within the container
        form = container.querySelector('form');

        // Initialize variables from data attributes if they exist
        if (form.hasAttribute('data-ratingreasonminvalue')) {
            ratingReasonMinValue = parseInt(form.getAttribute('data-ratingreasonminvalue'), 10);
        }
        if (form.hasAttribute('data-keepminonesearchresult')) {
            keepMinOneSearchResult = form.getAttribute('data-keepminonesearchresult') === '1';
        }
        if (form.hasAttribute('data-partnerlabelfields')) {
            partnerLabelFields = form.getAttribute('data-partnerlabelfields');
        }
        if (form.hasAttribute('data-partnerlabelfieldsplitstring')) {
            partnerLabelFieldSplitString = form.getAttribute('data-partnerlabelfieldsplitstring');
        }
        if (form.hasAttribute('data-allowmultiplereasons')) {
            allowMultipleReasons = form.getAttribute('data-allowmultiplereasons') === '1';
        }

        // Query other relevant elements within the container
        reasonWrapper = container.querySelector(reasonWrapperClass);
        searchInput = container.querySelector('[name="' + extensionName + pluginName + '[' + partnerSearchName + ']"]');
        partnerSelect = container.querySelector('[name="' + extensionName + pluginName + '[' + ratingName + '][' + partnerName + ']"]');
        radioRating = container.querySelectorAll('[name="' + extensionName + pluginName + '[' + ratingName + '][' + rateValueName + ']"]');
        textareaField = container.querySelector('[name="' + extensionName + pluginName + '[' + ratingName + '][' + reasonTextName + ']"]');
        savedRatingAlert = container.querySelector(savedRatingAlertClass);

        // Attach event listeners based on the condition if multiple reasons are allowed or not
        if (allowMultipleReasons) {
            reasonOptions = reasonWrapper.querySelectorAll('[name="' + extensionName + pluginName + '[' + ratingName + '][' + reasonName + '][]"]');
        } else {
            reasonOptions = reasonWrapper.querySelectorAll('[name="' + extensionName + pluginName + '[' + ratingName + '][' + reasonName + ']"]');
        }

        // Attach input event listener for the search input box
        if (searchInput && partnerSelect) {
            searchInput.addEventListener('input', updatePartnerSelect);
            // Pre-populate the partner select field based on initial search input
            updatePartnerSelect();
            // Set focus on the search input field
            searchInput.focus();
        }

        // Attach input event listener for the textarea field
        if (textareaField) {
            textareaField.addEventListener('input', checkReasonOptions);
        }

        // Attach event listeners for reason radio buttons and textarea field
        if (reasonOptions && textareaField && !allowMultipleReasons) {
            reasonOptions.forEach(option => {
                option.addEventListener('change', updateTextareaStatus);
            });
            // Initialize textarea status based on reason options
            updateTextareaStatus();
        }

        // Attach change event listeners for rating radio buttons and reason options
        if (radioRating && reasonOptions) {
            reasonOptions.forEach(radio => {
                radio.addEventListener('change', handleRatingSelectChange);
            });
            radioRating.forEach(radio => {
                radio.addEventListener('change', handleRatingSelectChange);
            });
            // Initialize the required attribute for radio buttons based on rating select
            handleRatingSelectChange();
        }

        // Attach change event listener to partner select
        if (radioRating && reasonOptions && partnerSelect) {
            reasonOptions.forEach(radio => {
                radio.addEventListener('change', handlePartnerSelectChange);
            });
        }

        // Attach change event listener to partner select for validation
        if (partnerSelect) {
            partnerSelect.addEventListener('change', handlePartnerSelectChange);
            // Validate partner select initially
            handlePartnerSelectChange();
        }

        // Attach submit event listener to the form for additional validation
        if (form) {
            form.addEventListener('submit', handleFormSubmit);
        }

        // Hide the saved rating alert after a timeout
        if (searchInput && savedRatingAlert) {
            hideAlertTimeout();
        }
    });
})();
