<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;


class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $medicines = Medicine::where('name', 'LIKE', '%'. $request-> search_medicine. '%')->orderBy('name', 'ASC')->simplePaginate(10);
        return view('medicine.index', compact('medicines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medicine.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'type' => 'required|min:3',
            'price' => 'required|numeric',
            'stock' => 'required|numeric'
        ], [
            'name.required' => 'Nama obat harus diisi!',
            'type.required' => 'Tipe obat harus diisi!',
            'price.required' => 'Harga obat harus diisi!',
            'stock.required' => 'Stok obat harus diisi!',
            'name.max' => 'Nama obat maksimal 100 karakter!',
            'type.min' => 'Tipe obat minimal 3 karakter!',
            'price.numeric' => 'Harga obat harus berupa angka!',
            'stock.numeric' => 'Stok obat harus berupa angka!',
        ]);

        $proses = Medicine::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'stock' => $request->stock
        ]);

        if ($proses) {
            return redirect()->route('medicines.index')->with('success', 'Berhasil mengubah data obat!');
        } else {
            return redirect()->back()->with('failed', 'Gagal mengubah data obat!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicine $medicine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //ambil dlu data lama
        // cari berdasarkan id pada path /{id}
        // first() : mengambil data pertama (hanya satu data)
        $medicine = Medicine::where('id', $id)->first();
        // compact : kirim data ke view ($)
        return view('medicine.edit', compact('medicine'));
    }

    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'type' => 'required|min:3',
            'price' => 'required|numeric',
        ], [
            'name.required' => 'Nama obat harus diisi!',
            'type.required' => 'Tipe obat harus diisi!',
            'price.required' => 'Harga obat harus diisi!',
            'name.max' => 'Nama obat maksimal 100 karakter!',
            'type.min' => 'Tipe obat minimal 3 karakter!',
            'price.numeric' => 'Harga obat harus berupa angka!',
        ]);
        
        $proses = Medicine::where('id', $id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
        ]);

        if ($proses) {
            return redirect()->route('medicines.index')->with('success', 'Berhasil mengubah data obat!');
        } else {
            return redirect()->back()->with('failed', 'Gagal mengubah data obat!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // dicari (where) berdasarkan id, lalu hapus
        $proses = Medicine::where('id', $id)->delete();

        if ($proses) {
            return redirect()->back()->with('success', 'Berhasil menghapus data obat!');
        } else {
            return redirect()->back()->with('failed', 'Gagal menghapus data obat!');
        }
    }
}
