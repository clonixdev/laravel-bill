<?php

namespace Clonixdev\LaravelBill\Http\Controllers;



class InvoiceController extends Controller
{

    public function index()
    {
        //
    }

    public function show()
    {
        //
    }

    public function store()
    {

        if (! auth()->check()) {
            abort (403, 'Only authenticated users can create new invoices.');
        }


        $client = auth()->user();

    }


}