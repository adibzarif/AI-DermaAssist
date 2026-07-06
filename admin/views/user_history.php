<div class="ml-64 bg-[#f7f7f7] min-h-screen p-6">

    <!-- TOP BAR -->
    <div class="flex justify-between items-center mb-6">

        <!-- SEARCH -->
        <form method="GET" class="relative">

            <input
                type="hidden"
                name="page"
                value="userHistory"
            >

            <input
                type="text"
                name="search"
                value="<?= $_GET['search'] ?? '' ?>"
                placeholder="Search anything"
                class="w-[210px] h-[40px] bg-white border border-gray-200 rounded-xl pl-10 pr-16 text-sm outline-none"
            >

            <!-- SEARCH ICON -->
            <i class="fa fa-search absolute left-4 top-3 text-gray-400 text-sm"></i>

        </form>

    </div>

    <!-- CARD -->
    <div class="bg-white border border-gray-200 rounded-2xl p-5">

        <!-- TITLE -->
        <div class="flex items-center gap-2 mb-6">

            <div class="w-2 h-2 rounded-full bg-blue-500"></div>

            <h2 class="text-[22px] font-semibold text-gray-800">
                User Analysis History
            </h2>

        </div>

        <!-- TABLE -->
        <table class="w-full table-fixed">

            <!-- HEADER -->
            <thead>

                <tr class="text-left text-[14px] text-gray-500 border-b border-gray-100">

                    <th class="pb-4 font-medium w-[16%]">
                        User
                    </th>

                    <th class="pb-4 font-medium w-[18%]">
                        Problem
                    </th>

                    <th class="pb-4 font-medium w-[10%]">
                        Skin Type
                    </th>

                    <th class="pb-4 font-medium w-[10%]">
                        Skin Tone
                    </th>

                    <th class="pb-4 font-medium w-[26%]">
                        Result
                    </th>

                    <th class="pb-4 font-medium w-[12%]">
                        Date
                    </th>

                    <th class="pb-4 font-medium text-center w-[8%]">
                        Action
                    </th>

                </tr>

            </thead>

            <!-- BODY -->
            <tbody>

            <?php while($row = $data->fetch_assoc()): ?>

            <?php

            $result = json_decode($row['result_json'], true);

            $problems = [];

            if(isset($result['problem_scores'])){

                foreach($result['problem_scores'] as $problem => $score){

                    if($score > 0.20){
                        $problems[] = $problem;
                    }
                }
            }

            ?>

            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">

                <!-- USER -->
                <td class="py-5 text-[15px] font-medium text-gray-800">
                    <?= $row['name'] ?>
                </td>

                <!-- PROBLEM -->
                <td class="text-[14px] text-gray-600">

                    <?= !empty($problems)
                        ? implode(', ', $problems)
                        : '-'
                    ?>

                </td>

                <!-- SKIN TYPE -->
                <td class="text-[14px] text-gray-600">
                    <?= $row['skintype'] ?>
                </td>

                <!-- SKIN TONE -->
                <td class="text-[14px] text-gray-600">
                    <?= $row['skintone'] ?>
                </td>

                <!-- RESULT -->
                <td class="text-[13px] leading-7 text-gray-700">

                    <?php

                    if(isset($result['problem_scores'])){

                        foreach($result['problem_scores'] as $key => $score){

                            echo "<div>";
                            echo $key . " : " . round($score * 100, 2) . "%";
                            echo "</div>";
                        }

                    }else{

                        echo "-";
                    }

                    ?>

                </td>

                <!-- DATE -->
                <td class="text-[14px] text-gray-600">
                    <?= date('d M Y', strtotime($row['created_at'])) ?>
                </td>

                <!-- ACTION -->
                <td>

                    <div class="flex justify-center">

                        <a
                            href="index.php?action=deleteHistory&id=<?= $row['id'] ?>"
                            onclick="return confirm('Delete this history?')"
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
        <div class="flex justify-center items-center gap-3 mt-6">

            <!-- PREV -->
            <?php if($page > 1): ?>

            <a
                href="index.php?page=userHistory&p=<?= $page-1 ?>&search=<?= $_GET['search'] ?? '' ?>"
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
                href="index.php?page=userHistory&p=<?= $i ?>&search=<?= $_GET['search'] ?? '' ?>"
                class="w-10 h-10 rounded-xl flex items-center justify-center text-sm

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
                href="index.php?page=userHistory&p=<?= $page+1 ?>&search=<?= $_GET['search'] ?? '' ?>"
                class="w-10 h-10 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-gray-100"
            >
                →
            </a>

            <?php endif; ?>

        </div>

    </div>

</div>