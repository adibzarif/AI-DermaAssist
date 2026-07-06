<div class="ml-64 bg-[#f7f7f7] min-h-screen p-6">

    <!-- TOP BAR -->
    <div class="flex justify-between items-center mb-6">

        <!-- SEARCH -->
        <form method="GET" class="relative">

            <input
                type="hidden"
                name="page"
                value="products"
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
            + Add Product
        </button>

    </div>

    <!-- CARD -->
    <div class="bg-white border border-gray-200 rounded-2xl p-6">

        <!-- TITLE -->
        <div class="flex items-center gap-2 mb-6">

            <div class="w-2 h-2 rounded-full bg-blue-500"></div>

            <h2 class="text-[22px] font-semibold text-gray-800">
                Product Management
            </h2>

        </div>

        <!-- TABLE -->
        <table class="w-full table-fixed">

            <!-- HEADER -->
            <thead>

                <tr class="text-left text-[14px] text-gray-500 border-b border-gray-100">

                    <th class="pb-4 font-medium w-[10%]">
                        Image
                    </th>

                    <th class="pb-4 font-medium w-[20%]">
                        Name
                    </th>

                    <th class="pb-4 font-medium w-[15%]">
                        Brand
                    </th>

                    <th class="pb-4 font-medium w-[30%]">
                        Description
                    </th>

                    <th class="pb-4 font-medium w-[10%]">
                        Link
                    </th>

                    <th class="pb-4 font-medium text-center w-[15%]">
                        Action
                    </th>

                </tr>

            </thead>

            <!-- BODY -->
            <tbody>

            <?php if($products && $products->num_rows > 0): ?>

                <?php while($p = $products->fetch_assoc()): ?>

                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">

                    <!-- IMAGE -->
                    <td class="py-5">

                        <img
                            src="<?= $p['image_url'] ?>"
                            onerror="this.src='https://via.placeholder.com/80'"
                            class="w-16 h-16 rounded-2xl object-cover border border-gray-200"
                        >

                    </td>

                    <!-- NAME -->
                    <td class="text-[15px] font-medium text-gray-800">
                        <?= htmlspecialchars($p['name']) ?>
                    </td>

                    <!-- BRAND -->
                    <td class="text-[14px] text-gray-600">
                        <?= htmlspecialchars($p['brand']) ?>
                    </td>

                    <!-- DESCRIPTION -->
                    <td class="text-[13px] text-gray-500 leading-6 truncate">
                        <?= htmlspecialchars($p['description']) ?>
                    </td>

                    <!-- LINK -->
                    <td>

                        <a
                            href="<?= $p['image_url'] ?>"
                            target="_blank"
                            class="text-blue-500 hover:underline text-sm"
                        >
                            Open
                        </a>

                    </td>

                    <!-- ACTION -->
                    <td>

                        <div class="flex items-center justify-center gap-3">

                            <!-- EDIT -->
                            <button
                                onclick='editProduct(<?= json_encode($p) ?>)'
                                class="w-9 h-9 rounded-full bg-gray-100 hover:bg-blue-100 flex items-center justify-center text-gray-600"
                            >
                                <i class="fa fa-pen text-xs"></i>
                            </button>

                            <!-- DELETE -->
                            <a
                                href="index.php?action=deleteProduct&id=<?= $p['id'] ?>"
                                onclick="return confirm('Delete this product?')"
                                class="w-9 h-9 rounded-full bg-gray-100 hover:bg-red-100 flex items-center justify-center text-red-500"
                            >
                                <i class="fa fa-trash text-xs"></i>
                            </a>

                        </div>

                    </td>

                </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>

                    <td colspan="6" class="py-10 text-center text-gray-400">
                        No products found
                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>

        <!-- PAGINATION -->
        <div class="flex justify-center items-center gap-3 mt-6">

            <!-- PREV -->
            <?php if($page > 1): ?>

            <a
                href="index.php?page=products&p=<?= $page-1 ?>&search=<?= $_GET['search'] ?? '' ?>"
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
                href="index.php?page=products&p=<?= $i ?>&search=<?= $_GET['search'] ?? '' ?>"
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
                href="index.php?page=products&p=<?= $page+1 ?>&search=<?= $_GET['search'] ?? '' ?>"
                class="w-10 h-10 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-gray-100"
            >
                →
            </a>

            <?php endif; ?>

        </div>

    </div>

</div>

<!-- MODAL -->
<?php include __DIR__ . '/components/product_modal.php'; ?>