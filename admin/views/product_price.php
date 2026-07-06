<div class="ml-64 bg-[#f7f7f7] min-h-screen p-6">

    <!-- TOP BAR -->
<div class="flex justify-between items-center mb-6">

    <!-- SEARCH -->
    <form method="GET" class="relative">

        <input
            type="hidden"
            name="page"
            value="productPrice"
        >

        <input
            type="text"
            name="search"
            value="<?= $_GET['search'] ?? '' ?>"
            placeholder="Search anything"
            class="w-[230px] h-[42px] bg-white border border-gray-200 rounded-2xl pl-10 pr-4 text-sm outline-none"
        >

        <i class="fa fa-search absolute left-4 top-3 text-gray-400 text-sm"></i>

    </form>

    <!-- ADD -->
    <button
        onclick="openPriceModal()"
        class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-xl text-sm hover:opacity-90"
    >
        + Add Price
    </button>

</div>

    <!-- CARD -->
    <div class="bg-white border border-gray-200 rounded-2xl p-6">

        <!-- CARD TITLE -->
        <div class="flex items-center gap-2 mb-6">

            <div class="w-2 h-2 rounded-full bg-blue-500"></div>

            <h2 class="text-[22px] font-semibold text-gray-800">
                Product Price List
            </h2>

        </div>

        <!-- TABLE -->
        <table class="w-full table-fixed">

            <thead>

                <tr class="text-left text-[14px] text-gray-500 border-b border-gray-100">

                    <th class="pb-4 font-medium w-[10%]">
                        ID
                    </th>

                    <th class="pb-4 font-medium w-[35%]">
                        Product
                    </th>

                    <th class="pb-4 font-medium w-[25%]">
                        Store
                    </th>

                    <th class="pb-4 font-medium w-[15%]">
                        Price
                    </th>

                    <th class="pb-4 font-medium w-[20%]">
                        URL
                    </th>

                    <th class="pb-4 font-medium text-center w-[15%]">
                        Action
                    </th>

                </tr>

            </thead>

            <tbody>

            <?php while($row = mysqli_fetch_assoc($data)): ?>

            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">

                <!-- ID -->
                <td class="py-5 text-sm text-gray-500">
                    #<?= $row['id'] ?>
                </td>

                <!-- PRODUCT -->
                <td class="py-5 text-[15px] font-medium text-gray-800">
                    <?= $row['product_name'] ?>
                </td>

                <!-- STORE -->
                <td class="py-5">

                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-xl text-xs">
                        <?= $row['store_name'] ?>
                    </span>

                </td>

                <!-- PRICE -->
                <td class="py-5">

                    <span class="bg-green-100 text-green-600 px-3 py-1 rounded-xl text-xs font-semibold">
                        RM <?= number_format($row['price'], 2) ?>
                    </span>

                </td>

                <!-- URL -->
                <td class="py-5">

                    <a
                        href="<?= $row['url'] ?>"
                        target="_blank"
                        class="text-blue-500 hover:underline text-sm"
                    >
                        Open Link
                    </a>

                </td>

                <!-- ACTION -->
                <td>

                    <div class="flex justify-center gap-2">

                        <!-- EDIT -->
                        <button
                            type="button"
                            onclick="editPrice(this)"
                            data-id="<?= $row['id'] ?>"
                            data-product="<?= $row['product_id'] ?>"
                            data-store="<?= $row['store_name'] ?>"
                            data-price="<?= $row['price'] ?>"
                            data-url="<?= $row['url'] ?>"
                            class="w-9 h-9 rounded-full bg-gray-100 hover:bg-blue-100 flex items-center justify-center text-blue-500"
                        >
                            <i class="fa fa-pen text-xs"></i>
                        </button>

                        <!-- DELETE -->
                        <a
                            href="index.php?action=deletePrice&id=<?= $row['id'] ?>"
                            onclick="return confirm('Delete this price?')"
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
                href="index.php?page=productPrice&p=<?= $page-1 ?>&search=<?= $_GET['search'] ?? '' ?>"
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
                href="index.php?page=productPrice&p=<?= $i ?>&search=<?= $_GET['search'] ?? '' ?>"
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
                href="index.php?page=productPrice&p=<?= $page+1 ?>&search=<?= $_GET['search'] ?? '' ?>"
                class="w-10 h-10 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-gray-100"
            >
                →
            </a>

            <?php endif; ?>

        </div>
    </div>

</div>

<?php include __DIR__ . '/components/product_price_modal.php'; ?>