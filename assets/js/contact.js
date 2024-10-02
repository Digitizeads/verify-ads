

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

document.getElementById('contactForm').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent the form from actually submitting

  // Create thank you popup
  const thankYouPopup = document.createElement('div');
  thankYouPopup.classList.add('thank-you-popup', 'fade-in');
  thankYouPopup.innerHTML = `
    <div class="thank-you-content">
      <h2>Thank You! 😊</h2>
      <p>We have received your message. Our team will get back to you shortly.</p>
      <a href="index.html">
        <button class="btn btn-primary close-thank-you-btn">Go to Home</button>
      </a>
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
