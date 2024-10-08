const faqItemHead = document.querySelectorAll('.faq-item-head');


faqItemHead.forEach((head, index) => {
    head.addEventListener('click', () => {
        let icon = head.querySelector('.faq-item-icon').firstElementChild;
        if(icon.className == "fa fa-chevron-down"){
            head.nextElementSibling.classList.add('show-para');
            icon.className = "fa fa-chevron-up";
        } else if(icon.className == "fa fa-chevron-up"){
            head.nextElementSibling.classList.remove('show-para');
            icon.className = "fa fa-chevron-down";
        }
    });
});

$('.testimonials-container').owlCarousel({
    loop:true,
    autoplay:true,
    autoplayTimeout:6000,
    margin:10,
    nav:true,
    navText:["<i class='fa-solid fa-arrow-left'></i>",
             "<i class='fa-solid fa-arrow-right'></i>"],
    responsive:{
        0:{
            items:1,
            nav:false
        },
        600:{
            items:1,
            nav:true
        },
        768:{
            items:2
        },
    }
  })


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

/* document.getElementById('whatsapp-button').addEventListener('click', function() {
    const phoneNumber = '9178898880'; // Replace with your company number
    const message = 'Hello, I would like to inquire about your services.';
    const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
    
    window.open(url, '_blank');
  }); */

 /*  callbutton */

  document.getElementById("callButton").addEventListener("click", function () {
    window.location.href = "tel:+917788994131"; // Replace with the desired phone number
  });

   // Event listener for the LinkedIn button
document.querySelector('.social-button.linkedin').addEventListener('click', function() {
  window.open('https://www.linkedin.com/company/digitizeads/', '_blank');
});
  
  // Event listener for the Skype button
  document.querySelector('.social-button.skype').addEventListener('click', function() {
    window.location.href = 'skype:live:8e8997a5794b1e91?chat';
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
  
    
  // Event listener for the Google Review button
document.getElementById("reviewButton").addEventListener("click", function () {
  // Simplified Google Review URL
  window.location.href = 'https://www.google.com/search?hl=en-IN&gl=in&q=Digitize+Ads,+BASUNDHARA+APARTMENT,+214,+Rasulgarh,+Bhubaneswar,+Odisha+751010&ludocid=7984704298041396686&lsig=AB86z5VDJmA3VPRA4dIbRSkLCXJQ#lrd=0x3a190baa01e2c72f:0x6ecf5e41194acdce,3';
});