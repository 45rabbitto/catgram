@extends('layout')

@section('title', 'Mengikuti ' . $user->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('profile.show', $user) }}" class="text-pink-600 hover:text-pink-700">
            <i class="fas fa-arrow-left"></i> Kembali ke Profil
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Mengikuti {{ $user->name }}</h2>
        <p class="text-gray-600">Total: {{ $following->total() }} yang diikuti</p>
    </div>

    @if($following->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
            @foreach($following as $followedUser)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden">
                    <div class="bg-gradient-to-r from-pink-400 to-pink-600 h-24"></div>
                    
                    <div class="p-4 text-center -mt-12 relative">
                        <div class="w-24 h-24 bg-pink-200 rounded-full mx-auto mb-3 flex items-center justify-center border-4 border-white shadow-lg text-4xl">
                            😺
                        </div>
                        
                        <a href="{{ route('profile.show', $followedUser) }}" class="font-bold text-gray-800 hover:text-pink-600 block mb-1">
                            {{ $followedUser->name }}
                        </a>
                        <p class="text-gray-600 text-sm mb-3">@ {{ $followedUser->username }}</p>
                        
                        <div class="flex justify-center gap-2 mb-4 text-sm text-gray-600">
                            <span><strong>{{ $followedUser->posts()->count() }}</strong> posting</span>
                        </div>
                        
                        @auth
                            @if(Auth::id() !== $followedUser->id)
                                <form method="POST" action="{{ Auth::user()->isFollowing($followedUser) ? route('follow.destroy', $followedUser) : route('follow.store', $followedUser) }}" style="display:block;">
                                    @csrf
                                    @if(Auth::user()->isFollowing($followedUser))
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-gray-300 text-gray-800 font-semibold py-2 rounded-lg hover:bg-gray-400 transition text-sm">
                                            <i class="fas fa-user-check"></i> Mengikuti
                                        </button>
                                    @else
                                        <button type="submit" class="w-full bg-pink-600 text-white font-semibold py-2 rounded-lg hover:bg-pink-700 transition text-sm">
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
            {{ $following->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-user-friends text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-600 text-lg">{{ $user->name }} belum mengikuti siapa pun</p>
        </div>
    @endif
</div>
@endsection
