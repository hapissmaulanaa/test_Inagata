<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    // Proses Menambahkan Data Inventory
    public function addInventory(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        // Cari barang berdasarkan nama
        $inventory = Inventory::where('name', $request->name)->first();

        if ($inventory) {
            // Jika barang sudah ada, tambahkan stok
            $inventory->quantity += $request->quantity;
            $inventory->save();

            // Berikan respons sukses
            return response()->json([
                'status' => true,
                'data' => ['id' => $inventory->id],
                'message' => 'Tambah stok berhasil'
            ], 200);
        } else {
            // Jika barang belum ada, buat data baru
            $newInventory = Inventory::create([
                'name' => $request->name,
                'quantity' => $request->quantity,
            ]);

            // Berikan respons sukses
            return response()->json([
                'status' => true,
                'data' => ['id' => $newInventory->id],
                'message' => 'Tambah inventaris baru berhasil'
            ], 200);
        }
    }

    // Proses Update Data Inventory
    public function updateInventory(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        // Cari barang berdasarkan ID
        $inventory = Inventory::find($id);

        // Jika barang tidak ditemukan, kembalikan respons error
        if (!$inventory) {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'Inventaris tidak ditemukan'
            ], 404);
        }

        // Update data inventaris berdasarkan input dari request
        $inventory->name = $request->name;
        $inventory->quantity = $request->quantity;
        $inventory->save();

        // Berikan respons sukses
        return response()->json([
            'status' => true,
            'data' => ['id' => $inventory->id],
            'message' => 'Update inventaris berhasil'
        ], 200);
    }

    // Proses Mengahpus Data Inventory
    public function deleteInventory($id)
    {
        // Cari barang berdasarkan ID
        $inventory = Inventory::find($id);

        // Jika barang tidak ditemukan, kembalikan respons error
        if (!$inventory) {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'Inventaris tidak ditemukan'
            ], 404);
        }

        // Hapus data inventaris
        $inventory->delete();

        // Berikan respons sukses
        return response()->json([
            'status' => true,
            'data' => null,
            'message' => 'Hapus inventaris berhasil'
        ], 200);
    }

    // Proses List Data Inventory
    public function listInventories()
    {
        // Mengambil semua data inventaris
        $inventories = Inventory::all();

        // Jika data inventaris kosong, kembalikan respons data kosong
        if ($inventories->isEmpty()) {
            return response()->json([
                'status' => true,
                'data' => [],
                'message' => 'Data inventaris kosong'
            ], 200);
        }

        // Berikan respons sukses dengan data inventaris
        return response()->json([
            'status' => true,
            'data' => $inventories,
            'message' => 'Daftar inventaris berhasil diambil'
        ], 200);
    }

    // Proses Menampilkan Data Sesuai ID
    public function getInventoryById($id)
    {
        // Cari barang berdasarkan ID
        $inventory = Inventory::find($id);

        // Jika barang tidak ditemukan, kembalikan respons error
        if (!$inventory) {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'Inventaris tidak ditemukan'
            ], 404);
        }

        // Berikan respons sukses dengan data inventaris
        return response()->json([
            'status' => true,
            'data' => $inventory,
            'message' => 'Data inventaris berhasil diambil'
        ], 200);
    }
}
