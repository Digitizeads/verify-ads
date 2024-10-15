"use strict";

/**
 * navbar variables
 */
const menuToggleBtn = document.querySelector("[data-navbar-toggle-btn]");
const navbar = document.querySelector("[data-navbar]");

/**
 * element toggle function
 */

const elemToggleFunc = function (elem) {
  elem.classList.toggle("active");
};

menuToggleBtn.addEventListener("click", function () {
  elemToggleFunc(navbar);
});

/**
 * go to top
 */

const goTopBtn = document.querySelector("[data-go-top]");

window.addEventListener("scroll", function () {
  if (window.scrollY >= 800) {
    goTopBtn.classList.add("active");
  } else {
    goTopBtn.classList.remove("active");
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector(".contact-form");

  form.addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the form from actually submitting

    // Show a popup notification
    alert("Your message was sent successfully!");

    // Optionally, reset the form after submission
    form.reset();
  });
});

/* callbutton */
document.getElementById("callButton").addEventListener("click", function () {
  window.location.href = "tel:+917788994131"; // Replace with the desired phone number
});

/* counter */

document.addEventListener("DOMContentLoaded", () => {
  // Configuration for each counter
  const counters = [
    { id: "counter1", target: 200, duration: 2000 }, // Projects Completed
    { id: "counter2", target: 150, duration: 2500 }, // Clients Served
  ];

  const startCounter = (element, counter) => {
    let count = 0;
    const increment = counter.target / (counter.duration / 100);

    const updateCounter = () => {
      count += increment;
      if (count < counter.target) {
        element.innerText = `${Math.floor(count)}+`;
        setTimeout(updateCounter, 100);
      } else {
        element.innerText = `${counter.target}+`;
      }
    };

    updateCounter();
  };

  // IntersectionObserver callback
  const observerCallback = (entries, observer) => {
    entries.forEach((entry) => {
      const counter = counters.find((c) => c.id === entry.target.id);
      if (entry.isIntersecting) {
        startCounter(entry.target, counter);
      } else {
        entry.target.innerText = "+0"; // Reset the counter when out of view
      }
    });
  };

  const observer = new IntersectionObserver(observerCallback, {
    threshold: 0.5,
  });

  counters.forEach((counter) => {
    const element = document.getElementById(counter.id);
    observer.observe(element);
  });
});

// This is script file

$('.testimonials-container').owlCarousel({
  loop: true,
  autoplay: true,
  autoplayTimeout: 6000,
  margin: 10,
  nav: true,
  navText: [
    "<i class='fa-solid fa-arrow-left'></i>",
    "<i class='fa-solid fa-arrow-right'></i>",
  ],
  responsive: {
    0: {
      items: 1,
      nav: false,
    },
    600: {
      items: 1,
      nav: true,
    },
    768: {
      items: 2,
    },
  },
});

// Event listener for the LinkedIn button
document.querySelector(".social-button.linkedin").addEventListener("click", function () {
  window.open("https://www.linkedin.com/company/digitizeads/", "_blank");
});

// Event listener for the Skype button
document.querySelector(".social-button.skype").addEventListener("click", function () {
  window.open("https://web.skype.com/?openPstnPage=true/en/skype/live:.cid.ec8506b8a4ab3f", "_blank");
});

// Event listener for the WhatsApp button
document.querySelector(".social-button.whatsapp").addEventListener("click", function () {
  const phoneNumber = "917788994131"; // Company phone number (without '+')
  const defaultMessage = "Hello! Can we get in touch?"; // Pre-filled message from company side
  const whatsappURL = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(defaultMessage)}`;
  
  window.open(whatsappURL, "_blank");
});


// Event listener for the Google Review button
document.getElementById("reviewButton").addEventListener("click", function () {
  // Simplified Google Review URL
  window.location.href = 'https://www.google.com/search?hl=en-IN&gl=in&q=Digitize+Ads,+BASUNDHARA+APARTMENT,+214,+Rasulgarh,+Bhubaneswar,+Odisha+751010&ludocid=7984704298041396686&lsig=AB86z5VDJmA3VPRA4dIbRSkLCXJQ#lrd=0x3a190baa01e2c72f:0x6ecf5e41194acdce,3';
});

// Event listener for the map button
document.querySelector(".map").addEventListener("click", function () {
  // Latitude and Longitude from the provided URL
  var latitude = 20.2902191;
  var longitude = 85.8692255;
  // Constructing the Google Maps URL
  var url = `https://www.google.com/maps?q=${latitude},${longitude}`;
  // Open the URL in a new tab
  window.open(url, "_blank");
});

/* window.addEventListener('load', () => {
  const loadingScreen = document.getElementById('loading-screen');
  const mainContent = document.getElementById('main-content');

  // Hide the loading screen and show the main content
  loadingScreen.style.display = 'none';
  mainContent.style.display = 'block';
}); */

window.addEventListener("load", () => {
  const loadingScreen = document.getElementById("loading-screen");
  const mainContent = document.getElementById("main-content");

  // Hide the loading screen and show the main content
  loadingScreen.style.display = "none";
  mainContent.style.display = "block";
});


/* newsletter */
/* document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
  e.preventDefault();
  const email = document.querySelector('.email-input').value;
  if (email) {
    alert('Thank you for subscribing!');
  }
}); */



 // Handle form submission
  // Handle form submission
  document.querySelector('.newsletter-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form from submitting normally

    // Create thank you popup
    const thankYouPopup = document.createElement('div');
    thankYouPopup.classList.add('thank-you-popup', 'fade-in');
    thankYouPopup.innerHTML = `
      <div class="thank-you-content">
        <h2>Thank You! 😊</h2>
        <p>We have received your subscription. You will start receiving updates soon.</p>
        <a href="index.html">
          <div class="news-btn"><button class="btn btn-primary close-thank-you-btn">OK</button></div>
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

     // Load the footer dynamically
     document.addEventListener("DOMContentLoaded", function() {
      fetch("footer.html")
          .then(response => response.text())
          .then(data => {
              document.getElementById("footer-placeholder").innerHTML = data;
          })
          .catch(error => console.error('Error loading footer:', error));
  });