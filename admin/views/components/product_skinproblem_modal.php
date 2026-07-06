<div id="modal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-center z-50 p-4">
<div class="bg-white rounded-2xl w-[440px] shadow-2xl overflow-hidden">

    <!-- HEADER -->
    <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-rose-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-face-sad-tear text-rose-500 text-sm"></i>
            </div>
            <h2 class="text-[17px] font-semibold text-gray-800">Product Skin Problem</h2>
        </div>
        <button onclick="closeModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center transition">
            <i class="fas fa-times text-gray-400 text-sm"></i>
        </button>
    </div>

    <!-- BODY -->
    <div class="px-6 py-5">
        <form method="POST" id="pspForm" action="index.php?action=savePSPForm">

            <!-- PRODUCT -->
            <div class="mb-4">
                <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Product</label>
                <select name="product_id"
                    class="border border-gray-200 focus:border-rose-400 focus:ring-2 focus:ring-rose-50 p-3 w-full rounded-xl text-sm outline-none transition bg-white" required>
                    <option value="">Select Product</option>
                    <?php
                    $products = mysqli_query(Database::connect(), "SELECT * FROM products");
                    while($p = mysqli_fetch_assoc($products)):
                    ?>
                    <option value="<?= $p['id'] ?>"><?= $p['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- SKIN PROBLEM -->
            <div class="mb-6">
                <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Skin Problems</label>
                <select id="skinProblemSelect"
                    class="border border-gray-200 focus:border-rose-400 focus:ring-2 focus:ring-rose-50 p-3 w-full rounded-xl text-sm outline-none transition bg-white">
                    <option value="">Select Skin Problem</option>
                    <?php
                    $problems = mysqli_query(Database::connect(), "SELECT * FROM skin_problems");
                    while($p = mysqli_fetch_assoc($problems)):
                    ?>
                    <option value="<?= $p['id'] ?>"><?= $p['name'] ?></option>
                    <?php endwhile; ?>
                </select>
                <p class="text-[11px] text-gray-400 mt-1.5">Select one at a time to add multiple</p>
                <div id="selectedSkinProblems" class="flex flex-wrap gap-2 mt-3 min-h-[32px]"></div>
                <div id="hiddenSkinProblemInputs"></div>
            </div>

            <!-- ACTIONS -->
            <div class="flex gap-3">
                <button type="button" onclick="closeModal()"
                    class="flex-1 h-[44px] rounded-xl border border-gray-200 text-sm text-gray-500 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 h-[44px] rounded-xl bg-rose-500 hover:bg-rose-600 text-white text-sm font-medium transition">
                    Save
                </button>
            </div>

        </form>
    </div>

</div>
</div>