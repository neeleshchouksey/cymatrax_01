@extends('layouts.app')

@section('content')

    <section class="contained">
        <h1 class="myaccount">{{$title}}
        <span class="free-trial">
             @if(!Auth::user()->trial_expiry_date)
                <a href="{{URL::to('/')}}/free-subscription">Start <b><?php echo get_free_trial_days(); ?> Days</b> free
                    trial</a>
            @elseif(Auth::user()->trial_expiry_date<time())
                Your trial period is expired
            @else
                Your trial period expire on {{ date("m/d/Y",Auth::user()->trial_expiry_date) }}
            @endif
        </span>
        </h1>
        
        <div class="relative">
        <select style="margin-bottom: 15px;" class="input" name="file_filter" id="file_filter" onchange="fileFilter(this.value);">  
            <option value="2">Filter By</option>
            <option value="0">Cleaned</option>
            <option value="1">Uncleaned</option>
            <option value="2">All</option>
            
        </select>
        </div>
        <div class="checkouttotal">
          @include('common-uploaded-files')
        </div>
    </section>

@endsection

