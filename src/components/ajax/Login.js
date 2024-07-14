$(document).ready(function() {
    isLoggedIn();
    $('#login-form').submit(function(e) {
        // Prevent the default form submission
        e.preventDefault();
        var formdata = new FormData();
        formdata.append("email", $("#username").val());
        formdata.append("phoneNumber", $("#username").val());
        formdata.append("password", $("#password").val());

        var requestOptions = {
        method: 'POST',
        body: formdata,
        redirect: 'follow'
        };

        fetch(ajax_base_url+"login", requestOptions)
        .then(response => response.json())
        .then(result => {
            // Assuming the API returns a JSON response with a status field
        //console.log(result);
        if (result.status === true) {
                // Example using localStorage:
                localStorage.setItem('isLoggedIn', 'true');
                // Optionally, store the user data or token in localStorage
                localStorage.setItem('userData', JSON.stringify(result.data));
                localStorage.setItem('userToken', result.data.token);
                setMessage('success','Success:'+result.message);
                window.location.href = '/profile';

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

    $('#register-form').submit(function(e) {
        // Prevent the default form submission
        e.preventDefault();
        var formdata = new FormData();
        formdata.append("name", $('input[name="name"]').val());
        formdata.append("email", $('input[name="email"]').val());
        formdata.append("phone", $('input[name="username"]').val());
        formdata.append("password", $('input[name="password"]').val());
        formdata.append("password_confirmation", $('input[name="repeat_password"]').val());
        formdata.append("type", 'USER');
        var requestOptions = {
        method: 'POST',
        body: formdata,
        redirect: 'follow'
        };

        fetch(ajax_base_url+"register", requestOptions)
        .then(response => response.json())
        .then(result => {
            // Assuming the API returns a JSON response with a status field
        //console.log(result);
        if (result.status === true) {
                // Example using localStorage:
                //localStorage.setItem('isLoggedIn', 'true');
                // Optionally, store the user data or token in localStorage
                //localStorage.setItem('userData', JSON.stringify(result.data));
                //localStorage.setItem('userToken', result.data.token);
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
    });
});