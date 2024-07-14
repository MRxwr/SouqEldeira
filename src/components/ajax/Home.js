window.onload = function() {
    loadProperType();
    loadAreaRegion();
    loadBuildingType();
    var listData = LoadHomeApi();
   
    // Check if the element with class 'make-ajax-call' exists
    var elements = document.querySelectorAll('.load-ajax-call');
    // Loop through each element
        elements.forEach(function(element) {
            var loadId = element.id;
            var divId =$('#'+loadId);
            
        }); 
};

var LoadHomeApi = function(){
  var listData = '';
  var endpoint ='home';
  var userToken = localStorage.getItem('userToken');
        const customHeaders = {
            'Authorization': 'Bearer '+userToken,
        };
   makeAjaxRequest(
      ajax_base_url + endpoint,
      'POST',
      {},
      response => {
          if(response.status){ 
               listData = response.data;  
               console.log(listData);
              var  homeDetails = listData.homeDetails;  
              var  clients = listData.clients; 
              var  exchangeAds = listData.exchangeAds;
              var  rentAds = listData.rentAds;
              var  saleAds = listData.saleAds;
              var  requestAds = listData.requestAds;
            if (saleAds.length > 0) {
              var saleAdslist = myListAds(saleAds);
                if(saleAdslist) {
                    $('#LatestAdsForSale').html('<div class="row gy-3">'+saleAdslist+'</div>') 
                }  
             }else{
              $('#LatestAdsForSale').html('<div class="row gy-3"><p>No data</p></div>') 
            }
             if (rentAds.length > 0){
                var rentAdslist = myListAds(rentAds);
                if(rentAdslist) {
                    $('#LatestAdsForRent').html('<div class="row gy-3">'+rentAdslist+'</div>') 
                }else{
                  $('#LatestAdsForRent').html('<div class="row gy-3"><p>No data</p></div>') 
                }  
             }else{
              $('#LatestAdsForRent').html('<div class="row gy-3"><p>No data</p></div>') 
            }
             if (exchangeAds.length > 0){
              var exchangAdslist = myListAds(exchangeAds);
               if(exchangAdslist) {
                  $('#LatestAdsForAllowance').html('<div class="row gy-3">'+exchangAdslist+'</div>') 
               }  
             }else{
              $('#LatestAdsForAllowance').html('<div class="row gy-3"><p>No data</p></div>') 
            }
            if (requestAds.length > 0){
              var requestAdslist = myListAds(requestAds);
               if(requestAdslist) {
                  $('#LatestAdsForAnnouncements').html('<div class="row gy-3">'+requestAdslist+'</div>') 
               }  
             }else{
              $('#LatestAdsForAnnouncements').html('<div class="row gy-3"><p>No data</p></div>') 
            }
            
            $('#homeDetails').html(homeDetails.original)
            if (clients.length > 0) {
                var html ='';
                  clients.forEach(item => {
                     html +='<div class="item"><a href="office-view?slug?'+item.id+'"><img src="'+item.images+'" class="w-100"></a></div>';
                  });
                  $('#officesSlider').html(html);
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
                
              }
             

           }
        
      },
      error => {
        console.error('Error:', error);
      },
      customHeaders
    );
    return listData;
}

