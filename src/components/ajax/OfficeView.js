var per_page =5;
var id= 0;
window.onload = function() {
 
    const parameters = getURLParameters();
            //console.log(parameters.slug);
              var endpoint ='office';
              var adId =parameters.slug;
              var per_page =5;
              const customHeaders = {};
               makeAjaxRequest(
                  ajax_base_url + endpoint,
                  'POST',
                  { id: adId},
                  response => {
                      if(response.status){
                        var html ='';
                        var data = response.data.office;
                        //console.log(data);
                        $('title').text(data.name);
                          html +='<div class="card card-office text-center" style="height: auto;">';
                          html +='<a class="card-img" href="office-view?slug='+adId+'">';
                          html +='<img src="'+data.avatar+'" class="img-fluid">';
                          html +='</a>';
                          html +='<div class="card-body">';
                          html +='<h5 class="card-title fw-bold mb-5"><a href="office-view.php">'+data.name+'</a></h5>';
                          html +='<div class="card-social mb-5">';
                          html +='<ul>';
                          html +='<li><a href="'+data.socials.facebook+'"><i class="bi bi-facebook"></i></a></li>';
                          html +='<li><a href="'+data.socials.twitter+'"><i class="bi bi-twitter-x"></i></a></li>';
                          html +='<li><a href="'+data.socials.instagram+'"><i class="bi bi-instagram"></i></a></li>';
                          html +='<li><a href="'+data.socials.telegram+'"><i class="bi bi-telegram"></i></a></li>';
                          html +='</ul>';
                          html +='</div>';
                          html +='<div class="mx-0">'; 
                          html +='<a href="'+data.socials.website+'" class="webURL w-100">';
                          html +='<i class="bi bi-link-45deg mx-2"></i>'; 
                          html +='<span>'+data.socials.website+'</span>';
                          html +='</a>';
                          html +='</div>';
                          html +='<div class="office-side-desc"> '; 
                          html +='<div class="office-description my-3"> ';
                          //html +='<h3 class="mb-2">'+Description+'</h3>';
                          //html +='<p>office-description</p> ';
                          html +='</div>';
                          html +='<div class="mx-0"> ';
                          html +='<a href="tel:'+data.phone+'" class="btn btn-primary px-4"><i class="bi bi-telephone-fill mx-2"></i>'+Call+'</a>';
                          html +='</div>';
                          html +='</div>';
                            
                          html +='</div>';
                          html +='</div>';
                          $('#OfficeView').html(html);
                          getAgentAds(per_page);
                       }
                  },
                  error => {
                    console.error('Error:', error);
                  },
                  customHeaders
                );
         
  
      
  };
  document.getElementById('OfficeAdsLoad').addEventListener('click', function(event) {
    event.preventDefault(); 
    per_page = per_page+5;
    // Your custom JavaScript logic here
    getAgentAds(per_page);
  });

  var getAgentAds =  function(per_page){
    const parameters = getURLParameters();
    var id =parameters.slug;
    var listData = '';
    var endpoint ='search';
    var userToken = localStorage.getItem('userToken');
          const customHeaders = {
              'Authorization': 'Bearer '+userToken,
          };
     makeAjaxRequest(
        ajax_base_url + endpoint,
        'POST',
        {agency_id:id,per_page:per_page},
        response => {
            if(response.status){ 
                 listData = response.data;  
                 console.log(listData);
                var officeAds = listData.data;
              if (officeAds.length > 0) {
                var saleAdslist = myListAds(officeAds);
                  if(saleAdslist) {
                      $('#LatestAdsForSale').html('<div class="row gy-3">'+saleAdslist+'</div>') 
                  }  
               }
               
             }
          
        },
        error => {
          console.error('Error:', error);
        },
        customHeaders
      );
  }