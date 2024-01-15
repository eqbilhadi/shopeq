<div>
    <form wire:submit.prevent='save'>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <label>Code</label>
                    <input type="text" class="form-control" wire:model.live.debounce.300ms='form.code'>
                    @error('form.code')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <label>Role Name</label>
                    <input type="text" class="form-control" wire:model.live.debounce.300ms='form.name'>
                    @error('form.name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-6">
                    <label>Description</label>
                    <input type="text" class="form-control" wire:model.live.debounce.300ms='form.description'>
                </div>
                <div class="col-sm-6">
                    <label>Active</label>
                    <div class="form-check form-switch form-switch-md">
                        <input type="checkbox" class="form-check-input" id="customSwitchsizemd" wire:model.live.debounce.300ms='form.is_active'>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <h4 class="card-title pb-4">Permission</h4>
            <div class="table-responsive table-card">
                <table class="table table-nowrap mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Menu</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($navigations as $nav)
                            <x-rbac::permissionitem :$nav :$loop />
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row mt-5">
                <div class="col-lg-2 col-md-3 col-sm-4 ms-auto">
                    <button class="btn btn-primary w-100" wire:loading.remove wire:target='save'>Save</button>
                    <button type="button" class="btn btn-primary w-100 btn-load" wire:loading wire:target='save'>
                        <span class="d-flex align-items-center">
                            <span class="spinner-grow flex-shrink-0" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </span>
                            <span class="flex-grow-1 ms-2">
                                Loading...
                            </span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
