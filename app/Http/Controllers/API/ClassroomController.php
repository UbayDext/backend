<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * GET /api/classrooms
     * Ambil semua data kelas
     */
    public function index()
    {
        return Classroom::all();
    }

    /**
     * POST /api/classrooms
     * Tambah kelas baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
        ]);

        $classroom = Classroom::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil ditambahkan',
            'data' => $classroom,
        ], 201);
    }

    /**
     * GET /api/classrooms/{id}
     * Ambil detail kelas berdasarkan ID
     */
    public function show($id)
    {
        $classroom = Classroom::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $classroom,
        ]);
    }

    /**
     * PUT /api/classrooms/{id}
     * Update kelas
     */
    public function update(Request $request, $id)
    {
        $classroom = Classroom::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:191',
        ]);

        $classroom->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil diperbarui',
            'data' => $classroom,
        ]);
    }

    /**
     * DELETE /api/classrooms/{id}
     * Hapus kelas
     */
    public function destroy($id)
    {
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil dihapus',
        ]);
    }
}
