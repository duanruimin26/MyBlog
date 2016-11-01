/**
 * Created by Lenovo on 2016/10/19.
 */
$(document).ready(function(){
    (function(){
        $('#summernote').summernote({
            height: 300,
            callbacks: {
                onImageUpload: function(files){
                    var $editor = $(this);
                    var data = new FormData();
                    data.append('file',files[0]);

                    $.ajax({
                        url: 'upload.php',
                        method: 'POST',
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function(imgUrl){
                            $editor.summernote('insertImage',imgUrl);
                        }
                    });
                }
            }
        });
    })();

    (function(){
        $('.publish').click(function() {
            var summernoteContent = $('#summernote').summernote('code');
            summernoteContent=summernoteContent.replace(/uploads/g,'admin/uploads');
            $("#content").html(summernoteContent);
        });
        $(".login-info").click(function () {
            $('.account-info').toggleClass('open');
        });
    })();

});