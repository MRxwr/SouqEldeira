window.onload = function() {
    var endpoint ='aboutUs';
    const customHeaders = {};
    makeAjaxRequest(
       ajax_base_url + endpoint,
       'POST',
       {},
       response => {
           if(response.status){
            var data = response.data.aboutUs.original;
                console.log(data);
                $('#Content').html(data);
            }
         
       },
       error => {
         console.error('Error:', error);
       },
       customHeaders
     );
};