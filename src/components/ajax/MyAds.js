var per_page =10;
document.getElementById('view-more-ads').addEventListener('click', function(event) {
    event.preventDefault(); 
    per_page = per_page+5;
    // Your custom JavaScript logic here
    MyAdsLoad(per_page,'cuurrent-ads');
  });
  document.getElementById('My-Ended-view-more').addEventListener('click', function(event) {
    event.preventDefault(); 
    per_page = per_page+5;
    // Your custom JavaScript logic here
    MyAdsLoad(per_page,'ended-ads');
  });
  document.getElementById('Favourite-view-more').addEventListener('click', function(event) {
    event.preventDefault(); 
    per_page = per_page+5;
    // Your custom JavaScript logic here
    MyAdsLoad(per_page,'MyFavouriteAds');
  });
  
			
			
window.onload = function() {
    isLoggedOut();
    MyAdsLoad(per_page ,'cuurrent-ads');
    MyAdsLoad(per_page ,'ended-ads');
    MyAdsLoad(per_page ,'MyFavouriteAds');
    $('body').on('click', '.delete', function(event) {
        // Retrieve the data-item-id attribute to get the ID of the clicked element
        var itemId = $(this).attr('data-id');
        var endpoint ='my-ads/delete';
        var userToken = localStorage.getItem('userToken');
        const customHeaders = {
            'Authorization': 'Bearer '+userToken,
        };
         makeAjaxRequest(
            ajax_base_url + endpoint,
            'POST',
            { id: itemId },
            response => {
                if(response.status){
                    setMessage('success','Success:'+result.message);
                    location.reload();
                }else{
                    if(result.errors ){
                        var message=   result.message + getError(result.errors);
                    }else{
                        var message=   result.message;
                    }
                    setMessage('error','Error:'+message)   
                } 
            },
            error => {
              console.error('Error:', error);
            },
            customHeaders
          );
    });


    $('#BuyRegular').submit(function(e) {
        e.preventDefault();
        var userToken = localStorage.getItem('userToken');
        var myHeaders = new Headers();
            myHeaders.append("Authorization", "Bearer " + userToken);
       
        var formdata = new FormData();
        formdata.append("count", $("form#BuyRegular .count").val());
        formdata.append("type",'normal');
        formdata.append("redirect_to", pay_redirect_to);
        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: formdata,
            redirect: 'follow'
          };
        fetch(ajax_base_url+"subscription/payAsGo", requestOptions)
        .then(response => response.json())
        .then(result => {
            // Assuming the API returns a JSON response with a status field
        //console.log(result);
        if (result.status === true) {
            if(result.data.redirect_gateway!==null){
                var url = result.data.redirect_gateway;
                window.location.href = url;
             }
            
            } else {
                if(result.errors ){
                    var message=   result.message + getError(result.errors);
                }else{
                    var message=   result.message;
                }
                setMessage('error','Error:'+message)
            }
        })
        .catch(error => {
            setMessage('error','Error : '+error);
        });

    });
    $('#BuySpecial').submit(function(e) {
        e.preventDefault();
        var userToken = localStorage.getItem('userToken');
        var myHeaders = new Headers();
            myHeaders.append("Authorization", "Bearer " + userToken);
        var formdata = new FormData();
        formdata.append("count", $("form#BuySpecial .count").val());
        formdata.append("type", 'premium');
        formdata.append("redirect_to", pay_redirect_to);
        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: formdata,
            redirect: 'follow'
          };
        fetch(ajax_base_url+"subscription/payAsGo", requestOptions)
        .then(response => response.json())
        .then(result => {
            // Assuming the API returns a JSON response with a status field
            //console.log(result);
        if (result.status === true) {
               if(result.data.redirect_gateway!==null){
                  var url = result.data.redirect_gateway;
                  window.location.href = url;
               }
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
    
};

var MyAdsLoad = function(per_page ,loadId){ 
    // Check if the element with class 'make-ajax-call' exists
        var divId =$('#'+loadId);   
        var endpoint =divId.attr('data-endpoint');
        var type =divId.attr('data-type');
        var userToken = localStorage.getItem('userToken');
        const customHeaders = {
            'Authorization': 'Bearer '+userToken,
        };
         makeAjaxRequest(
            ajax_base_url + endpoint,
            'POST',
            { type: type , per_page:per_page},
            response => {
                if(response.status){
                   console.log(loadId);
                   var listData = response.data[0].data;
                    if (listData.length > 0) {
                        if(loadId =='cuurrent-ads' ){
                           var Mylist = myListAds(listData);  
                           if(Mylist){
                               $('#'+loadId).html('<div class="row gy-3">'+Mylist+'</div>')
                           } else{
                               $('#'+loadId).html('<div class="row gy-3">Data not found!!</div>')
                           }
                           //$('#'+loadId).html(Mylist); 
                          }
                        if(loadId =='ended-ads' ){
                            var Myendlist = myEndedAds(listData);  
                            if(Myendlist){
                                $('#'+loadId).html(Myendlist);
                            }else{
                                $('#'+loadId).html('<div class="row gy-3">Data not found!!</div>')
                            }
                         }
                         if(loadId =='MyFavouriteAds' ){
                            if (listData.length > 0) {
                                var Mylist = myListAds(listData);
                                  if(Mylist) {
                                      $('#'+loadId).html('<div class="row gy-3">'+Mylist+'</div>') 
                                  }else{
                                    $('#'+loadId).html('<div class="row gy-3">Data not found!!</div>')
                                  }  
                               }
                         }
                      }else{
                          $('#'+loadId).html('<div class="row gy-3">Data not found!!</div>')
                      }
                  }else{
                      if(result.errors ){
                          var message=   result.message + getError(result.errors);
                      }else{
                          var message=   result.message;
                      }
                      setMessage('error','Error:'+message)
                  }
            },
            error => {
              console.error('Error:', error);
            },
            customHeaders
          );
    
}
$(document).on("click", ".paynow", function() {
// Retrieve the value of the data-id attribute
var dataId = $(this).data("id");
console.log(dataId);
var userToken = localStorage.getItem('userToken');
var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer " + userToken);
var formdata = new FormData();
            formdata.append("id", dataId);
            formdata.append("redirect_to", pay_redirect_to);
var requestOptions = {
    method: 'POST',
    headers: myHeaders,
    body: formdata,
    redirect: 'follow'
  };
fetch(ajax_base_url+"subscription/package", requestOptions)
.then(response => response.json())
.then(result => {
    // Assuming the API returns a JSON response with a status field
 //console.log(result);
if (result.status === true) {
       if(result.data.redirect_gateway!==null){
          var url = result.data.redirect_gateway;
          window.location.href = url;
       }
    }else {
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


var myListAds= function(lists){
    var html ='';
    lists.forEach(item => {
        const dateString = item.created_at.system;
        const date = new Date(dateString);
        const formattedDate = date.toLocaleDateString('en-GB'); // Adjust the locale based on your preference
            html +='<div class="my-ad-list-item my-2"> ';
            html +='<div class="row g-1"> ';
            html +='<div class="col-md-8 my-ad-list-item-side1">  ';
            html +='<img src="'+item.images.main+'" class="img-fluid" alt="...">';
            html +='<div class="data">';
            html +='<h4>'+item.title+'</h4>';
            html +='<h5>'+item.description.short+'</h5>';
            html +='<h6>Created Date  '+formattedDate+'</h6>';
            html +='</div>'; 
            html +='</div>';
            html +='<div class="col-md-4 my-ad-list-item-side2">';    
            html +='<div class="viewers"><i class="bi bi-eye"></i>'+item.views+'</div>';
            html +='<div class="status"><span class="published ad-status-type"><i class="bi bi-check"></i></span></div>';
            html +='<div class="actions">';
            html +='<a href="edit-ad?slug='+item.id+'" class="update"><i class="bi bi-pencil-square"></i></a>';
            html +='<a  class="delete" data-id="'+item.id+'" ><i class="bi bi-trash3"></i></a>';
            html +='</div> ';
            html +='</div>';
            html +='</div>';
            html +='</div>';
        //console.error( item);                   
    });
   return html;
}


var myEndedAds= function(lists){
    var html ='';
    lists.forEach(item => {
        const dateString = item.created_at.system;
        const date = new Date(dateString);
        const formattedDate = date.toLocaleDateString('en-GB'); // Adjust the locale based on your preference

        html +='<div class="my-ad-list-item my-2"> ';
        html +='<div class="row g-1"> ';
        html +='<div class="col-md-8 my-ad-list-item-side1">  ';
        html +='<img src="'+item.images.main+'" class="img-fluid" alt="...">';
        html +='<div class="data">';
        html +='<h4>'+item.title+'</h4>';
        html +='<h5>'+item.description.short+'</h5>';
        html +='<h6>Created Date &nbsp;&nbsp; '+formattedDate+'</h6>';
        html +='</div>'; 
        html +='</div>';
        html +='<div class="col-md-4 my-ad-list-item-side2">';    
        html +='<div class="viewers"><i class="bi bi-eye"></i>'+item.views+'</div>';
        //html +='<div class="status"><span class="published ad-status-type"><i class="bi bi-check"></i></span></div>';
        html +='<div class="actions">';
        html +='<a href="javascript:void(0);" class="republish" data-id="'+item.id+'"><i class="bi bi-arrow-repeat"></i> Republish </a>';
        //html +='<a href="#!" class="update"><i class="bi bi-pencil-square"></i></a>';
        //html +='<a href="#!" class="delete"><i class="bi bi-trash3"></i></a>';
        html +='</div> ';
        html +='</div>';
        html +='</div>';
        html +='</div>';
        //console.error( item);                   
    });
   return html;
}


var getSubcription = function(){
    // Prevent the default form submission
    var userToken = localStorage.getItem('userToken');
    var myHeaders = new Headers();
        myHeaders.append("Authorization", "Bearer " + userToken);
    var formdata = new FormData();
    var requestOptions = {
        method: 'POST',
        headers: myHeaders,
        body: formdata,
        redirect: 'follow'
      };

    fetch(ajax_base_url+"subscription/list", requestOptions)
    .then(response => response.json())
    .then(result => {
        // Assuming the API returns a JSON response with a status field
    //console.log(result);
      if (result.status === true) {
        var balanceKeys = Object.keys(result.data.balance);
        //console.log(balanceKeys.length);
            if(balanceKeys.length>0){
                var balance = result.data.balance;
                $('#normal').text(balance.normal);
                $('#premium').text(balance.premium);
            }
        var pay_as_go_priceKeys = Object.keys(result.data.pay_as_go_price);
            if(pay_as_go_priceKeys.length>0){
                var PayAsgoPrice  = result.data.pay_as_go_price;
                $('#pp_normal').text(PayAsgoPrice.normal);
                $('#pp_premium').text(PayAsgoPrice.premium);
            }
        var  packagesKeys = Object.keys(result.data.packages);
         //console.log(result.data.packages);
           if(packagesKeys.length>0){
            var html ='';
           var packages =result.data.packages;
            packages.forEach(item => {
                html +='<div class="col-md-6"> ';
                html +='<div class="package-data">';
                html +='<div class="img">';
                html +='<img src="'+item.image+'" class="img-fluid" alt="..."> ';
                html +='</div>';
                html +='<div class="data">';
                html +='<span class="title">'+item.name+' - 1</span>';  
                html +='<span class="content">'+Price+' : '+item.price+' '+currency+'</span>';
                html +='<span class="content">'+RegularAd+' : '+item.adv_normal_count+' </span>';
                html +='<span class="content">'+SpecialAd+' : '+item.adv_premium_count+' </span> ';
                html +='<span class="content">'+ExpireData+' : '+item.expire_time+' Days</span>';
                html +='</div>';
                html +='<div class="buy">';
                html +='<a href="javascript:void(0)" class="btn btn-primary py-0 btn-sm paynow" data-id="'+item.id+'"><span id="loadingIndicator" class="loadingIndicator spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>'+Pay+'</a>';  
                html +='</div>';
                html +='</div>';
                html +='</div>';
            });
            $('#PackageDataDiv').html(html);
           }else{
            $('#PackageDataDiv').html('');
           }
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
}
getSubcription();

$(document).on("click", ".republish", function() {
    var dataId = $(this).data("id");
    var endpoint ='my-ads/repost';
    var userToken = localStorage.getItem('userToken');
    const customHeaders = {
          'Authorization': 'Bearer '+userToken,
      };
     makeAjaxRequest(
        ajax_base_url + endpoint,
        'POST',
        { id: dataId},
        response => {
          if (result.status === true) {
              setMessage('success','Success:'+result.message);
              location.reload();
          } else {
              if(result.errors ){
                  var message=   result.message + getError(result.errors);
              }else{
                  var message=   result.message;
              }
              setMessage('error','Error:'+message)
          }
        },
        error => {
          console.error('Error:', error);
        },
        customHeaders
      );
});
