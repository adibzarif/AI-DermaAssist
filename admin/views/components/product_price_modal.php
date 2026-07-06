<div id="priceModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-center z-50 p-4">
<div class="bg-white rounded-2xl w-[440px] shadow-2xl overflow-hidden">

    <!-- HEADER -->
    <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-amber-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-tag text-amber-500 text-sm"></i>
            </div>
            <h2 class="text-[17px] font-semibold text-gray-800">Product Price</h2>
        </div>
        <button onclick="closePriceModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center transition">
            <i class="fas fa-times text-gray-400 text-sm"></i>
        </button>
    </div>

    <!-- BODY -->
    <div class="px-6 py-5">
        <form method="POST" id="priceForm" action="index.php?action=savePrice">

            <input type="hidden" name="id" id="price_id">

            <!-- PRODUCT -->
            <div class="mb-4">
                <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Product</label>
                <select name="product_id" id="price_product"
                    class="border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-50 p-3 w-full rounded-xl text-sm outline-none transition bg-white" required>
                    <option value="">Select Product</option>
                    <?php while($p = mysqli_fetch_assoc($products)): ?>
                    <option value="<?= $p['id'] ?>"><?= $p['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- STORE -->
            <div class="mb-4">
                <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Store Name</label>
                <input type="text" name="store_name" id="price_store" placeholder="e.g. Watson / Shopee"
                    class="border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-50 p-3 w-full rounded-xl text-sm outline-none transition" required>
            </div>

            <!-- PRICE + URL side by side -->
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div>
                    <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Price (RM)</label>
                    <input type="number" step="0.01" name="price" id="price_value" placeholder="0.00"
                        class="border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-50 p-3 w-full rounded-xl text-sm outline-none transition" required>
                </div>
                <div>
                    <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Product URL</label>
                    <input type="text" name="url" id="price_url" placeholder="https://..."
                        class="border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-50 p-3 w-full rounded-xl text-sm outline-none transition">
                </div>
            </div>

            <!-- ACTIONS -->
            <div class="flex gap-3 mt-2">
                <button type="button" onclick="closePriceModal()"
                    class="flex-1 h-[44px] rounded-xl border border-gray-200 text-sm text-gray-500 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 h-[44px] rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium transition">
                    Save Price
                </button>
            </div>

        </form>
    </div>

</div>
</div>