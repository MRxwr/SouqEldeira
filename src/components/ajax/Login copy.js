$(document).ready(function() {
   
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
                isLoggedIn();
            } else {
                console.error('Login failed:', result.error);
                localStorage.setItem('isLoggedIn', 'false');
            }
        })
        .catch(error => console.log('error', error));
    });
});