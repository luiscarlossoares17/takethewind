$(function(){
    

    if($("#usersTable")){

        let numColumns = $("#usersTable thead th").length;

        $("#usersTable").DataTable({
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
                url: route('get_users'),
                dataSrc: function(json){
                    let users = new Array();

                    for(let i = 0; i < json.data.length; i++){
                        users.push({
                            'user'  : json.data[i].user,
                            'email' : json.data[i].email,
                        });
                    }

                    return users;
                }
            },
            'columns': [
                {'data': 'user'},
                {'data': 'email'}
            ]
        })

    }

    $("#create-user").on('click', function(){
        $("#user-modal").appendTo('body').modal('show');
    });


});