Dropzone.options.dropzoneForm = {
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 100,
    acceptedFiles: ".mp3,.wav",
    maxFiles: 25,
    maxFilesize: 500, // MB
    addRemoveLinks: true,

    init: function () {


        var myDropZone = this;
        myDropZone.on('maxfilesexceeded', function (file) {    // remove more than 25 files function validation
            Swal.fire({
                title: 'Error',
                text: 'Upto 25 files are allowed at once',
                icon: 'error',
                showCancelButton: false,
            });
            myDropzone.removeFile(file); //remove button code
        });


        myDropZone.on("error", function (file, message) {    //max file size validation 500mb
            console.log(message);
            Swal.fire({
                title: 'Error',
                text: message,
                icon: 'error',
                showCancelButton: false,
            });
            myDropzone.removeFile(file); //remove button code
        });


        var submitButton = document.querySelector("#submit-all");
        // var cancelButton = document.querySelector("#cancel-all");
        myDropzone = this;

        // console.log(myDropzone.files);


        submitButton.addEventListener('click', function () {
            myDropzone.processQueue();
        });

        //for getting total mb fil size

        this.on("addedfile", function (file) {
            var fileSizes = file.size;
            $('.att-filesize').html(fileSizes).append(' Bytes');
            var sizeInMB = (fileSizes / (1024 * 1024)).toFixed(2);
            console.log((sizeInMB + 'MB'));
        });
//end

//for sending file data
        myDropzone.on("sending", function (file, xhr, data) {

            // First param is the variable name used server side
            // Second param is the value, you can add what you what
            // Here I added an input value
            data.append("price", '1000');
        });


        this.on("success", function (data) {

            var file = myDropzone.files[0];
            var count = myDropzone.files.length;

            console.log(count);

            Swal.fire({
                title: 'Thank You',
                text: 'File uploaded sucessfully...',
                icon: 'success',
                showCancelButton: false,
            })
                .then((result) => {
                    console.log(result);
                    window.location = APP_URL + '/upload-summary/' + count;
                    //  window.location = APP_URL+'/file/fetch';

                })

        });

    }

};

var total = 0;

function getDuration(aud_id) {

    setTimeout(function () {
        var duration = document.getElementById("audio" + aud_id).duration; //in seconds
        var duration_in_sec = document.getElementById("audio" + aud_id).duration; //in seconds

        var minutes = Math.floor(duration / 60);
        var seconds = Math.floor(duration % 60);

        $("#duration" + aud_id).html(minutes + "." + seconds);

        $("#duration_in_sec" + aud_id).val(duration_in_sec);

    }, 1500);


}

function onlyNumberKey(evt) {

    // Only ASCII charactar in that range allowed
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
    return true;
}

function checkout() {
    $("#process-button").html("Loading...");
    $("#input-button").prop("disabled", true);
    $("#process-button").prop("disabled", true);
    $.ajax({
        method: "post",
        url: APP_URL + "/payment/store",
        data: {
            "_token": CSRF_TOKEN,
            "amount": $("#paypal_total_cost").val(),
            "number": $("#number").val(),
            "expiry": $("#expiry").val(),
            "cvc": $("#cvc").val(),
            "firstName": $("#first-name").val(),
            "lastName": $("#last-name").val(),
            "email": $("#email").val(),
            "streetaddress": $("#streetaddress").val(),
            "city": $("#city").val(),
            "state": $("#state").val(),
            "country": $("#country").val(),
            "zipcode": $("#zipcode").val(),
            "checkout_id": $("#checkout_id").val(),
            "totalduration": $("#paypal_total_duration").val(),
            "fileids": $("#fileids").val()
        },
        success: function (response) {
            $("#process-button").html("Process Payment");
            $("#process-button").prop("disabled", false);
            $("#input-button").prop("disabled", false);
            console.log(response);
            Swal.fire({
                title: 'Thank You',
                text: response.msg,
                icon: 'success',
                showCancelButton: false,
            }).then((result) => {
                window.location = APP_URL + '/transaction-details/' + response.payment_id;
            })
        },
        error: function (error) {
            $("#process-button").html("Process Payment");
            $("#process-button").prop("disabled", false);
            $("#input-button").prop("disabled", false);
            console.log(error);
            Swal.fire({
                title: "Error",
                text: error.responseJSON.msg,
                icon: "error",
            });
        }
    });
}
function clean_files(id) {
    $("#alert-info").html('<div class="alert">' +
        'Processing Files! Please DO NOT close your browser, this may take several minutes' +
        '</div>');
    $("#clean-btn").html("Loading...");
    $("#clean-btn").prop("disabled", true);
    $.ajax({
        method: "get",
        url: APP_URL + "/clean-files/"+id,
        success: function (response) {
            $("#alert-info").hide();
            $("#clean-btn").html("Clean File(s)");
            $("#clean-btn").prop("disabled", false);
            console.log(response);
            Swal.fire({
                title: 'Success!',
                text: response.msg,
                icon: 'success',
                showCancelButton: false,
            }).then((result) => {
                window.location = APP_URL + '/account';
            })
        },
        error: function (error) {
            $("#clean-btn").html("Loading...");
            $("#clean-btn").prop("disabled", true);
            console.log(error);
            Swal.fire({
                title: "Error",
                text: error.responseJSON.msg,
                icon: "error",
            });
        }
    });
}

function clean_files_with_free_trial(id) {
    $("#alert-info").html('<div class="alert">' +
        'Processing Files! Please DO NOT close your browser, this may take several minutes' +
        '</div>')
    $("#clean-btn").html("Loading...");
    $("#clean-btn").prop("disabled", true);
    $.ajax({
        method: "get",
        url: APP_URL + "/clean-files-with-free-trial/"+id,
        success: function (response) {
            $("#clean-btn").html("Clean File(s)");
            $("#clean-btn").prop("disabled", false);
            console.log(response);
            Swal.fire({
                title: 'Success!',
                text: response.msg,
                icon: 'success',
                showCancelButton: false,
            }).then((result) => {
                window.location = APP_URL + '/account';
            })
        },
        error: function (error) {
            $("#clean-btn").html("Loading...");
            $("#clean-btn").prop("disabled", true);
            console.log(error);
            Swal.fire({
                title: "Error",
                text: error.responseJSON.msg,
                icon: "error",
            });
        }
    });
}
function clean_file(id) {
    $("#alert-info").html('<div class="alert">' +
        'Processing Files! Please DO NOT close your browser, this may take several minutes' +
        '</div>')
    $("#clean-btn"+id).html("Loading...");
    $("#clean-btn"+id).prop("disabled", true);
    $.ajax({
        method: "get",
        url: APP_URL + "/clean-file/"+id,
        success: function (response) {
            $("#clean-btn"+id).html("Clean File(s)");
            $("#clean-btn"+id).prop("disabled", false);
            console.log(response);
            Swal.fire({
                title: 'Success!',
                text: response.msg,
                icon: 'success',
                showCancelButton: false,
            }).then((result) => {
                window.location = APP_URL + '/account';
            })
        },
        error: function (error) {
            $("#clean-btn"+id).html("Loading...");
            $("#clean-btn"+id).prop("disabled", true);
            console.log(error);
            Swal.fire({
                title: "Error",
                text: error.responseJSON.msg,
                icon: "error",
            });
        }
    });
}

function clean_multiple_files_with_free_trial() {

    var ids = [];
    $('input.testCheckbox[type="checkbox"]:checked').each(function () {
        if ($(this).attr("idd") > 0) {
            ids.push($(this).attr("idd"));
        }
    });
    if (ids.length > 0) {
        $("#alert-info").html('<div class="alert">' +
            'Processing Files! Please DO NOT close your browser, this may take several minutes' +
            '</div>')
        $("#clean-btn").html("Loading...");
        $("#clean-btn").prop("disabled", true);
        $.ajax({
            method: "post",
            url: APP_URL + "/clean-multiple-files-with-free-trial",
            data: {
                "_token": CSRF_TOKEN,
                "id": ids
            },
            success: function (response) {
                $("#clean-btn").html("Clean File(s)");
                $("#clean-btn").prop("disabled", false);
                console.log(response);
                Swal.fire({
                    title: 'Success!',
                    text: response.msg,
                    icon: 'success',
                    showCancelButton: false,
                }).then((result) => {
                    window.location = APP_URL + '/account';
                })
            },
            error: function (error) {
                $("#clean-btn").html("Loading...");
                $("#clean-btn").prop("disabled", true);
                console.log(error);
                Swal.fire({
                    title: "Error",
                    text: error.responseJSON.msg,
                    icon: "error",
                });
            }
        });
    }
}
function clean_multiple_files() {

    var ids = [];
    $('input.testCheckbox[type="checkbox"]:checked').each(function() {
        if($(this).attr("idd") > 0){
            ids.push($(this).attr("idd"));
        }
    });
    if(ids.length > 0) {
        $("#alert-info").append('<div class="alert">' +
            'Processing Files! Please DO NOT close your browser, this may take several minutes' +
            '</div>')
        $("#clean-btn").html("Loading...");
        $("#clean-btn").prop("disabled", true);
        $.ajax({
            method: "post",
            url: APP_URL + "/clean-multiple-file",
            data: {
                "_token": CSRF_TOKEN,
                "id": ids
            },
            success: function (response) {
                $("#clean-btn").html("Clean File(s)");
                $("#clean-btn").prop("disabled", false);
                console.log(response);
                Swal.fire({
                    title: 'Success!',
                    text: response.msg,
                    icon: 'success',
                    showCancelButton: false,
                }).then((result) => {
                    window.location = APP_URL + '/account';
                })
            },
            error: function (error) {
                $("#clean-btn").html("Loading...");
                $("#clean-btn").prop("disabled", true);
                console.log(error);
                Swal.fire({
                    title: "Error",
                    text: error.responseJSON.msg,
                    icon: "error",
                });
            }
        });
    }
}

function redirectUrl(url) {
    window.location = url;
}

function fileFilter(value){
    $("#audio-list").html('');
    // $('#overlay').fadeIn();
    var currentUrl = document.URL.split('/');
    var segment1 = currentUrl[currentUrl.length - 1];
    var segment2 = currentUrl[currentUrl.length - 2];
    if(segment1 == 'multiple-checkout'){
        getMultiCheckoutDuration($('#fileids').val());
    }
    if (segment1 == "account") {
        var url = APP_URL + "/get-account-audio/" + value;
    }
    if (segment2 == "upload-summary" || segment2 == "checkout" || segment2 == "checkout-single") {
        var url = APP_URL + "/get-uploaded-audio/" + segment1;
    }
    if (segment2 == "transaction-details") {
        var url = APP_URL + "/get-transaction-audio/" + segment1;
    }

    if (segment1 == "account" || segment2 == "upload-summary" || segment2 == "transaction-details" || segment2 == "checkout" || segment2 == "checkout-single") {

        $.ajax({
            method: "get",
            url: url,
            success: function (response) {
                var data = response.res;
                if(data.length > 0){
                for (var i = 0; i < data.length; i++) {
                    aud_id = data[i].id;

                    $new_array = data[i].file_name.split('_');
                    console.log($new_array);
                    $new_array.shift();
                    console.log($new_array);
                    $new_array = $new_array.join('_');
                    console.log($new_array);
                    // data[i].file_name.toString();
                    // console.log(data[i].file_name);

                    var html = '';

                    /*var hrhtmlclass = '';
                    if((data.length) % 2 != 0){
                        $('#file_count').addClass('mt-248');
                        if(i == data.length-1 )
                        hrhtmlclass = 'hr-html';
                    }*/

                    /*var hr_html = '';
                    if((i+1) % 2 == 0){
                        hr_html = '<hr class="hr-line">';
                    }*/

                    if (segment2 != 'upload-summary') {
                        var current_time = Math.floor(Date.now() / 1000);
                        if (!data[i].cleaned) {
                            if(!data[i].trial_expiry_date || data[i].trial_expiry_date<current_time) {

                                if(data[i].is_admin){
                                    var oncl1 = APP_URL + '/download-file/' + data[i].file_name
                                    html = '<div class="flex">' +
                                        '<button class="c-btn1 mr-2" onclick="redirectUrl(\'' + oncl1 + '\')">Download </button>' +
                                        '<button class="c-btn1 mr-2" id="clean-btn'+data[i].id+'" onclick="clean_file('+data[i].id+')">Clean File </button>' +
                                        '</div>';
                                }else{
                                    var oncl1 = APP_URL + '/download-file/' + data[i].file_name
                                    var oncl2 = APP_URL + '/checkout-single/' + data[i].id
                                    html = '<div class="flex">' +
                                        '<button class="c-btn1 mr-2" onclick="redirectUrl(\'' + oncl1 + '\')">Download </button>' +
                                        '<button class="c-btn1 mr-2" onclick="redirectUrl(\'' + oncl2 + '\')">Pay & Checkout </button>' +
                                        '</div>';
                                }

                            }else{
                                var oncl1 = APP_URL + '/download-file/' + data[i].file_name
                                html = '<div class="flex">' +
                                    '<button class="c-btn1 mr-2" onclick="redirectUrl(\'' + oncl1 + '\')">Download </button>' +
                                    '<button class="c-btn1 mr-2" id="clean-btn'+data[i].id+'" onclick="clean_file('+data[i].id+')">Clean File </button>' +
                                    '</div>';
                            }
                        } else {
                            var oncl1 = APP_URL + '/download-file/' + data[i].processed_file
                            var oncl2 = APP_URL + '/audio-analysis/' + data[i].id
                            html = '<div class="flex">' +
                                '<button class="c-btn1 mr-2" onclick="redirectUrl(\'' + oncl1 + '\')">Download </button>' +
                                '<button class="c-btn1 mr-2" onclick="redirectUrl(\'' + oncl2 + '\')">Audio Analysis </button>' +
                                '</div>';

                        }
                    }

                    if (segment1 == "account"){
                        var cleanText = '';
                        var idd = '';
                        if(data[i].cleaned == 0){
                            var cleanText = 'Uncleaned';
                            var idd = data[i].id;
                        }else{
                            var cleanText = 'Cleaned';
                        }

                        var dlink = APP_URL + '/public/upload/' + data[i].file_name;

                        $("#audio-list-datatable").append('<tr class="border_bottom">\n' +
                            '                    <td style="cursor:pointer;" title="'+data[i].file_name+'">' + $new_array.substring(0,15) + ($new_array.length > 15 ? "..." : "") + '</td>\n' +
                            '                    <td><span id="duration' + aud_id + '"></span></td>\n' +
                            '                    <td>' + data[i].created + '</td>\n' +
                            '                    <td><input type="hidden" id="duration_in_sec' + aud_id + '" class="durValue"/>' +
                            '                    <audio id="audio' + aud_id + '" controls="" style="vertical-align: middle"' +
                            '                           src="' + APP_URL + '/public/upload/' + data[i].file_name + '" type="audio/mp3"' +
                            '                           controlslist="nodownload">' +
                            '                        Your browser does not support the audio element.' +
                            '                    </audio></td>\n' +
                            '                    <td>' + cleanText + '</td>\n' +
                            '                    <td style="width: 5px"><input onchange="checkboxCount();" class="testCheckbox" link="'+dlink+'" idd="'+idd+'" type="checkbox"> </td>\n' +
                            '                </tr>');

                    }
                    else if (segment2 == "upload-summary"){
                        var cleanText = '';
                        var idd = '';
                        if(data[i].cleaned == 0){
                            var cleanText = 'Uncleaned';
                            var idd = data[i].id;
                        }else{
                            var cleanText = 'Cleaned';
                        }

                        var dlink = APP_URL + '/public/upload/' + data[i].file_name;

                        $("#audio-list-datatable").append('<tr class="border_bottom">\n' +
                            '                    <td style="cursor:pointer;" title="'+data[i].file_name+'">' + $new_array.substring(0,15) + ($new_array.length > 15 ? "..." : "") + '</td>\n' +
                            '                    <td><span id="duration' + aud_id + '"></span></td>\n' +
                            '                    <td>' + data[i].created + '</td>\n' +
                            '                    <td><input type="hidden" id="duration_in_sec' + aud_id + '" class="durValue"/>' +
                            '                    <audio id="audio' + aud_id + '" controls="" style="vertical-align: middle"' +
                            '                           src="' + APP_URL + '/public/upload/' + data[i].file_name + '" type="audio/mp3"' +
                            '                           controlslist="nodownload">' +
                            '                        Your browser does not support the audio element.' +
                            '                    </audio></td>\n' +
                            '                    <td>' + cleanText + '</td>\n' +
                            '                </tr>');

                    }
                    else {
                        $("#audio-list").append('  <div class="row">' +
                            '                <div>' +
                            '                    <b>Upload Date:</b>' +
                            '                    <span>' + data[i].created + '</span>\n' +
                            '                </div>' +
                            '            </div>' +
                            '            <div class="row">' +
                            '                <div>' +
                            '                    <b>File Name:</b>' +

                            '                        <span>' + $new_array + '</span>' +

                            '                </div>' +
                            '            </div>' +
                            '            <div class="row">' +
                            '                <div>' +
                            '                    <b> File duration :</b>' +
                            '                    <span id="duration' + aud_id + '"></span>' +
                            '                </div>' +
                            '            </div>' +
                            '            <div class="half-row">' +
                            '                <div>' +
                            '                    <input type="hidden" id="duration_in_sec' + aud_id + '" class="durValue"/>' +
                            '                    <audio id="audio' + aud_id + '" controls="" style="vertical-align: middle"' +
                            '                           src="' + APP_URL + '/public/upload/' + data[i].file_name + '" type="audio/mp3"' +
                            '                           controlslist="nodownload">' +
                            '                        Your browser does not support the audio element.' +
                            '                    </audio>' +
                            '                </div>' + html +
                            '            </div>')
                    }
                    getDuration1(APP_URL + '/public/upload/' + data[i].file_name,aud_id);
                    // $('#overlay').fadeOut();
                }
                    if (segment1 == "account"){
                        $(document).ready(function() {
                            var table = $('#example').DataTable( {
                                pagingType:'simple',
                                "order": [[ 1, "desc" ]]
                                /*"oLanguage": {
                                    "oPaginate": {
                                        "sNext": '<button type="button" class="c-btn"">Next</button>',
                                        "sPrevious": '<button type="button" class="c-btn"">Previous</button>'
                                    }
                                }*/
                            } )
                            $('#selectAll').click(function(e) {
                                if($(this).hasClass('checkedAll')) {
                                    $('input').prop('checked', false);
                                    $(this).removeClass('checkedAll');
                                    $('#btnDownload').attr('disabled','disabled');
                                    $('#btnCheckout').attr('disabled','disabled');
                                    $('#clean-btn').attr('disabled','disabled');
                                } else {
                                    $('#btnDownload').removeAttr('disabled');
                                    $('#btnCheckout').removeAttr('disabled');
                                    $('#clean-btn').removeAttr('disabled');
                                    $('input').prop('checked', true);
                                    $(this).addClass('checkedAll');
                                }
                            });

                        } );
                    }
                }else{
                    if (segment1 == "account"){
                        var table = $('#example').DataTable( {
                            pagingType:'simple',
                            "order": [[ 1, "desc" ]]
                        })
                    }
                    $("#audio-list").html('<h4>No Data Found</h4>');
                }
            },
            error: function (error) {

            }
        });
    }
};

function checkboxCount(){
    setInterval(function(){
        var links = [];
        $('input.testCheckbox[type="checkbox"]:checked').each(function() {
            links.push($(this).attr("link"));
        });
        if(links.length > 0){
            $('#btnDownload').removeAttr('disabled');
            $('#btnCheckout').removeAttr('disabled');
            $('#clean-btn').removeAttr('disabled');
        }else{
            $('#btnDownload').attr('disabled','disabled');
            $('#btnCheckout').attr('disabled','disabled');
            $('#clean-btn').attr('disabled','disabled');
        }
    }, 1000);
}

function allDownload(){

    var links = [];
    $('input.testCheckbox[type="checkbox"]:checked').each(function() {
        links.push($(this).attr("link"));
    });


    for(var i = 0; i < links.length; i++) {
        var url = links[i];
        var name = url.split('/')[url.split('/').length-1];
        var a = document.createElement("a");
        a.setAttribute('href', url);
        a.setAttribute('download', name);
        a.setAttribute('target', '_blank');
        a.click();
    }
}

function allCheckout(){
    var ids = [];
    $('input.testCheckbox[type="checkbox"]:checked').each(function() {
        if($(this).attr("idd") > 0){
            ids.push($(this).attr("idd"));
        }
    });
    console.log(ids);
    var value = ids.toString();
    if(ids.length > 0){
        $('#allCheckoutIds').val(value);
        $('#multiple-checkout-frm').submit();
    }/*else{
        Swal.fire({
            title: 'Error',
            text: 'You can checkout for uncleaned files only',
            icon: 'error',
            showCancelButton: true,
        });
    }*/
}


$(document).ready(function () {
    fileFilter(2);
});

var total_min = 0;
var total_sec = 0;
var total_duration = 0;
var total_cost = 0;
function getDuration1(path,aud_id){
    console.log("duration1 calling");
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
        $("#duration_in_sec" + aud_id).val(duration_in_sec);


        var per_sec_cost = 1 / 60;
        total_cost = per_sec_cost * total_duration;
        $("#total-duration").html(total_min + ' min ' + total_sec + ' sec')
        $("#total-cost").html('$' + total_cost.toFixed(2))

        total_cost = total_cost.toFixed(2);
        $("#paypal_total_cost").val(total_cost)
        $("#span_paypal_total_cost").html("$ " + total_cost);
        $("#paypal_total_duration").val(total_min + '.' + total_sec)


        // example 12.3234 seconds
        console.log("The duration of the song is of: " + duration + " seconds");
        // Alternatively, just display the integer value with
        // parseInt(duration)
        // 12 seconds
    }, false);

}

function getTotalDuration() {

    var total_dur = document.getElementsByClassName('durValue');

    var total = 0;
    var total_duration = 0;

    for (var i = 0; i < total_dur.length; i++) {
        total = $("#" + total_dur[i].id).val();
        total_duration = total_duration + parseFloat(total);
    }
    var minutes = Math.floor(total_duration / 60);
    var seconds = Math.floor(total_duration % 60);

    var per_sec_cost = 1 / 60;

    total_cost = per_sec_cost * total_duration;

    $("#total-duration").html(minutes + ' min ' + seconds + ' sec')
    $("#total-cost").html('$' + total_cost.toFixed(2))


    total_cost = total_cost.toFixed(2);
    $("#paypal_total_cost").val(total_cost)
    $("#span_paypal_total_cost").html("$ " + total_cost);
    $("#paypal_total_duration").val(minutes + '.' + seconds)

}

function getMultiCheckoutDuration(str) {
    var arr = str.split(',');

    var tot_min = 0;
    var tot_sec = 0;
    var total_duration = 0;
    var tot_cost = 0;
    for(var i = 0; i < arr.length; i++) {
        var url = APP_URL + "/get-audio/" + arr[i];
        $.ajax({
            method: "get",
            url: url,
            success: function (response) {
                var data = response.res;

                var aud_id = data.id;
                var path = APP_URL + '/public/upload/' + data.file_name;


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
                    //$("#duration" + aud_id).html(minutes + "." + seconds);
                    //$("#duration_in_sec" + aud_id).val(duration_in_sec);


                    var per_sec_cost = 1 / 60;
                    total_cost = per_sec_cost * total_duration;
                    //$("#total-duration").html(total_min + ' min ' + total_sec + ' sec')
                    //$("#total-cost").html('$' + total_cost.toFixed(2))

                    total_cost = total_cost.toFixed(2);


                    tot_cost = parseFloat(tot_cost) + parseFloat(total_cost);
                    tot_min = tot_min + total_min;
                    tot_sec = tot_sec + total_sec;



                    //$("#paypal_total_cost").val(total_cost)
                    //$("#span_paypal_total_cost").html("$ " + total_cost);
                    //$("#paypal_total_duration").val(total_min + '.' + total_sec)


                    // example 12.3234 seconds
                    console.log("The duration of the song is of: " + duration + " seconds");
                    // Alternatively, just display the integer value with
                    // parseInt(duration)
                    // 12 seconds
                }, false);
            },
            error: function (error) {

            }
        });
    }

    setTimeout(function(){
        $("#paypal_total_cost").val(tot_cost.toFixed(2));
        $("#span_paypal_total_cost").html("$ " + tot_cost.toFixed(2));
        $("#paypal_total_duration").val(tot_min + '.' + tot_sec);
     }, 1000);












}
