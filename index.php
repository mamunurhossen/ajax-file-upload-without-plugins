
<!DOCTYPE html>
<html>
	<head>
		<title>Ajax image upload</title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		  <!-- Load jQuery and the necessary widget JS files to enable file upload -->
		  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> 
		<script>
			$(document).ready(function () { 
				$('body').on('click', '.upload', function(){

					var fileInput = document.getElementById('upload-file');
					var file = fileInput.files[0];
					var formData = new FormData();
					formData.append('file', file);
						
					// Get the form data. This serializes the entire form. pritty easy huh!
					//var form = new FormData($('#myform')[0]);
					
					// Make the ajax call
					$.ajax({
					    url: 'upload.php',
					    type: 'POST',
					    xhr: function() {
					        var myXhr = $.ajaxSettings.xhr();
					        if(myXhr.upload){
					            myXhr.upload.addEventListener('progress',progress, false);
					        }
					        return myXhr;
					    },
						//add beforesend handler to validate or something
					    //beforeSend: functionname,
					    success: function (res) {
							$('#content_here_please').html(res);
						},
						//add error handler for when a error occurs if you want!
					    //error: errorfunction,
					    data: formData,
						// this is the important stuf you need to overide the usual post behavior
					    cache: false,
					    contentType: false,
					    processData: false
					});
				});
			});	
			
			// Yes outside of the .ready space becouse this is a function not an event listner!
			function progress(e){
			    if(e.lengthComputable){
					//this makes a nice fancy progress bar
			        $('progress').attr({value:e.loaded,max:e.total});
			    }
			}
		</script>
	</head>
	<body>
		<form enctype="multipart/form-data" id="myform">	
			<input type="text" name="some_usual_form_data" />
			<br>
			<input type="file" accept="image/*" multiple name="img[]" id="upload-file" /> <sub>note that you have to use [] behind the name or php wil only see one image</sub>
			<br>
			<input type="button" value="Upload images" class="upload" />
		</form>
		<progress value="0" max="100"></progress>
		<hr>
		<div id="content_here_please"></div>
	</body>
</html>
  
  