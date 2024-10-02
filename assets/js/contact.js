

document.getElementById("callButton").addEventListener("click", function () {
  window.location.href = "tel:+919178898880"; // Replace with the desired phone number
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
  window.open('https://wa.me/+919178898880', '_blank');
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

// Get the form element and the thank-you popup element
const form = document.querySelector('#contactForm');
const contactFormPopup = document.getElementById('contactFormPopup');

// Event listener for form submission
form.addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent form submission

  // Add fade-in effect to the thank-you popup
  contactFormPopup.classList.add('fade-in');
  contactFormPopup.style.display = 'block';

  // Optional: Reset the form fields after submission
  form.reset();

  // Auto-hide the thank-you popup after 5 seconds (optional)
  setTimeout(() => {
    contactFormPopup.classList.remove('fade-in');
    contactFormPopup.classList.add('fade-out');
    setTimeout(() => {
      contactFormPopup.style.display = 'none';
      contactFormPopup.classList.remove('fade-out');
    }, 500); // Match the CSS transition duration
  }, 5000); // Time before auto-hiding the popup
});

// Close thank you popup when "Go to Home" button is clicked
const closeThankYouBtn = document.querySelector('.close-thank-you-btn');
closeThankYouBtn.addEventListener('click', function() {
  contactFormPopup.classList.remove('fade-in');
  contactFormPopup.classList.add('fade-out');
  setTimeout(() => {
    contactFormPopup.style.display = 'none';
    contactFormPopup.classList.remove('fade-out');
  }, 500); // Timing should match CSS transition duration
});
