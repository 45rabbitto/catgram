@extends('layout')

@section('title', 'Jelajahi - Cari Pengguna')

@section('content')
<div class="max-w-4xl mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">
        <i class="fas fa-compass"></i> Jelajahi Pengguna
    </h2>

    <!-- Search Form -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('explore') }}" class="flex gap-3">
            <input type="text" name="search" placeholder="Cari pengguna berdasarkan nama atau username..." 
                value="{{ $search }}" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
            <button type="submit" class="bg-pink-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-pink-700 transition">
                <i class="fas fa-search"></i> Cari
            </button>
        </form>
    </div>

    <!-- Users Grid -->
    @if($users->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
            @foreach($users as $user)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden">
                    <div class="bg-gradient-to-r from-pink-400 to-pink-600 h-24"></div>
                    
                    <div class="p-4 text-center -mt-12 relative">
                        <div class="w-24 h-24 bg-pink-200 rounded-full mx-auto mb-3 flex items-center justify-center border-4 border-white shadow-lg text-4xl">
                            😺
                        </div>
                        
                        <a href="{{ route('profile.show', $user) }}" class="font-bold text-gray-800 hover:text-pink-600 block mb-1">
                            {{ $user->name }}
                        </a>
                        <p class="text-gray-600 text-sm mb-3">@ {{ $user->username }}</p>
                        
                        @if($user->bio)
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $user->bio }}</p>
                        @endif
                        
                        <div class="flex justify-center gap-2 mb-4 text-sm text-gray-600">
                            <span><strong>{{ $user->posts()->count() }}</strong> posting</span>
                            <span><strong>{{ $user->followers()->count() }}</strong> pengikut</span>
                        </div>
                        
                        @auth
                            @if(Auth::id() !== $user->id)
                                <form method="POST" action="{{ Auth::user()->isFollowing($user) ? route('follow.destroy', $user) : route('follow.store', $user) }}" style="display:block;">
                                    @csrf
                                    @if(Auth::user()->isFollowing($user))
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-gray-300 text-gray-800 font-semibold py-2 rounded-lg hover:bg-gray-400 transition">
                                            <i class="fas fa-user-check"></i> Mengikuti
                                        </button>
                                    @else
                                        <button type="submit" class="w-full bg-pink-600 text-white font-semibold py-2 rounded-lg hover:bg-pink-700 transition">
                                            <i class="fas fa-user-plus"></i> Ikuti
                                        </button>
                                    @endif
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $users->appends(request()->query())->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-600 text-lg">
                @if($search)
                    Tidak ada pengguna yang cocok dengan "{{ $search }}"
                @else
                    Mulai cari pengguna untuk mengikuti mereka
                @endif
            </p>
        </div>
    @endif
</div>
@endsection
