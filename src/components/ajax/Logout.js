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
getLogout();