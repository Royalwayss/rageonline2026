function printErrorMsg(msg,className='print-error-msg'){
    $("."+className).find("ul").html('');
    $("."+className).css('display','block');
    $.each( msg, function( key, value ) {
        $("."+className).find("ul").append('<li>'+value+'</li>');
    });
}

function printSuccessMsg(msg,className='print-success-msg'){
    $("."+className).find("ul").html('');
    $("."+className).css('display','block');
    $.each( msg, function( key, value ) {
        $("."+className).find("ul").append('<li>'+value+'</li>');
    });
}