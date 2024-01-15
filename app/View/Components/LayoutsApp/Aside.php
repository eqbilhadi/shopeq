<?php

namespace App\View\Components\LayoutsApp;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;
use Modules\Rbac\app\Models\Menu;

class Aside extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $menus = $this->getCachingMenus();

        return view('components.layouts-app.aside', compact('menus'));
    }

    /**
     * Method getCachingMenus
     *
     * @return void
     */
    protected function getCachingMenus()
    {
        $user = auth()->user();

        return Cache::remember($user->id . '_menus', now()->addhours(5), function () use ($user) {
            return Menu::query()
                ->whereHas('roles', fn ($query) => $query->whereIn('role_id', $user->roles->pluck('id')))
                ->where([
                    'parent_id' => null,
                    'is_active' => '1',
                ])
                ->with([
                    'children' => function ($query) use ($user) {
                        $query->whereHas('roles', fn ($query) => $query->whereIn('role_id', $user->roles->pluck('id')));
                    }
                ])
                ->orderBy('sort_num', 'asc')
                ->get();
        });
    }
    
    /**
     * Method getMenus
     *
     * @return void
     */
    protected function getMenus()
    {
        $user = auth()->user();
        return Menu::query()
            ->whereHas('roles', fn ($query) => $query->whereIn('role_id', $user->roles->pluck('id')))
            ->where([
                'parent_id' => null,
                'is_active' => '1',
            ])
            ->with([
                'children' => function ($query) use ($user) {
                    $query->whereHas('roles', fn ($query) => $query->whereIn('role_id', $user->roles->pluck('id')));
                }
            ])
            ->orderBy('sort_num', 'asc')
            ->get();
    }
}
