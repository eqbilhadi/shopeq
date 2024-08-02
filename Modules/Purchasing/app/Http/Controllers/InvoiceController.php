<?php

namespace Modules\Purchasing\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Purchasing\app\Models\Transaction;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('purchasing::pages.invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $isEdit = request()->route()->getActionMethod() == 'edit';
        
        return view('purchasing::pages.invoice.create', [
            'isEdit' => $isEdit
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $invoice)
    {
        $isEdit = request()->route()->getActionMethod() == 'edit';

        return view('purchasing::pages.invoice.form', [
            'isEdit' => $isEdit,
            'invoice' => $invoice
        ]);
    }
}
