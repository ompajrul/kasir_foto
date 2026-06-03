@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto p-4 md:py-8">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase tracking-wider">
                    👥 Kelola Anggota Staf
                </h2>
                <p class="text-sm text-gray-500 mt-1">Daftar pengguna, hak akses sistem, dan manajemen kru Hoshigraph.</p>
            </div>
            <a href="{{ route('staf.create') }}"
                class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold px-5 py-3 rounded-xl transition shadow-md uppercase tracking-wider">
                + Tambah Staf Baru
            </a>
        </div>

        @if(session('success'))
            <div
                class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl text-sm text-green-700 font-semibold shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl text-sm text-red-700 font-semibold shadow-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse align-middle">
                    <thead>
                        <tr class="bg-gray-900 text-white text-xs font-black uppercase tracking-wider">
                            <th class="px-6 py-4">Nama Anggota</th>
                            <th class="px-6 py-4">Alamat Email</th>
                            <th class="px-6 py-4 text-center">Akses Sistem</th>
                            <th class="px-6 py-4 text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-black">
                        @foreach($stafs as $staf)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 font-bold text-gray-900">{{ $staf->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $staf->email }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($staf->role === 'super_admin')
                                        <span
                                            class="inline-block bg-red-100 text-red-700 text-xs font-black px-2.5 py-1 rounded-full uppercase tracking-wide">
                                            👑 SUPER ADMIN
                                        </span>
                                    @else
                                        <span
                                            class="inline-block bg-blue-100 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">
                                            📸 STAF KASIR
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center space-x-1 flex justify-center items-center">
                                    <button type="button" onclick="openResetModal('{{ $staf->id }}', '{{ $staf->name }}')"
                                        class="bg-amber-50 hover:bg-amber-100 text-amber-600 hover:text-amber-700 text-xs font-bold px-3 py-1.5 rounded-lg border border-amber-200 transition">
                                        🔑 Password
                                    </button>

                                    @if($staf->id !== auth()->id())
                                        <form action="{{ route('staf.destroy', $staf->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus akses staf {{ $staf->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-50 hover:bg-red-100 text-red-600 hover:text-red-700 text-xs font-bold px-3 py-1.5 rounded-lg border border-red-200 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span
                                            class="text-xs font-bold text-gray-400 italic bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200">
                                            Anda
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="resetModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center p-4">
        <div
            class="bg-white rounded-2xl max-w-md w-full shadow-2xl overflow-hidden border border-gray-100 transform transition-all">
            <div class="bg-gray-900 px-6 py-4 flex justify-between items-center text-white">
                <h3 class="text-sm font-black uppercase tracking-wider">🔑 Reset Password Staf</h3>
                <button onclick="closeResetModal()" class="text-gray-400 hover:text-white font-bold">&times;</button>
            </div>

            <form id="formResetPassword" action="" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <p class="text-xs text-gray-500">
                    Mengubah password untuk staf: <span id="modalStafName" class="font-bold text-gray-800"></span>
                </p>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Password Baru</label>
                    <input type="password" name="password" required minlength="8"
                        class="w-full text-sm text-black bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:border-orange-500 focus:bg-white transition"
                        placeholder="Minimal 8 karakter">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Konfirmasi
                        Password</label>
                    <input type="password" name="password_confirmation" required minlength="8"
                        class="w-full text-sm text-black bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:border-orange-500 focus:bg-white transition"
                        placeholder="Ulangi password baru">
                </div>

                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" onclick="closeResetModal()"
                        class="px-4 py-2 bg-gray-100 text-gray-500 rounded-xl text-xs font-bold hover:bg-gray-200 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2 bg-orange-500 text-white rounded-xl text-xs font-bold hover:bg-orange-600 transition shadow-md">
                        Simpan Password Baru
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openResetModal(userId, userName) {
            // 1. Ambil elemen modal
            const modal = document.getElementById('resetModal');

            // 2. Tembak nama staf ke teks info modal
            document.getElementById('modalStafName').innerText = userName;

            // 3. Set action URL Form secara dinamis sesuai ID staf yang diklik
            document.getElementById('formResetPassword').action = `/staf/${userId}/reset-password`;

            // 4. Munculkan modal (hapus class hidden)
            modal.classList.remove('hidden');
        }

        function closeResetModal() {
            // Sembunyikan kembali modal (tambahkan class hidden)
            document.getElementById('resetModal').classLabel = document.getElementById('resetModal').classList.add('hidden');
        }
    </script>
@endsection