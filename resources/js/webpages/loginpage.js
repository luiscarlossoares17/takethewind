$(function(){


    $('#myLoginTab li').on('click', function (e) {
       let element = $(this).find('button').attr('data-bs-target');

       $(this).find('button').addClass('active');
       $(element).addClass('show').addClass('active');

       $("#myLoginTabContent").find('div').not(element).removeClass('show').removeClass('active');
       $('#myLoginTab li').not($(this)).find('button').removeClass('active');
    })


});
