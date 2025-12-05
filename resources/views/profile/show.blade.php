@extends('layout')

@section('title', $user->name . ' - Profil')

@section('content')
<div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
    <!-- Profile Header -->
    <div class="bg-gradient-to-r from-pink-400 to-pink-600 h-32"></div>
    
    <div class="px-8 pb-8">
        <div class="flex flex-col md:flex-row md:items-end gap-4 -mt-16 mb-6">
            <div class="w-32 h-32 bg-pink-200 rounded-full flex items-center justify-center border-4 border-white shadow-lg text-6xl">
                😺
            </div>
            
            <div class="flex-1">
                <h1 class="text-4xl font-bold text-gray-800">{{ $user->name }}</h1>
                <p class="text-gray-600 text-lg">{{ $user->username }}</p>
                @if($user->bio)
                    <p class="text-gray-700 mt-2"> @ {{ $user->bio }}</p>
                @endif
            </div>
            
            @auth
                @if(Auth::id() !== $user->id)
                    <form method="POST" action="{{ $is_following ? route('follow.destroy', $user) : route('follow.store', $user) }}" style="display:inline;">
                        @csrf
                        @if($is_following)
                            @method('DELETE')
                            <button type="submit" class="bg-gray-300 text-gray-800 font-semibold px-6 py-2 rounded-lg hover:bg-gray-400 transition">
                                <i class="fas fa-user-check"></i> Mengikuti
                            </button>
                        @else
                            <button type="submit" class="bg-pink-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-pink-700 transition">
                                <i class="fas fa-user-plus"></i> Ikuti
                            </button>
                        @endif
                    </form>
                @else
                    <a href="{{ route('profile.edit') }}" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 transition inline-block">
                        <i class="fas fa-edit"></i> Edit Profil
                    </a>
                @endif
            @endauth
        </div>
        
        <!-- Stats -->
        <div class="grid grid-cols-3 gap-8 py-6 border-t border-gray-200">
            <div class="text-center">
                <p class="text-3xl font-bold text-pink-600">{{ $posts->total() }}</p>
                <p class="text-gray-600">Postingan</p>
            </div>
            <a href="{{ route('profile.followers', $user) }}" class="text-center hover:bg-gray-50 rounded-lg py-2 transition cursor-pointer">
                <p class="text-3xl font-bold text-pink-600">{{ $followers_count }}</p>
                <p class="text-gray-600">Pengikut</p>
            </a>
            <a href="{{ route('profile.following', $user) }}" class="text-center hover:bg-gray-50 rounded-lg py-2 transition cursor-pointer">
                <p class="text-3xl font-bold text-pink-600">{{ $following_count }}</p>
                <p class="text-gray-600">Mengikuti</p>
            </a>
        </div>
    </div>
</div>

<!-- Posts Grid -->
<div>
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Postingan</h2>
    
    @if($posts->count() > 0)
        <div class="grid grid-cols-3 gap-4 mb-8">
            @foreach($posts as $post)
                <a href="{{ route('posts.show', $post) }}" class="relative group overflow-hidden rounded-lg shadow-md hover:shadow-lg transition">
                    <img src="{{ route('storage.file', $post->image_path) }}" alt="Post" class="w-full h-64 object-cover group-hover:opacity-75 transition">
                    
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition flex items-center justify-center">
                        <div class="text-white opacity-0 group-hover:opacity-100 transition text-center">
                            <p class="text-2xl font-bold">
                                <i class="fas fa-heart"></i> {{ $post->likes()->count() }}
                            </p>
                            <p class="text-lg">
                                <i class="fas fa-comment"></i> {{ $post->comments()->count() }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        
        <div class="flex justify-center">
            {{ $posts->links() }}
        </div>
    @else
        <div class="bg-gray-50 rounded-lg p-12 text-center">
            <i class="fas fa-image text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-600 text-lg">Belum ada postingan</p>
        </div>
    @endif
</div>
@endsection
