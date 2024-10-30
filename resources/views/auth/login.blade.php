<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<style>
body{
    overflow: hidden;
    margin: 0px
}
.loginform-input:focus{
    border-color: #00a83d !important;
    box-shadow: none !important;
}
.login-section {
    background-image: url(/images/grass-image.png);
     height: 100vh;
    overflow: hidden;
    background-attachment: fixed;
    background-position: center;
    background-size: cover

}
.login-card{
    padding: 50px
}
.login-btn{

background-color:#00a83d;
color:white;
}
.login-btn:focus{

background-color:#00a83d;
color:white;
border-color: #e3e7eb !important;
box-shadow: none !important;

}
.login-btn:focus{

background-color:#00a83d;
color:white;
border-color: #e3e7eb !important;
box-shadow: none !important;

}
.login-btn:hover{

background-color:#00a83d;
color:white;
border-color: #e3e7eb !important;
box-shadow: none !important;

}
</style>
<section class="login-section d-flex align-items-center justify-content-center">
<div class="container">
    <div class="row justify-content-center">
        <div class=" col-12 col-sm-12 col-md-8 col-lg-5 p-4">
            <div class="card login-card">
                <div class="bg-0 mx-auto pb-5">
                    <img src="{{ asset('images/logo.png') }}" class="img-fluid" width="111" height="111" alt="logo image" >

                </div>

                <div class="card-body p-0">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">

                            <div class="form-group col-12 mb-3">

                                <input id="email" type="email" class="loginform-input form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-12 mb-3">

                                <input id="password" type="password" class="loginform-input form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                            <div class="col-12 text-center d-grid mt-5">
                                <button type="submit" class="btn btn-md btn-block login-btn">
                                    {{ __('Login') }}
                                </button>

                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link text-decoration-none text-end text-success" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
                            </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
