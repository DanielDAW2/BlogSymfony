$(document).ready(function(){
    $("#register_username").on('blur',function(){
        var user=$(this).val();
        $.ajax({
            url:URL+'validuser',
            data: {username: user},
            type: 'POST',
            success: function(response){
                if(response==1){
                    $("#register_username").css("border","1px solid red");
                    $(".error-message").html('<p>Choose another username</p>')
                    $("#register_username").focus();
                    setTimeout(function(){
                         $(".error-message").html('<p></p>');
                    },5000);
                    
                }else{
                    $("#reg-user").css("border","1px solid green");
                }
                
            }
            
        });
    });
});
