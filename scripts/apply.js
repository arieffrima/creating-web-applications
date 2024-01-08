/*
filename: Arief Frima Saipul
created: 07/09/2023
last modified: 27/08/2023
description: Assignment2
Tutor: Md Arafat Hossain
*/
"use strict";

// Define a global Boolean variable for debugging mode
let debug = false; // Change to true to enable validation

function displayErrorMessage(message) {
    const errorDiv = document.getElementById('error-messages');
    errorDiv.innerHTML = message;
}


function validateForm(event) {
    const dateOfBirth = document.getElementById('DOB');
    const stateSelect = document.getElementById('state');
    const postcodeInput = document.getElementById('postcode');
    const skillsCheckbox = document.querySelectorAll('input[name="category[]"][type="checkbox"]');
    const otherSkillsTextarea = document.getElementById('comments');
    const $streetAddress = document.getElementById('streetaddress');
    const $suburbTown = document.getElementById('suburb/town')
    let isValid = true;
    let errorMessage = '';

    if (!debug) { // Check if debug mode is disabled
        // Access the job reference number from the URL
        const urlParams = new URLSearchParams(window.location.search);
        const jobId = urlParams.get('jobId');
        document.getElementById('JRN').value = jobId || '';
    }

    // Reset error messages
    displayErrorMessage('');

    // Validate Date of Birth
    if (!debug) { // Check if debug mode is disabled
        const dobInput = document.querySelector('input[type="date"]');
        const dobValue = new Date(dobInput.value);
        const today = new Date();
        const minAge = 15;
        const maxAge = 80;

        if (isNaN(dobValue)) {
            errorMessage += 'Please enter a valid date of birth in dd/mm/yyyy format.<br>';
            isValid = false;
        } else {
            const age = today.getFullYear() - dobValue.getFullYear();
            if (age < minAge || age > maxAge) {
                errorMessage += 'Applicants must be between 15 and 80 years old.<br>';
                isValid = false;
            }
        }
    }


    // Validate State and Postcode
    if (!debug) {
    const selectedState = stateSelect.value;
    const postcode = parseInt(postcodeInput.value);

    const statePostcodeMappings = {
        VIC: [3, 8],
        NSW: [1, 2],
        QLD: [4, 9],
        NT: [0],
        WA: [6],
        SA: [5],
        TAS: [7],
        ACT: [0]
    };
 
    if (statePostcodeMappings[selectedState]) {
        if (!statePostcodeMappings[selectedState].includes(Math.floor(postcode / 1000))) {
            errorMessage += 'The selected state must match the first digit(s) of the postcode.<br>';
            isValid = false;
        }
    }
}

    // Validate Other Skills if "Other Skills..." is selected
    if (!debug) {
    const otherSkillsCheckbox = document.querySelector('input[name="category[]"][value="other"]');
    if (otherSkillsCheckbox.checked && otherSkillsTextarea.value.trim() === '') {
        errorMessage += 'If "Other Skills..." is selected, please provide details in the Other Skills text area.<br>';
        isValid = false;
    }


 // Validation code for Date of Birth
 if (!debug) {
 $dob = sanitize($_POST["DOB"]);
 $dobTimestamp = strtotime($dob);
 if (!$dobTimestamp || $dobTimestamp > strtotime("-15 years") || $dobTimestamp < strtotime("-80 years")) {
     displayError("Invalid date of birth. Age must be between 15 and 80.");
 }
 }


 // Validation code for Suburb/Town
 if (!debug) {
 $suburbTown = sanitize($_POST["suburb/town"]);
 if (strlen($suburbTown) > 40) {
     displayError("Suburb/town must be a maximum of 40 characters.");
 }
 }


 // Validation code for Street Address
 if (!debug) {
 $streetAddress = sanitize($_POST["streetaddress"]);
 if (strlen($streetAddress) > 40) {
     displayError("Street address must be a maximum of 40 characters.");
 }
}
}

if (!isValid) {
    displayErrorMessage(errorMessage);
    event.preventDefault();
} else {
    const formData = new FormData(document.getElementById('applynow'));
    const applicantDetails = {};
    for (const [key, value] of formData.entries()) {
        applicantDetails[key] = value;
    }
    sessionStorage.setItem('applicantDetails', JSON.stringify(applicantDetails));
}
}

function prefillFormFields(applicantDetails) {
    // Pre-fill the form fields with the applicant's details
    document.getElementById('JRN').value = localStorage.getItem('jobId') || '';
    document.getElementById('firstname').value = applicantDetails.firstname || '';
    document.getElementById('lastname').value = applicantDetails.lastname || '';
    document.getElementById('DOB').value = applicantDetails.DOB || '';
    document.getElementById('streetaddress').value = applicantDetails['streetaddress'] || '';
    document.getElementById('suburb/town').value = applicantDetails['suburb/town'] || '';
    document.getElementById('state').value = applicantDetails.state || '';
    document.getElementById('postcode').value = applicantDetails.postcode || '';
    document.getElementById('email').value = applicantDetails.email || '';
    document.getElementById('phonenumber').value = applicantDetails.phonenumber || '';
    document.getElementById('applyfor').value = applicantDetails.applyfor || '';
    document.getElementById('comments').value = applicantDetails.comments || '';

    const urlParams = new URLSearchParams(window.location.search);
    const jobId = urlParams.get('jobId');
    document.getElementById('JRN').value = jobId || '';
}

function submitForm(event) {
    event.preventDefault(); // Prevent the form from submitting by default

    // Get the form data and store it in session storage
    const formData = new FormData(document.getElementById('applynow'));
    const applicantDetails = {};
    for (const [key, value] of formData.entries()) {
        applicantDetails[key] = value;
    }

    // Store the job reference number in local storage
    const jobId = document.getElementById('JRN').value;
    localStorage.setItem('jobId', jobId);
}

function init() {
    // Prefill form fields with stored data
    const storedApplicantDetails = sessionStorage.getItem('applicantDetails');
    if (storedApplicantDetails) {
        prefillFormFields(JSON.parse(storedApplicantDetails));
    }

    // Validate the form
    const applyNowButton = document.getElementById('apply-now-button');
    applyNowButton.addEventListener('click', validateForm);

    // Attach a submit event listener to the form
    const applyForm = document.getElementById('applynow');
    applyForm.addEventListener('submit', submitForm);
}

window.onload = init;
