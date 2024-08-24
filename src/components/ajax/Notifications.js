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
                    var ReadClass='notification-list_unread';
                  }else{
                    var ReadClass='';
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
                  html +='<div class="notification-list_feature-img">';
                    html +='<i class="bi bi-bell"></i> ';
                  html +='</div>';
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