<div>
    <div class="card-body">
        <div class="table-responsive table-card">
            <table class="table align-middle table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Role Code</th>
                        <th scope="col">Role Name</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" style="width: 150px;" class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $result)
                        <tr wire:key='{{ $result->id }}'>
                            <td>{{ $result->code }}</td>
                            <td>{{ $result->name }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <i class="@if ($result->is_active == 1) fa-solid fa-toggle-on text-success @else fa-solid fa-toggle-off text-danger @endif me-1 mt-2 fa-2xl" role="button" wire:click="changeActiveStatus('{{ $result->id }}', '{{ $result->is_active }}')"></i>
                                    <span class="badge @if ($result->is_active == 1) bg-success @else bg-danger @endif">
                                        @if ($result->is_active == 1)
                                            Active
                                        @else
                                            Non-Active
                                        @endif
                                    </span>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('rbac.role.edit', $result->id) }}" class="btn btn-sm btn-primary">Manage</a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-id={{ "$result->id" }}>
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if ($results->hasPages())
        <div class="card-footer border-0">
            {{ $results->links('components.pagination') }}
        </div>
    @else
        <div class="card-footer border-0 pb-0">
            <ul class="pagination pagination-sm">
                {{ __('Showing') }} {{ ($results->currentpage() - 1) * $results->perpage() + 1 }} {{ __('to') }}
                {{ min($results->currentPage() * $results->perPage(), $results->total()) }}
                {{ __('of') }} {{ $results->total() }}
                {{ __('entries') }}
            </ul>
        </div>
    @endif
    <x-delete-modal />
</div>
