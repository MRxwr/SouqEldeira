/*Tinymce Init*/

$(function() {
	"use strict";

	function uploadEditorImage(file, success, failure, progress) {
		var xhr = new XMLHttpRequest();
		var formData = new FormData();

		xhr.open('POST', 'upload-editor-image.php');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

		xhr.upload.onprogress = function(event) {
			if (progress && event.lengthComputable) {
				progress(event.loaded / event.total * 100);
			}
		};

		xhr.onload = function() {
			var response;

			try {
				response = JSON.parse(xhr.responseText);
			} catch (error) {
				failure('The server returned an invalid upload response.');
				return;
			}

			if (xhr.status < 200 || xhr.status >= 300 || !response.location) {
				failure(response.error || 'Image upload failed.');
				return;
			}

			success(response.location);
		};

		xhr.onerror = function() {
			failure('Image upload failed because of a network error.');
		};

		formData.append('file', file, file.name);
		xhr.send(formData);
	}
	
	tinymce.init({
	  selector: '.tinymce',
	  height: 300,
	  automatic_uploads: true,
	  file_picker_types: 'image',
	  images_upload_handler: function(blobInfo, success, failure, progress) {
		uploadEditorImage(blobInfo.blob(), success, failure, progress);
	  },
	  file_picker_callback: function(callback, value, meta) {
		if (meta.filetype !== 'image') {
			return;
		}

		var input = document.createElement('input');
		input.setAttribute('type', 'file');
		input.setAttribute('accept', 'image/jpeg,image/png,image/gif,image/webp');

		input.onchange = function() {
			var file = this.files[0];
			if (!file) {
				return;
			}

			uploadEditorImage(file, function(location) {
				callback(location, { alt: file.name.replace(/\.[^.]+$/, '') });
			}, function(message) {
				tinymce.activeEditor.windowManager.alert(message);
			});
		};

		input.click();
	  },
	  plugins: [
		'advlist autolink lists link image charmap print preview anchor',
		'searchreplace visualblocks code fullscreen',
		'insertdatetime media table contextmenu paste code'
	  ],
	  toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
	 
	});
});
