/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************!*\
  !*** ./resources/js/webpages/teams.js ***!
  \****************************************/
var usersTable;
$(function () {
  if ($("#teamsTable")) {
    var numColumns = $("#teamsTable thead th").length;
    $("#teamsTable").DataTable({
      fixedHeader: {
        header: true
      },
      dom: '<"row"<"col-sm-12 d-flex justify-content-end"f>>' + '<"row"<"col-sm-12"tr>>' + '<"row"<"col-sm-3 d-flex justify-content-start"i><"col-sm-6 d-flex justify-content-center"p><"col-sm-3 d-flex justify-content-end"l>>',
      'processing': true,
      'paging': true,
      'scrollY': '55vh',
      'scrollCollapse': true,
      'serverSide': true,
      'pageLength': 10,
      'columnDefs': [{
        'targets': [numColumns - 1],
        'searchable': false,
        'orderable': false,
        'width': '15%'
      }, {
        'className': 'hide-column',
        'targets': 0
      }],
      'ajax': {
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: route('get_teams'),
        dataSrc: function dataSrc(json) {
          var teams = new Array();

          for (var i = 0; i < json.data.length; i++) {
            var id = json.data[i].id;
            teams.push({
              'show': id,
              'team': json.data[i].name,
              'actions': '<button type="button" class="btn btn-primary edit-button">Edit</button><button type="button" class="btn btn-danger delete-button">Delete</button>'
            });
          }

          return teams;
        }
      },
      'columns': [{
        'data': 'show'
      }, {
        'data': 'team'
      }, {
        'data': 'actions'
      }]
    });
  }

  $("#team-modal").on('shown.bs.modal', function () {
    $('#usersTable').find('thead').find('tr').find('th').eq(0).trigger('click');
  });
  $("#create-team").on('click', function () {
    /**
    *  FUNCTION TO OPEN MODAL FOR CREATE A NEW Roles
    */
    $("#editModalButton").hide();
    $("#createModalButton").show();
    $("#modaltitle").html("Create Team");
    $("#team-modal").appendTo("body").modal('show');
    $('#usersTable').dataTable().fnDestroy();
    usersTable = $('#usersTable').DataTable({
      fixedHeader: {
        header: true
      },
      dom: '<"row"<"col-sm-12 d-flex justify-content-end"f>>' + '<"row"<"col-sm-12"tr>>' + '<"row"<"col-sm-3 d-flex justify-content-start"i><"col-sm-6 d-flex justify-content-center"p><"col-sm-3 d-flex justify-content-end"l>>',
      'paging': false,
      //'scrollY': '30vh',
      //'scrollCollapse': true,
      'serverSide': true,
      'searching': false,
      'pageLength': 15,
      'columnDefs': [{
        'targets': [5],
        'searchable': false,
        'orderable': false,
        'width': '8%'
      }],
      'ajax': {
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          'team': 'all'
        },
        type: 'POST',
        url: route('get_teams_users'),
        'dataSrc': function dataSrc(json) {
          var select = json.select;
          var usersData = json.data;
          var users = new Array();

          for (var i = 0; i < usersData.length; i++) {
            var id = usersData[i].id;
            users.push({
              'name': usersData[i].name,
              'age': usersData[i].age,
              'email': usersData[i].email,
              'category': usersData[i].category,
              'userLevel': select,
              'checkbox': '<div class="form-check d-flex justify-content-center align-items-center"><input class="form-check-input" type="checkbox" id="companyuser" value="' + id + '"></div>'
            });
          }

          return users;
        }
      },
      'columns': [{
        'data': 'name'
      }, {
        'data': 'age'
      }, {
        'data': 'email'
      }, {
        'data': 'category'
      }, {
        'data': 'userLevel'
      }, {
        'data': 'checkbox'
      }]
    });
    $('#selectAllAccesses').prop('checked', false);
    $("#modaltitle").html('Create user');
    $("#createModalButton").show();
    $("#editModalButton").hide();
    $("#team-modal").appendTo('body').modal('show');
  });
  $("#createModalButton").on('click', function () {
    //usersTable.fnFilter('');
    //$("#usersTable_filter").find('input').val('');
    //$("#usersTable").dataTable().api().columns.search( '' ).draw();
    var name = $("#name").val();
    var users = [];
    var userLevel = [];
    var save = true;
    $("#companyuser:checked").each(function () {
      var userLevelId = $(this).closest('tr').find('select').val();

      if (userLevelId != '') {
        users.push($(this).val());
        userLevel.push(userLevelId);
        console.log(userLevelId);
      } else {
        save = false;
      }
    }); //let route       = route('companyusers.store');

    if (save) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: route('teams.store'),
        data: {
          name: name,
          users: users,
          userlevels: userLevel
        },
        success: function success(result) {
          $("#user-modal").modal('toggle');
          location.reload(); //Normalmente o Datatables devia suportar o reload dos dados
        },
        error: function error(errors) {
          $.each(errors.responseJSON.errors, function (index, value) {
            alert(index + ' - ' + value);
          });
        }
      });
    } else {
      alert('Please select all levels of users that are checked');
    }
  });
  $(document).on('click', '.edit-button', function () {
    var teamId = $(this).closest('tr').find('td').eq(0).html();

    if (teamId > 0) {
      $.getJSON(route('teams.show', teamId), function (data) {
        var team = data;
        $("#teamId").val(teamId);
        $("#name").val(team.name);
        $("#modaltitle").html('Update Team');
        $("#createModalButton").hide();
        $("#editModalButton").show();
        $('#usersTable').dataTable().fnDestroy();
        usersTable = $('#usersTable').DataTable({
          fixedHeader: {
            header: true
          },
          dom: '<"row"<"col-sm-12 d-flex justify-content-end"f>>' + '<"row"<"col-sm-12"tr>>' + '<"row"<"col-sm-3 d-flex justify-content-start"i><"col-sm-6 d-flex justify-content-center"p><"col-sm-3 d-flex justify-content-end"l>>',
          'paging': false,
          //'scrollY': '30vh',
          //'scrollCollapse': true,
          'serverSide': true,
          // 'scrollY': '200px',
          //'lengthChange': false,
          'pageLength': 15,
          'columnDefs': [{
            'targets': [5],
            'searchable': false,
            'orderable': false,
            'width': '8%'
          }],
          'ajax': {
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
              'team': team.id
            },
            type: 'POST',
            url: route('get_teams_users'),
            'dataSrc': function dataSrc(json) {
              var select = json.select;
              var usersData = json.data;
              var users = new Array();

              for (var i = 0; i < usersData.length; i++) {
                var id = usersData[i][0];
                users.push({
                  'name': usersData[i][1],
                  'age': usersData[i][2],
                  'email': usersData[i][3],
                  'category': usersData[i][4],
                  'userLevel': usersData[i][5],
                  'checkbox': '<div class="form-check d-flex justify-content-center align-items-center"><input class="form-check-input" type="checkbox" id="companyuser" value="' + id + '"></div>',
                  'teamMember': usersData[i][6]
                });
              }

              return users;
            }
          },
          'createdRow': function createdRow(row, users, dataIndex) {
            $(row).find('input[type=checkbox]').prop('checked', users.teamMember);
          },
          'columns': [{
            'data': 'name'
          }, {
            'data': 'age'
          }, {
            'data': 'email'
          }, {
            'data': 'category'
          }, {
            'data': 'userLevel'
          }, {
            'data': 'checkbox'
          }]
        });
        $("#team-modal").appendTo('body').modal('show');
      });
    }
  });
  $("#editModalButton").on('click', function () {
    var teamId = $("#teamId").val();
    var name = $("#name").val();
    var users = [];
    var userLevel = [];
    var save = true;
    $("#companyuser:checked").each(function () {
      var userLevelId = $(this).closest('tr').find('select').val();

      if (userLevelId != '') {
        users.push($(this).val());
        userLevel.push(userLevelId);
        console.log(userLevelId);
      } else {
        save = false;
      }
    });

    if (save) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: route('teams.update', teamId),
        data: {
          name: name,
          users: users,
          userlevels: userLevel,
          _method: 'PUT'
        },
        success: function success(result) {
          $("#team-modal").modal('toggle');
          location.reload(); //Normalmente o Datatables devia suportar o reload dos dados
        },
        error: function error(errors) {
          $("#modalBodyDiv :input").removeClass('is-invalid');
          $("#modalBodyDiv select").removeClass('is-invalid');
          $.each(errors.responseJSON.errors, function (index, value) {
            $(':input[name=' + index + ']').addClass('is-invalid');
            $('select[name=' + index + ']').addClass('is-invalid');
            $('#span-' + index).removeClass('invalid-feedback').html('').addClass('is-invalid').html(value);
          });
        }
      });
    } else {
      alert('Please select all levels of users that are checked');
    }
  });
  $(document).on('click', '.delete-button', function () {
    var teamId = $(this).closest('tr').find('td').eq(0).html();

    if (userId > 0) {
      $("#operation-modaltitle").html('Delete');
      $("#confirm-modal-procceed").html('Do you want delete this user?').show();
      $('#confirm-modal-procceed').append('<input type="text" value="' + teamId + '" hidden>');
      $("#operation-confirm-modal").appendTo('body').modal('show');
    }
  });
  $("#confirm-modal-button").on('click', function () {
    var userId = $('#confirm-modal-procceed').find('input').val();

    if (userId > 0) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: route('teams.destroy', userId),
        data: {
          _method: 'DELETE'
        },
        success: function success(result) {
          $("#operation-confirm-modal").modal('toggle');
          location.reload(); //Normalmente o Datatables devia suportar o reload dos dados
        }
      });
    }
  });
  $("#team-modal").on('hidden.bs.modal', function () {
    $("#modalBodyDiv :input").val('').removeClass('is-invalid');
    $("#modalBodyDiv input").parent().find('span').removeClass('invalid-feedback').html('');
  });
});
/******/ })()
;