@extends('layout')

@section('title', 'Edit Postingan')

@section('content')
<div class="flex justify-center">
    <div class="w-full max-w-2xl bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Edit Postingan</h2>
        
        <form method="POST" action="{{ route('posts.update', $post) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Post Image Preview -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Postingan</label>
                <div class="border border-gray-300 rounded-lg overflow-hidden bg-gray-200 flex items-center justify-center">
                    <img src="{{ route('storage.file', $post->image_path) }}" alt="Post" class="w-full object-contain max-h-80">
                </div>
                <p class="text-sm text-gray-500 mt-2">Foto tidak dapat diubah, hanya caption yang dapat diedit.</p>
            </div>
            
            <div>
                <label for="caption" class="block text-sm font-medium text-gray-700 mb-2">Caption</label>
                <textarea id="caption" name="caption" rows="6" placeholder="Tulis caption untuk postingan Anda..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">{{ $post->caption }}</textarea>
                @error('caption')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">Karakter: <span id="charCount">{{ strlen($post->caption ?? '') }}</span>/2000</p>
            </div>
            
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-pink-600 text-white font-semibold py-3 rounded-lg hover:bg-pink-700 transition">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('posts.show', $post) }}" class="flex-1 bg-gray-200 text-gray-800 font-semibold py-3 rounded-lg text-center hover:bg-gray-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const captionTextarea = document.getElementById('caption');
    const charCount = document.getElementById('charCount');

    captionTextarea.addEventListener('input', () => {
        charCount.textContent = captionTextarea.value.length;
    });
</script>
@endsection
