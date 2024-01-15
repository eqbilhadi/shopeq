<tr>
    <td>
        <div class="d-flex flex-column">
            <span class="{{ $loop->depth === 1 ? 'fw-bolder' : '' }}">
                @for ($i = 1; $i < $loop->depth; $i++)
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -
                @endfor{{ $nav->label_name }}
            </span>
        </div>
    </td>
    <td>
        <div class="d-flex justify-content-center">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{ $nav->id }}" id="cardtableCheck01" wire:model.live='form.menu_id'>
                <label class="form-check-label" for="cardtableCheck01"></label>
            </div>
        </div>
    </td>
</tr>
@isset($nav->children)
    @foreach ($nav->children as $child)
        <x-rbac::permissionitem :nav="$child" :$loop />
    @endforeach
@endisset
