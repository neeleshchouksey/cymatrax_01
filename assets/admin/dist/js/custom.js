function activateDeactivateUser(id,status){
    if(status){
        st = "Activate";
    }else{
        st = "Deactivate"
    }
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to "+st+" this user ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, '+st+' it!'
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
function resetTrial(id){
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
                url: APP_URL + "/admin/reset-trial/"+id,
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
