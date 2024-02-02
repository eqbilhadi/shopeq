<?php

namespace Modules\Master\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Master\app\Models\MstProduct;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master::pages.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master::pages.product.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mstproduct $product)
    {
        $product = MstProduct::with('images')->with('units')->find($product->id);
        return view('master::pages.product.edit', compact('product'));
    }
}
