<div>
    <div class="card-body p-5">
        <div>
            <h5 class="text-primary"><i class="fa-solid fa-user fa-sm me-2"></i> Register Account</h5>
            <p class="text-muted">Get your account now.</p>
        </div>
        <div id="custom-progress-bar" class="progress-nav mb-4">
            <div class="progress" style="height: 1px;">
                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

            <ul class="nav nav-pills progress-bar-tab custom-nav" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill {{ $currentStep == 1 ? 'active' : '' }} {{ $isStepOne ? 'done' : '' }}" data-progressbar="custom-progress-bar" id="step-one-tab" role="tab" aria-controls="step-one" aria-selected="true">1</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill {{ $currentStep == 2 ? 'active' : '' }} {{ $isStepTwo ? 'done' : '' }}" data-progressbar="custom-progress-bar" id="step-two-tab" type="button" role="tab" aria-controls="step-two" aria-selected="false">2</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill {{ $currentStep == 3 ? 'active' : '' }} {{ $isStepThree ? 'done' : '' }}" data-progressbar="custom-progress-bar" id="step-three-tab" role="tab" aria-controls="step-three" aria-selected="false">3</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill {{ $currentStep == 4 ? 'active' : '' }} {{ $isStepFour ? 'done' : '' }}" data-progressbar="custom-progress-bar" id="step-four-tab" role="tab" aria-controls="step-four" aria-selected="false">4</button>
                </li>
            </ul>
        </div>

        <div class="tab-content">
            <div class="tab-pane fade {{ $currentStep == 1 ? 'show active' : '' }}" id="step-one" role="tabpanel" aria-labelledby="step-one-tab">
                <form wire:submit.prevent='firstStepSubmit'>
                    <div>
                        <div class="mb-4">
                            <div>
                                <h5 class="mb-1">Information Account</h5>
                                <p class="text-muted">Fill in all forms below to continue</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Email <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms='stepOneForm.email' placeholder="Enter email">
                                    @error('stepOneForm.email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Username <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms='stepOneForm.username' placeholder="Enter username">
                                    @error('stepOneForm.username')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Password <small class="text-danger">*</small></label>
                                    <input type="password" class="form-control" wire:model.live.debounce.500ms='stepOneForm.password' placeholder="Enter Password">
                                    @error('stepOneForm.password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Password Confirmation <small class="text-danger">*</small></label>
                                    <input type="password" class="form-control" wire:model.live.debounce.500ms='stepOneForm.password_confirmation' placeholder="Enter Password Confirmation">
                                    @error('stepOneForm.password_confirmation')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3 mt-4">
                        <button class="btn btn-success btn-label right ms-auto" wire:loading.flex wire:target='firstStepSubmit'>
                            <div class="label-icon align-middle fs-16 ms-2"><i class="fa-solid fa-spinner-third fa-spin" style="--fa-animation-duration: 0.5s;"></i></div>Loading
                        </button>
                        <button type="submit" class="btn btn-success btn-label right ms-auto" wire:loading.remove wire:target='firstStepSubmit'><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next</button>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade {{ $currentStep == 2 ? 'show active' : '' }}" id="step-two" role="tabpanel" aria-labelledby="step-two-tab">
                <form wire:submit.prevent='secondStepSubmit'>
                    <div>
                        <div class="mb-4">
                            <div>
                                <h5 class="mb-1">Information Personal</h5>
                                <p class="text-muted">Fill in all forms below to continue</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">FirstName <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms='stepTwoForm.first_name' placeholder="Enter First Name">
                                    @error('stepTwoForm.first_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">LastName <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms='stepTwoForm.last_name' placeholder="Enter Last Name">
                                    @error('stepTwoForm.last_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Birthplace <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms='stepTwoForm.birthplace' placeholder="Enter birthplace">
                                    @error('stepTwoForm.birthplace')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Birthdate <small class="text-danger">*</small></label>
                                    <input type="date" class="form-control" wire:model.live.debounce.500ms='stepTwoForm.birthdate'>
                                    @error('stepTwoForm.birthdate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Gender <small class="text-danger">*</small></label>
                                    <select class="form-select" wire:model.live.debounce.500ms='stepTwoForm.gender'>
                                        <option value="">Select Gender</option>
                                        <option value="l">Male</option>
                                        <option value="p">Female</option>
                                    </select>
                                    @error('stepTwoForm.gender')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Phone Number <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms='stepTwoForm.phone' placeholder="Enter Phone/Wa Number">
                                    @error('stepTwoForm.phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="form-label">Address</label>
                                <textarea rows="3" class="form-control" wire:model.live.debounce.500ms='stepTwoForm.address'></textarea>
                                @error('stepTwoForm.address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3 mt-4">
                        <button type="button" class="btn btn-outline-primary text-decoration-none btn-label" wire:click='back(1)'><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back</button>
                        <button class="btn btn-success btn-label right ms-auto" wire:loading wire:target='secondStepSubmit'>
                            <div class="label-icon align-middle fs-16 ms-2"><i class="fa-solid fa-spinner-third fa-spin" style="--fa-animation-duration: 0.5s;"></i></div>Loading
                        </button>
                        <button type="submit" class="btn btn-success btn-label right ms-auto" wire:loading.remove wire:target='secondStepSubmit'><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next</button>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade {{ $currentStep == 3 ? 'show active' : '' }}" id="step-three" role="tabpanel" aria-labelledby="step-three-tab">
                <div>
                    <div class="text-center">
                        <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <div class="profile-user position-relative d-inline-block mx-auto mb-2">
                                <div wire:ignore>
                                    <img src="assets/images/users/user-dummy-img.jpg" class="rounded-circle avatar-lg img-thumbnail user-profile-image" alt="user-profile-image">
                                </div>
                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                    <input id="profile-img-file-input" type="file" class="profile-img-file-input" wire:model.live.debounce.200ms='stepThreeForm.photo'>
                                    <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                        <span class="avatar-title rounded-circle bg-light text-body">
                                            <i class="ri-camera-fill"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <h5 class="fs-14">Add Profile Picture</h5>
                            @error('stepThreeForm.photo')
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
                    </div>
                </div>
                <div class="d-flex align-items-start gap-3 mt-4">
                    <button type="button" class="btn btn-outline-primary text-decoration-none btn-label" wire:click='back(2)'><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back</button>
                    <button class="btn btn-success btn-label right ms-auto" wire:loading wire:target='thirdStepSubmit'>
                        <div class="label-icon align-middle fs-16 ms-2"><i class="fa-solid fa-spinner-third fa-spin" style="--fa-animation-duration: 0.5s;"></i></div>Loading
                    </button>
                    <button type="button" class="btn btn-success btn-label right ms-auto" wire:loading.remove wire:target='thirdStepSubmit' wire:click='thirdStepSubmit'><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Register</button>
                </div>
            </div>

            <div class="tab-pane fade {{ $currentStep == 4 ? 'show active' : '' }}" id="step-four" role="tabpanel" aria-labelledby="step-four-tab">
                <div>
                    <div class="text-center">

                        <div class="mb-4">
                            <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>
                        </div>
                        <h5>Well Done !</h5>
                        <p class="text-muted">You have Successfully Register</p>
                    </div>
                    <div class="d-flex align-items-start gap-3 mt-4">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-label right ms-auto"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
