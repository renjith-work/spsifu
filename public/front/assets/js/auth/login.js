$(document).ready(function() {
    $.ajaxSetup({
    	headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $('#password').keypress(function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            $('form#login').submit();
            event.stopPropagation();
            // return false;    //<---- Add this line	
        }
        // event.stopPropagation();
    });

    $('#modal-login-btn').click(function(event) {
    	event.preventDefault();
    	var _token = $("input[name='_token']").val();
    	var email = $('#modal-email').val();
    	var password = $('#modal-password').val();
    	var object = {};
    	object["_token"] = _token;
    	object["email"] = email;
    	object["password"] = 'passmenow';
    	console.log(object);
    	$.ajax({
            url: "/api/login",
            type:'POST',
            data: object,
            success:function(response){
                console.log(response);
            }
        });
    });

});