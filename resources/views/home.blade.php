@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload files from here </div>
                <div class="card-body">
                <div class="card-title text-center text-white card-style">
                  Audio Conversion Tool
                </div>
                    <form id="dropzoneForm" enctype="multipart/form-data" class="dropzone" action="{{ route('file.upload') }}" >
                    

                        @csrf
                       
                    </form>

                    <div align="center">
                    <br>
            <button type="button" class="btn btn-info" id="submit-all">Upload</button>
            


          </div>

  
                </div>

            </div>
        </div>
    </div>
</div>

<!-- <script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        Swal.fire({
                title: 'Error',
                text: 'Your payment not done.',
                icon: 'error',
                showCancelButton: false,
            });
    }
  </script> -->

  <script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){

            Swal.fire({
                title: 'Thank You',
                text: 'File uploaded sucessfully...',
                icon: 'success',
                showCancelButton: false,
            });
    }
  </script>
@endsection

