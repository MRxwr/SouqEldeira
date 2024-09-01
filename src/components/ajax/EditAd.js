window.onload = function() {
    
    isLoggedOut();
    loadProperType();
    loadAreaRegion();
    loadBuildingType();
    loadMyadDetail();
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
var loadMyadDetail = function(){
    const parameters = getURLParameters();
    var loadId = '';
              //var divId =$('#'+loadId);
                var endpoint ='my-ads/detail';
                var adId =parameters.slug;
                var per_page =5;
                var userToken = localStorage.getItem('userToken');
                const customHeaders = {
                    'Authorization': 'Bearer '+userToken,
                };
               makeAjaxRequest(
                  ajax_base_url + endpoint,
                  'POST',
                  { id: adId},
                  response => {
                      if(response.status){
                        var data = response.data;
                          console.log(data);
                          $('#aSale'+data.type.system).prop('checked', true);
                          if(data.is_featured){
                            $('#aSpecial').prop('checked', true)
                          }else{
                            $('#aRegular').prop('checked', true)
                          }
                          $('#governoratesRegion').val(data.location.town_id)
                          $('#buildingType option:contains("'+data.buildingType+'")').prop('selected', true);
                          //$('#buildingType').val(data.buildingType)
                          $("#price").val(data.price);
                          $("#phone").val(data.phone);
                          $("#description").val(data.description.htmlLess);
                          $("#file1Input").html('<img src="'+data.images.main+'" style="width:100%"/>');
                          if(data.images.other){
                            var items = data.images.other;
                            var pkey=2;
                            items.forEach(dipitem => {
                                $("#file"+pkey+"Input").html('<img src="'+dipitem+'" style="width:100%"/>');
                                pkey++;
                            });
                          }
                       }
                  },
                  error => {
                    console.error('Error:', error);
                  },
                  customHeaders
                );
}

$('#edit-ad-form').submit(function(e) {
    // Prevent the default form submission
    e.preventDefault();
    const parameters = getURLParameters();
    var adId =parameters.slug;
    var userToken = localStorage.getItem('userToken');
    var myHeaders = new Headers();
        myHeaders.append("Authorization", "Bearer " + userToken);
    var file1Input = document.getElementById('fileI1nputFld');
    var SaleType = $('input[name="SaleType"]:checked').val();
    var is_featured = $('input[name="is_featured"]:checked').val();
    var formdata = new FormData();
        formdata.append("id", adId);
        formdata.append("type", SaleType);
        formdata.append("field", SaleType);
        formdata.append("is_featured", is_featured);
        formdata.append("region_id", $("#governoratesRegion").val());
        formdata.append("building_type_id", $("#buildingType").val());
        formdata.append("text", $("#description").val());
        formdata.append("price", $("#price").val());
        formdata.append("phone", $("#phone").val());
    if (file1Input.files.length > 0) {
        formdata.append('image',file1Input.files[0]);
    }
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

    fetch(ajax_base_url+"my-ads/edit", requestOptions)
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