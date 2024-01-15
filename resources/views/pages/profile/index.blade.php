<x-layouts-app.base>
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Profile</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Profile</a></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        
        <div class="profile-foreground position-relative mx-n4 mt-n4">
            <div class="profile-wid-bg">
            </div>
        </div>
        <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
            <div class="row g-4">
                <div class="col-auto">
                    <div class="avatar-lg">
                        <img src="{{ auth()->user()->photo_url }}" alt="user-img" class="img-thumbnail rounded-circle user-image-profile avatar-lg" />
                    </div>
                </div>
                
                <div class="col">
                    <div class="p-2">
                        <h3 class="text-white mb-1">{{ auth()->user()->full_name }}</h3>
                        <p class="text-white-75">{{ implode(' | ',auth()->user()->roles->pluck('name')->toArray()) }}</p>
                        <div class="hstack text-white-50 gap-1">
                            <div class="me-2"><i class="ri-map-pin-user-line me-1 text-white-75 fs-16 align-middle"></i>{{ auth()->user()->age }}</div>
                            <div><i class="ri-building-line me-1 text-white-75 fs-16 align-middle"></i>Themesbrand</div>
                        </div>
                    </div>
                </div>

            </div>
            
        </div>
        <div class="row">
            <div class="col-lg-12">
                <livewire:profile.profile-page :user="$user" />
            </div>
        </div>
    </div>


</x-layouts-app.base>
