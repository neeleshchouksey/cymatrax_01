@extends('layouts.app')

@section('content')

<div class="content">
    <section class="banner-section">
        <div class="banner-section-left">
            <h1 class="banner-section-title"> Take audio from better to best </h1>
            <h3 class="banner-section-subtitle">All digital audio can make you healthier. You are one step away from
                making
                it happen.
            </h3>

            <div class="reg">
                <div>
                    @if (session('status'))
                    <div class="success">{{ session('status') }}</div>
                    @endif

                    @php $error = $errors->getMessages(); @endphp

                    @if (isset($error['email']))
                    <div class="errors">{{ $error['email'][0] }}</div>
                    @elseif(isset($error['password']))
                    <div class="errors">{{ $error['password'][0] }}</div>
                    @endif

                    <br>
                    <form method="POST" action="{{ route('home-register') }}" class="register" id="register-form">
                        @csrf
                        <div>
                            <h3>Registration</h3>

                        </div>
                        <table>
                            <tbody>

                                <tr>
                                    <td>Email Address<span class="req">*</span> :</td>
                                    <td>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    </td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td>
                                        <button type="submit">Create Account</button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    </form>
                </div>

            </div>
        </div>
        <div class="banner-section-right">
            <div class="feature">
                <article>
                    <div>
                        <h3>Conversion Service</h3>
                        <div class="clip-wrapper">
                            <video autoplay muted loop>
                                <source src="{{URL::to('/')}}/assets/images/spectrum.mp4" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <h4>Digital Audio</h4>
                        <?php
                                $const_settings = DB::table('constant_settings')->where('id',6)->first();
                            ?>
                        <p>{{ $const_settings->value }}</p>
                        <a href="{{URL::to('/')}}/services/">
                            <button>LEARN MORE</button>
                        </a>
                    </div>
                </article>
                <!--
                    <video controls autoplay muted>
                    <source src="assets/v9.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                    </video>
                    -->
            </div>

        </div>
    </section>







    <section class="inverted">
        <h1>Why Cymatrax?</h1>
        <blockquote>
            <q>It’s absolutely logical and surprising no one has ever thought of this.</q>
            <p>Neurobiology Chair, UAB</p>
        </blockquote>
        <ul class="faq">
            <li>
                <h3>White Noise Puts You to Sleep</h3>
                <p>You know people that listen to white noise to go to sleep. White noise is found in all digital
                    audio.
                    With a reduction of the white noise volume in recordings your concentration and energy levels
                    are
                    raised for greater cognitive ability.</p>
            </li>
            <li>
                <h3>Former NASA Engineer</h3>
                <p>&#8220;Having this remarkable quality audio enhanced the ability of our listeners to hear the
                    materials.&#8221; C.C. Culver, international speaker Leadership ,Management, Organization,
                    Systems
                    Engineering and Space Exploration.</p>
            </li>
            <li>
                <h3>Music Recording Studios</h3>
                <p>&#8220;I had so much energy, I felt like I could dance all night long. (My own master) was murky
                    and
                    put me to sleep. Every recording studio on the world needs to be using this!&#8221; claims one
                    Grammy Hall of Fame Member.</p>
            </li>
            <li>
                <h3>Audio fidelity at its finest.</h3>
                <p>Cymatrax combines vibrational frequency, world-class sound engineering in a patented system,
                    enabling
                    , less stress , more energy and a higher cognitive ability of the brain from any digital audio
                    file.</p>
            </li>
            <li>
                <h3>Podcasters</h3>
                <p>Reap rewards of longer engagement, increased audiences and higher subscriptions with frequency
                    based
                    delivery of digital audio in a process called &#8220;Optimized Signal Transduction.&#8221;</p>
            </li>
            <li>
                <h3>Online education</h3>
                <p>Retention is significantly raised with the Cymatrax patented technology, which will raise a
                    student’s
                    GPA as well as so higher success in teaching success from all online teaching educational
                    entities.</p>
            </li>

        </ul>
    </section>
</div>
@endsection