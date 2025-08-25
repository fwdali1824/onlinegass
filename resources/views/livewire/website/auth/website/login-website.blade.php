<div>
    <style>
        .login-box {
            max-width: 400px;
            width: 100%;
            padding: 2rem;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* margin: auto; */
        }
    </style>

    <div class="login-box" style="margin-top: 50px; margin-bottom:50px;">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <h2 class="text-center mb-4">Login Form</h2>
        <form wire:submit.prevent="login">
            <div class="mb-3" style="margin-top: 20px;">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" wire:model.defer="email"
                    placeholder="Enter email" required />
            </div>
            <div class="mb-3" style="margin-top: 20px">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" wire:model.defer="password"
                    placeholder="Password" required />
            </div>
            <div class="d-grid mb-3" style="margin-top: 20px;">
                <button type="submit" class="btn theme-btn">Login</button>
            </div>
            <div class="text-left">
                <small><a href="#">Forgot password?</a></small>
            </div>
        </form>
    </div>
</div>
