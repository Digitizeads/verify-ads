

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
document.addEventListener("DOMContentLoaded", function () {
  const whatsappButton = document.querySelector(".social-button.whatsapp");
  
  whatsappButton.addEventListener("click", function () {
      const phoneNumber = "917788994131"; // Company phone number (without '+')
      const defaultMessage = "Hello! Can we get in touch?"; // Pre-filled message from company side
      const whatsappURL = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(defaultMessage)}`;

      // Open WhatsApp URL in a new tab
      window.open(whatsappURL, "_blank");
  });
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

   // Load the footer dynamically
   document.addEventListener("DOMContentLoaded", function() {
    fetch("footer.html")
        .then(response => response.text())
        .then(data => {
            document.getElementById("footer-placeholder").innerHTML = data;
        })
        .catch(error => console.error('Error loading footer:', error));
});



// scripts.js

document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("search-input");
  const tagButtons = document.querySelectorAll(".tag-button");
  const posts = document.querySelectorAll(".post");

  // Filter posts by tag
  tagButtons.forEach(button => {
      button.addEventListener("click", function () {
          const tag = button.getAttribute("data-tag");
          filterPostsByTag(tag);
      });
  });

  // Filter posts based on search input
  searchInput.addEventListener("input", function () {
      const query = searchInput.value.toLowerCase();
      filterPostsBySearch(query);
  });

  function filterPostsByTag(tag) {
      posts.forEach(post => {
          const postTags = post.getAttribute("data-tags").split(" ");
          if (postTags.includes(tag)) {
              post.style.display = "flex";
          } else {
              post.style.display = "none";
          }
      });
  }

  function filterPostsBySearch(query) {
      posts.forEach(post => {
          const title = post.querySelector("h2").innerText.toLowerCase();
          const content = post.querySelector("p").innerText.toLowerCase();
          if (title.includes(query) || content.includes(query)) {
              post.style.display = "flex";
          } else {
              post.style.display = "none";
          }
      });
  }
});
