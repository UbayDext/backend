<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ClassroomController extends Controller
{
    // GET /api/classrooms
    public function index()
    {
        try {
            $data = Classroom::all();

            return response()->json([
                'success' => true,
                'message' => 'Data kelas berhasil diambil',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // POST /api/classrooms
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:191',
            ]);

            $classroom = Classroom::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Kelas berhasil ditambahkan',
                'data' => $classroom,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan kelas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /api/classrooms/{id}
    public function show($id)
    {
        try {
            $classroom = Classroom::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $classroom,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas tidak ditemukan',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // PUT /api/classrooms/{id}
    public function update(Request $request, $id)
    {
        try {
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
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas tidak ditemukan',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui kelas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // DELETE /api/classrooms/{id}
    public function destroy($id)
    {
        try {
            $classroom = Classroom::findOrFail($id);
            $classroom->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kelas berhasil dihapus',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas tidak ditemukan',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kelas',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
