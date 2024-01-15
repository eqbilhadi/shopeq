<div wire:ignore.self class="modal fade" id="bulkDeleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure, you want to remove {{ $count }} items data ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification" wire:loading.remove wire:click='bulkDelete'>Yes, Delete It!</button>
                    <button type="button" class="btn btn-danger btn-load" wire:loading>
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
    </div>
</div>
@push('scripts')
    <script>
        Livewire.on('close-modal', (event) => {
            $("#bulkDeleteModal").modal('hide');
        });
    </script>
@endpush