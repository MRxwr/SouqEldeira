$(document).ready(function () {     
	
	$('#dismiss, .main-overlay').on('click', function () {
        $('#sidebar').removeClass('active');
        $('.main-overlay').removeClass('active');
    });     
    
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').addClass('active');
        $('.main-overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });
 
    $('.advanced-search-a').on('click', function() { 
	    $('.advanced-search-view').slideToggle('', function() {  
	       // if ($(this).css('display') == 'block') $(this).css('display', 'flex'); // enter desired display type
	    });
	});
	
	$('#recharge-balance-btn').on('click', function() { 
	    $('.add-ads-balance-big').slideToggle('', function() {  
	       // if ($(this).css('display') == 'block') $(this).css('display', 'flex'); // enter desired display type
	    });
	});
    
    
});

// $(document).ready(function() {
//   var owl = $('.owl-carousel-offices');
//   owl.owlCarousel({
//     margin: 10,
//     nav: true, 
//     navText:["<div class='nav-btn prev-slide'><span aria-label='Previous'>›</span></div>","<div class='nav-btn next-slide'><span aria-label='Next'>‹</span></div>"],
//     loop: true,
//     rtl: true,
//     responsive: {
//       0: {
//         items: 1
//       },
//       600: {
//         items: 3
//       },
//       1000: {
//         items: 5
//       }
//     }
//   })
// });



document.addEventListener('DOMContentLoaded', function() {
  // Simulate a delay (replace this with your actual content loading logic)
  setTimeout(function() {
      // Hide the preloader
      document.getElementById('preloader').style.display = 'none';

      // Show the content
      //document.getElementById('content').style.display = 'block';
  }, 2000); // Adjust the delay time as needed
});


/*=====================================
Sticky
======================================= */
window.onscroll = function () {
    var header_navbar = document.querySelector(".navbar-area");
    var sticky = header_navbar.offsetTop;

    // show or hide the back-top-top button
    var backToTo = document.querySelector(".scroll-top");
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        backToTo.style.display = "flex";
    } else {
        backToTo.style.display = "none";
    }
};



let timerOn = true;

function timer(remaining) {
  var m = Math.floor(remaining / 60);
  var s = remaining % 60;
  
  m = m < 10 ? '0' + m : m;
  s = s < 10 ? '0' + s : s;
 // document.getElementById('timerOTP').innerHTML = m + ':' + s;
  remaining -= 1;
  
  if(remaining >= 0 && timerOn) {
    setTimeout(function() {
        timer(remaining);
    }, 1000);
    return;
  }

  if(!timerOn) {
    // Do validate stuff here
    return;
  }
  
  // Do timeout stuff here
  alert('Timeout for otp');
}

//timer(120);