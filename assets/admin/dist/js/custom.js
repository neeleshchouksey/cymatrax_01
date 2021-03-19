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
                        window.location.reload();
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
                        window.location.reload();
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
                        window.location.reload();
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
                window.location.reload();
            })
        },
        error: function (error) {
            Swal.fire({
                title: "Error",
                text: error.responseJSON.message,
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
                window.location.reload();
            })
        },
        error: function (error) {
            Swal.fire({
                title: "Error",
                text: error.responseJSON.message,
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
                window.location.reload();
            })
        },
        error: function (error) {
            Swal.fire({
                title: "Error",
                text: error.responseJSON.message,
                icon: "error",
            });
        }
    });

}

