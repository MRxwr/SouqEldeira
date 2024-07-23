var per_page =5;
window.onload = function() {
  const params = getURLParameters();
$('#dataTitle').text(params.propertyType);
$('#dataRegion').text(params.propertyRegion);
  loadSearchResult(per_page)
};
document.getElementById('searchLoad').addEventListener('click', function(event) {
  event.preventDefault(); 
  per_page = per_page+10;
  //alert(per_page);
  // Your custom JavaScript logic here
  loadSearchResult(per_page)
});
var loadSearchResult = function(per_page){
  const parameters = getURLParameters();

  // Check if the element with class 'make-ajax-call' exists
  var elements = document.querySelectorAll('.load-ajax-call');
  var TownText ='';
  // Loop through each element
      elements.forEach(function(element) {
          // Your code for each element goes here
          // For example, you can perform an AJAX call for each element
          
          var loadId = element.id;
          var divId =$('#'+loadId);
          var endpoint =divId.attr('data-endpoint');
          var type =parameters.SaleType;
          var region =parameters.propertyRegion;
          var propertyType =parameters.propertyType;
          var priceFrom =parameters.propertyPriceFrom;
          var priceTo =parameters.propertyPriceTo;
          var userToken = localStorage.getItem('userToken');
          const customHeaders = {
              'Authorization': 'Bearer '+userToken,
          };
           makeAjaxRequest(
              ajax_base_url + endpoint,
              'POST',
              { saleId: type,townId:region,propertyType:propertyType,priceFrom:priceFrom,priceTo:priceTo,per_page : per_page },
              response => {
                  if(response.status){
                      console.log(loadId);
                      var listData = response.data.data;
                       if (listData.length > 0) {
                          var Mylist = myListAds(listData);
                          if(Mylist) {
                            $('#'+loadId).html('<div class="row gy-3">'+Mylist+'</div>') 
                          }   
                         }
                   }
              },
              error => {
                console.error('Error:', error);
              },
              customHeaders
            );
      });
}

