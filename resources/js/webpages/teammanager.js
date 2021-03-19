const { runInContext } = require("lodash");

$(function(){

    if($("#profile").length){
        $("#sidebar-main-page").css('height', '92.5vh');
    }else{
        $("#sidebar-main-page").css('height', '98.6vh');
    }

    $("#logout-button").on('click', function(){        
        $(this).closest('form').submit();
    });


    $("#login-button").on('click', function(){
        $("#login-modal").modal('show');
    });


    $(document).on('click', '.nav.nav-tabs.topnav a', function(){
        let tab = $(this).attr('href');

        if(tab == '.login'){
            $('.tab-pane.topnav-content.login').addClass('active');
            $('.tab-pane.topnav-content.register').removeClass('active');
        } else if(tab == '.register') {
            $('.tab-pane.topnav-content.register').addClass('active');
            $('.tab-pane.topnav-content.login').removeClass('active');
        }

    });


    if($("#teamusersTable")){

        let numColumns = $("#teamusersTable thead th").length;

        $("#teamusersTable").DataTable({
            fixedHeader: {
                header: true
            },
            'bProcessing': true,
            'paging': true,
            'scrollY': '55vh',
            'scrollCollapse': true,
            'serverSide': true,
            'pageLength': 10,
        
            'ajax': {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: route('get_user_teams'),
                dataSrc: function(json){
                    let userTeams = new Array();

                    for(let i = 0; i < json.data.length; i++){
                        userTeams.push({
                            'user': json.data[i].user,
                            'email': json.data[i].email,
                            'team': json.data[i].team
                        });
                    }

                    return userTeams;
                }
            },
            'columns': [
                {'data': 'user'},
                {'data': 'email'},
                {'data': 'team'},
            ]
        })

    }


    $("#sidebar li a").on('click', function(){       
        $("#sidebar").find('a').not($(this)).removeClass('active');
        $(this).addClass('active');
    });


    if (window.location.href.indexOf("manager") > -1) {
        $("#main-page").addClass('active');
    }

});
