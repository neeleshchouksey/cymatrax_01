$(function () {

    var uri_segment = document.URL.split('/')[document.URL.split('/').length-1];

    if(uri_segment == 'admins'){
        get_admins();
    }
    if(uri_segment == 'roles'){
        get_roles();
    }
    if(uri_segment == 'users'){
        get_users();
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

function get_admins() {

    var admin_datatable =  $("#admin-datatable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "bDestroy": true,
        "ordering":false,
        ajax: {
            url:APP_URL+"/admin/get-all-admins",
            type:"GET",
        },
        "columns": [
            { mData: 'sno' } ,
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
            if(response.res.role_id == 1){
                $("#edit_role").prop("disabled",true);
            }else{
                $("#edit_role").prop("disabled",false);
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
            $.each(features,function (key,value){
                if(value.selected){
                    $("#edit_features").append(`<option value="`+value.id+`" selected="`+value.selected+`">`+value.feature+`</option>`)
                }else{
                    $("#edit_features").append(`<option value="`+value.id+`">`+value.feature+`</option>`)

                }
            })
        },
    });
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

function get_roles() {

    $("#role-datatable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "bDestroy": true,
        "ordering":false,
        ajax: {
            url:APP_URL+"/admin/get-all-roles",
            type:"GET",
        },
        "columns": [
            { mData: 'sno' } ,
            { mData: 'role' },
            { mData: 'action' }
        ]

    }).buttons().container().appendTo('#role-datatable_wrapper .col-md-6:eq(0)');
}
function get_users() {

    $("#user-datatable").DataTable({
        // "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "scrollX": true,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "bDestroy": true,
        "ordering":false,
        ajax: {
            url:APP_URL+"/admin/get-all-users",
            type:"GET",
        },
        "columns": [
            { mData: 'sno' } ,
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

    }).buttons().container().appendTo('#user-datatable_wrapper .col-md-6:eq(0)');
}

$(document).ready(function () {
    get_user_files();
});

function get_user_files(){
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
        "ordering":false,
        ajax: {
            url:APP_URL+"/admin/get-user-files/" + segment1,
            type:"GET",
        },
        "columns": [
            { mData: 'sno' } ,
            { mData: 'name' },
            { mData: 'file_name' },
            //{ mData: 'created_at' },
            { mData: 'action' }
        ]

    }).buttons().container().appendTo('#files-dt_wrapper .col-md-6:eq(0)');
}

function deleteFile(id){
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

