<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function inbound()
    {
        return view('transactions.inbound');
    }

    public function outbound()
    {
        return view('transactions.outbound');
    }

    public function show($id)
    {
        return view('transactions.show', compact('id'));
    }
}
