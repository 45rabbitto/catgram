<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Catgram</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        html, body {
            background-color: white !important;
            color: #000;
        }
    </style>
</head>
<body class="bg-white m-0 p-0">
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 w-full">
        <div class="px-4 py-3 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-pink-600">
                <i class="fas fa-cat"></i> Catgram
            </a>
            
            <div class="flex items-center gap-6">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-pink-600">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a href="{{ route('explore') }}" class="text-gray-700 hover:text-pink-600">
                        <i class="fas fa-compass"></i> Jelajahi
                    </a>
                    <a href="{{ route('posts.create') }}" class="text-gray-700 hover:text-pink-600">
                        <i class="fas fa-plus-circle"></i> Posting
                    </a>
                    <a href="{{ route('profile.show', Auth::user()) }}" class="text-gray-700 hover:text-pink-600">
                        <i class="fas fa-user"></i> Profil
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-pink-600">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-pink-600">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">
                        <i class="fas fa-user-plus"></i> Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 py-8">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <h3 class="text-red-800 font-semibold mb-2">Kesalahan:</h3>
                <ul class="text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="bg-white border-t border-gray-200 mt-12 py-6 text-center text-gray-600">
        <p>&copy; 2024 Catgram - Berbagi Momen Kucing Kesayangan Anda</p>
    </footer>
</body>
</html>
