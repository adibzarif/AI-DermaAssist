<div class="ml-64 bg-[#f7f7f7] min-h-screen p-6">

    <!-- TOP BAR -->
    <div class="flex justify-between items-center mb-6">

        <!-- SEARCH -->
        <form method="GET" class="relative">

            <input
                type="hidden"
                name="page"
                value="productSkinProblem"
            >

            <input
                type="text"
                name="search"
                value="<?= $_GET['search'] ?? '' ?>"
                placeholder="Search anything"
                class="w-[230px] h-[42px] bg-white border border-gray-200 rounded-2xl pl-10 pr-16 text-sm outline-none"
            >

            <!-- ICON -->
            <i class="fa fa-search absolute left-4 top-3 text-gray-400 text-sm"></i>

        </form>

        <!-- ADD BUTTON -->
        <button
            onclick="openModal()"
            class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-xl text-sm hover:opacity-90"
        >
            + Add Problem
        </button>

    </div>

    <!-- CARD -->
    <div class="bg-white border border-gray-200 rounded-2xl p-6">

        <!-- TITLE -->
        <div class="flex items-center gap-2 mb-6">

            <div class="w-2 h-2 rounded-full bg-blue-500"></div>

            <h2 class="text-[22px] font-semibold text-gray-800">
                Product Skin Problem
            </h2>

        </div>

        <!-- TABLE -->
        <table class="w-full table-fixed">

            <!-- HEADER -->
            <thead>

                <tr class="text-left text-[14px] text-gray-500 border-b border-gray-100">

                    <th class="pb-4 font-medium w-[30%]">
                        Product
                    </th>

                    <th class="pb-4 font-medium w-[55%]">
                        Skin Problems
                    </th>

                    <th class="pb-4 font-medium text-center w-[15%]">
                        Action
                    </th>

                </tr>

            </thead>

            <!-- BODY -->
            <tbody>

            <?php while($row = mysqli_fetch_assoc($data)): ?>

            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">

                <!-- PRODUCT -->
                <td class="py-5 text-[15px] font-medium text-gray-800">
                    <?= $row['product'] ?>
                </td>

                <!-- PROBLEMS -->
                <td class="py-4">

                    <div class="flex flex-wrap gap-2">

                    <?php

                    $names = explode(',', $row['problems']);
                    $ids = explode(',', $row['problem_ids']);

                    foreach($names as $i => $name):

                    ?>

                    <span
                        class="bg-blue-50 text-blue-600 px-3 py-1 rounded-xl text-xs inline-flex items-center gap-2"
                    >

                        <?= $name ?>

                    </span>

                    <?php endforeach; ?>

                    </div>

                </td>

                <!-- ACTION -->
                <td>

                    <div class="flex justify-center gap-2">

                        <!-- EDIT -->
                        <button
                            onclick='editPSP(
                                <?= $row["product_id"] ?>,
                                "<?= $row["problem_ids"] ?>"
                            )'
                            class="w-9 h-9 rounded-full bg-gray-100 hover:bg-blue-100 flex items-center justify-center text-blue-500"
                        >
                            <i class="fa fa-pen text-xs"></i>
                        </button>

                        <!-- DELETE -->
                        <a
                            href="index.php?action=deletePSPRow&product_id=<?= $row['product_id'] ?>"
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
                href="index.php?page=productSkinProblem&p=<?= $page-1 ?>&search=<?= $_GET['search'] ?? '' ?>"
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
                href="index.php?page=productSkinProblem&p=<?= $i ?>&search=<?= $_GET['search'] ?? '' ?>"
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
                href="index.php?page=productSkinProblem&p=<?= $page+1 ?>&search=<?= $_GET['search'] ?? '' ?>"
                class="w-10 h-10 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-gray-100"
            >
                →
            </a>

            <?php endif; ?>

        </div>

    </div>

</div>

<!-- MODAL -->
<?php include __DIR__ . '/components/product_skinproblem_modal.php'; ?>