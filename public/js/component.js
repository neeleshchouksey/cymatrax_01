Dropzone.options.dropzoneForm = {
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 100,
    acceptedFiles: ".mp3",
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
                    window.location = APP_URL + '/filedetail/' + count;
                    //  window.location = APP_URL+'/file/fetch';

                })

        });

    }

};

function hello() {
    alert('Hello world! in func hello');
}

$(function () {
    $('div[onload]').trigger('onload');
});

var total = 0;

function getDuration(aud_id) {
    setTimeout(function () {
        var duration = document.getElementById("audio" + aud_id).duration; //in seconds
        var duration_in_sec = document.getElementById("audio" + aud_id).duration; //in seconds
        var minutes = Math.floor(duration / 60);
        var seconds = Math.floor(duration % 60);

        $("#duration" + aud_id).html(minutes + "." + seconds);
        $("#duration_in_sec" + aud_id).val(duration_in_sec);
    }, 500);

}
