/**
 * All the code of Plugin Front-End Script, should reside in this file.
 */

jQuery(document).ready(function($) {

    $('#ulr-show-reg').click(function(e){
        e.preventDefault();
        console.log('hi');

        $('.ulr-form-wrapper .ulr-header-login').addClass('ulr-hidden');
        $('.ulr-form-wrapper .ulr-header-register').removeClass('ulr-hidden');
    });

    $('#ulr-show-log').click(function(e){
        e.preventDefault();

        $('.ulr-form-wrapper .ulr-header-register').addClass('ulr-hidden');
        $('.ulr-form-wrapper .ulr-header-login').removeClass('ulr-hidden');
    });

});


// Code for Ajax
jQuery(document).ready(function($) {

  // login
  $('#bg-login').click(function(e){
    e.preventDefault();

    var get_all_data = $('#bg-login-form').serializeArray();

    $.ajax({
        url: ajax_object.ajaxurl+'?action=user_login',
        type: 'POST',
        dataType:"json",
        data: get_all_data,
        success:function(result){

            if(!result.loggedin){
                $(".ulr-status-log").html(result.message).show(0).delay(5000).hide(0);
            }else{
                $(".ulr-status-log").html(result.message).show(0).delay(5000).hide(0);
                window.location.href = result.url;
            }

        }
    });

  });

  // register
  $('#user_registration_form_submit').click(function(e){
    e.preventDefault();

    var formData = $('#user_registration_form').serialize();

    $.ajax({
        url: ajax_object.ajaxurl,
        type:'POST',
        data: {'action':'user_registration', 'form_data': formData },
        success: function(result){
            console.log("SUCCESS");
            console.log(result);
            $(".ulr-status-reg").html(result).show(0).delay(5000).hide(0);
        }
    })

  });

});

