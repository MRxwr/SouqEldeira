$(document).ready(function () {    
  
  $(".favo").on("click", function () {
    var id = $(this).attr("id");
    var cookieValue = document.cookie.match(/CSseldeira=([^;]*)/);
    if (cookieValue) {
      var valid = cookieValue[1];
    }else{
      var valid = "";
    }
    $.get("requests/index.php?a=Favo&id=" + id + "&valid=" + valid)
    .done(function(response) {
      const responseObject = JSON.parse(response);
      var elem = $(".favo"+id);
      console.log(responseObject.data.tag);
      if( responseObject.data.tag == "0" ){
        elem.attr("style", "color:#000");
      }else{
        elem.attr("style", "color:red");
      }
      alert(responseObject.data.msg);
    })
    .fail(function() {
      alert("Error occurred!");
    });
  });

  $(".share").on("click", function () {
    var url = $(this).attr("id");
    if (navigator.share) {
      navigator.share({
        url: url
      })
      .then(() => console.log('Successful share'))
      .catch((error) => console.log('Error sharing:', error));
    }
  });
	
	$('#dismiss, .main-overlay').on('click', function () {
        $('#sidebar').removeClass('active');
        $('.main-overlay').removeClass('active');
    });     
    
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').addClass('active');
        $('.main-overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });	$('.advanced-search-a').on('click', function() { 
	    $('.advanced-search-view').slideToggle('', function() {  
	       // if ($(this).css('display') == 'block') $(this).css('display', 'flex'); // enter desired display type
	    });
	});
	
	/*
	 * The search form holds ids while the site wants titles in the url
	 * (/search/بيع/العدان/بيت), so the address is built here before sending.
	 * Without javascript the form still submits and the server cleans the url.
	 */
	$('form.search-area').on('submit', function (event) {
		var url = searchFormUrl(this);
		if (!url) return; // no category chosen, the server asks for one
		event.preventDefault();
		window.location.href = url;
	});

	
	$('#recharge-balance-btn').on('click', function() { 
	    $('.add-ads-balance-big').slideToggle('', function() {  
	       // if ($(this).css('display') == 'block') $(this).css('display', 'flex'); // enter desired display type
	    });
	});
    // Handle file selection and preview for all file inputs
    $('input[type="file"]').on('change', function (event) {
      // Get the file input ID
      const fileInputId = $(this).attr('id');
      // Map to the corresponding span ID
      const spanId = fileInputId.replace('InputFld', 'Input');
      // Get the selected file
       displaySelectedFiles(this,spanId);
    });  
    
});

$(document).ready(function() {
  var owl = $('.owl-carousel-offices');
  owl.owlCarousel({
    margin: 10,
    nav: true, 
    navText:["<div class='nav-btn prev-slide'><span aria-label='Previous'>›</span></div>","<div class='nav-btn next-slide'><span aria-label='Next'>‹</span></div>"],
    loop: true,
    rtl: true,
    responsive: {
      0: {
        items: 1
      },
      600: {
        items: 3
      },
      1000: {
        items: 5
      }
    }
  })
});


window.onload = function () {
    window.setTimeout(fadeout, 500);
}

function fadeout() {
    document.querySelector('.preloader').style.opacity = '0';
    document.querySelector('.preloader').style.display = 'none';
}


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
  //document.getElementById('timerOTP').innerHTML = m + ':' + s;
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
  // alert('Timeout for otp');
}

timer(120);

/*
 * Title url of a search form: /search/{category}/{area}/{property-type}, keeping
 * only a price range after the path because it has no title to show.
 * Returns an empty string when the form cannot be turned into a title url.
 */
function searchFormUrl(form) {
  var $form = $(form || 'form.search-area');
  var $category = $form.find('input[name="categoryId"]:checked');
  if (!$category.length || !$category.data('slug')) return '';
  var parts = [$category.data('slug')];
  $.each(['areaId', 'propertyType'], function (index, name) {
    var $selected = $form.find('select[name="' + name + '"] option:selected');
    if ($selected.val() && $selected.data('slug')) parts.push($selected.data('slug'));
  });
  var url = '/search/' + $.map(parts, encodeURIComponent).join('/');
  var query = [];
  $.each(['from', 'to'], function (index, name) {
    var value = String($form.find('input[name="' + name + '"]').val() || '').trim();
    if (value !== '') query.push(name + '=' + encodeURIComponent(value));
  });
  return query.length ? url + '?' + query.join('&') : url;
}

  function displaySelectedFiles(input,preview) {
    var filePreview  = $('#'+preview);
    filePreview.empty(); // Clear previous file list

    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        filePreview.append('<img src="' + e.target.result + '" alt="File Preview" style="width:100%">');
      };
      reader.readAsDataURL(input.files[0]);
    } else {
      filePreview.html('No file selected');
    }
  }
		
