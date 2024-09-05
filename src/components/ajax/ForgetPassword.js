$(document).ready(function() {
    $('#forget-password-form').submit(function(e) {
        // Prevent the default form submission
        e.preventDefault();
        var formdata = new FormData();
        formdata.append("email", $("#username").val());
        formdata.append("phone", $("#username").val());
        
        var requestOptions = {
        method: 'POST',
        body: formdata,
        redirect: 'follow'
        };

        fetch(ajax_base_url+"forgetPassword", requestOptions)
        .then(response => response.json())
        .then(result => {
        if (result.status === true) {
                setMessage('success','Success:'+result.message);
            } else {
                if(result.errors ){
                    var message=   result.message + getError(result.errors);
                    $('forget-password-form').display = "none";
                    $('fforget-password-verify-form').display = "block";
                }else{
                    var message=   result.message;
                }
                setMessage('error','Error:'+message)
            }
        })
        .catch(error => console.log('error', error));
    });
    $('#forget-password-verify-form').submit(function(e) {
        // Prevent the default form submission
        e.preventDefault();
        var formdata = new FormData();
        formdata.append("email", $("#username").val());
        formdata.append("phone", $("#username").val());
        formdata.append("password", $("#password").val());
        formdata.append("code", $("#code").val());
        var requestOptions = {
        method: 'POST',
        body: formdata,
        redirect: 'follow'
        };

        fetch(ajax_base_url+"forgetPassword", requestOptions)
        .then(response => response.json())
        .then(result => {
        if (result.status === true) {
                setMessage('success','Success:'+result.message);
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