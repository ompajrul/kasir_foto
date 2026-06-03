<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreStafRequest;
use App\Services\StafService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
class UserController extends Controller
{
    protected $stafService;

    // Suntikkan StafService ke dalam constructor Controller
    public function __construct(StafService $stafService)
    {
        $this->stafService = $stafService;
    }

    /**
     * Menampilkan daftar seluruh anggota staf Hoshigraph
     */
    public function index()
    {
        $stafs = User::latest()->get();

        // Mengarah ke folder views/staf/index.blade.php (jika kamu ingin membuat tabel daftarnya nanti)
        return view('staf.index', compact('stafs'));
    }

    /**
     * Menampilkan form halaman tambah staf baru
     */
    public function create()
    {
        // Mengarah ke file views/staf/create.blade.php yang kita buat kemarin
        return view('staf.create');
    }

    /**
     * Memproses dan menyimpan data akun staf baru
     */
    public function store(StoreStafRequest $request)
    {
        // Ambil data yang sudah lolos validasi, lalu lempar ke Service Layer
        $this->stafService->registerStaf($request->validated());

        return redirect()->route('staf.index')->with('success', 'Anggota staf baru berhasil didaftarkan!');
    }

    /**
     * Menghapus hak akses staf/fotografer dari studio
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Keamanan: Mencegah pemilik/super_admin tidak sengaja menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return redirect()->back()->withErrors(['error' => 'Kamu tidak bisa menghapus akunmu sendiri!']);
        }

        $user->delete();
        return redirect()->route('staf.index')->with('success', 'Akun staf berhasil dihapus!');
    }

    public function resetPassword(Request $request, $id)
    {
        // 1. Validasi input password baru
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.min' => 'Password baru minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        // 2. Cari akun staf yang dimaksud
        $user = User::findOrFail($id);

        // 3. Update password dengan enkripsi Hash
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('staf.index')->with('success', "Password untuk staf {$user->name} berhasil diperbarui!");
    }
}