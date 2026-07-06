<div id="ingredientModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-center z-50 p-4">
<div class="bg-white rounded-2xl w-[440px] shadow-2xl overflow-hidden">

    <!-- HEADER -->
    <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-flask text-blue-500 text-sm"></i>
            </div>
            <h2 class="text-[17px] font-semibold text-gray-800">Ingredient</h2>
        </div>
        <button onclick="closeIngredientModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center transition">
            <i class="fas fa-times text-gray-400 text-sm"></i>
        </button>
    </div>

    <!-- BODY -->
    <div class="px-6 py-5">
        <form method="POST" action="index.php?action=addIngredient" id="ingredientForm">

            <input type="hidden" name="id" id="ingredient_id">

            <!-- NAME -->
            <div class="mb-4">
                <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Ingredient Name</label>
                <input type="text" name="name" id="ingredient_name" placeholder="e.g. Niacinamide"
                    class="border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-50 p-3 w-full rounded-xl text-sm outline-none transition" required>
            </div>

            <!-- SAFETY -->
            <div class="mb-4">
                <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Safety Level</label>
                <select name="safety" id="ingredient_safety"
                    class="border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-50 p-3 w-full rounded-xl text-sm outline-none transition bg-white" required>
                    <option value="safe">✅ Safe</option>
                    <option value="caution">⚠️ Caution</option>
                    <option value="harmful">❌ Harmful</option>
                </select>
            </div>

            <!-- NOTES -->
            <div class="mb-6">
                <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Notes</label>
                <textarea name="notes" id="ingredient_notes" rows="3" placeholder="Additional notes about this ingredient..."
                    class="border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-50 p-3 w-full rounded-xl text-sm outline-none resize-none transition"></textarea>
            </div>

            <!-- ACTIONS -->
            <div class="flex gap-3">
                <button type="button" onclick="closeIngredientModal()"
                    class="flex-1 h-[44px] rounded-xl border border-gray-200 text-sm text-gray-500 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 h-[44px] rounded-xl bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium transition">
                    Save Ingredient
                </button>
            </div>

        </form>
    </div>

</div>
</div>