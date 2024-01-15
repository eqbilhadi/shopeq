<div>
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div class="d-flex gap-2">
                <select class="form-select w-100" wire:model.live='filter.role'>
                    <option value="">All Role</option>
                    @foreach ($filterOptionRole as $fRole)
                        <option value="{{ $fRole->id }}">{{ $fRole->name }}</option>
                    @endforeach
                </select>
                <select class="form-select w-100" wire:model.live='filter.gender'>
                    <option value="">All Gender</option>
                    <option value="l">Male</option>
                    <option value="p">Female</option>
                </select>
            </div>
            <div>
                <input type="text" class="form-control" placeholder="Search user..." wire:model.live='filter.search'>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive table-card">
            <table class="table align-middle table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">User</th>
                        <th scope="col">Email</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Role</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" class="text-end">Last Login</th>
                        <th scope="col" style="width: 150px;" class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $user)
                        <tr wire:key='{{ $user->id }}'>
                            <td>
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $user->photo_url }}" alt="" class="avatar-sm rounded-circle me-2" />
                                    </div>
                                    <div class="flex-grow-1">
                                        <b class="m-0 d-block">{{ $user->full_name }}</b>
                                        <small class="fs-11">{{ $user->username }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->gender == 'l')
                                    <span class="badge bg-primary">
                                        <i class="fa-solid fa-user-hair me-1"></i> Male
                                    </span>
                                @elseif ($user->gender == 'p')
                                    <span class="badge bg-danger">
                                        <i class="fa-solid fa-user-hair-long me-1"></i> Female
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    @foreach ($user->roles()->pluck('name') as $role)
                                        <span class="badge bg-secondary">
                                            {{ $role }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <i class="@if ($user->is_active == 1) fa-solid fa-toggle-on text-success @else fa-solid fa-toggle-off text-danger @endif me-1 mt-2 fa-2xl" role="button" wire:click="changeActiveStatus('{{ $user->id }}', '{{ $user->is_active }}')"></i>
                                    <span class="badge @if ($user->is_active == 1) bg-success @else bg-danger @endif">
                                        @if ($user->is_active == 1)
                                            Active
                                        @else
                                            Non-Active
                                        @endif
                                    </span>
                                </div>
                            </td>
                            <td class="text-end">
                                @if ($user->lastSuccessfulLoginAt() != null)
                                    {{ date('d F Y H:i', strtotime($user->lastSuccessfulLoginAt())) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('rbac.user.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-id={{ "$user->id" }}>
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
