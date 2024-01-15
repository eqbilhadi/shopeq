<tr wire:key='{{ $menu->id }}'>
    <td>
        <div class="form-check">
            @if($menu->children->isNotEmpty())
                @if (!in_array($menu->id, $idBulkDelete))
                    <input type="checkbox" class="form-check-input" value="{{ $menu->id }}" wire:model.live='idBulkDelete' wire:click='selectWithChild("{{ $menu->id }}")'>
                @else
                    <input type="checkbox" class="form-check-input" value="{{ $menu->id }}" wire:model.live='idBulkDelete' wire:click='unSelectWithChild("{{ $menu->id }}")'>
                @endif
            @else
                <input type="checkbox" class="form-check-input" value="{{ $menu->id }}" wire:model.live='idBulkDelete'>
            @endisset
        </div>
    </td>
    <td>
        <div class="d-flex">
            @for ($i = 1; $i < $loop->depth; $i++)
                <div class="align-self-center me-3">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                </div>
            @endfor
            <div class="align-self-center me-3">
                <i class="{{ $menu->icon }} fa-xl"></i>
            </div>
            <div class="d-flex flex-column">
                <span class="{{ $loop->depth === 1 ? 'fw-bolder' : 'fw-semibold' }}">
                    {{ $menu->label_name }}
                </span>
                <span class="text-sm text-muted">Route : {{ $menu->route_name ?? '-' }}</span>
                <span class="text-sm text-muted">Url : {{ $menu->url ?? '-' }}</span>
            </div>
        </div>
    </td>
    <td>{{ $menu->controller_name }}</td>
    <td class="text-center">
        <div class="d-flex justify-content-center">
            <i class="@if ($menu->is_active == 1) fa-solid fa-toggle-on text-success @else fa-solid fa-toggle-off text-danger @endif me-1 mt-2 fa-2xl" role="button" wire:click="changeActiveStatus('{{ $menu->id }}', '{{ $menu->is_active }}')"></i>
            <span class="badge @if ($menu->is_active == 1) bg-success @else bg-danger @endif">
                @if ($menu->is_active == 1)
                    Active
                @else
                    Non-Active
                @endif
            </span>
        </div>
    </td>
    <td class="text-end">
        <div class="d-flex flex-row justify-content-end align-items-center gap-2">
            <div class="d-flex flex-column">
                @unless ($loop->first)
                    <button data-bs-toggle="tooltip" title="Sort Up" class="btn btn-icon btn-sm" wire:click="changeOrder('{{ $menu->id }}','up')"><i class="fa-solid fa-chevron-up"></i></button>
                @endunless
                @unless ($loop->last)
                    <button data-bs-toggle="tooltip" title="Sort Down" class="btn btn-icon btn-sm" wire:click="changeOrder('{{ $menu->id }}','down')"><i class="fa-solid fa-chevron-down"></i></button>
                @endunless
            </div>
            <a href="{{ route('rbac.nav.edit', $menu->id) }}" class="btn btn-sm btn-warning">Edit</a>
            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-id={{ "$menu->id" }}>
                Delete
            </button>
        </div>
    </td>
</tr>
@isset($menu->children)
    @foreach ($menu->children as $child)
        <x-rbac::menuitem :menu="$child" :$loop />
    @endforeach
@endisset
