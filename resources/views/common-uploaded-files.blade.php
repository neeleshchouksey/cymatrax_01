
            @if(count($getData))
                <table class="tr-table">
                    <tbody>
                    @foreach($getData as $key=>$item)
                        <tr>
                            <td><b>Upload
                                    Date:</b><span>{{ Carbon\Carbon::parse($item->created_at)->format('d-M-Y, H: i A') }}</span>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <b>File Name:</b>
                                @if(!$item->cleaned)
                                    <span>{{$item->file_name}}</span>
                                @else
                                    <span>{{$item->processed_file}}</span>
                                @endif
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <b> File duration :</b>
                                <span id="duration{{$key}}"></span>
                                <button style="visibility:hidden;" type="button" onclick="getDuration({{$key}})"
                                        class="getdur">Get Duration
                                </button>
                                <span id="ids{{$key}}"></span>
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr class="tr-border">
                            <td>
                                <input type="hidden" id="duration_in_sec{{$key}}" class="durValue"/>
                                <audio id="audio{{$key}}" controls="" style="vertical-align: middle"
                                       src="{{ asset('public/upload/'.$item->file_name) }}" type="audio/mp3"
                                       controlslist="nodownload">
                                    Your browser does not support the audio element.
                                </audio>
                            </td>
                            <td>
                                @if(!$item->cleaned)

                                    <button class="c-btn"
                                       onclick="document.location = '{{URL::to('/')}}/download-file/{{$item->file_name}}'"
                                       >Download</button>
                                @else
                                    <button class="c-btn"
                                            onclick="document.location = '{{URL::to('/')}}/download-file/{{$item->file_name}}'"
                                       >Download</button>
                                @endif
                            </td>
                            <td>
                                @if(!$item->cleaned)
                                    <button onclick="document.location = '{{URL::to('/')}}/checkout-single/{{$item->id}}'" class="c-btn">Pay
                                        &
                                        Checkout</button>
                                @else
                                    <button onclick="document.location = '{{URL::to('/')}}/audio-analysis/{{$item->id}}'" class="c-btn">Audio
                                        Analysis</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <h4>No Data Found</h4>
            @endif
