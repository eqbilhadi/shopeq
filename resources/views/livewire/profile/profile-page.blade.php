<div>
    <div class="tab-content pt-4 text-muted">
        <div class="tab-pane active" id="overview-tab" role="tabpanel">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @if ($currentTab == 'formPersonal') active @endif" role="button" wire:click='changeTab("formPersonal")'>
                                        <i class="far fa-user me-2"></i>
                                        Personal Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if ($currentTab == 'formAccount') active @endif" role="button" wire:click='changeTab("formAccount")'>
                                        <i class="fas fa-key me-2"></i>
                                        Change Account & Password
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if ($currentTab == 'formImage') active @endif" role="button" wire:click='changeTab("formImage")'>
                                        <i class="far fa-image me-2"></i>
                                        Change Profile Picture
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body p-4">
                            <div class="tab-content">
                                <div class="tab-pane  @if ($currentTab == 'formPersonal') active @endif" id="personalDetails" role="tabpanel">
                                    <form wire:submit='updatePersonal'>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">FirstName <small class="text-danger">*</small></label>
                                                    <input type="text" class="form-control" wire:model.live.debounce.500ms='formPersonal.first_name' placeholder="Enter First Name">
                                                    @error('formPersonal.first_name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">LastName <small class="text-danger">*</small></label>
                                                    <input type="text" class="form-control" wire:model.live.debounce.500ms='formPersonal.last_name' placeholder="Enter Last Name">
                                                    @error('formPersonal.last_name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Birthplace</label>
                                                    <input type="text" class="form-control" wire:model.live.debounce.500ms='formPersonal.birthplace' placeholder="Enter birthplace">
                                                    @error('formPersonal.birthplace')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Birthdate</label>
                                                    <input type="date" class="form-control" wire:model.live.debounce.500ms='formPersonal.birthdate'>
                                                    @error('formPersonal.birthdate')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Gender</label>
                                                    <select class="form-select" wire:model.live.debounce.500ms='formPersonal.gender'>
                                                        <option value="">Select Gender</option>
                                                        <option value="l">Male</option>
                                                        <option value="p">Female</option>
                                                    </select>
                                                    @error('formPersonal.gender')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Phone Number</label>
                                                    <input type="text" class="form-control" wire:model.live.debounce.500ms='formPersonal.phone' placeholder="Enter Phone/Wa Number">
                                                    @error('formPersonal.phone')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-12">
                                                <label class="form-label">Address</label>
                                                <textarea rows="3" class="form-control" wire:model.live.debounce.500ms='formPersonal.address'></textarea>
                                                @error('formPersonal.address')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="float-end">
                                            <button type="submit" class="btn btn-primary"><i class="ri-edit-box-line align-bottom"></i> Update</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane @if ($currentTab == 'formAccount') active @endif" id="changePassword" role="tabpanel">
                                    <form wire:submit='updateAccount'>
                                        <div class="row g-2">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Email <small class="text-danger">*</small></label>
                                                    <input type="text" class="form-control" wire:model.live.debounce.500ms='formAccount.email' placeholder="Enter email">
                                                    @error('formAccount.email')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Username <small class="text-danger">*</small></label>
                                                    <input type="text" class="form-control" wire:model.live.debounce.500ms='formAccount.username' placeholder="Enter username">
                                                    @error('formAccount.username')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Password <small class="text-danger">*</small></label>
                                                    <input type="password" class="form-control" wire:model.live.debounce.500ms='formAccount.password' placeholder="Enter Password">
                                                    @error('formAccount.password')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Password Confirmation <small class="text-danger">*</small></label>
                                                    <input type="password" class="form-control" wire:model.live.debounce.500ms='formAccount.password_confirmation' placeholder="Enter Password Confirmation">
                                                    @error('formAccount.password_confirmation')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary"><i class="ri-edit-box-line align-bottom"></i> Update</button>
                                            </div>
                                        </div>

                                    </form>
                                    <div class="mt-4 mb-3 pb-2">
                                        <h5 class="card-title">Login History</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive table-card">
                                            <table class="table table-nowrap mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th scope="col">Device</th>
                                                        <th scope="col">Location</th>
                                                        <th scope="col">Login At</th>
                                                        <th scope="col">Login Status</th>
                                                        <th scope="col">Logout At</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (auth()->user()->authlog as $key => $item)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center mb-3">
                                                                    <div class="flex-shrink-0 avatar-sm">
                                                                        {!! $item->device_icon !!}
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-3">
                                                                        <h6>{{ $item->ip_address }}</h6>
                                                                        <p class="mb-0">{{ $item->platform }}, {{ $item->browser }}</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{ $item->location['city'] }}, {{ $item->location['country'] }}</td>
                                                            <td>{{ date('d F Y H:i', strtotime($item->login_at)) }}</td>
                                                            <td>
                                                                @if ($item->login_successful)
                                                                    <span class="badge bg-success">Success</span>
                                                                @else
                                                                    <span class="badge bg-danger">Failed</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($item->logout_at != null)
                                                                    {{ date('d F Y H:i', strtotime($item->logout_at)) }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @if ($key == 4)
                                                            @php
                                                                break;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane @if ($currentTab == 'formImage') active @endif" id="experience" role="tabpanel">
                                    <div>
                                        <div class="text-center">
                                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                <div class="profile-user position-relative d-inline-block mx-auto mb-2">
                                                    @if ($formAvatar->photo)
                                                        <img src="{{ $formAvatar->photo->temporaryUrl() }}" class="rounded-circle avatar-lg img-thumbnail user-profile-image" alt="user-profile-image">
                                                    @else
                                                        <img src="{{ $user->photo_url }}" class="rounded-circle avatar-lg img-thumbnail user-profile-image" alt="user-profile-image">
                                                    @endif
                                                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                        <input id="profile-img-file-input" type="file" class="profile-img-file-input" wire:model.live.debounce.200ms='formAvatar.photo'>
                                                        <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                            <span class="avatar-title rounded-circle bg-light text-body">
                                                                <i class="ri-camera-fill"></i>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <h5 class="fs-14">Add Profile Picture</h5>
                                                @error('formAvatar.photo')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
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
                                            @if ($formAvatar->photo)
                                                <button type="button" wire:click='updateAvatar' class="btn btn-primary">Update Profile Picture</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
