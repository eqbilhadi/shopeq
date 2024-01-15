<?php

namespace Modules\Rbac\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Rbac\app\Models\Role;

class RoleManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('rbac::pages.role-management.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rbac::pages.role-management.create');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('rbac::pages.role-management.edit', compact('role'));
    }
}
