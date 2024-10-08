document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("expert-form");

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
  
  
document.querySelector('.openFormBtn').addEventListener('click', function () {
    document.querySelector('.form-container').classList.add('show');
});

document.querySelector('.close-btn').addEventListener('click', function () {
    document.querySelector('.form-container').classList.remove('show');
});

window.onclick = function(event) {
    if (event.target == document.querySelector('.form-container')) {
        document.querySelector('.form-container').classList.remove('show');
    }
}

// Get the modal
var popup = document.getElementById("contactFormPopup");

// Get the button that opens the modal
var btns = document.querySelectorAll(".btn-primary");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close-btn")[0];

// When the user clicks on any "Explore More" button, open the modal 
btns.forEach(function(btn) {
    btn.onclick = function() {
        popup.style.display = "block";
    };
});

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    popup.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == popup) {
        popup.style.display = "none";
    }
}


 // Get the form element and the popup elements
 const form = document.querySelector('form');
 const contactFormPopup = document.getElementById('contactFormPopup');
 const closeBtn = document.querySelector('.close-btn');

 // Event listener for form submission
 form.addEventListener('submit', function(event) {
   event.preventDefault(); // Prevent form from submitting

   // Add fade-out effect for the contact form popup
   contactFormPopup.classList.add('fade-out');
   setTimeout(() => {
     contactFormPopup.style.display = 'none'; // Hide the popup after fade out
   }, 500); // Timing should match CSS transition duration

   // Create the thank you message popup
   const thankYouPopup = document.createElement('div');
   thankYouPopup.classList.add('thank-you-popup', 'fade-in');
   thankYouPopup.innerHTML = `
     <div class="thank-you-content">
       <h2>Thank You! 😊</h2>
       <p>We have received your message. Our team will get back to you shortly.</p>
    <a href="index.html" <button class="close-thank-you-btn">Go to Home</button></a>
     </div>
   `;

   // Append the thank you popup to the body
   document.body.appendChild(thankYouPopup);

   // Close the thank you popup when the close button is clicked
   const closeThankYouBtn = thankYouPopup.querySelector('.close-thank-you-btn');
   closeThankYouBtn.addEventListener('click', function() {
     thankYouPopup.classList.remove('fade-in');
     thankYouPopup.classList.add('fade-out');
     setTimeout(() => {
       document.body.removeChild(thankYouPopup);
     }, 500); // Timing should match CSS transition duration
   });
 });

 // Close contact form popup when the close button is clicked
 closeBtn.addEventListener('click', function() {
   contactFormPopup.classList.add('fade-out');
   setTimeout(() => {
     contactFormPopup.style.display = 'none';
   }, 500); // Timing should match CSS transition duration
 });