<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WarehouseController extends Controller
{
    public function index()
    {
        return Inertia::render('MasterData/Warehouses', [
            'warehouses' => Warehouse::latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_gudang' => 'required|unique:warehouses',
            'nama' => 'required',
            'alamat' => 'required',
        ]);

        Warehouse::create($validated);

        return redirect()->back();
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
        ]);

        $warehouse->update($validated);

        return redirect()->back();
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return redirect()->back();
    }
}
