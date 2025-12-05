@extends('layout')

@section('title', 'Dashboard - Timeline')

@section('content')
<div class="grid grid-cols-12 gap-6">
    <!-- Main Feed -->
    <div class="col-span-8 max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Timeline Kucing Teman-teman</h2>
        
        @forelse($posts as $post)
            <div class="bg-white rounded-lg shadow-md mb-4">
                <!-- Post Header -->
                <div class="border-b border-gray-200 p-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-pink-200 rounded-full flex items-center justify-center text-lg">
                            😺
                        </div>
                        <div>
                            <a href="{{ route('profile.show', $post->user) }}" class="font-semibold text-gray-800 hover:text-pink-600">
                                {{ $post->user->name }}
                            </a>
                            <p class="text-sm text-gray-500"> @ {{ $post->user->username }}</p>
                        </div>
                    </div>
                    
                    @can('delete', $post)
                        <div class="flex gap-2">
                            <a href="{{ route('posts.edit', $post) }}" class="text-blue-500 hover:text-blue-700">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('posts.destroy', $post) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Hapus postingan ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
                
                <!-- Post Image -->
                <div class="w-full bg-gray-200 flex items-center justify-center">
                    <img src="{{ route('storage.file', $post->image_path) }}" alt="Post" class="w-full object-contain">
                </div>
                
                <!-- Post Actions -->
                <div class="p-3 border-b border-gray-200 flex gap-4">
                    <form method="POST" action="{{ $post->isLikedBy(Auth::user()) ? route('likes.destroy', $post) : route('likes.store', $post) }}" style="display:inline;">
                        @csrf
                        @if($post->isLikedBy(Auth::user()))
                            @method('DELETE')
                        @endif
                        <button type="submit" class="{{ $post->isLikedBy(Auth::user()) ? 'text-red-500' : 'text-gray-600' }} hover:text-red-500 text-xl">
                            <i class="fas fa-heart"></i>
                        </button>
                    </form>
                    
                    <a href="{{ route('posts.show', $post) }}" class="text-gray-600 hover:text-pink-600 text-xl">
                        <i class="fas fa-comment"></i>
                    </a>
                </div>
                
                <!-- Post Stats -->
                <div class="px-4 py-2 text-sm text-gray-600">
                    <p class="font-semibold">{{ $post->likes()->count() }} menyukai</p>
                </div>
                
                <!-- Post Caption -->
                @if($post->caption)
                    <div class="px-4 py-2 text-gray-800 text-sm">
                        <p>
                            <span class="font-semibold">
                                <a href="{{ route('profile.show', $post->user) }}" class="hover:text-pink-600">
                                    {{ $post->user->name }}
                                </a>
                            </span>
                            {{ $post->caption }}
                        </p>
                    </div>
                @endif
                
                <!-- Comments Section -->
                <div class="border-t border-gray-200 p-4">
                    <a href="{{ route('posts.show', $post) }}" class="text-sm text-gray-500 hover:text-gray-700 mb-3 block">
                        Lihat semua {{ $post->comments()->count() }} komentar
                    </a>
                    
                    <!-- Comment Form -->
                    <form method="POST" action="{{ route('comments.store', $post) }}" class="flex gap-2">
                        @csrf
                        <input type="text" name="body" placeholder="Tambah komentar..." required 
                            class="flex-1 px-3 py-2 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-pink-600">
                        <button type="submit" class="text-pink-600 hover:text-pink-700 font-semibold">
                            Posting
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <p class="text-gray-600 text-lg">Belum ada postingan. Ikuti pengguna lain untuk melihat timeline mereka!</p>
            </div>
        @endforelse
        
        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-span-4">
        <!-- User Info -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-pink-200 rounded-full mx-auto mb-3 flex items-center justify-center text-3xl">
                    😺
                </div>
                <h3 class="font-bold text-lg text-gray-800">{{ $user->name }}</h3>
                <p class="text-gray-600"> @ {{ $user->username }}</p>
                @if($user->bio)
                    <p class="text-gray-700 mt-2">{{ $user->bio }}</p>
                @endif
            </div>
        </div>
        
        <!-- Stats -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="grid grid-cols-3 text-center">
                <div>
                    <p class="text-2xl font-bold text-pink-600">{{ $user->posts()->count() }}</p>
                    <p class="text-sm text-gray-600">Postingan</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-pink-600">{{ $user->followers()->count() }}</p>
                    <p class="text-sm text-gray-600">Pengikut</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-pink-600">{{ $user->following()->count() }}</p>
                    <p class="text-sm text-gray-600">Mengikuti</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
