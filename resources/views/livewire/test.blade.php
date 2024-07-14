<div class="bg-gray-200 py-8" x-data="{ imagePreview: '', showPreview: false }">
    <div class="max-w-md mx-auto bg-white p-8 shadow-md rounded-md">
        <h2 class="text-lg font-semibold mb-4">Preview Image Before Upload</h2>
        <input type="file" id="fileInput" class="mb-4"
            x-on:change="showPreview = true; imagePreview = URL.createObjectURL($event.target.files[0])">
        <div x-show="showPreview" class="w-full mb-4">
            <img :src="imagePreview" alt="Preview" class="max-w-full h-auto">
        </div>
        <button x-show="showPreview" @click="showPreview = false; $refs.fileInput.value = ''"
            class="bg-red-500 text-white px-4 py-2 rounded-md">Clear</button>
    </div>

</div>
