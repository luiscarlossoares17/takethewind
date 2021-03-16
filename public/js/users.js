/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************!*\
  !*** ./resources/js/webpages/users.js ***!
  \****************************************/
$(function () {
  if ($("#usersTable")) {
    var numColumns = $("#usersTable thead th").length;
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
        dataSrc: function dataSrc(json) {
          var users = new Array();

          for (var i = 0; i < json.data.length; i++) {
            users.push({
              'user': json.data[i].user,
              'email': json.data[i].email
            });
          }

          return users;
        }
      },
      'columns': [{
        'data': 'user'
      }, {
        'data': 'email'
      }]
    });
  }

  $("#create-user").on('click', function () {
    $("#user-modal").appendTo('body').modal('show');
  });
});
/******/ })()
;