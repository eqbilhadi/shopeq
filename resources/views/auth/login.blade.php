<x-layouts-auth.base pageTitle="Login | ">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card overflow-hidden">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="p-lg-5 p-4 auth-one-bg h-100">
                                <div class="bg-overlay"></div>
                                <div class="position-relative h-100 d-flex flex-column">
                                    <div class="mb-4">
                                        <a href="{{ route('login') }}" class="d-block">
                                            <img src="assets/images/logo-light.png" alt="" height="18">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="p-lg-5 p-4">
                                <div>
                                    <h5 class="text-primary"><i class="fa-sharp fa-solid fa-wreath fa-sm me-2"></i>Welcome Back !</h5>
                                    <p class="text-muted">Log in to continue to App.</p>
                                </div>

                                <div class="mt-4">
                                    <form action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email/Username</label>
                                            <input type="text" class="form-control" id="email" name="email" @error('email') is-invalid @enderror placeholder="Enter email or username" value="{{ old('email') }}" required>
                                            @error('email')
                                                <small class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </small>
                                            @enderror
                                            @error('username')
                                                <small class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </small>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            {{-- <div class="float-end">
                                                <a href="auth-pass-reset-cover.html" class="text-muted">Forgot password?</a>
                                            </div> --}}
                                            <label class="form-label" for="password">Password</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5 password-input" name="password" placeholder="Enter password" id="password-input" @error('password') is-invalid @enderror required>
                                                <button aria-label="show password" class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                            @error('password')
                                                <small class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </small>
                                            @enderror
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Log In</button>
                                        </div>

                                    </form>
                                </div>

                                <div class="mt-5 text-center">
                                    <p class="mb-0">Don't have an account ? <a href="{{ route('register') }}" class="fw-semibold text-primary text-decoration-underline"> Register</a> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @push('scripts')
        <script>
            Array.from(document.querySelectorAll("form .auth-pass-inputgroup")).forEach(function(e) {
                Array.from(e.querySelectorAll(".password-addon")).forEach(function(r) {
                    r.addEventListener("click", function(r) {
                        var o = e.querySelector(".password-input");
                        "password" === o.type ? o.type = "text" : o.type = "password"
                    })
                })
            });
        </script>
    @endpush
</x-layouts-auth.base>
