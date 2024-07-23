window.onload = function() {
    isLoggedOut();
    loadProperType();
    loadAreaRegion();
    loadBuildingType();
};
$(document).ready(function() {
    $('#fileI1nputFld').change(function() {
        displaySelectedFiles(this,'file1Input');
    });
    $('#fileI2nputFld').change(function() {
        displaySelectedFiles(this,'file2Input');
    });
    $('#fileI3nputFld').change(function() {
        displaySelectedFiles(this,'file3Input');
    });
    $('#fileI4nputFld').change(function() {
        displaySelectedFiles(this,'file4Input');
    });
});

function displaySelectedFiles(input,preview) {
    var filePreview  = $('#'+preview);
    filePreview.empty(); // Clear previous file list

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            filePreview.append('<img src="' + e.target.result + '" alt="File Preview" style="width:100%">');
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        filePreview.html('No file selected');
    }
}

$('#add-ad-form').submit(function(e) {
    // Prevent the default form submission
    e.preventDefault();
    var userToken = localStorage.getItem('userToken');
    var myHeaders = new Headers();
        myHeaders.append("Authorization", "Bearer " + userToken);
    var file1Input = document.getElementById('fileI1nputFld');
    var SaleType = $('input[name="SaleType"]:checked').val();
    var is_featured = $('input[name="is_featured"]:checked').val();
    var formdata = new FormData();
        formdata.append("type", SaleType);
        formdata.append("field", SaleType);
        formdata.append("is_featured", is_featured);
        formdata.append("region_id", $("#governoratesRegion").val());
        formdata.append("building_type_id", $("#buildingType").val());
        formdata.append("name", $("#name").val());
        formdata.append("text", $("#description").val());
        formdata.append("description", $("#description").val());
        formdata.append("price", $("#price").val());
        formdata.append("phone", $("#phone").val());
        //formdata.append("telegram", $("#telegram").val());
        //formdata.append("website", $("#website").val());
    if (file1Input.files.length > 0) {
        const galleryFiles = file1Input.files;
        formdata.append('image',file1Input.files[0]);
        for (let i = 0; i < galleryFiles.length; i++) {
            formData.append('gallery[]', galleryFiles[i]);
        }
    }
    var requestOptions = {
        method: 'POST',
        headers: myHeaders,
        body: formdata,
        redirect: 'follow'
      };

    fetch(ajax_base_url+"my-ads/create", requestOptions)
    .then(response => response.json())
    .then(result => {
        // Assuming the API returns a JSON response with a status field
    //console.log(result);
    if (result.status === true) {
           $('#add-ad-form')[0].reset();
            setMessage('success','Success:'+result.message);
            setTimeout(function() {
                location.reload();
            }, 2000);
        } else {
            if(result.errors){
                console.log(result.errors);
                var message=   result.message +  getError(result.errors);
            }else{
                var message=   result.message;
            }
            setMessage('error','Error:'+message)
        }
    })
    .catch(error => console.log('error', error));
});

$(document).on('click', '#shareButton', function() {
    if (navigator.share) {
        navigator.share({
            title: document.title,
            text: 'Check out this site!',
            url: window.location.href
        }).then(() => {
            console.log('Thanks for sharing!');
        }).catch((error) => {
            console.log('Error sharing:', error);
        });
    } else {
        alert('Web Share API is not supported in your browser.');
    }
});
