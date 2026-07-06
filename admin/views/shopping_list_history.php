<div class="ml-64 bg-[#f7f7f7] min-h-screen p-6">

    <!-- TOP BAR -->
    <div class="flex justify-between items-center mb-6">

        <!-- SEARCH -->
        <form method="GET" class="relative">
            <input type="hidden" name="page" value="shoppingListHistory">
            <input
                type="text"
                name="search"
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                placeholder="Search user, product or store"
                class="w-[280px] h-[40px] bg-white border border-gray-200 rounded-xl pl-10 pr-4 text-sm outline-none"
            >
            <i class="fa fa-search absolute left-4 top-3 text-gray-400 text-sm"></i>
        </form>

        <!-- TOTAL -->
        <div class="text-sm text-gray-500">
            Total records: <span class="font-semibold text-gray-800"><?= $total ?></span>
        </div>

    </div>

    <!-- CARD -->
    <div class="bg-white border border-gray-200 rounded-2xl p-5">

        <!-- TITLE -->
        <div class="flex items-center gap-2 mb-6">
            <div class="w-2 h-2 rounded-full bg-blue-500"></div>
            <h2 class="text-[22px] font-semibold text-gray-800">Shopping List History</h2>
        </div>

        <!-- TABLE -->
        <table class="w-full table-fixed">

            <thead>
                <tr class="text-left text-[14px] text-gray-500 border-b border-gray-100">
                    <th class="pb-4 font-medium w-[16%]">User</th>
                    <th class="pb-4 font-medium w-[22%]">Product</th>
                    <th class="pb-4 font-medium w-[14%]">Store</th>
                    <th class="pb-4 font-medium w-[10%]">Price (RM)</th>
                    <th class="pb-4 font-medium w-[10%]">Session</th>
                    <th class="pb-4 font-medium w-[14%]">Date</th>
                    <th class="pb-4 font-medium text-center w-[14%]">Action</th>
                </tr>
            </thead>

            <tbody>

            <?php if(mysqli_num_rows($data) === 0): ?>
                <tr>
                    <td colspan="7" class="py-12 text-center text-gray-400 text-sm">
                        No shopping list records found.
                    </td>
                </tr>
            <?php endif; ?>

            <?php while($row = mysqli_fetch_assoc($data)): ?>

                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">

                    <!-- USER -->
                    <td class="py-4">
                        <div class="text-[15px] font-medium text-gray-800">
                            <?= htmlspecialchars($row['user_name']) ?>
                        </div>
                        <div class="text-[12px] text-gray-400 truncate">
                            <?= htmlspecialchars($row['email']) ?>
                        </div>
                    </td>

                    <!-- PRODUCT -->
                    <td class="text-[14px] text-gray-700 pr-2">
                        <span class="truncate"><?= htmlspecialchars($row['product_name'] ?? '—') ?></span>
                    </td>

                    <!-- STORE -->
                    <td class="text-[14px] text-gray-600">
                        <?= htmlspecialchars($row['store_name'] ?? '—') ?>
                    </td>

                    <!-- PRICE -->
                    <td class="text-[14px] text-gray-700 font-medium">
                        <?= number_format($row['price'], 2) ?>
                    </td>

                    <!-- SESSION ID -->
                    <td class="text-[13px] text-gray-400">
                        #<?= $row['session_id'] ?>
                    </td>

                    <!-- DATE -->
                    <td class="text-[13px] text-gray-500">
                        <?= date('d M Y', strtotime($row['created_at'])) ?>
                        <div class="text-[11px] text-gray-400">
                            <?= date('h:i A', strtotime($row['created_at'])) ?>
                        </div>
                    </td>

                    <!-- ACTION -->
                    <td>
                        <div class="flex justify-center items-center gap-2">

                            <!-- DELETE SINGLE ITEM -->
                            <a
                                href="index.php?action=deleteShoppingHistory&id=<?= $row['id'] ?>&p=<?= $page ?>&search=<?= urlencode($_GET['search'] ?? '') ?>"
                                onclick="return confirm('Delete this item from the shopping list?')"
                                class="w-9 h-9 rounded-full bg-gray-100 hover:bg-red-100 flex items-center justify-center"
                                title="Delete this item"
                            >
                                <i class="fa fa-trash text-red-500 text-xs"></i>
                            </a>

                            <!-- DELETE ALL FOR THIS USER -->
                            <a
                                href="index.php?action=deleteShoppingHistoryByUser&user_id=<?= $row['user_id'] ?>"
                                onclick="return confirm('Delete ALL shopping history for <?= htmlspecialchars(addslashes($row['user_name'])) ?>?')"
                                class="w-9 h-9 rounded-full bg-gray-100 hover:bg-red-100 flex items-center justify-center"
                                title="Delete all for this user"
                            >
                                <i class="fa fa-user-slash text-red-400 text-xs"></i>
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
                href="index.php?page=shoppingListHistory&p=<?= $page - 1 ?>&search=<?= urlencode($_GET['search'] ?? '') ?>"
                class="w-10 h-10 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-gray-100"
            >←</a>
            <?php endif; ?>

            <?php
            $start = max(1, $page - 2);
            $end   = min($totalPages, $page + 2);
            for($i = $start; $i <= $end; $i++):
            ?>
            <a
                href="index.php?page=shoppingListHistory&p=<?= $i ?>&search=<?= urlencode($_GET['search'] ?? '') ?>"
                class="w-10 h-10 rounded-xl flex items-center justify-center text-sm
                <?= ($i == $page) ? 'bg-gray-200 text-black font-semibold' : 'text-gray-500 hover:bg-gray-100' ?>"
            ><?= $i ?></a>
            <?php endfor; ?>

            <?php if($page < $totalPages): ?>
            <a
                href="index.php?page=shoppingListHistory&p=<?= $page + 1 ?>&search=<?= urlencode($_GET['search'] ?? '') ?>"
                class="w-10 h-10 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-gray-100"
            >→</a>
            <?php endif; ?>

        </div>

    </div>

</div>