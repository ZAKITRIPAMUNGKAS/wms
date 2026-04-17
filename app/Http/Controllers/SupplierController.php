<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupplierController extends Controller
{
    public function index()
    {
        return Inertia::render('MasterData/Suppliers', [
            'suppliers' => Supplier::latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'kontak' => 'required',
            'alamat' => 'required',
            'email' => 'nullable|email',
        ]);

        Supplier::create($validated);

        return redirect()->back();
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'kontak' => 'required',
            'alamat' => 'required',
            'email' => 'nullable|email',
        ]);

        $supplier->update($validated);

        return redirect()->back();
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->back();
    }
}
