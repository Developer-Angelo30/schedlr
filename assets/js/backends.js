$(document).ready(()=>{

    const reset = () =>{
        $(document).on('focus', '.input' , function(){
            $('.error-email').html('')
            $('.error-password').html('')
            $('.alert-show ').addClass('d-none');
            $('.error-globals').html('')
        } )
    }
    reset()
    
    const loginAccount = () =>{

        $(document).on("submit", "#login-form", function(event){
            event.preventDefault()
            
            let formdData = new FormData(this);
            formdData.append("action", "loginAccounts");

            $.ajax({
                type: "POST",
                url: "./views/user.view.php",
                data: formdData,
                processData: false,
                contentType: false,
                dataType: "JSON",
                beforeSend: function(){
                    $('#login-form-submit').attr('disabled', true)
                    $('#login-form-submit').html('<i class="fa fa-spinner fa-spin"></i> Please wait')
                },
                success: function (response) {
                    if(response.status == true){
                        if(response.role == 1){
                            location.reload();
                        }
                        else{
                            location.href = response.message;
                        }
                    }
                    else{
                        switch(response.error){
                            case 'email':{
                                $('.error-email').html(response.message)
                                break;
                            }
                            case 'password':{
                                $('.error-password').html(response.message)
                                break;
                            }
                            default:{
                                $('.alert-show ').removeClass('d-none');
                                $('.error-global').html(response.message)
                                break;
                            }
                        }
                    }
                },
                complete: function(){
                    $('#login-form-submit').removeAttr('disabled')
                    $('#login-form-submit').html('Login <i class="fa fa-arrow-right"></i>')
                }
            });
        })

    }
    loginAccount()

    const loginVerificationAcount = ()=>{

        $(document).on('submit', '#login-verification-form' , function(event){
            event.preventDefault()
            
            let formdData = new FormData(this);
            formdData.append("action", "loginVerifications");

            $.ajax({
                type: "POST",
                url: "./views/user.view.php",
                data: formdData,
                processData: false,
                contentType: false,
                dataType: "JSON",
                beforeSend: function(){
                    $('#login-verification-form-submit').attr('disabled', true)
                    $('#login-verification-form-submit').html('<i class="fa fa-spinner fa-spin"></i> Please wait')
                },
                success: function (response) {
                   if(response.status == true){
                    location.href = response.message;
                   }
                   else{
                    $('.alert-show-verification').removeClass('d-none');
                    $('.error-global-verification').html(response.message)
                   }
                },
                complete: function(){
                    $('#login-verification-form-submit').removeAttr('disabled')
                    $('#login-verification-form-submit').html('Login <i class="fa fa-arrow-right"></i>')
                }
            });
        })

    }
    loginVerificationAcount()

})