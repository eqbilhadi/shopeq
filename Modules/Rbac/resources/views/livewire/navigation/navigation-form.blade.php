<div>
    <div class="card-body">
        <form wire:submit.prevent='save'>
            <div class="row">
                <label class="col-sm-2 offset-sm-1 col-form-label col-form-label">Navigation Icon</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control" placeholder="Use font awesome icon" wire:model.live.debounce.300ms='form.icon'>
                    @error('form.icon')
                        <small class="text-danger fs-11">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row mt-4">
                <label class="col-sm-2 offset-sm-1 col-form-label">Navigation Parent</label>
                <div class="col-sm-8">
                    <select class="form-select" wire:model.live.debounce.300ms='form.parent_id'>
                        <option value="">Parent</option>
                        @foreach ($parentMenuOption as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->label_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-4">
                <label class="col-sm-2 offset-sm-1 col-form-label col-form-label">Navigation Label</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control" placeholder="Label for navigation" wire:model.live.debounce.300ms='form.label_name'>
                    @error('form.label_name')
                        <small class="text-danger fs-11">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row mt-4">
                <label class="col-sm-2 offset-sm-1 col-form-label col-form-label">Controller Class Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control" placeholder="The name of the controller that handles the navigation" wire:model.live.debounce.300ms='form.controller_name'>
                    @error('form.controller_name')
                        <small class="text-danger fs-11">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row mt-4">
                <label class="col-sm-2 offset-sm-1 col-form-label col-form-label">Route Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control" placeholder="The name of the route that handles the navigation" wire:model.live.debounce.300ms='form.route_name'>
                    @error('form.route_name')
                        <small class="text-danger fs-11">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row mt-4">
                <label class="col-sm-2 offset-sm-1 col-form-label col-form-label">Url</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control" placeholder="The url that handles the navigation" wire:model.live.debounce.300ms='form.url'>
                    @error('form.url')
                        <small class="text-danger fs-11">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row mt-4">
                <label class="col-sm-2 offset-sm-1 col-form-label col-form-label">Show It</label>
                <div class="col-sm-8">
                    <div class="form-check form-switch form-switch-md">
                        <input type="checkbox" class="form-check-input" id="customSwitchsizemd" wire:model.live.debounce.300ms='form.is_active'>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
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
        </form>
    </div>
</div>
