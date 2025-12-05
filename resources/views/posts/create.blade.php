@extends('layout')

@section('title', 'Buat Postingan Baru')

@section('content')
<div class="flex justify-center">
    <div class="w-full max-w-2xl bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Bagikan Momen Kucing Anda</h2>
        
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Foto Kucing <span class="text-red-500">*</span></label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-pink-600" id="imageDropZone">
                    <input type="file" id="image" name="image" accept="image/*" required class="hidden" onchange="previewImage()">
                    <div id="imagePreview" class="hidden">
                        <img id="previewImg" src="" alt="Preview" class="max-h-80 mx-auto mb-4">
                        <button type="button" class="text-pink-600 hover:text-pink-700 text-sm font-semibold" onclick="document.getElementById('image').click()">
                            Ubah foto
                        </button>
                    </div>
                    <div id="imagePlaceholder">
                        <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mb-2"></i>
                        <p class="text-gray-600 font-semibold">Klik atau seret foto di sini</p>
                        <p class="text-gray-500 text-sm">PNG, JPG, atau GIF (Max 2MB)</p>
                    </div>
                </div>
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="caption" class="block text-sm font-medium text-gray-700 mb-2">Caption (Opsional)</label>
                <textarea id="caption" name="caption" rows="4" placeholder="Tulis cerita tentang kucing kesayangan Anda..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">{{ old('caption') }}</textarea>
                @error('caption')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">Karakter: <span id="charCount">0</span>/2000</p>
            </div>
            
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-pink-600 text-white font-semibold py-3 rounded-lg hover:bg-pink-700 transition">
                    <i class="fas fa-share"></i> Posting
                </button>
                <a href="{{ route('dashboard') }}" class="flex-1 bg-gray-200 text-gray-800 font-semibold py-3 rounded-lg text-center hover:bg-gray-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const imageInput = document.getElementById('image');
    const imageDropZone = document.getElementById('imageDropZone');
    const imagePreview = document.getElementById('imagePreview');
    const imagePlaceholder = document.getElementById('imagePlaceholder');
    const captionTextarea = document.getElementById('caption');
    const charCount = document.getElementById('charCount');

    // Drag and drop
    imageDropZone.addEventListener('click', () => imageInput.click());
    
    imageDropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        imageDropZone.classList.add('border-pink-600', 'bg-pink-50');
    });
    
    imageDropZone.addEventListener('dragleave', () => {
        imageDropZone.classList.remove('border-pink-600', 'bg-pink-50');
    });
    
    imageDropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        imageDropZone.classList.remove('border-pink-600', 'bg-pink-50');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            imageInput.files = files;
            previewImage();
        }
    });

    function previewImage() {
        const file = imageInput.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                document.getElementById('previewImg').src = e.target.result;
                imagePreview.classList.remove('hidden');
                imagePlaceholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    }

    // Character counter
    captionTextarea.addEventListener('input', () => {
        charCount.textContent = captionTextarea.value.length;
    });
</script>
@endsection
