$(function(){


    if($("#teamsTable")){

        let numColumns = $("#teamsTable thead th").length;

        $("#teamsTable").DataTable({
            fixedHeader: {
                header: true
            },
            'processing': true,
            'paging': true,
            'scrollY': '55vh',
            'scrollCollapse': true,
            'serverSide': true,
            'pageLength': 10,
            'columnDefs': [
                {
                    'targets': [numColumns-1],
                    'searchable': false,
                    'orderable': false,
                    'width': '15%'
                },
                {
                    'className': 'hide-column',
                    'targets': 0
                },
            ],     
            'ajax': {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: route('get_teams'),
                dataSrc: function(json){
                    let teams = new Array();

                    for(let i = 0; i < json.data.length; i++){
                        let id = json.data[i].id;
                        teams.push({
                            'show'  : id,
                            'team'  : json.data[i].name,
                            'actions' : '<button type="button" class="btn btn-primary edit-button">Edit</button><button type="button" class="btn btn-danger delete-button">Delete</button>'
                        });
                    }

                    return teams;
                }
            },
            'columns': [
                {'data': 'show'},
                {'data': 'team'},
                {'data': 'actions'}
            ]
        })

    }


    $("#create-team").on('click', function(){

        /**
     *  FUNCTION TO OPEN MODAL FOR CREATE A NEW Roles
     */
         $("#createModal").click(function(){
            $("#editModalButton").hide();
            $("#createModalButton").show();
            $("#modaltitle").html("Create Role");
            $("#role-modal").appendTo("body").modal('show');


            $('#permissions-table').dataTable().fnDestroy();
            var apiAccessesTable = $('#permissions-table').DataTable({
                fixedHeader: {
                    header: true
                },
                'paging': false,
                'scrollY': '20vh',
                'scrollCollapse': true,
                // 'scrollY': '200px',
                //'lengthChange': false,
                'pageLength': 15,
                'columnDefs':[
                    {
                        'targets'   : [2],
                        'searchable': false,
                        'orderable' : false,
                        'width'     : '8%'
                    }
                ],
                'ajax':{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'role' : 'all'
                    },
                    type: 'POST',
                    url : route('get_permissions'),
                    'dataSrc': function (json){
                        var permissions = new Array();
                        for(var i = 0; i < json.data.length; i++){
                            var id = json.data[i][2];
                            permissions.push({
                                'name'        : json.data[i][0],
                                'description' : json.data[i][1],
                                //'updated_at'  : json.data[i][2],
                                'checkbox'    : new Checkbox({id: 'permissions', value: id, name: 'permissions[]'}).datatable().render()
                            });
                        }
                        return permissions;
                    }
                },
                'columns': [
                    {'data': 'name'},
                    {'data': 'description'},
                    //{'data': 'updated_at'},
                    {'data': 'checkbox'}
                ]
            });

            $('#selectAllAccesses').prop('checked', false);
    });






        $("#modaltitle").html('Create user');
        $("#createModalButton").show();
        $("#editModalButton").hide();
        $("#team-modal").appendTo('body').modal('show');
    });


});
