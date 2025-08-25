<div>
    <style>
        .login-box {
            max-width: 400px;
            width: 100%;
            padding: 2rem;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto;
        }
    </style>

    <div class="login-box" style="margin-top: 200px; margin-bottom:50px;">
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
        <h2 class="text-center mb-4">Forget Password</h2>
        @if ($forget == true)
            <form wire:submit.prevent="forgetPassword">
                <div class="mb-3" style="margin-top: 20px;">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" wire:model.defer="email"
                        placeholder="Enter email" required />
                </div>

                <div class="d-grid mb-3" style="margin-top: 20px;text-align: center;">
                    <button type="submit" class="btn btn-primary">Forget Password</button>
                </div>
            </form>
        @elseif($this->forgetpassword == true)
            <form wire:submit.prevent="forgetPasswordNew">
                <div class="mb-3" style="margin-top: 20px;">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" wire:model.defer="password"
                        placeholder="Enter password" required />
                </div>

                <div class="d-grid mb-3" style="margin-top: 20px;text-align: center;">
                    <button type="submit" class="btn btn-primary">Forget Password</button>
                </div>
            </form>
        @else
            <div>
                <form wire:submit.prevent="verifyOtp">
                    <div class="mb-3" style="margin-top: 20px;">
                        <label>Enter OTP</label>
                        <div style="display: flex; gap: 10px; margin-top: 20px;">
                            @for ($i = 0; $i < 5; $i++)
                                <input type="text" maxlength="1" wire:model="otpDigits.{{ $i }}"
                                    class="form-control text-center" style="width: 50px; font-size: 24px;" />
                            @endfor
                        </div>
                        @error('otpDigits')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-grid mb-3" style="margin-top: 20px;text-align: center;">
                        <button type="submit" class="btn btn-primary">
                            Verify OTP
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('input[type="text"][wire\\:model^="otpDigits"]');

            inputs.forEach((input, index) => {
                input.addEventListener('input', () => {
                    if (input.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });
            });
        });
    </script>
</div>
