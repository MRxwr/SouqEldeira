var per_page =5;
window.onload = function() {
  //$('#NotificationList').html('');
              var per_page =5;
              getNotificationsAds(per_page); 
  };
  document.getElementById('NotificationsLoad').addEventListener('click', function(event) {
    event.preventDefault(); 
    per_page = per_page+5;
    // Your custom JavaScript logic here
    getNotificationsAds(per_page);
  });

  var getNotificationsAds =  function(per_page){
    var Notifications = '';
    var endpoint ='notifications';
              var per_page =per_page;
              var userToken = localStorage.getItem('userToken');
              const customHeaders = {
                    'Authorization': 'Bearer '+userToken,
                };
     makeAjaxRequest(
        ajax_base_url + endpoint,
        'POST',
        {per_page:per_page},
        response => {
            if(response.status){ 
                 Notifications = response.data.messages;  
                 console.log(Notifications);
                var NotificationsList = Notifications.data;
              if (NotificationsList.length > 0) {
                var html ='';
                NotificationsList.forEach(item => {
                  if(item.isRead == false){
                    var ReadClass='notification-list--unread';
                    var actionLink =''
                  }else{
                    var ReadClass='';
                    var iconLink ='<i class="bi bi-trash"></i>'
                  }
                  //console.log(item);
                  html +='<div class="notification-list '+ReadClass+'">';
                  html +='<div class="notification-list_content">';
                  html +='<div class="notification-list_img">';
                  html +='<img src="assets/img/profile.png" class="img-fluid" alt="...">';
                  html +='</div>';
                  html +='<div class="notification-list_detail">';
                  html +='<p><b>'+ item.title+'</b> </p>';
                  html +='<p class="text-muted">'+ item.message+'</p>';
                  html +='<p class="text-muted"><small>'+ item.created_at.human+'</small></p>';
                  html +='</div>';
                  html +='</div>';
                  if(item.isRead == false){
                    html +='<div class="notification-list_feature-img notifyview" data-id="'+item.id+'">';
                    html +='<i class="bi bi-bell"></i> ';
                    html +='</div>';
                  }else{
                    html +='<div class="notification-list_feature-img notifytrash" data-id="'+item.id+'">';
                    html +='<i class="bi bi-trash3"></i> ';
                    html +='</div>';
                  }
                  // html +='<div class="notification-list_feature-img notifyview" data-id="'+item.id+'">';
                  //   html +='<i class="bi bi-bell"></i> ';
                  // html +='</div>';
                  
                  html +='</div>';
                });
                 $('#NotificationList').html(html);
               }else{
                  $('#NotificationList').html('');
               }
             }
        },
        error => {
          console.error('Error:', error);
        },
        customHeaders
      );
  }

  $(document).on("click", ".notifyview", function() {
    var dataId = $(this).data("id");
    var endpoint ='notifications/view';

    var userToken = localStorage.getItem('userToken');
    const customHeaders = {
          'Authorization': 'Bearer '+userToken,
      };
     makeAjaxRequest(
        ajax_base_url + endpoint,
        'POST',
        { id: dataId},
        response => {
          if (response.status === true) {
              setMessage('success','Success:'+response.message);
              location.reload();
          } else {
              if(response.errors ){
                  var message=   response.message + getError(response.errors);
              }else{
                  var message=   response.message;
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
$(document).on("click", ".notifytrash", function() {
  var dataId = $(this).data("id");
  var endpoint ='notifications/delete';

  var userToken = localStorage.getItem('userToken');
  const customHeaders = {
        'Authorization': 'Bearer '+userToken,
    };
   makeAjaxRequest(
      ajax_base_url + endpoint,
      'POST',
      { id: dataId},
      response => {
        if (response.status === true) {
            setMessage('success','Success:'+response.message);
            location.reload();
        } else {
            if(response.errors ){
                var message=   response.message + getError(response.errors);
            }else{
                var message=   response.message;
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