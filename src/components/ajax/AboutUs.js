window.onload = function() {
    var endpoint ='aboutUs';
    const customHeaders = {};
    makeAjaxRequest(
       ajax_base_url + endpoint,
       'POST',
       {},
       response => {
           if(response.status){
            var data = response.data;
                console.log(data);
               
                $('#Content').html(html);
            }
         
       },
       error => {
         console.error('Error:', error);
       },
       customHeaders
     );
};