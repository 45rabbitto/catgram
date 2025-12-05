@extends('layout')

@section('title', 'Edit Profil')

@section('content')
<div class="flex justify-center">
    <div class="w-full max-w-2xl bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Edit Profil</h2>
        
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ $user->name }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <input type="text" id="username" name="username" value="{{ $user->username }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-pink-600 text-white font-semibold py-3 rounded-lg hover:bg-pink-700 transition">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('profile.show', $user) }}" class="flex-1 bg-gray-200 text-gray-800 font-semibold py-3 rounded-lg text-center hover:bg-gray-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
