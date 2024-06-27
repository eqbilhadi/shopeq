<div>
    <form wire:submit='save'>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-sm-6 border-end">
                    <h3 class="card-title mb-3 pb-3 border-bottom">Information User Account</h3>
                    <div class="text-center mb-3">
                        <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                <div wire:ignore>
                                    <img src="{{ asset('assets/images/users/user-dummy-img.jpg') }}" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                                </div>
                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                    <input id="profile-img-file-input" type="file" class="profile-img-file-input" wire:model.live.debounce.200ms='form.photo'>
                                    <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                        <span class="avatar-title rounded-circle bg-light text-body">
                                            <i class="ri-camera-fill"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div x-show="isUploading">
                                <div class="card bg-light overflow-hidden">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0"><b x-text="progress + '%'"></b> &nbsp;&nbsp;&nbsp; Uploading image in progress...</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress bg-soft-secondary rounded-0">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" :style="'width: ' + progress + '%'" aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Email <small class="text-danger">*</small></label>
                                <input type="text" class="form-control" wire:model.live.debounce.500ms='form.email' placeholder="Enter email">
                                @error('form.email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Username <small class="text-danger">*</small></label>
                                <input type="text" class="form-control" wire:model.live.debounce.500ms='form.username' placeholder="Enter username" autocomplete="username">
                                @error('form.username')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Password <small class="text-danger">*</small></label>
                                <input type="password" class="form-control" wire:model.live.debounce.500ms='form.password' placeholder="Enter Password" autocomplete="current-password">
                                @error('form.password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">User Role <small class="text-danger">*</small></label>
                                <div wire:ignore>
                                    <select class="form-select" wire:model.live='form.role' id="roleUser" multiple>
                                        <option value="">Select User Role</option>
                                        @foreach ($roleOption as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('form.role')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <h3 class="card-title mb-3 pb-3 border-bottom">Information User Personal</h3>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">FirstName <small class="text-danger">*</small></label>
                                <input type="text" class="form-control" wire:model.live.debounce.500ms='form.first_name' placeholder="Enter First Name">
                                @error('form.first_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">LastName <small class="text-danger">*</small></label>
                                <input type="text" class="form-control" wire:model.live.debounce.500ms='form.last_name' placeholder="Enter Last Name">
                                @error('form.last_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Birthplace</label>
                                <input type="text" class="form-control" wire:model.live.debounce.500ms='form.birthplace' placeholder="Enter birthplace">
                                @error('form.birthplace')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Birthdate</label>
                                <input type="date" class="form-control" wire:model.live.debounce.500ms='form.birthdate'>
                                @error('form.birthdate')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <select class="form-select" wire:model.live.debounce.500ms='form.gender'>
                                    <option value="">Select Gender</option>
                                    <option value="l">Male</option>
                                    <option value="p">Female</option>
                                </select>
                                @error('form.gender')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control" wire:model.live.debounce.500ms='form.phone' placeholder="Enter Phone/Wa Number">
                                @error('form.phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label class="form-label">Address</label>
                            <textarea rows="3" class="form-control" wire:model.live.debounce.500ms='form.address'></textarea>
                            @error('form.address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-end">
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
        </div>
    </form>
    @script
        <script>
            $('#roleUser').on('change', function() {
                let data = $("#roleUser").val()
                $wire.set('form.role', data)
            })
        </script>
    @endscript
</div>
