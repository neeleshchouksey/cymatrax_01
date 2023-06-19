$(function () {

    var uri_segment = document.URL.split('/')[document.URL.split('/').length - 1];
    var uri_segment2 = document.URL.split('/')[document.URL.split('/').length - 2];

    if (uri_segment == 'admins') {
        get_admins();
    }
    if (uri_segment == 'roles') {
        get_roles();
    }
    if (uri_segment == 'plan-and-subscription') {
        get_plans();
    }
    if (uri_segment == 'users') {
        get_users();
    }
    if (uri_segment == 'reports') {
        get_reports();
    }
    if (uri_segment2 == 'user-files') {
        get_user_files();
    }
    if (uri_segment2 == 'view') {
        view_user_files();
    }
});

function activateDeactivateUser(id, status) {
    if (status) {
        st = "Activate";
    } else {
        st = "Deactivate"
    }
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to " + st + " this user ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, ' + st + ' it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: "post",
                data: {
                    "_token": CSRF_TOKEN,
                    id: id,
                    status: status
                },
                url: APP_URL + "/admin/activate-deactivate-user",
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.msg,
                        icon: 'success',
                        showCancelButton: false,
                    }).then((result) => {
                        get_users();
                    })
                },
                error: function (error) {
                    Swal.fire({
                        title: "Error",
                        text: error.responseJSON.msg,
                        icon: "error",
                    });
                }
            });
        }
    });
}
function deleteUser(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this user, you wont be able to revert this, all related data of this user will be permanently deleted.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: "post",
                data: {
                    "_token": CSRF_TOKEN,
                    id: id
                },
                url: APP_URL + "/admin/delete-user",
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.msg,
                        icon: 'success',
                        showCancelButton: false,
                    }).then((result) => {
                        get_users();
                    })
                },
                error: function (error) {
                    Swal.fire({
                        title: "Error",
                        text: error.responseJSON.msg,
                        icon: "error",
                    });
                }
            });
        }
    });
}
function makeRemoveEnterPriseUser(id, status) {
    if (status) {
        st = "Make";
    } else {
        st = "Remove"
    }
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to " + st + " this user as enterprise user?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, ' + st + ' it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: "post",
                data: {
                    "_token": CSRF_TOKEN,
                    id: id,
                    status: status
                },
                url: APP_URL + "/admin/make-remove-enterprise-user",
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.msg,
                        icon: 'success',
                        showCancelButton: false,
                    }).then((result) => {
                        get_users();
                    })
                },
                error: function (error) {
                    Swal.fire({
                        title: "Error",
                        text: error.responseJSON.msg,
                        icon: "error",
                    });
                }
            });
        }
    });
}

function get_admins() {

    var admin_datatable = $("#admin-datatable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "bDestroy": true,
        "ordering": false,
        ajax: {
            url: APP_URL + "/admin/get-all-admins",
            type: "GET",
        },
        "columns": [
            { mData: 'sno' },
            { mData: 'name' },
            { mData: 'email' },
            { mData: 'action' }
        ]

    }).buttons().container().appendTo('#admin-datatable_wrapper .col-md-6:eq(0)');
}

function activateDeactivateAdmin(id, status) {
    if (status) {
        st = "Activate";
    } else {
        st = "Deactivate"
    }
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to " + st + " this admin ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, ' + st + ' it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: "post",
                data: {
                    "_token": CSRF_TOKEN,
                    id: id,
                    status: status
                },
                url: APP_URL + "/admin/activate-deactivate-admin",
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.msg,
                        icon: 'success',
                        showCancelButton: false,
                    }).then((result) => {
                        get_admins();
                    })
                },
                error: function (error) {
                    Swal.fire({
                        title: "Error",
                        text: error.responseJSON.msg,
                        icon: "error",
                    });
                }
            });
        }
    });
}

function resetTrial(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to reset trial period for this user ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Reset it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: "get",
                url: APP_URL + "/admin/reset-trial/" + id,
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.msg,
                        icon: 'success',
                        showCancelButton: false,
                    }).then((result) => {
                        get_users();
                    })
                },
                error: function (error) {
                    Swal.fire({
                        title: "Error",
                        text: error.responseJSON.msg,
                        icon: "error",
                    });
                }
            });
        }
    });
}
function subscribe(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want unlimited subscription for this user ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Subscribe it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: "get",
                url: APP_URL + "/admin/subscription/" + id,
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.msg,
                        icon: 'success',
                        showCancelButton: false,
                    }).then((result) => {
                        get_users();
                    })
                },
                error: function (error) {
                    Swal.fire({
                        title: "Error",
                        text: error.responseJSON.msg,
                        icon: "error",
                    });
                }
            });
        }
    });
}

function addAdmin() {
    $.ajax({
        method: "post",
        url: APP_URL + "/admin/add-admin",
        data: {
            "_token": CSRF_TOKEN,
            "name": $("#name").val(),
            "email": $("#email").val(),
            "password": $("#password").val(),
            "role": $("#role").val(),
        },
        success: function (response) {
            Swal.fire({
                title: 'Success!',
                text: response.msg,
                icon: 'success',
                showCancelButton: false,
            }).then((result) => {
                $("#add-admin-modal").modal("hide");
                get_admins();
            })
        },
        error: function (error) {
            Swal.fire({
                title: "Error",
                text: error.responseJSON.msg,
                icon: "error",
            });
        }
    });

}

function getSingleAdmin(id) {
    $.ajax({
        method: "get",
        url: APP_URL + "/admin/get-admin/" + id,
        success: function (response) {
            $("#update-admin-modal").modal("show");
            $("#edit_id").val(response.res.id);
            $("#edit_email").val(response.res.email);
            $("#edit_name").val(response.res.name);
            $("#edit_password").val('');
            $("#edit_role").val(response.res.role_id);
            if (response.res.role_id == 1) {
                $("#edit_role").prop("disabled", true);
            } else {
                $("#edit_role").prop("disabled", false);
            }
        },
    });

}

function updateAdmin() {
    $.ajax({
        method: "post",
        url: APP_URL + "/admin/update-admin",
        data: {
            "_token": CSRF_TOKEN,
            "id": $("#edit_id").val(),
            "name": $("#edit_name").val(),
            "email": $("#edit_email").val(),
            "password": $("#edit_password").val(),
            "role": $("#edit_role").val(),
        },
        success: function (response) {
            Swal.fire({
                title: 'Success!',
                text: response.msg,
                icon: 'success',
                showCancelButton: false,
            }).then((result) => {
                $("#update-admin-modal").modal("hide");
                get_admins();
            })
        },
        error: function (error) {
            Swal.fire({
                title: "Error",
                text: error.responseJSON.msg,
                icon: "error",
            });
        }
    });

}

function getSingleRole(id) {
    $.ajax({
        method: "get",
        url: APP_URL + "/admin/get-role/" + id,
        success: function (response) {
            $("#update-role-modal").modal("show");
            $("#edit_id").val(response.res.id);
            $("#edit_role").val(response.res.role);
            let features = response.features;
            $("#edit_features").empty();
            $.each(features, function (key, value) {
                if (value.selected) {
                    $("#edit_features").append(`<option value="` + value.id + `" selected="` + value.selected + `">` + value.feature + `</option>`)
                } else {
                    $("#edit_features").append(`<option value="` + value.id + `">` + value.feature + `</option>`)

                }
            })
        },
    });
}

function getSinglePlan(id) {
    $.ajax({
        method: "get",
        url: APP_URL + "/admin/get-plan/" + id,
        success: function (response) {
            $("#update-plan-modal").modal("show");
            $("#edit_id").val(response.res.id);
            $("#edit_name").val(response.res.name);
            $("#edit_charges").val(response.res.charges);
            $("#edit_no_of_clean_file").val(response.res.no_of_clean_file);
            $("#edit_text_1").val(response.res.text_1);
            $("#edit_text_2").val(response.res.text_2);
            $("#edit_text_3").val(response.res.text_3);
        },
    });
}

function cancelPlanModal() {
    // $.ajax({
    //     method: "get",
    //     url: APP_URL + "/admin/get-plan/" + id,
    //     success: function (response) {
            $("#cancel-plan-modal").modal("show");
            // $("#edit_id").val(response.res.id);
            // $("#edit_name").val(response.res.name);
            // $("#edit_charges").val(response.res.charges);
            // $("#edit_no_of_clean_file").val(response.res.no_of_clean_file);
    //     },
    // });
}

function updateRole() {
    $.ajax({
        method: "post",
        url: APP_URL + "/admin/update-role",
        data: {
            "_token": CSRF_TOKEN,
            "id": $("#edit_id").val(),
            "role": $("#edit_role").val(),
            "features": $("#edit_features").val(),
        },
        success: function (response) {
            Swal.fire({
                title: 'Success!',
                text: response.msg,
                icon: 'success',
                showCancelButton: false,
            }).then((result) => {
                $("#update-role-modal").modal("hide");
                get_roles();
            })
        },
        error: function (error) {
            Swal.fire({
                title: "Error",
                text: error.responseJSON.msg,
                icon: "error",
            });
        }
    });
}

function updatePlan() {
    $.ajax({
        method: "post",
        url: APP_URL + "/admin/update-plan",
        data: {
            "_token": CSRF_TOKEN,
            "id": $("#edit_id").val(),
            "name": $("#edit_name").val(),
            "charges": $("#edit_charges").val(),
            "no_of_clean_file": $("#edit_no_of_clean_file").val(),
            "text_1": $("#edit_text_1").val(),
            "text_2": $("#edit_text_2").val(),
            "text_3": $("#edit_text_3").val(),
        },
        success: function (response) {
            Swal.fire({
                title: 'Success!',
                text: response.msg,
                icon: 'success',
                showCancelButton: false,
            }).then((result) => {
                $("#update-plan-modal").modal("hide");
                get_plans();
            })
        },
        error: function (error) {
            Swal.fire({
                title: "Error",
                text: error.responseJSON.msg,
                icon: "error",
            });
        }
    });
}

function get_roles() {

    $("#role-datatable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "bDestroy": true,
        "ordering": false,
        ajax: {
            url: APP_URL + "/admin/get-all-roles",
            type: "GET",
        },
        "columns": [
            { mData: 'sno' },
            { mData: 'role' },
            { mData: 'action' }
        ]

    }).buttons().container().appendTo('#role-datatable_wrapper .col-md-6:eq(0)');
}

function get_plans() {

    $("#plan-datatable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "bDestroy": true,
        "ordering": false,
        ajax: {
            url: APP_URL + "/admin/get-all-plans",
            type: "GET",
        },
        "columns": [
            { mData: 'sno' },
            { mData: 'name' },
            { mData: 'charges' },
            { mData: 'no_of_clean_file' },
            { mData: 'text_1' },
            { mData: 'text_2' },
            { mData: 'text_3' },
            { mData: 'action' }
        ]

    }).buttons().container().appendTo('#plan-datatable_wrapper .col-md-6:eq(0)');
}

function get_users() {

    $("#user-datatable").DataTable({
        // "responsive": false,
        // "dom": 'Bfrtip',
        "lengthChange": false,
        "autoWidth": false,
        "scrollX": true,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "bDestroy": true,
        "ordering": false,
        ajax: {
            url: APP_URL + "/admin/get-all-users",
            type: "GET",
        },
        "columns": [
            { mData: 'sno' },
            { mData: 'name' },
            { mData: 'email' },
            { mData: 'address' },
            { mData: 'city' },
            { mData: 'state' },
            { mData: 'country' },
            { mData: 'zip_code' },
            { mData: 'trial_expiry_date' },
            { mData: 'uploaded_files_count' },
            { mData: 'cleaned_files_count' },
            { mData: 'paid_files_count' },
            { mData: 'last_login_at' },
            { mData: 'enterprise_user' },
            { mData: 'action' }
        ]

    }).buttons().container().appendTo('#user-datatable_wrapper .col-md-6:eq(0)');
}

function get_reports() {

    $("#report-datatable").DataTable({
        // "responsive": false,
        "dom": 'Bfrtip',
        "lengthChange": false,
        "autoWidth": false,
        "scrollX": true,
        "buttons": [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            "colvis",
        ],
        "bDestroy": true,
        "ordering": false,
        ajax: {
            url: APP_URL + "/admin/get-all-reports",
            type: "GET",
        },
        "columns": [
            { mData: 'sno' },
            { mData: 'name' },
            { mData: 'email' },
            { mData: 'address' },
            { mData: 'city' },
            { mData: 'state' },
            { mData: 'country' },
            { mData: 'zip_code' },
            { mData: 'trial_expiry_date' },
            { mData: 'uploaded_files_count' },
            { mData: 'cleaned_files_count' },
            { mData: 'paid_files_count' },
            { mData: 'last_login_at' },
            { mData: 'action' }
        ]

    }).buttons().container().appendTo('#report-datatable_wrapper .col-md-6:eq(0)');
}

function get_user_files() {
    var currentUrl = document.URL.split('/');
    var segment1 = currentUrl[currentUrl.length - 1];
    var segment2 = currentUrl[currentUrl.length - 2];

    $("#files-dt").DataTable({
        // "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "scrollX": true,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "bDestroy": true,
        "ordering": false,
        ajax: {
            url: APP_URL + "/admin/get-user-files/" + segment1,
            type: "GET",
        },
        "columns": [
            { mData: 'sno' },
            { mData: 'name' },
            { mData: 'file_name' },
            { mData: 'created' },
            { mData: 'action' }
        ]

    }).buttons().container().appendTo('#files-dt_wrapper .col-md-6:eq(0)');
}

var date, fromDate, toDate;
var total = 0;
function clear_filter() {
    $('#fromDate').val('');
    $('#filter-by').val('');
    $('#date-filter-by').val('');
    $('#keyword').val('');
    date = undefined;
    view_user_files();
}

var user_files_dt;
function view_user_files() {
    var currentUrl = document.URL.split('/');
    var segment1 = currentUrl[currentUrl.length - 1];
    var segment2 = currentUrl[currentUrl.length - 2];
    var filter_by = $("#filter-by").val();
    var date_filter_by = $("#date-filter-by").val();
    var keyword = $("#keyword").val();
    user_files_dt = $("#user-files-dt").DataTable({
        "lengthChange": false,
        "dom": 'Bfrtip',
        "buttons": [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                },
                footer: true,
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: ':visible'
                },
                footer: true,
            },
            "colvis",
        ],
        "bDestroy": true,
        "ordering": false,
        "autoWidth": false,
        "scrollX": true,
        "searching": false,
        ajax: {
            url: APP_URL + "/admin/view-user-files/" + segment1 + "?date=" + date + "&filter_by=" + filter_by + "&keyword=" + keyword + "&date_filter_by=" + date_filter_by,
            type: "GET",
        },
        "columns": [
            { mData: 'sno' },
            { mData: 'name' },
            { mData: 'file_name' },
            { mData: 'created' },
            { mData: 'cleaned' },
            { mData: 'cleaned_at' },
            { mData: 'duration' },
            { mData: 'action' }
        ],
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // computing column Total of the complete result
            var total = api
                .column(6)
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);
            $(api.column(5).footer()).html('Total Duration');
            $(api.column(6).footer()).html(total.toFixed(2));

        }

    }).buttons().container().appendTo('#user-files-dt_wrapper .col-md-6:eq(0)');
}


function deleteFile(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this file ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: "get",
                url: APP_URL + "/admin/delete-file/" + id,
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.msg,
                        icon: 'success',
                        showCancelButton: false,
                    }).then((result) => {
                        get_user_files();
                    })
                },
                error: function (error) {
                    Swal.fire({
                        title: "Error",
                        text: error.responseJSON.msg,
                        icon: "error",
                    });
                }
            });
        }
    });
}

function deleteUserFile(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this file ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: "get",
                url: APP_URL + "/admin/delete-file/" + id,
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.msg,
                        icon: 'success',
                        showCancelButton: false,
                    }).then((result) => {
                        view_user_files();
                    })
                },
                error: function (error) {
                    Swal.fire({
                        title: "Error",
                        text: error.responseJSON.msg,
                        icon: "error",
                    });
                }
            });
        }
    });
}

$(document).ready(function () {
    // Create date inputs
    minDate = $('#fromDate').daterangepicker({
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
            format: 'MM/DD/YYYY'
        }
    });

    $('#fromDate').val('');

    // Refilter the table
    $('#fromDate').on('change', function () {
        date = minDate[0].value;
        view_user_files()
    });

});

var total_min = 0;
var total_sec = 0;
var total_duration = 0;
var total_cost = 0;

function getDuration1(path, aud_id) {
    path = APP_URL + '/public/upload/' + path;
    // console.log("duration1 calling");
    // Create a non-dom allocated Audio element
    var au = document.createElement('audio');

    // Define the URL of the MP3 audio file
    au.src = path;

    // Once the metadata has been loaded, display the duration in the console
    au.addEventListener('loadedmetadata', function () {
        // Obtain the duration in seconds of the audio file (with milliseconds as well, a float value)
        var duration = au.duration;
        var duration_in_sec = au.duration;
        var minutes = Math.floor(duration / 60);
        var seconds = Math.floor(duration % 60);

        total_duration = total_duration + duration_in_sec;

        total_min = Math.floor(total_duration / 60);
        total_sec = Math.floor(total_duration % 60);

        $("#duration" + aud_id).html(minutes + "." + seconds);

    }, false);

}

function getTotalDuration() {
    console.log(total_min + "." + total_sec);
    $("#total-duration-full").html(total_min + "." + total_sec);

}

function htmlToCSV() {
    var html = document.querySelector("#user-files-dt").outerHTML;
    var filename = "files.csv";
    var data = [];
    var rows = document.querySelectorAll("#user-files-dt tr");

    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");

        for (var j = 0; j < cols.length; j++) {
            row.push(cols[j].innerText);
        }

        data.push(row.join(","));
    }

    downloadCSVFile(data.join("\n"), filename);
}

function downloadCSVFile(csv, filename) {
    var csv_file, download_link;

    csv_file = new Blob([csv], { type: "text/csv" });

    download_link = document.createElement("a");

    download_link.download = filename;

    download_link.href = window.URL.createObjectURL(csv_file);

    download_link.style.display = "none";

    document.body.appendChild(download_link);

    download_link.click();
}


// $(document).ready(function (){
//     var table = $('#user-files-dt').DataTable();
//     table.destroy();
//     $('#user-files-dt').on( 'page.dt', function () {
//         var info = table.page.info();
//         $('#pageInfo').html( 'Showing page: '+info.page+' of '+info.pages );
//     } );
// })
