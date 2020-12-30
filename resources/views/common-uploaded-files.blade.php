@if(count($getData))
    @foreach($getData as $key=>$item)
        <div class="tr-border">
        <div class="row">
            <div>
                <b>Upload Date:</b>
                <span>{{ Carbon\Carbon::parse($item->created_at)->format('d-M-Y, H: i A') }}</span>
            </div>
        </div>
        <div class="row">
            <div>
                <b>File Name:</b>
                @if(!$item->cleaned)
                    <span>{{$item->file_name}}</span>
                @else
                    <span>{{$item->processed_file}}</span>
                @endif
            </div>
        </div>
        <div class="row">
            <div>
                <b> File duration :</b>
                <span id="duration{{$key}}"></span>
                <button style="visibility:hidden;" type="button" onclick="getDuration({{$key}})"
                        class="getdur">Get Duration
                </button>
                <span id="ids{{$key}}"></span>
            </div>
        </div>
        <div class="half-row">
            <div>
                <input type="hidden" id="duration_in_sec{{$key}}" class="durValue"/>
                <audio id="audio{{$key}}" controls="" style="vertical-align: middle"
                       src="{{ asset('public/upload/'.$item->file_name) }}" type="audio/mp3"
                       controlslist="nodownload">
                    Your browser does not support the audio element.
                </audio>
            </div>
            <div class="flex">
                @if(!$item->cleaned)

                    <button class="c-btn1 mr-2"
                            onclick="document.location = '{{URL::to('/')}}/download-file/{{$item->file_name}}'"
                    >Download</button>
                @else
                    <button class="c-btn1 mr-2"
                            onclick="document.location = '{{URL::to('/')}}/download-file/{{$item->file_name}}'"
                    >Download</button>
                @endif

                    @if(!$item->cleaned)
                        <button onclick="document.location = '{{URL::to('/')}}/checkout-single/{{$item->id}}'" class="c-btn1 mr-2">Pay
                            &
                            Checkout</button>
                    @else
                        <button onclick="document.location = '{{URL::to('/')}}/audio-analysis/{{$item->id}}'" class="c-btn1 mr-2">Audio
                            Analysis</button>
                    @endif
            </div>
        </div>
        </div>
    @endforeach
@else
    <h4>No Data Found</h4>
@endif
