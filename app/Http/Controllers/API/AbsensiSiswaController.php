<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AbsensiSiswa;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Rule;
use Exception;

class AbsensiSiswaController extends Controller
{
    // GET /api/absensi
    public function index(Request $request)
    {
        try {
            $query = AbsensiSiswa::with(['user', 'classroom', 'pelajaran']);

            if ($request->filled('classroom_id')) {
                $query->where('classroom_id', $request->classroom_id);
            }

            if ($request->filled('pelajaran_id')) {
                $query->where('pelajaran_id', $request->pelajaran_id);
            }

            if ($request->filled('date')) {
                $query->where('date', $request->date);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data absensi berhasil diambil',
                'data' => $query->get(),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data absensi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // GET /api/absensi/{id}
    public function show($id)
    {
        try {
            $data = AbsensiSiswa::with(['user', 'classroom', 'pelajaran'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Data absensi ditemukan',
                'data' => $data,
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => 'Absensi tidak ditemukan',
            ], 404);
        }
    }

    // POST /api/absensi
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'name' => 'required|string|max:191',
                'pelajaran_id' => 'required|exists:pelajarans,id',
                'classroom_id' => 'required|exists:classrooms,id',
                'date' => [
                    'required',
                    'date',
                    Rule::unique('absensi_siswas')->where(fn ($q) =>
                        $q->where('user_id', $request->user_id)
                          ->where('pelajaran_id', $request->pelajaran_id)
                          ->where('classroom_id', $request->classroom_id)
                          ->where('date', $request->date)
                    ),
                ],
                'check_in_time' => 'required|date_format:H:i:s',
                'check_out_time' => 'required|date_format:H:i:s',
                'status' => 'required|in:hadir,izin,sakit,alpha',
                'notes' => 'nullable|string',
            ]);

            $absensi = AbsensiSiswa::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data absensi berhasil disimpan',
                'data' => $absensi,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan absensi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // PUT /api/absensi/{id}
    public function update(Request $request, $id)
    {
        try {
            $absen = AbsensiSiswa::findOrFail($id);

            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'name' => 'required|string|max:191',
                'pelajaran_id' => 'required|exists:pelajarans,id',
                'classroom_id' => 'required|exists:classrooms,id',
                'date' => 'required|date',
                'check_in_time' => 'required|date_format:H:i:s',
                'check_out_time' => 'required|date_format:H:i:s',
                'status' => 'required|in:hadir,izin,sakit,alpha',
                'notes' => 'nullable|string',
            ]);

            $absen->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data absensi berhasil diperbarui',
                'data' => $absen,
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => 'Data absensi tidak ditemukan',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui absensi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // DELETE /api/absensi/{id}
    public function destroy($id)
    {
        try {
            $absen = AbsensiSiswa::findOrFail($id);
            $absen->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data absensi berhasil dihapus',
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => 'Data absensi tidak ditemukan',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data absensi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
