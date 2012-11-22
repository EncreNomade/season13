// Initialisation
$(window).load(function() {
    var uploadForm = $('#imageuploadform');
    var imageAttach =  $('#image_attach');
    // Prepare Options Object for upload form
    var options = {
        type :      'POST',
        url :       config.restUploadPath+'create_mail_attachment', 
        dataType :  'json',
        success :   function(res) {
            uploadForm.get(0).reset();
            if(res.success) {
                var img = $('#imageUploaded');
                if(img.length == 0) {
                    img = $("<img id='imageUploaded'/>");
                    imageAttach.after(img);
                }
                
                img.attr('src', res.path);
                imageAttach.val(res.path);
            }
            else {
                if(res.errorMessage) alert(res.errorMessage);
            }
        },
        error :     function(res) {
            uploadForm.get(0).reset();
            alert("Erreur de téléchargement");
        }
    };
    // Prepare ajax form
    uploadForm.ajaxForm(options);
    // Upload interaction
    $('#imageuploadform #upload_btn').click(function() {
        uploadForm.submit();
    });
    
});