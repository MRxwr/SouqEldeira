$(document).ready(function() {
    isLoggedOut();
    getProfile();
    $('#changeProfileImage').click(function() {
        $('#fileInput').click();
    });

    $('#profile-form').submit(function(e) {
        // Prevent the default form submission
        e.preventDefault();
        var userToken = localStorage.getItem('userToken');
        var myHeaders = new Headers();
            myHeaders.append("Authorization", "Bearer " + userToken);
        var fileInput = document.getElementById('fileInput');
        var formdata = new FormData();
        formdata.append("name", $("#name").val());
        formdata.append("email", $("#email").val());
        formdata.append("phone", $("#phone").val());
        formdata.append("description", $("#description").val());
        formdata.append("facebook", $("#facebook").val());
        formdata.append("twitter", $("#twitter").val());
        formdata.append("instagram", $("#instagram").val());
        formdata.append("telegram", $("#telegram").val());
        formdata.append("website", $("#website").val());
        formdata.append("field", "SALE");
        if (fileInput.files.length > 0) {
            formdata.append('image',fileInput.files[0]);
        }

        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: formdata,
            redirect: 'follow'
          };

        fetch(ajax_base_url+"editProfile", requestOptions)
        .then(response => response.json())
        .then(result => {
            // Assuming the API returns a JSON response with a status field
        //console.log(result);
        if (result.status === true) {
            getProfile();
                setMessage('success','Success:'+result.message);
            } else {
                console.log(result.errors);
                if(result.errors>0 ){
                   
                    var message=   result.message + getError(result.errors);
                }else{
                    var message=   result.message;
                }
                setMessage('error','Error:'+message)
            }
        })
        .catch(error => console.log('error', error));
    });
    $('#change-password-form').submit(function(e) {
        // Prevent the default form submission
        e.preventDefault();
        var userToken = localStorage.getItem('userToken');
        
        var myHeaders = new Headers();
            myHeaders.append("Authorization", "Bearer " + userToken);
          var password = $('input[name="new-password"]').val();
          var confirmPassword = $('input[name="confirm-new-password"]').val();
  
          // Check if the passwords match
          if (password !== confirmPassword) {
              alert('Passwords do not match. Please try again.');
          } else {
              // Passwords match, you can proceed with form submission or other actions
              var formdata = new FormData();
              formdata.append("oldPassword", $('input[name="password"]').val());
              formdata.append("newPassword", $('input[name="new-password"]').val());
              var requestOptions = {
                  method: 'POST',
                  headers: myHeaders,
                  body: formdata,
                  redirect: 'follow'
                };
                fetch(ajax_base_url+"updatePassword", requestOptions)
                .then(response => response.json())
                .then(result => {
                if (result.status === true) {
                    localStorage.setItem('isLoggedIn', 'false');
                    // Optionally, store the user data or token in localStorage
                    localStorage.setItem('userData', '');
                    localStorage.setItem('userToken', '');
                     setMessage('success','Success:'+result.message);
                    window.location.href = '/login';
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
        
    });

});

$(document).on("click", "#DeleteAccount", function() {
    var endpoint ='profile/delete';
    var userToken = localStorage.getItem('userToken');
    const customHeaders = {
          'Authorization': 'Bearer '+userToken,
      };
     makeAjaxRequest(
        ajax_base_url + endpoint,
        'POST',
        { },
        result => {
            if (result.status === true) {
                setMessage('success','Success:'+result.message);
                getLogout();
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
$(document).on("click", "#DowngradeToUser", function() {
   
    var endpoint ='profile/downgrade';
    var userToken = localStorage.getItem('userToken');
    const customHeaders = {
          'Authorization': 'Bearer '+userToken,
      };
     makeAjaxRequest(
        ajax_base_url + endpoint,
        'POST',
        { },
        result => {
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
$(document).on("click", "#UpgradeToOffice", function() {
      var endpoint ='profile/upgrade';
      var userToken = localStorage.getItem('userToken');
      const customHeaders = {
            'Authorization': 'Bearer '+userToken,
        };
       makeAjaxRequest(
          ajax_base_url + endpoint,
          'POST',
          { },
          result => {
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
    
 var getProfile = function() {
        // Prevent the default form submission
        var userToken = localStorage.getItem('userToken');
        console.log(userToken);
        var myHeaders = new Headers();
            myHeaders.append("Authorization", "Bearer " + userToken);
        var formdata = new FormData();
        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: formdata,
            redirect: 'follow'
          };

        fetch(ajax_base_url+"profile", requestOptions)
        .then(response => response.json())
        .then(result => {
            // Assuming the API returns a JSON response with a status field
        //console.log(result);
        if (result.status === true) {
            $('title').text(result.data.name);
                    $('input[name="name"]').val(result.data.name);
                    $('input[name="phone"]').val(result.data.phone);
                    $('input[name="email"]').val(result.data.email);
                    $('input[name="description"]').val(result.data.description);
                    $('input[name="facebook"]').val(result.data.socials.facebook);
                    $('input[name="twitter"]').val(result.data.socials.twitter);
                    $('input[name="instagram"]').val(result.data.socials.instagram);
                    $('input[name="telegram"]').val(result.data.socials.telegram);
                    $('input[name="website"]').val(result.data.socials.website);
                    $('#profileImg').html('<img src="'+result.data.avatar+'" class="img-fluid" alt="...">');

                    if(result.data.type=='USER'){
                        $("#DowngradeToUser").css('display', 'none');
                        $("#UpgradeToOffice").css('display', 'block');
                    }else{
                        $("#UpgradeToOffice").css('display', 'none');
                        $("#DowngradeToUser").css('display', 'block');
                    }
                
                // Optionally, store the user data or token in localStorage
                localStorage.setItem('userData', JSON.stringify(result.data));
            } else {
                
                setMessage('error','Error:'+result.message);
            }
        })
        .catch(error => console.log('error', error));
    }


    var getLogout = function() {
        // Prevent the default form submission
        var userToken = localStorage.getItem('userToken');
        console.log(userToken);
        var myHeaders = new Headers();
            myHeaders.append("Authorization", "Bearer " + userToken);
        var formdata = new FormData();
        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: formdata,
            redirect: 'follow'
          };
    
        fetch(ajax_base_url+"logout", requestOptions)
        .then(response => response.json())
        .then(result => {
        if (result.status === true) {
            localStorage.setItem('isLoggedIn', 'false');
            // Optionally, store the user data or token in localStorage
            localStorage.setItem('userData', '');
            localStorage.setItem('userToken', '');
            window.location.href = '/login';    
            } else {
                localStorage.setItem('isLoggedIn', 'false');
                // Optionally, store the user data or token in localStorage
                localStorage.setItem('userData', '');
                localStorage.setItem('userToken', '');
                window.location.href = '/login';
            }
        })
        .catch(error => console.log('error', error));
    }