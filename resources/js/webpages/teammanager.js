$(function(){
    $("#logout").on('click', function(){        
        $(this).closest('form').submit();
    });
});