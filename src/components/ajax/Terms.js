window.onload = function() {
    var endpoint ='terms';
    const customHeaders = {};
    makeAjaxRequest(
       ajax_base_url + endpoint,
       'POST',
       {},
       response => {
           if(response.status){
            var data = response.data.terms_condition.original;
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