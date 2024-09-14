var inputs = document.querySelectorAll('input[required]');
inputs.forEach(function(input) {
    input.addEventListener('input', function () {
        if (input.validity.valid) {
            input.classList.remove('invalid');
            input.nextElementSibling.style.display = 'none';
        } else {
            input.classList.add('invalid');
            input.nextElementSibling.style.display = 'block';
        }
    });
});
 var isLoggedIn = function  () {
    var isLoggedIn = localStorage.getItem('isLoggedIn');
    if (isLoggedIn === 'true') {
        console.log('User is logged in.');
        window.location.href = '/profile';
    } 
}
var isLoggedOut = function  () {
    var isLoggedIn = localStorage.getItem('isLoggedIn');
    if (isLoggedIn === 'false'){
        console.log('User is logged in.');
        window.location.href = '/login';
    } 
}
var getSidebar = function (){
    var isLoggedIn = localStorage.getItem('isLoggedIn');
    var userData = localStorage.getItem('userData');
    console.log(userData);
    if (userData !== null && userData.trim() !== '') {
            userData = JSON.parse(userData);
        }
    console.log(userData);
    var html='';
    var menu='';
    var lgout='';
    if (isLoggedIn === 'true') { //AddAd
        var socials = userData.socials;
        $('#Regular_Ad').text(userData.adv_normal_count);
        $('#Special_Ad').text(userData.adv_star_count);
        $('#add-ad-btn').html('<a href="/add-ad" class="btn btn-primary btn-border-radius-1 btn-new-ad"><i class="bi bi-plus-lg"></i> <span>'+AddAd+'</span></a>');

         html +='<div class="profile">';
         html +='<div class="avatar">';
         html +='<a href="/profile" class="d-block">';
         html +='<img src="'+userData.avatar+'" class="img-fluid" alt="..." style="border-radius: 50px;">';
         html +='</a>';
         html +='</div>';
        
         html +='<div class="details">';
         html +='<h3 class="fullname">'+userData.name+'</h3>';
         html +='<a href="/profile">'+MyProfile+'</a>';
         html +='</div>';
        
         html +='</div>';
         html +='<div class="">';
         html +='<a href="/notifications" class="notifications" style="padding: 10px;">';
         html +='<i class="bi bi-bell"></i> ';
         html +='<span class="badge badge-light">'+userData.NumbersOfNotification+'</span>';				  
         html +='</a>'; 
         html +='</div>';
         menu +='<li>';
         menu +='<a href="/my-ads"><i class="bi bi-grid"></i> '+MyAds+' <span class="badge">'+userData.dashboard.total_ads+'</span></a>';
         menu +='</li>'
         menu +='<li>';
         menu +='<a class="logout" href="/logout"><i class="bi bi-box-arrow-right"></i>'+lnLogout+'</a>';
         menu +='</li>' 
         $('#uemail').attr('href', 'mailto:'+userData.email);
         $('#ufacebook').attr('href', socials.facebook);
         $('#utwitter').attr('href', +socials.twitter); 
         $('#uinstagram').attr('href', +socials.instagram);
         $('#uyoutube').attr('href', +socials.youtube);
         $('#utelephone').attr('href', 'tel:'+userData.phone);
         $('#whatsapp').attr('href', 'https://wa.me/965'+userData.phone);
    } else {
        html +='<div class="">';
        html +='<a href="/">';
        html +='<img src="assets/img/logo-1.png" style="border-radius: 50px;">';
        html +='</a>';
        html +='</div>';
        html +='<div class="">';
        html +='<a href="/notifications" class="notifications" style="padding: 10px;">';
        html +='<i class="bi bi-bell"></i> ';
        html +='<span class="badge badge-light">0</span>';				  
        html +='</a> ';
        html +='</div>';
        menu +='<li>';
        menu +='<a href="/login"><i class="bi bi-box-arrow-right"></i>'+Login+'</a>';
        menu +='</li>';
        $('#add-ad-btn').html('');
    }
    $('#sidebarHeader').html(html);
    $('#sidebarMenu li:eq(1)').after(menu);
    $('#sidebarMenu li:eq(10)').after(lgout);
    
}
getSidebar();

var chnageMeta = function(title='',description='',keywords=''){
    if (title !== null ) {
        $('title').text(title);
    }
    if (description !== null ){
        $('meta[name="description"]').attr('content', description);
    }
    if (keywords !== null ){
        $('meta[name="keywords"]').attr('content', keywords);
    }
  
}

var getMessage =function(){
    var alert_type = localStorage.getItem('alert_type');
    var alert_msg = localStorage.getItem('alert_msg');
    if (alert_type !== null && alert_msg!== null) {
        $('#alert').css('display', 'block');
        $('#alert').removeClass('alert-danger');
        $('#alert').removeClass('alert-success');
        $('#alert').addClass(alert_type);
        $('#alert').html(alert_msg);
    }
    setTimeout(function (){ 
        $('#alert').css('display', 'none');
    }, 15000); 
}
// setMessage(type,msg);
var setMessage = function(type,msg){
    //alert(type);
    if(type=='error'){
        type='alert-danger';
    }
    if(type=='warning'){
        type='alert-warning';
    }
    if(type=='success'){
        type='alert-success';
    }
    if (type !== null && msg!== null) {
        localStorage.setItem('alert_type', type);
        localStorage.setItem('alert_msg',msg);
        getMessage();
    }
}
var getError = function(errors){
    var html='';
    html='<ul>';
    $.each(errors, function(key, value) {
        // Check if the value is an array and has elements
        if (Array.isArray(value) && value.length > 0) {
          // Log each text in the array
          value.forEach(function(text) {
            //console.log(text);
            html +='<li>'+text+'</li>';
          });
        }
      });
      html +='</ul>';
    return  html;
}

var myListAds= function(lists){
    var parameters = getURLParameters();
    var TownText ='';
    var PropertyType='';
    var html ='';
    lists.forEach(item => {
        html +='<div class="col-lg-12">';
        if(item.is_featured){
            //html +='<a style="cursor: pointer" class="card card-ad card-feature" data-id="'+item.id+'" >';
            html +='<a href="/ad-view?slug='+item.id+'" class="card card-ad card-feature">';
        }else{
           
            html +='<a href="/ad-view?slug='+item.id+'" class="card card-ad">';
        }
       
        html +='<div class="row g-0"> ';
        if(TownText==''){
            TownText = item.location.town_title;
        }
        if(PropertyType==''){
            PropertyType = item.type.human;

        }
        if(item.is_featured){
          
        html +='<div class="col-4 col-sm-3 position-relative">';    
        html +='<span class="feature-label">Feature</span> ';    
        html +='<div id="carouselAdMainImages" class="carousel slide" data-bs-ride="carousel">';
        html +='<div class="carousel-indicators">';
        html +='<button type="button" data-bs-target="#carouselAdMainImages" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>';
        html +='<button type="button" data-bs-target="#carouselAdMainImages" data-bs-slide-to="1" aria-label="Slide 2"></button>';
        html +='<button type="button" data-bs-target="#carouselAdMainImages" data-bs-slide-to="2" aria-label="Slide 3"></button>';
        html +='</div>';
        html +='<div class="carousel-inner">';
        if (item.images.hasOwnProperty('main')) {
            html +='<div class="carousel-item active">';
            html +='<object>';
            html +='<a href="'+item.images.main+'" data-toggle="lightbox" data-gallery="mixedgallery">';
            html +='<img src="'+item.images.main+'" class="d-block w-100 " alt="...">';
            html +='</a> ';
            html +='</object> ';
            html +='</div>';
            //html +='<img src="'+item.images.main+'" class="card-img h-100" alt="...">';
            }else{
                html +='<div class="carousel-item active">';
                html +='<object>';
                html +='<a href="'+item.images+'" data-toggle="lightbox" data-gallery="mixedgallery">';
                html +='<img src="'+item.images+'" class="d-block w-100" alt="...">';
                html +='</a> ';
                html +='</object> ';
                html +='</div>';
                //html +='<img src="'+item.images+'" class="card-img h-100" alt="...">';
            }
    
        html +='<div class="carousel-item">';
        html +='<object>';
        html +='</a>'; 
        html +='</object> ';
        html +='</div>';
        html +='<div class="carousel-item">';
          html +='<object>';
            html +='<a href="assets/img/items/item-3.png" data-toggle="lightbox" data-gallery="mixedgallery"> ';
            html +='<img src="assets/img/items/item-3.png" class="d-block w-100 h-100" alt="...">';
            html +='</a> ';
          html +='</object> ';
        html +='</div>';
        html +='</div>';
        html +='<button class="carousel-control-prev" type="button" data-bs-target="#carouselAdMainImages" data-bs-slide="prev">';
        html +='<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
        html +='<span class="visually-hidden">Previous</span>';
        html +='</button>';
        html +='<button class="carousel-control-next" type="button" data-bs-target="#carouselAdMainImages" data-bs-slide="next">';
        html +='<span class="carousel-control-next-icon" aria-hidden="true"></span>';
        html +='<span class="visually-hidden">Next</span>';
        html +='</button>';
        html +='</div>';      
        html +='</div>';

    }else{
        html +='<div class="col-4 col-sm-3 position-relative">';
        if (item.images.hasOwnProperty('main')) {
            html +='<img src="'+item.images.main+'" class="card-img h-100" alt="...">';
        }else{
            html +='<img src="'+item.images+'" class="card-img h-100" alt="...">';
        }
        html +='</div>'; 
    } 
          
        html +='<div class="col-8 col-sm-9">';
        html +='<div class="card-body">';
        html +='<h5 class="card-title fw-bold">'+item.title+'</h5>';
        if (item.hasOwnProperty('description')) {
         html +='<p class="card-text">'+item.description.short+'</p>';
        }
        html +='<p class="card-price">'+item.price+' '+currency+'</p>';
        html +='<hr>';
        html +='<div class="card-body-btn">';
        if(item.is_favorite){
            html +='<span class="text-success"><i class="bi bi-heart text-success"></i> Favourite</span>'; 
        
        }else{
            html +='<span class=""><i class="bi bi-heart"></i> Favourite</span>';
        }
       
        html +='<span class=""><i class="bi bi-clock"></i> '+item.created_at.human+'</span>';
        html +='<span class=""><i class="bi bi-eye"></i>'+item.views+'</span>';
        html +='</div>';
        html +='</div>';
              html +='</div>';
          html +='</div>';
      html +='</a>';
  html +='</div>';
                   
    });
    if(parameters.SaleType==''){
        $('#dataTitle').text('All');
    }else{
        $('#dataTitle').text(parameters.SaleType);
    }
    //alert(parameters.propertyRegion);
    if(parameters.propertyRegion=='' || parameters.propertyRegion=='Area or Region'){
        $('#dataRegion').text('All Regions');
    }else{
        $('#dataRegion').text(TownText);
    }
   return html;
}
const adDetails=function(data){
    var htmlTop='';
    var htmlBot='';
    $('title').text(data.title);
    $('#ad-title').text(data.title);
    $('#ad-top-details').html('');
    htmlTop +='<div class="row">';
    htmlTop +='<div class="col-sm-4">';
    htmlTop +='<div class="ad-top-details-items">';
    htmlTop +='<div class=""> <span class="sp1"><i class="bi bi-geo-alt"></i></span><span class="sp2">'+data.location.town_title+'</span></div>';
    htmlTop +='<div class=""> <span class="sp1">'+Price+' </span>  <span class="sp2">'+data.price+' '+currency+'</span></div>';
    htmlTop +='</div>';
    htmlTop +='</div>';
    htmlTop +='<div class="col-sm-1">';
    htmlTop +='</div>';
    htmlTop +='<div class="col-sm-7"> '; 
    htmlTop +='<div class="ad-top-details-items">';

     if(data.is_favorite){
        htmlTop +='<div class="text-success"><span class="sp1 text-success"><i class="bi bi-heart"></i> </span> <span class="sp2 text-success">'+Favourite+'</span></div>';
     }else{
        htmlTop +='<div class="make_favourite"  data-id="'+data.id+'"><span class="sp1"><i class="bi bi-heart"></i> </span> <span class="sp2">'+Favourite+'</span></div>';
     }
    
    htmlTop +='<div class=""><span class="sp1"><i class="bi bi-clock"></i> </span> <span class="sp2">'+data.created_at.human+'</span></div>';
    htmlTop +='<div class=""><span class="sp1"><i class="bi bi-eye"></i>   </span> <span class="sp2">'+data.views+'</span></div>';
    htmlTop +='<div class="" ><span class="sp1"><i class="bi bi-share"></i> </span> <span class="sp2" id="shareButton">'+Share+'</span></div>';
    htmlTop +='</div>';
    htmlTop +='</div>';
    htmlTop +='</div>';

    $('#ad-top-details').html(htmlTop);

     htmlBot +='<div class="row">';
     htmlBot +='<div class="col-sm-6"> ';
     htmlBot +='<h5 class="fw-bold">'+Description+'</h5>';
     htmlBot +='<p>'+data.description.original+'</p>';
     htmlBot +='<div class="contact">';
     htmlBot +='<a href="'+data.whatsapp+'" class="btn btn-default btn-border-radius-1 py-2 btn-wts"><i class="bi bi-whatsapp"></i></a>';
     htmlBot +='<a href="tel:'+data.phone+'" class="btn btn-default btn-border-radius-1 py-2 btn-call"><i class="bi bi-telephone"></i> '+Call+'</a> ';  
     htmlBot +='</div>';
     htmlBot +='</div>';
     htmlBot +='<div class="col-sm-6">'; 
     htmlBot +='<div id="carouselExampleCaptions" class="ad-in-view-carousel carousel slide" data-bs-ride="carousel">';

     htmlBot +='<div class="carousel-inner">';
               
     if (data.images.hasOwnProperty('main')) {
        htmlBot +='<div class="carousel-item active bg-1">';
        htmlBot +='<object>';
        htmlBot +='<a href="'+data.images.main+'" data-toggle="lightbox" data-gallery="mixedgallery">';
        htmlBot +='<img src="'+data.images.main+'" class="d-block w-100" alt="...">';
        htmlBot +='</a> ';
        htmlBot +='</object> ';
        htmlBot +='</div>';
        //html +='<img src="'+item.images.main+'" class="card-img h-100" alt="...">';
        }else{
        htmlBot +='<div class="carousel-item active">';
        htmlBot +='<object>';
        htmlBot +='<a href="'+data.images+'" data-toggle="lightbox" data-gallery="mixedgallery">';
        htmlBot +='<img src="'+data.images+'" class="d-block w-100 " alt="...">';
        htmlBot +='</a> ';
        htmlBot +='</object> ';
        htmlBot +='</div>';
            //html +='<img src="'+item.images+'" class="card-img h-100" alt="...">';
        }
             
    //  htmlBot +='<div class="carousel-item bg-2">   ';   
    //  htmlBot +='<a href="assets/img/items/item-2.png" data-toggle="lightbox" data-gallery="mixedgallery">';
    //  htmlBot +='<img src="assets/img/items/item-2.png" class="d-block w-100 h-100" alt="...">';
    //  htmlBot +='</a> ';
    //  htmlBot +='</div>';
             
    //  htmlBot +='<div class="carousel-item bg-3">   ';   
    //  htmlBot +='<a href="assets/img/items/item-3.png" data-toggle="lightbox" data-gallery="mixedgallery">';
    //  htmlBot +='<img src="assets/img/items/item-3.png" class="d-block w-100 h-100" alt="...">';
    //  htmlBot +='</a>';
    //  htmlBot +='</div>';
             
    //  htmlBot +='<div class="carousel-item bg-4">';      
    //  htmlBot +='<a href="assets/img/items/item.png" data-toggle="lightbox" data-gallery="mixedgallery">';
    //  htmlBot +='<img src="assets/img/items/item.png" class="d-block w-100 h-100" alt="..."> ';
    //  htmlBot +='</a> ';
    //  htmlBot +='</div>';
             
     htmlBot +='</div>'; 
     htmlBot +='<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">';
     htmlBot +='<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
     htmlBot +='<span class="visually-hidden">Previous</span>';
     htmlBot +='</button>';
     htmlBot +='<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">';
     htmlBot +='<span class="carousel-control-next-icon" aria-hidden="true"></span>';
     htmlBot +='<span class="visually-hidden">Next</span>';
     htmlBot +='</button>';
              
     htmlBot +='<div class="carousel-indicators">';
     if (data.images.hasOwnProperty('main')) {
         htmlBot +='<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"><img class="d-block w-100" src="'+data.images.main+'" class="img-fluid"></button>';
         // html +='<img src="'+item.images.main+'" class="card-img h-100" alt="...">';
        }else{
            htmlBot +='<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"><img class="d-block w-100" src="'+data.images+'" class="img-fluid"></button>';
        
        }

     //htmlBot +='<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"><img class="d-block w-100" src="assets/img/items/item-2.png" class="img-fluid"></button>';
     //htmlBot +='<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"><img class="d-block w-100" src="assets/img/items/item-3.png" class="img-fluid"></button>';
     //htmlBot +='<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"><img class="d-block w-100" src="assets/img/items/item.png" class="img-fluid"></button>';
     htmlBot +='</div> ';     
     htmlBot +='</div>';  
     htmlBot +='</div>';
     htmlBot +='</div>';
     $('#ad-bot-details').html(htmlBot);
}

$(document).ready(function() {
    // Handle click event on elements with the specified class
    $(document.body).on("click", ".card-feature", function() {
      // Get the data-id attribute value
      var dataId = $(this).data("id");
      var loadId = '';
      //var divId =$('#'+loadId);
      var endpoint ='adDetails';
      var adId = $(this).data("id");
      var per_page =5;
      var userToken = localStorage.getItem('userToken');
      const customHeaders = {
            'Authorization': 'Bearer '+userToken,
        };
       makeAjaxRequest(
          ajax_base_url + endpoint,
          'POST',
          { adId: adId},
          response => {
              if(response.status){
                 // console.log(response.data);
                  adDetails(response.data);
                  var location = response.data.location;
                  if (location.length > 0) {
                    $('#SameRegionAds'),text(location.town_title);
                  }
                  var similarAds = response.data.similarAds
                  
                  if (similarAds.length > 0) {
                    var saleAdslist = myListAds(similarAds);
                      if(saleAdslist) {
                          $('#SameRegionAds').html('<div class="row gy-3">'+saleAdslist+'</div>') 
                      }  
                   }
                   $('#ad_modal').show();
               }
          },
          error => {
            console.error('Error:', error);
          },
          customHeaders
        );
      
    });  //Favourite
    $(document.body).on("click", ".make_favourite", function() {
        var userToken = localStorage.getItem('userToken');
        var dataId = $(this).data("id");
        //alert(dataId);
        var myHeaders = new Headers();
        myHeaders.append("Authorization", 'Bearer '+userToken);
        var formdata = new FormData();
        formdata.append("adId", dataId);
            var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: formdata,
            redirect: 'follow'
            };
        fetch(ajax_base_url+"addToFavorite", requestOptions)
        .then(response => response.json())
        .then(result =>{
            if (result.status === true) {
                setMessage('success','Success:'+result.message);
            } else {
                if(result.errors ){
                    var message=   result.message + getError(result.errors);
                }else{
                    var message=   result.message;
                }
                setMessage('error','Error:'+message)
            }
        })
        .catch(error => console.log('error', error));
        
    });
  });
  getSettings();
  getFooterSettings();