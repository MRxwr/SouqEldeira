window.onload = function() {
    // Check if the element with class 'make-ajax-call' exists
    var elements = document.querySelectorAll('.load-ajax-call');
    // Loop through each element
        elements.forEach(function(element) {
            // Your code for each element goes here
            // For example, you can perform an AJAX call for each element
            var loadId = element.id;
            var divId =$('#'+loadId);
            var endpoint =divId.attr('data-endpoint');
            var type =divId.attr('data-type');
            var per_page =5;
            const customHeaders = {};
             makeAjaxRequest(
                ajax_base_url + endpoint,
                'POST',
                { saleId: type,per_page : per_page },
                response => {
                    if(response.status){
                        console.log(loadId);
                        var listData = response.data.offices.data;
                        console.log(listData);
                         if (listData.length > 0) {
                             var Mylist = ListOffices(listData);
                            if(Mylist) {
                                $('#'+loadId).html(Mylist);
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
};

var ListOffices= function(lists){
    console.log(lists);
    var html ='';
    lists.forEach(item => {
        var socials = item.socials
        html +='<div class="col-6 col-lg-4">';
        html +='<div class="card card-office text-center">';
        html +='<a class="card-img" href="office-view?slug='+item.id+'">';
        html +='<img src="'+item.avatar+'" class="img-fluid">';
        html +='</a>';
        html +='<div class="card-body">';
        html +='<h5 class="card-title fw-bold"><a href="office-view?slug='+item.id+'">'+item.name+'</a></h5>';
        html +='<div class="card-social">';
            html +='<ul>';
                html +='<li><a href="'+socials.facebook+'"><i class="bi bi-facebook"></i></a></li>';
                html +='<li><a href="'+socials.twitter+'"><i class="bi bi-twitter-x"></i></a></li>';
                html +='<li><a href="'+socials.instagram+'"><i class="bi bi-instagram"></i></a></li>';
                html +='<li><a href="'+socials.telegram+'"><i class="bi bi-telegram"></i></a></li>';
            html +='</ul>';
        html +='</div>';
        html +='<div class="mx-0"> ';
        if(item.phone){
            html +='<a href="'+item.whatsapp+'" class="btn btn-primary w-100"><i class="bi bi-telephone-fill mx-2"></i>'+Call+'</a>';
        }
         
        html +='</div>';
        html +='</div>';
        html +='</div>';
        html +='</div>';   
    });
    return html;
}

