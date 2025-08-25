<!-- WRAPPER -->
<div id="wrapper">
    <style>
        .theme-cyan .auth-main .btn-primary {
            background: #025888;
            border-color: #1b9b48;
        }
    </style>
    <div class="vertical-align-wrap">
        <div class="vertical-align-middle auth-main">
            <div class="auth-box">
                <div class="top">
                    <img src="{{ asset('assets/images/logo.png') }}" width="200" alt="Lucid">
                </div>
                <div class="card">
                    <div class="header">
                        <p class="lead">Login to your account</p>
                    </div>
                    <div class="body">
                        <form wire:submit.prevent="login" class="form-auth-small">
                            @csrf
                            <div class="form-group">
                                <label for="signin-email" class="control-label sr-only">Email</label>
                                <input type="email" wire:model.lazy="email"
                                    class="form-control @error('email') is-invalid @enderror" id="signin-email"
                                    placeholder="Email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="signin-password" class="control-label sr-only">Password</label>
                                <input type="password" wire:model.lazy="password"
                                    class="form-control @error('password') is-invalid @enderror" id="signin-password"
                                    placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group clearfix">
                                <label class="fancy-checkbox element-left">
                                    <input type="checkbox" wire:model="remember">
                                    <span>Remember me</span>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                LOGIN
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
