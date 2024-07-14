var ajax_base_url = 'https://www.souqeldeira.com/api/';
var pay_redirect_to  = 'http://souqeldeiradev.assima.com.kw/success';
var currency='KD';
 // This could be dynamically set
 var makeAjaxRequest = function(url, method = 'GET', data = null, successCallback = null, errorCallback = null, headers = {}) {
  const dynamicAcceptLanguage =$('html').attr('lang');
  const options = {
      method: method,
      headers: {
        'Content-Type': 'application/json', // Default content type, modify as needed
        'Accept': 'application/json',
        'Accept-Language': dynamicAcceptLanguage, // Dynamic value for Accept-Language
        ...headers, // Merge with additional headers
      },
    };
  
    if (data) {
      options.body = JSON.stringify(data);
    }
   
    fetch(url, options)
      .then(response => {
        if (!response.status) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
      })
      .then(response => {
        if (successCallback) {
          successCallback(response);
        }
      })
      .catch(error => {
        if (errorCallback) {
          errorCallback(error);
        } else {
          console.error('Error in AJAX request:', error);
        }
      });
  }
  var getURLParameters = function () {
    const urlParams = new URLSearchParams(window.location.search);
    const params = {};
    urlParams.forEach((value, key) => {
      params[key] = value;
    });
    return params;
  }
  var getSettings = function(){
    var endpoint ='settings';
    const customHeaders = {};
    makeAjaxRequest(
       ajax_base_url + endpoint,
       'POST',
       {},
       response => {
           if(response.status){
            var lists = response;
                console.log(response.data);  
            }
         
       },
       error => {
         console.error('Error:', error);
       },
       customHeaders
     );
  }
  var loadProperType = function(){
    var endpoint ='saleType';
    const customHeaders = {};
    makeAjaxRequest(
       ajax_base_url + endpoint,
       'POST',
       {},
       response => {
           if(response.status){
            var lists = response.data.sales;
               // console.log(lists);
                if (Array.isArray(lists)) {
                    var html = '';
                    lists.forEach(item => {
                        html += '<div class="radio-btn">';
                        html += '<input type="radio" id="aSale' + item.saleId +'" name="SaleType" value="' + item.saleId + '" />';
                        html += '<label for="aSale'+ item.saleId +'">' + item.SaleName + '</label>';
                        html += '</div>';
                    });
                // Your further logic with the generated HTML
                } else {
                console.error('response.data is not an array.');
                }
                $('#saleType').html(html);
            }
         
       },
       error => {
         console.error('Error:', error);
       },
       customHeaders
     );
}
var loadBuildingType = function(){
    var endpoint ='buildingType';
    const customHeaders = {};
    makeAjaxRequest(
       ajax_base_url + endpoint,
       'POST',
       {},
       response => {
        if(response.status){
            var lists = response.data.buildingType;
                //console.log(lists);
                if (Array.isArray(lists)) {
                    const dropdown = document.getElementById('buildingType');
                    while (dropdown.options.length > 1) {
                        dropdown.remove(1);
                      }
                    var html = '';
                    lists.forEach(item => {
                        const newOption = document.createElement('option');
                        newOption.value = item.typeId;
                        newOption.text = item.typeName;
                        dropdown.add(newOption);  
                    });
                // Your further logic with the generated HTML
                } else {
                console.error('response.data is not an array.');
                }
               
            }
         
       },
       error => {
         console.error('Error:', error);
       },
       customHeaders
     );
}
var loadAreaRegion = function(){
    var endpoint ='governorates';
    const customHeaders = {};
    makeAjaxRequest(
       ajax_base_url + endpoint,
       'POST',
       {},
       response => {
        if(response.status){
            var lists = response.data.governorates;
               / // console.log(lists);
                if (Array.isArray(lists)) {
                    const dropdown = document.getElementById('governoratesRegion');
                    // while (dropdown.options.length > 1) {
                    //     dropdown.remove(1);
                    //   }
                    var html = '';
                    lists.forEach(governorate => {
                      const optgroup = document.createElement('optgroup');
                      optgroup.label = governorate.governorateName;
                      governorate.towns.forEach(town => {
                        const newOption = document.createElement('option');
                        newOption.value = town.townId;
                        newOption.text = town.townName;
                        optgroup.appendChild(newOption);
                      });
                      dropdown.appendChild(optgroup);
                    });
                    
                    
                } else {
                console.error('response.data is not an array.');
                }
                //$('#saleType').html(html);
            }
       },
       error => {
         console.error('Error:', error);
       },
       customHeaders
     );
}
var loadFooterContent = function(){
  
}