document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("expert-form");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent the form from submitting

        // Get the form elements
        const name = document.getElementById("name");
        const email = document.getElementById("email");
        const service = document.getElementById("service");
        const message = document.getElementById("message");

        // Clear any previous error messages
        clearErrors();

        // Perform validation
        let isValid = true;

        // Validate name
        if (name.value.trim() === "") {
            showError(name, "Name is required.");
            isValid = false;
        }

        // Validate email
        if (email.value.trim() === "") {
            showError(email, "Email is required.");
            isValid = false;
        } else if (!isValidEmail(email.value.trim())) {
            showError(email, "Please enter a valid email address.");
            isValid = false;
        }

        // Validate service
        if (service.value.trim() === "") {
            showError(service, "Please select a service.");
            isValid = false;
        }

        // Validate message (optional)
        if (message.value.trim() !== "" && message.value.trim().length < 10) {
            showError(message, "Additional details must be at least 10 characters long.");
            isValid = false;
        }

        // If the form is valid, submit it
        if (isValid) {
            form.submit();
        }
    });

    function showError(input, message) {
        const formGroup = input.parentElement;
        const error = document.createElement("span");
        error.className = "error-message";
        error.innerText = message;
        formGroup.appendChild(error);
    }

    function clearErrors() {
        const errorMessages = document.querySelectorAll(".error-message");
        errorMessages.forEach(function (errorMessage) {
            errorMessage.remove();
        });
    }

    function isValidEmail(email) {
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailPattern.test(email);
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const navbarMenuBtn = document.querySelector('[data-navbar-toggle-btn]');
    const navbar = document.querySelector('[data-navbar]');

    navbarMenuBtn.addEventListener('click', () => {
        navbar.classList.toggle('active');
    });
});



document.getElementById("callButton").addEventListener("click", function () {
    window.location.href = "tel:+917788994131"; // Replace with the desired phone number
  });

  // Event listener for the LinkedIn button
document.querySelector('.social-button.linkedin').addEventListener('click', function() {
    window.open('https://www.linkedin.com/company/digitizeads/', '_blank');
  });
  
  // Event listener for the Skype button
  document.querySelector('.social-button.skype').addEventListener('click', function() {
    // Replace 'skype_id' with the actual Skype ID
    window.open('https://web.skype.com/?openPstnPage=true/en/skype/live:8e8997a5794b1e91', '_blank');
  });
  
  // Event listener for the WhatsApp button
  document.querySelector('.social-button.whatsapp').addEventListener('click', function() {
    window.open('https://wa.me/+917788994131', '_blank');
  });
  document.querySelector('.map').addEventListener('click', function() {
    // Latitude and Longitude from the provided URL
    var latitude = 20.2902191;
    var longitude = 85.8692255;
    // Constructing the Google Maps URL
    var url = `https://www.google.com/maps?q=${latitude},${longitude}`;
    // Open the URL in a new tab
    window.open(url, '_blank');
  });
  
  function openCareerPage() {
    window.location.href = 'carrer.html'; // Replace with your actual career page URL
}

