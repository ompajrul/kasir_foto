<?php

namespace App\Http\Controllers;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index ()
    {
        $items = Item::latest()->get();
        return view('item.index', compact('items'));
    }

    public function create()
    {
        return view('item.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_item' => 'required|string|max:255',
            'jenis' => 'required|in:paket,add_on',
            'harga' => 'required|numeric|min:0',
            'jumlah_foto' => 'nullable|integer|min:0',
        ]);

        Item::create($request->all());

        return redirect()->route('item.index')->with('success', 'Item berhasil ditambahkan.');
    }
    public function edit (Request $request)
    {
       
    }

    /**
     * Update the user's profile information.
     */
    public function update( Request $request, Item $item)
    {
       // 1. Validasi input
        $request->validate([
            'nama_item' => 'required|string|max:255',
            'jenis' => 'required|in:paket,add_on',
            'harga' => 'required|numeric|min:0',
            'jumlah_foto' => 'nullable|integer|min:0',
        ]);

        // 2. Update data
        $item->update($request->all());

        // 3. Redirect kembali ke index dengan pesan sukses
        return redirect()->route('item.index')
                         ->with('success', 'Item ' . $item->nama_item . ' berhasil diperbarui!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Item $item)
    {
       $namaItem = $item->nama_item;
        
        // Melakukan penghapusan (Otomatis Soft Delete karena trait di Model)
        $item->delete();

        return redirect()->route('item.index')
                         ->with('success', 'Item ' . $namaItem . ' berhasil dihapus.');
    }
}
