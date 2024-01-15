<x-layouts-auth.base pageTitle="Register |">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card overflow-hidden m-0">
                    <div class="row justify-content-center g-0">
                        <div class="col-lg-6">
                            <div class="p-lg-5 p-4 auth-one-bg h-100">
                                <div class="bg-overlay"></div>
                                <div class="position-relative h-100 d-flex flex-column">
                                    <div class="mb-4">
                                        <a href="#" class="d-block">
                                            <img src="assets/images/logo-light.png" alt="" height="18">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card h-100">
                                <livewire:auth.register-page />
                                <div class="mt-2 text-center">
                                    <p class="mb-0">Already have an account ? <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-underline"> Login</a> </p>
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
            document.querySelector("#profile-img-file-input") && document.querySelector("#profile-img-file-input").addEventListener("change", function() {
                var e = document.querySelector(".user-profile-image"),
                    t = document.querySelector(".profile-img-file-input").files[0],
                    r = new FileReader;
                r.addEventListener("load", function() {
                    e.src = r.result
                }, !1), t && r.readAsDataURL(t)
            })
        </script>
    @endpush
    @push('styles')
        <style>
            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            .spinning-icon {
                animation: spin 2s infinite linear;
            }
        </style>
    @endpush
</x-layouts-auth.base>
