@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-4 md:py-8">
    
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        
        <div class="bg-gray-900 px-6 py-4 flex items-center border-b border-gray-800">
            <span class="text-xl mr-2">👥</span>
            <h2 class="text-sm font-black text-white uppercase tracking-wider">
                Tambah Anggota Staf Baru
            </h2>
        </div>

        <div class="p-6 bg-white">
            
            @if($errors->any())
                <div class="mb-5 p-3 bg-red-50 border-l-4 border-red-500 rounded-r-xl text-xs text-red-700 font-semibold shadow-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('staf.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                        class="w-full text-sm text-black bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:border-orange-500 focus:bg-white transition" 
                        placeholder="Contoh: Ahmad Kru" required autocomplete="off">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                        class="w-full text-sm text-black bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:border-orange-500 focus:bg-white transition" 
                        placeholder="nama@hoshigraph.com" required>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Hak Akses (Role)</label>
                    <select name="role" class="w-full text-sm text-black bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:border-orange-500 focus:bg-white transition" required>
                        <option value="" disabled selected class="text-gray-400">-- Pilih Role Anggota --</option>
                        <option value="staf" {{ old('role') == 'staf' ? 'selected' : '' }}>📸 Staf / Fotografer / Kasir</option>
                        <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>👑 Super Admin (Pemilik)</option>
                    </select>
                </div>

                <div class="border-t border-gray-100 my-4 pt-4"></div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Password Akun</label>
                        <input type="password" name="password" 
                            class="w-full text-sm text-black bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:border-orange-500 focus:bg-white transition" 
                            placeholder="Minimal 8 karakter" required>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" 
                            class="w-full text-sm text-black bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:border-orange-500 focus:bg-white transition" 
                            placeholder="Ulangi password" required>
                    </div>
                </div>

                <div class="pt-4 space-y-2">
                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs uppercase tracking-wider py-3 rounded-xl shadow-md transition transform active:scale-98">
                        💾 Daftarkan Anggota Baru
                    </button>
                    <a href="{{ route('staf.index') }}" class="block text-center text-xs font-semibold text-gray-400 hover:text-gray-600 transition py-1">
                        ← Kembali ke Daftar Staf
                    </a>
                </div>
            </form>
        </div>
    </div>
    
</div>
@endsection