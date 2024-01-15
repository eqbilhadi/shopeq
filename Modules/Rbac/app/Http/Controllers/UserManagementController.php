<?php

namespace Modules\Rbac\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('rbac::pages.user-management.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rbac::pages.user-management.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('rbac::pages.user-management.edit', compact('user'));
    }
}
