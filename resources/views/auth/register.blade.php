@extends('layout')

@section('title', 'Daftar')

@section('content')
<div class="flex justify-center min-h-screen items-center">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-center text-pink-600 mb-8">
            <i class="fas fa-cat"></i> Catgram
        </h1>
        
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Akun Baru</h2>
        
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" id="name" name="name" required value="{{ old('name') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <input type="text" id="username" name="username" required value="{{ old('username') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" id="email" name="email" required value="{{ old('email') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" id="password" name="password" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                @error('password_confirmation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" class="w-full bg-pink-600 text-white font-semibold py-2 rounded-lg hover:bg-pink-700 transition">
                Daftar
            </button>
        </form>
        
        <p class="text-center text-gray-600 mt-4">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-pink-600 font-semibold hover:underline">Login di sini</a>
        </p>
    </div>
</div>
@endsection
