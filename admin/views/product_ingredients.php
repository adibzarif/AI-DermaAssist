<div class="ml-64 bg-[#f7f7f7] min-h-screen p-6">

    <!-- TOP -->
    <div class="flex justify-between items-center mb-6">

        <!-- SEARCH -->
        <form method="GET" class="relative">

            <input
                type="hidden"
                name="page"
                value="productIngredients"
            >

            <input
                type="text"
                name="search"
                value="<?= $_GET['search'] ?? '' ?>"
                placeholder="Search anything"
                class="w-[230px] h-[42px] bg-white border border-gray-200 rounded-2xl pl-10 text-sm outline-none"
            >

            <i class="fa fa-search absolute left-4 top-3 text-gray-400 text-sm"></i>

        </form>

        <!-- ADD -->
        <button
            onclick="openProductIngredientModal()"
            class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-xl text-sm hover:opacity-90"
        >
            + Add Ingredient
        </button>

    </div>

    <!-- CARD -->
    <div class="bg-white border border-gray-200 rounded-2xl p-6">

        <div class="flex items-center gap-2 mb-6">

            <div class="w-2 h-2 rounded-full bg-blue-500"></div>

            <h2 class="text-[22px] font-semibold">
                Product Ingredients
            </h2>

        </div>

        <!-- TABLE -->
        <table class="w-full table-fixed">

            <thead>

                <tr class="border-b border-gray-100 text-left text-sm text-gray-500">

                    <th class="pb-4 w-[30%]">
                        Product
                    </th>

                    <th class="pb-4 w-[55%]">
                        Ingredients
                    </th>

                    <th class="pb-4 text-center w-[15%]">
                        Action
                    </th>

                </tr>

            </thead>

            <tbody>

            <?php while($row = mysqli_fetch_assoc($productList)): ?>

            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">

                <!-- PRODUCT -->
                <td class="py-5 font-medium text-gray-800">
                    <?= $row['name'] ?>
                </td>

                <!-- INGREDIENT -->
                <td class="py-4">

                    <div class="flex flex-wrap gap-2">

                    <?php

                    $names = explode(',', $row['ingredients']);

                    foreach($names as $name):

                    ?>

                    <span class="bg-green-50 text-green-600 px-3 py-1 rounded-xl text-xs">
                        <?= trim($name) ?>
                    </span>

                    <?php endforeach; ?>

                    </div>

                </td>

                <!-- ACTION -->
                <td>

                    <div class="flex justify-center gap-2">

                        <!-- EDIT -->
                        <button
                            onclick="editIngredient(
                                <?= $row['id'] ?>,
                                '<?= $row['ingredient_ids'] ?>'
                            )"
                            class="w-9 h-9 rounded-full bg-gray-100 hover:bg-blue-100 flex items-center justify-center text-blue-500"
                        >
                            <i class="fa fa-pen text-xs"></i>
                        </button>

                        <!-- DELETE -->
                        <a
                            href="index.php?action=deleteProductIngredients&id=<?= $row['id'] ?>"
                            onclick="return confirm('Delete this row?')"
                            class="w-9 h-9 rounded-full bg-gray-100 hover:bg-red-100 flex items-center justify-center text-red-500"
                        >
                            <i class="fa fa-trash text-xs"></i>
                        </a>

                    </div>

                </td>

            </tr>

            <?php endwhile; ?>

            </tbody>

        </table>

        <!-- PAGINATION -->
        <div class="flex justify-center items-center gap-3 mt-6">

            <!-- PREV -->
            <?php if($page > 1): ?>

            <a
                href="index.php?page=productIngredients&p=<?= $page-1 ?>&search=<?= $_GET['search'] ?? '' ?>"
                class="w-10 h-10 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-gray-100"
            >
                ←
            </a>

            <?php endif; ?>

            <?php

            $start = max(1, $page - 2);
            $end = min($totalPages, $page + 2);

            for($i = $start; $i <= $end; $i++):

            ?>

            <a
                href="index.php?page=productIngredients&p=<?= $i ?>&search=<?= $_GET['search'] ?? '' ?>"
                class="w-10 h-10 rounded-xl flex items-center justify-center text-sm transition

                <?= ($i == $page)
                    ? 'bg-gray-200 text-black font-semibold'
                    : 'text-gray-500 hover:bg-gray-100'
                ?>"
            >
                <?= $i ?>
            </a>

            <?php endfor; ?>

            <!-- NEXT -->
            <?php if($page < $totalPages): ?>

            <a
                href="index.php?page=productIngredients&p=<?= $page+1 ?>&search=<?= $_GET['search'] ?? '' ?>"
                class="w-10 h-10 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-gray-100"
            >
                →
            </a>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php include __DIR__ . '/components/product_ingredient_modal.php'; ?>