<div class="ml-64 bg-[#f7f7f7] min-h-screen p-6">

    <!-- TOP BAR -->
    <div class="flex justify-between items-center mb-6">

        <!-- SEARCH -->
        <form method="GET" class="relative">

            <input type="hidden" name="page" value="userManagement">

            <input
                type="text"
                name="search"
                value="<?= $_GET['search'] ?? '' ?>"
                placeholder="Search anything"
                class="w-[210px] h-[40px] bg-white border border-gray-200 rounded-xl pl-10 pr-16 text-sm outline-none"
            >

            <i class="fa fa-search absolute left-4 top-3 text-gray-400 text-sm"></i>

        </form>

        <!-- ADD USER -->
        <button
            onclick="openUserModal()"
            class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-xl text-sm hover:opacity-90"
        >
            + Add User
        </button>

    </div>

    <!-- CARD -->
    <div class="bg-white border border-gray-200 rounded-2xl p-5">

        <!-- TITLE -->
        <div class="flex items-center gap-2 mb-6">

            <div class="w-2 h-2 rounded-full bg-blue-500"></div>

            <h2 class="text-[22px] font-semibold text-gray-800">
                User Management
            </h2>

        </div>

        <!-- TABLE -->
        <table class="w-full table-fixed">

            <thead>

                <tr class="text-left text-[14px] text-gray-500 border-b border-gray-100">

                    <th class="pb-4 font-medium">
                        User name
                    </th>

                    <th class="pb-4 font-medium">
                        Email
                    </th>

                    <th class="pb-4 font-medium">
                        Created
                    </th>

                    <th class="pb-4 font-medium text-center">
                        Action
                    </th>

                </tr>

            </thead>

            <tbody>

            <?php while($row = mysqli_fetch_assoc($data)): ?>

                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">

                    <!-- USER -->
                    <td class="py-5">

                        <div class="text-[16px] font-medium text-gray-900">
                            <?= $row['name'] ?>
                        </div>

                    </td>

                    <!-- EMAIL -->
                    <td class="text-[14px] text-gray-500">
                        <?= $row['email'] ?>
                    </td>

                    <!-- CREATED -->
                    <td class="text-[14px] text-gray-700">
                        <?= date('d M Y', strtotime($row['created_at'])) ?>
                    </td>

                    <!-- ACTION -->
                    <td>

                        <div class="flex justify-center items-center gap-3">

                            <!-- EDIT -->
                            <button
                                type="button"
                                onclick="editUser(this)"
                                data-id="<?= $row['id'] ?>"
                                data-name="<?= htmlspecialchars($row['name']) ?>"
                                data-email="<?= htmlspecialchars($row['email']) ?>"
                                class="w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center"
                            >
                                <i class="fa fa-pen text-gray-600 text-xs"></i>
                            </button>

                            <!-- DELETE -->
                            <a
                                href="index.php?action=deleteUser&id=<?= $row['id'] ?>"
                                onclick="return confirm('Delete user?')"
                                class="w-9 h-9 rounded-full bg-gray-100 hover:bg-red-100 flex items-center justify-center"
                            >
                                <i class="fa fa-trash text-red-500 text-xs"></i>
                            </a>

                        </div>

                    </td>

                </tr>

            <?php endwhile; ?>

            </tbody>

        </table>

        <!-- PAGINATION -->
        <div class="flex justify-center items-center mt-6 gap-2">

            <!-- PREV -->
            <?php if($page > 1): ?>

            <a
                href="index.php?page=userManagement&p=<?= $page-1 ?>&search=<?= $_GET['search'] ?? '' ?>"
                class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-sm hover:bg-gray-100"
            >
                ←
            </a>

            <?php endif; ?>

            <!-- PAGE NUMBER -->
            <?php

            $start = max(1, $page - 1);
            $end = min($totalPages, $page + 1);

            for($i = $start; $i <= $end; $i++):

            ?>

            <a
                href="index.php?page=userManagement&p=<?= $i ?>&search=<?= $_GET['search'] ?? '' ?>"
                class="w-8 h-8 rounded-lg flex items-center justify-center text-sm transition

                <?= $page==$i
                    ? 'bg-gray-200 text-black font-medium'
                    : 'text-gray-500 hover:bg-gray-100'
                ?>"
            >
                <?= $i ?>
            </a>

            <?php endfor; ?>

            <!-- NEXT -->
            <?php if($page < $totalPages): ?>

            <a
                href="index.php?page=userManagement&p=<?= $page+1 ?>&search=<?= $_GET['search'] ?? '' ?>"
                class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-sm hover:bg-gray-100"
            >
                →
            </a>

            <?php endif; ?>

        </div>

    </div>

    <!-- MODAL -->
    <?php include __DIR__ . '/components/user_modal.php'; ?>

</div>