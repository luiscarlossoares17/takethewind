$(function(){
    $("#logout").on('click', function(){
        console.log("aa");
        
        $(this).closest('form').submit();
    });
});