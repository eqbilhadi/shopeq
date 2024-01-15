@if ($menu->children->isEmpty())
    <li class="nav-item" @if($menu->parent) style="margin-left: 10px;" @endif>
        <a class="nav-link menu-link @if (request()->is($menu->url . '*')) active @endif" href="{{ $menu->route_name && Route::has($menu->route_name) ? route($menu->route_name) : '/' }}">
            <i class="{{ $menu->icon }} me-3"></i><span>{{ $menu->label_name }}</span>
        </a>
    </li>
@else
    <li class="nav-item">
        <a class="nav-link menu-link @if (request()->is($menu->url . '*')) active @endif" href="#menu-{{ $menu->id }}" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="menu-{{ $menu->id }}">
            <i class="{{ $menu->icon }} me-1"></i><span>{{ $menu->label_name }}</span>
        </a>
        <div class="collapse menu-dropdown @if (request()->is($menu->url . '*')) show @endif" id="menu-{{ $menu->id }}">
            <ul class="nav flex-column">
                @foreach ($menu->children as $child)
                    @if ($child->is_active == 1)
                        <x-layouts-app.menu :menu="$child" />
                    @endif
                @endforeach
            </ul>
        </div>
    </li>
@endif