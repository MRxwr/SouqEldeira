window.onload = function() {
    const parameters = getURLParameters();
     console.log(parameters.slug);
      // Check if the element with class 'make-ajax-call' exists
       
              var loadId = '';
              //var divId =$('#'+loadId);
              var endpoint ='adDetails';
              var adId =parameters.slug;
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
                          console.log(response.data);
                          adDetails(response.data);
                          var location = response.data.location;
                          if (location.length > 0) {
                            //aleart(location.town_title);
                            $('#SameRegionAds'),text(location.town_title);
                          }
                          var similarAds = response.data.similarAds
                          
                          if (similarAds.length > 0) {
                            var saleAdslist = myListAds(similarAds);
                              if(saleAdslist) {
                                  $('#SameRegionAds').html('<div class="row gy-3">'+saleAdslist+'</div>') 
                              }  
                           }
                       }
                  },
                  error => {
                    console.error('Error:', error);
                  },
                  customHeaders
                );
  };
  $(document).on('click', '#shareButton', function() {
    if (navigator.share) {
        navigator.share({
            title: document.title,
            text: 'Check out this site!',
            url: window.location.href
        }).then(() => {
            console.log('Thanks for sharing!');
        }).catch((error) => {
            console.log('Error sharing:', error);
        });
    } else {
        alert('Web Share API is not supported in your browser.');
    }
});