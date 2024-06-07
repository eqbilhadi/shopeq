<x-layouts-app.base title="Navigation Management">
    <div class="container-fluid">
        {{ Breadcrumbs::render(Route::currentRouteName()) }}
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1" wire:navigate>Create User</h4>

                        <div class="flex-shrink-0">
                            <a href="{{ route('rbac.user.index') }}" class="btn btn-danger" wire:navigate>Back</a>
                        </div>

                    </div>
                    <livewire:rbac::user-management.user-create />
                </div>
            </div>
        </div>
    </div>
    <style>
        .select2-container .select2-search--inline .select2-search__field {
            margin: 5px;
        }
    </style>
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

        <script>
            $(document).ready(function() {
                $('#roleUser').select2({
                    placeholder: "Select User Role"
                })
            })
        </script>
    @endpush
    @push('styles')
        <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush
</x-layouts-app.base>
