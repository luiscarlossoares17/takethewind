$(function(){
    

    if($("#usersTable")){

        let numColumns = $("#usersTable thead th").length;

        $("#usersTable").DataTable({
            fixedHeader: {
                header: true
            },
            dom: '<"row"<"col-sm-12 d-flex justify-content-end"f>>' +
        '<"row"<"col-sm-12"tr>>' +
        '<"row"<"col-sm-3 d-flex justify-content-start"i><"col-sm-6 d-flex justify-content-center"p><"col-sm-3 d-flex justify-content-end"l>>',
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
                url: route('get_users'),
                dataSrc: function(json){
                    let users = new Array();

                    for(let i = 0; i < json.data.length; i++){
                        let id = json.data[i].id;
                        users.push({
                            'show'  : id,
                            'user'  : json.data[i].user,
                            'email' : json.data[i].email,
                            'age'   : json.data[i].age,
                            'category' : json.data[i].category,
                            'actions' : '<button type="button" class="btn btn-primary edit-button">Edit</button><button type="button" class="btn btn-danger delete-button">Delete</button>'
                        });
                    }

                    return users;
                }
            },
            'columns': [
                {'data': 'show'},
                {'data': 'user'},
                {'data': 'email'},
                {'data': 'age'},
                {'data': 'category'},
                {'data': 'actions'}
            ]
        })

    }

    $("#create-user").on('click', function(){
        $("#modaltitle").html('Create user');
        $("#createModalButton").show();
        $("#editModalButton").hide();
        $("#user-modal").appendTo('body').modal('show');
    });


    
    $("#createModalButton").on('click', function(){
        let name        = $("#name").val();
        let age         = $("#age").val();
        let email       = $("#email").val();
        let category    = $("#category").val();
        //let route       = route('companyusers.store');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: route('companyusers.store'),
            data: {
                name    : name,
                age     : age,
                email   : email,
                category: category
            },
            success: function(result){
            
                $("#user-modal").modal('toggle');
                location.reload(); //Normalmente o Datatables devia suportar o reload dos dados
            
            },
            error: function(errors){
                $("#modalBodyDiv :input").removeClass('is-invalid');
                $("#modalBodyDiv select").removeClass('is-invalid');
                $.each(errors.responseJSON.errors, function(index, value){
                    $(':input[name='+index+']').addClass('is-invalid');
                    $('select[name='+index+']').addClass('is-invalid');
                    $('#span-'+index).removeClass('invalid-feedback').html('').addClass('is-invalid').html(value);
                });
            }
        });
    });


    $(document).on('click', '.edit-button', function(){
        let userId = $(this).closest('tr').find('td').eq(0).html();

        if(userId > 0){
            $.getJSON(route('companyusers.show', userId), function(data){
                let user = data.user;

                $("#name").val(user.name);
                $("#email").val(user.email);
                $("#age").val(user.age);
                $("#category").val(user.category_id);
                $("#userId").val(user.id);

                $("#modaltitle").html('Update user');
                $("#createModalButton").hide();
                $("#editModalButton").show();

                $("#user-modal").appendTo('body').modal('show');
            });
        }
    });



    $("#editModalButton").on('click', function(){
        let name        = $("#name").val();
        let age         = $("#age").val();
        let email       = $("#email").val();
        let category    = $("#category").val();
        let userId      = $("#userId").val();
        
        if(userId > 0){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: route('companyusers.update', userId),
                data: {
                    name    : name,
                    age     : age,
                    email   : email,
                    category: category,
                    _method : 'PUT'
                },
                success: function(result){
                
                    $("#user-modal").modal('toggle');
                    location.reload(); //Normalmente o Datatables devia suportar o reload dos dados
                
                },
                error: function(errors){
                    $("#modalBodyDiv :input").removeClass('is-invalid');
                    $("#modalBodyDiv select").removeClass('is-invalid');
                    $.each(errors.responseJSON.errors, function(index, value){
                        $(':input[name='+index+']').addClass('is-invalid');
                        $('select[name='+index+']').addClass('is-invalid');
                        $('#span-'+index).removeClass('invalid-feedback').html('').addClass('is-invalid').html(value);
                    });
                }
            });
        }
    });


    $(document).on('click', '.delete-button', function(){
        let userId = $(this).closest('tr').find('td').eq(0).html();

        if(userId > 0){
            $("#operation-modaltitle").html('Delete');
            $("#confirm-modal-procceed").html('Do you want delete this user?').show();
            $('#confirm-modal-procceed').append('<input type="text" value="'+userId+'" hidden>');
            $("#operation-confirm-modal").appendTo('body').modal('show');
        }
    });


    $("#confirm-modal-button").on('click', function(){
        let userId = $('#confirm-modal-procceed').find('input').val();
        
        if(userId > 0){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: route('companyusers.destroy', userId),
                data: {
                    _method : 'DELETE'
                },
                success: function(result){
                
                    $("#operation-confirm-modal").modal('toggle');
                    location.reload(); //Normalmente o Datatables devia suportar o reload dos dados
                
                }
            });
        }

    });


    $("#user-modal").on('hidden.bs.modal', function(){
        $("#modalBodyDiv :input").val('').removeClass('is-invalid');
        $("#modalBodyDiv input").parent().find('span').removeClass('invalid-feedback').html('');
        $("#modalBodyDiv select").removeClass('is-invalid');
        $("#modalBodyDiv select").val(null);
    });


});