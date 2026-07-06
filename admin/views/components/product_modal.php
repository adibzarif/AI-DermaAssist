<div id="modal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-center z-50 p-4">
<div class="bg-white rounded-2xl w-[440px] shadow-2xl overflow-hidden">

    <!-- HEADER -->
    <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-purple-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-box text-purple-500 text-sm"></i>
            </div>
            <h2 class="text-[17px] font-semibold text-gray-800" id="title">Add Product</h2>
        </div>
        <button onclick="closeModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center transition">
            <i class="fas fa-times text-gray-400 text-sm"></i>
        </button>
    </div>

    <!-- BODY -->
    <div class="px-6 py-5">
        <form method="POST" action="index.php?action=saveProduct">

            <input type="hidden" name="id" id="id">

            <!-- NAME -->
            <div class="mb-4">
                <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Product Name</label>
                <input name="name" id="name" placeholder="e.g. Cetaphil Moisturizer"
                    class="border border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-50 p-3 w-full rounded-xl text-sm outline-none transition" required>
            </div>

            <!-- BRAND -->
            <div class="mb-4">
                <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Brand</label>
                <input name="brand" id="brand" placeholder="e.g. Cetaphil"
                    class="border border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-50 p-3 w-full rounded-xl text-sm outline-none transition" required>
            </div>

            <!-- IMAGE URL -->
            <div class="mb-4">
                <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Image URL</label>
                <input name="image_url" id="image" placeholder="https://example.com/image.jpg"
                    class="border border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-50 p-3 w-full rounded-xl text-sm outline-none transition">
            </div>

            <!-- DESCRIPTION -->
            <div class="mb-6">
                <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Description</label>
                <textarea name="description" id="desc" rows="3" placeholder="Short product description..."
                    class="border border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-50 p-3 w-full rounded-xl text-sm outline-none resize-none transition"></textarea>
            </div>

            <!-- ACTIONS -->
            <div class="flex gap-3">
                <button type="button" onclick="closeModal()"
                    class="flex-1 h-[44px] rounded-xl border border-gray-200 text-sm text-gray-500 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 h-[44px] rounded-xl bg-purple-500 hover:bg-purple-600 text-white text-sm font-medium transition">
                    Save Product
                </button>
            </div>

        </form>
    </div>

</div>
</div>