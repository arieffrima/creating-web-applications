/*
filename: Arief Frima Saipul
created: 07/09/2023
last modified: 27/08/2023
description: Assignment2
Tutor: Md Arafat Hossain
*/


  function initApplyForm() {


    const applyForm = document.getElementById('applynow');
    applyForm.addEventListener('submit', validateForm);
  
 
    // Check if there are previously stored applicant details in session storage
    const storedApplicantDetails = sessionStorage.getItem('applicantDetails');
    if (storedApplicantDetails) {
      // Parse the stored details and pre-fill the form fields
      const parsedDetails = JSON.parse(storedApplicantDetails);
      prefillFormFields(parsedDetails);
    }



    var timeLimit = 30 * 60; 

    var timerDisplay = document.getElementById("timer");
    var timerWarning = document.getElementById("timer-warning");

    var timerInterval = setInterval(function () {
      var minutes = Math.floor(timeLimit / 60);
      var seconds = timeLimit % 60;

      // Display the remaining time in the format "mm:ss".
      timerDisplay.textContent =
        (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;

      // Decrease the time limit by 1 second.
      timeLimit--;

      // Check if the time limit has reached 0.
      if (timeLimit < 0) {
        clearInterval(timerInterval); // Stop the timer.
        timerWarning.textContent = "Time limit exceeded. Redirecting to the home page...";
        setTimeout(function () {
          // Redirect to the home page after displaying the warning.
          window.location.href = "Index.html";
        }, 2000); // Redirect after 2 seconds (adjust as needed).
      }
    }, 1000); // Update the timer every 1 second.
  }

// Function to populate day, month, and year select elements
    function populateDateSelects() {
      const daySelect = document.getElementById('day');
      const monthSelect = document.getElementById('month');
      const yearSelect = document.getElementById('year');

      // Populate day select with numbers from 1 to 31
      for (let i = 1; i <= 31; i++) {
        const option = document.createElement('option');
        option.value = i;
        option.textContent = i;
        daySelect.appendChild(option);
      }

      // Populate month select with month names
      const months = [
        'January', 'February', 'March', 'April', 'May', 'June', 'July',
        'August', 'September', 'October', 'November', 'December'
      ];
      for (let i = 0; i < months.length; i++) {
        const option = document.createElement('option');
        option.value = i + 1; // Month values are 1-based
        option.textContent = months[i];
        monthSelect.appendChild(option);
      }

      // Populate year select with a range of years (adjust as needed)
      const currentYear = new Date().getFullYear();
      for (let i = currentYear; i >= currentYear - 10; i--) {
        const option = document.createElement('option');
        option.value = i;
        option.textContent = i;
        yearSelect.appendChild(option);
      }
    }

  

  window.onload = function () {
    initApplyForm();
    populateDateSelects();
    

  };
  
