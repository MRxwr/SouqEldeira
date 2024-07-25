window.onload = function() {
    var endpoint ='faq';
    const customHeaders = {};
    makeAjaxRequest(
       ajax_base_url + endpoint,
       'POST',
       {},
       response => {
           if(response.status){
            var newHtml ='';
            var lists = response.data.faqs;
                console.log(lists);
                
                    lists.forEach(item => {
                        newHtml  += '<div class="accordion-item">'; // Start the unordered list
                            newHtml += '<h2 class="accordion-header" id="flush-headingOne">';
                             newHtml += '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">';
                        newHtml +=item.question;
                            newHtml += '</button></h2>';
                                newHtml += '<div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="">';
                                newHtml += '<div class="accordion-body">'+item.answer+'</div>';
                            newHtml += '</div>';
                        newHtml += '</div>'; // End the unordered list
                    });
                
                $('#accordionFlushExample').html(newHtml);
            }
       },
       error => {
         console.error('Error:', error);
       },
       customHeaders
     );
};


