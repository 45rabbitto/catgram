@extends('layout')

@section('title', 'Detail Postingan')

@section('content')
<div class="grid grid-cols-12 gap-6">
    <!-- Post -->
    <div class="col-span-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Post Image -->
            @if($post->image_path)
                <div class="w-full bg-gray-200 flex items-center justify-center">
                    <img src="{{ route('storage.file', $post->image_path) }}" alt="Post" class="w-full object-contain max-h-screen">
                </div>
            @endif
            
            <!-- Post Header -->
            <div class="border-b border-gray-200 p-4 flex items-center justify-between">
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
            
            <!-- Post Caption -->
            @if($post->caption)
                <div class="px-4 py-3 border-b border-gray-200 text-gray-800">
                    <p>
                        <span class="font-semibold">{{ $post->user->name }}</span>
                        {{ $post->caption }}
                    </p>
                </div>
            @endif
            
            <!-- Post Actions -->
            <div class="px-4 py-3 border-b border-gray-200 flex gap-4">
                <form method="POST" action="{{ $post->isLikedBy(Auth::user()) ? route('likes.destroy', $post) : route('likes.store', $post) }}" style="display:inline;">
                    @csrf
                    @if($post->isLikedBy(Auth::user()))
                        @method('DELETE')
                    @endif
                    <button type="submit" class="{{ $post->isLikedBy(Auth::user()) ? 'text-red-500' : 'text-gray-600' }} hover:text-red-500 text-xl">
                        <i class="fas fa-heart"></i>
                    </button>
                </form>
            </div>
            
            <!-- Post Stats -->
            <div class="px-4 py-3 text-sm text-gray-600 border-b border-gray-200">
                <p class="font-semibold">{{ $post->likes()->count() }} menyukai</p>
                <p class="text-xs text-gray-500 mt-1">{{ $post->created_at->diffForHumans() }}</p>
            </div>
        </div>
    </div>
    
    <!-- Comments Sidebar -->
    <div class="col-span-4">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-comments"></i> Komentar ({{ $post->comments()->count() }})
            </h3>
            
            <!-- Comments List -->
            <div class="space-y-4 mb-6 max-h-96 overflow-y-auto">
                @forelse($post->comments as $comment)
                    <div class="border-b border-gray-200 pb-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <a href="{{ route('profile.show', $comment->user) }}" class="font-semibold text-gray-800 hover:text-pink-600">
                                    {{ $comment->user->name }}
                                </a>
                                <p class="text-xs text-gray-500">@ {{ $comment->user->username }}</p>
                            </div>
                            @can('delete', $comment)
                                <form method="POST" action="{{ route('comments.destroy', $comment) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endcan
                        </div>
                        <p class="text-gray-700 text-sm">{{ $comment->body }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">Belum ada komentar. Jadilah yang pertama!</p>
                @endforelse
            </div>
            
            <!-- Comment Form -->
            <form method="POST" action="{{ route('comments.store', $post) }}" class="border-t border-gray-200 pt-4">
                @csrf
                <textarea name="body" placeholder="Tambah komentar..." required rows="3" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-600"></textarea>
                <button type="submit" class="mt-2 w-full bg-pink-600 text-white font-semibold py-2 rounded-lg hover:bg-pink-700 transition">
                    Posting Komentar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
