<?php

namespace Modules\Rbac\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Rbac\app\Models\Menu;

class NavigationManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('rbac::pages.navigation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rbac::pages.navigation.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        return view('rbac::pages.navigation.edit', compact('menu'));
    }
}
