<div>
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">Table List Navigation</h4>

        <div class="flex-shrink-0">
            @if (count($idBulkDelete) > 0)
                <small class="text-danger fs-11 me-1">{{ count($idBulkDelete) }} items selected</small><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bulkDeleteModal">Delete</button>
            @endif
            <a href="{{ route('rbac.nav.create') }}" class="btn btn-primary">Add Navigation</a>
        </div>

    </div>
    <div class="card-body">
        <div class="table-responsive table-card">
            <table class="table align-middle table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th></th>
                        <th scope="col">Menu Label Name</th>
                        <th scope="col">Controller Name</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" style="width: 150px;" class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $menu)
                        <x-rbac::menuitem :$menu :$loop :$idBulkDelete/>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <x-delete-modal />
    <x-bulk-delete-modal :count="count($idBulkDelete)"/>
</div>
