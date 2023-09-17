@if(count($getData))
        <div class="tr-border" id="audio-list">
        </div>
@else
    @if(Request::segment(1) == "account")
        <h4>Welcome {{Auth::user()->name}}, you have not uploaded audio files yet, please <a class="href-link"
                                                                                             href="{{URL::to('/')}}/upload-audio">click
                here</a> to begin</h4>
    @else
        <h4>No Data Found</h4>
    @endif
@endif
