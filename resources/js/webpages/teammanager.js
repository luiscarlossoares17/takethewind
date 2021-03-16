const { runInContext } = require("lodash");

$(function(){

    $("#logout").on('click', function(){        
        $(this).closest('form').submit();
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