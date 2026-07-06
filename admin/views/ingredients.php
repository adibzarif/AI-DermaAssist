<div class="ml-64 bg-[#f7f7f7] min-h-screen p-6">

    <!-- TOP BAR -->
    <div class="flex justify-between items-center mb-6">

        <!-- SEARCH -->
        <form method="GET" class="relative">

            <input
                type="hidden"
                name="page"
                value="ingredients"
            >

            <input
                type="text"
                name="search"
                value="<?= $_GET['search'] ?? '' ?>"
                placeholder="Search ingredient"
                class="w-[230px] h-[42px] bg-white border border-gray-200 rounded-2xl pl-10 pr-4 text-sm outline-none"
            >

            <i class="fa fa-search absolute left-4 top-3 text-gray-400 text-sm"></i>

        </form>

        <!-- ADD BUTTON -->
        <button
            onclick="openIngredientModal()"
            class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-xl text-sm"
        >
            + Add Ingredient
        </button>

    </div>

    <!-- CARD -->
    <div class="bg-white border border-gray-200 rounded-2xl p-6">

        <!-- TITLE -->
        <div class="flex items-center gap-2 mb-6">

            <div class="w-2 h-2 rounded-full bg-blue-500"></div>

            <h2 class="text-[22px] font-semibold text-gray-800">
                Ingredients
            </h2>

        </div>

        <!-- TABLE -->
        <table class="w-full table-fixed">

            <thead>

                <tr class="text-left text-[14px] text-gray-500 border-b border-gray-100">

                    <th class="pb-4 font-medium w-[25%]">
                        Ingredient
                    </th>

                    <th class="pb-4 font-medium w-[20%]">
                        Safety
                    </th>

                    <th class="pb-4 font-medium w-[40%]">
                        Notes
                    </th>

                    <th class="pb-4 font-medium text-center w-[15%]">
                        Action
                    </th>

                </tr>

            </thead>

            <tbody>

            <?php while($i = $ingredients->fetch_assoc()): ?>

            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">

                <!-- NAME -->
                <td class="py-5 text-[15px] font-medium text-gray-800">
                    <?= $i['name'] ?>
                </td>

                <!-- SAFETY -->
                <td class="py-4">

                    <?php
                    $color =
                        $i['safety'] == 'safe'
                        ? 'bg-green-100 text-green-600'
                        : (
                            $i['safety'] == 'caution'
                            ? 'bg-yellow-100 text-yellow-600'
                            : 'bg-red-100 text-red-600'
                        );
                    ?>

                    <span class="<?= $color ?> px-3 py-1 rounded-xl text-xs">
                        <?= ucfirst($i['safety']) ?>
                    </span>

                </td>

                <!-- NOTES -->
                <td class="py-4 text-sm text-gray-600">
                    <?= $i['notes'] ?: '-' ?>
                </td>

                <!-- ACTION -->
                <td>

                    <div class="flex justify-center gap-2">

                        <!-- EDIT -->
                        <button
                            onclick="editIngredientData(
                                '<?= $i['id'] ?>',
                                '<?= htmlspecialchars($i['name'], ENT_QUOTES) ?>',
                                '<?= htmlspecialchars($i['safety'], ENT_QUOTES) ?>',
                                '<?= htmlspecialchars($i['notes'], ENT_QUOTES) ?>'
                            )"
                            class="w-9 h-9 rounded-full bg-gray-100 hover:bg-blue-100 flex items-center justify-center text-blue-500"
                        >
                            <i class="fa fa-pen text-xs"></i>
                        </button>

                        <!-- DELETE -->
                        <a
                            href="index.php?action=deleteIngredient&id=<?= $i['id'] ?>"
                            onclick="return confirm('Delete this ingredient?')"
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

            <?php if($page > 1): ?>

            <a
                href="index.php?page=ingredients&p=<?= $page-1 ?>"
                class="w-10 h-10 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-gray-100"
            >
                ←
            </a>

            <?php endif; ?>

            <?php for($x = 1; $x <= $totalPages; $x++): ?>

            <a
                href="index.php?page=ingredients&p=<?= $x ?>"
                class="w-10 h-10 rounded-xl flex items-center justify-center text-sm

                <?= ($x == $page)
                    ? 'bg-gray-200 text-black font-semibold'
                    : 'text-gray-500 hover:bg-gray-100'
                ?>"
            >
                <?= $x ?>
            </a>

            <?php endfor; ?>

            <?php if($page < $totalPages): ?>

            <a
                href="index.php?page=ingredients&p=<?= $page+1 ?>"
                class="w-10 h-10 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-gray-100"
            >
                →
            </a>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php include __DIR__ . '/components/ingredient_modal.php'; ?>