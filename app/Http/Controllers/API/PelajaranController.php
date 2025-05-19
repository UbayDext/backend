<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelajaran;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class PelajaranController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Pelajaran::with('classroom');

            // Optional filter
            if ($request->filled('classroom_id')) {
                $query->where('classroom_id', $request->classroom_id);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data pelajaran berhasil diambil',
                'data' => $query->get(),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data pelajaran',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $data = Pelajaran::with('classroom')->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Detail pelajaran ditemukan',
                'data' => $data,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pelajaran tidak ditemukan',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil detail pelajaran',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:191',
                'code' => 'required|string|max:191|unique:pelajarans,code',
                'start_time' => 'required|date_format:H:i:s',
                'end_time' => 'required|date_format:H:i:s',
                'classroom_id' => 'required|exists:classrooms,id',
            ]);

            $pelajaran = Pelajaran::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Pelajaran berhasil ditambahkan',
                'data' => $pelajaran,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan pelajaran',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $pelajaran = Pelajaran::findOrFail($id);

            $validated = $request->validate([
                'nama' => 'required|string|max:191',
                'code' => 'required|string|max:191|unique:pelajarans,code,' . $id,
                'start_time' => 'required|date_format:H:i:s',
                'end_time' => 'required|date_format:H:i:s',
                'classroom_id' => 'required|exists:classrooms,id',
            ]);

            $pelajaran->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Pelajaran berhasil diperbarui',
                'data' => $pelajaran,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pelajaran tidak ditemukan',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui pelajaran',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $pelajaran = Pelajaran::findOrFail($id);
            $pelajaran->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pelajaran berhasil dihapus',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pelajaran tidak ditemukan',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus pelajaran',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
