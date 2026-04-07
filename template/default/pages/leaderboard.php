<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<?php
if (!defined('BASEPATH')) {
    exit('Unable to view file.');
}

// Load Sidebar
require(BASE_PATH . '/template/' . $config['theme'] . '/common/sidebar.php');

// Get last session
$session = $db->QueryFetchArray("
    SELECT * FROM rank_sessions 
    WHERE status = '1' 
    ORDER BY id DESC 
    LIMIT 1
");

if (!$session) {
    echo '<div class="alert alert-warning text-center" style="
    margin-top: 200px;
">No ranking now</div>';
} else {
    // Get leaderboard data
    $leaderboard = $db->QueryFetchArrayAll("
    SELECT 
        w.payment_info,
        SUM(w.amount) AS total_amount,
        COUNT(w.id) AS total_withdrawals
    FROM withdrawals w
    WHERE w.status = 1
      AND w.time >= '" . $session['start_time'] . "' 
      AND (w.time <= '" . $session['end_time'] . "' OR '" . $session['end_time'] . "' = 0)
    GROUP BY w.payment_info
    ORDER BY total_amount DESC, total_withdrawals DESC
    LIMIT 20
");

// Get prizes
$prizes = $db->QueryFetchArrayAll("SELECT rank_position, prize FROM rank_prizes WHERE status = 1");
$prizeList = [];
foreach ($prizes as $p) {
    $prizeList[$p['rank_position']] = $p['prize'];
}



}
?>
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-fluid flex-grow-1 container-p-y">
        <div wire:snapshot="{&quot;data&quot;:[],&quot;memo&quot;:{&quot;id&quot;:&quot;fvDzz4d298LN7NffQAcL&quot;,&quot;name&quot;:&quot;user.pages.leaderboard-page&quot;,&quot;path&quot;:&quot;leaderboard&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;en&quot;},&quot;checksum&quot;:&quot;c333db472c8b8efaaab6b1b8a3f87517b3d91c19689ba65cfab564301f5883da&quot;}"
            wire:effects="[]" wire:id="fvDzz4d298LN7NffQAcL">
            <div class="bg-b-csm" style="background-image: url('/assets/img/background-1.webp')"></div>
            <div class="row d-flex justify-content-center align-items-end gap-1 gap-md-3 leaderboard-container">
                <?php
                $topRanks = [3, 1, 2]; 
                $leaderboard_values = array_values($leaderboard); // إعادة ترقيم المصفوفة
                
                foreach ($topRanks as $rank) {
                    $index = $rank - 1; // لأن المصفوفة تبدأ من 0
                    if (!isset($leaderboard_values[$index]))
                        continue; // لو ما فيهش عنصر، نتخطاه
                
                    $user = $leaderboard_values[$index];
                    $prize = isset($prizeList[$rank]) ? $prizeList[$rank] : "-";
                    ?>
                    <div
                        class="col-auto leaderboard-card <?= $rank === 3 ? 'third-place' : ($rank === 2 ? 'sec-place' : 'first-place') ?>">
                        <div class="leaderboard-image position-relative">
                            <img src="<?= !empty($user['avatar']) ? $user['avatar'] : "/assets/img/leaderboard/{$rank}.png" ?>"
                                alt="<?= htmlspecialchars($user['payment_info']) ?>">
                            <?php if ($rank === 1): ?>
                                <img class="crown" src="/assets/img/crown.webp" alt="Crown">
                            <?php endif; ?>
                        </div>

                        <p class="mt-3 mb-0 f-md text-break">
                            <?= htmlspecialchars($user['payment_info']) ?>
                        </p>

                        <p class="text-primary mt-1 f-md">
                            <?= number_format($user['total_amount'], 2) ?>
                        </p>

                        <span class="badge bg-dark align-items-center justify-content-between px-2 d-none d-md-flex">
                            <span class="badge bg-label-warning"><?= $rank ?></span>
                            <span class="text-body">Prize</span>
                            <div class="d-flex align-items-center">
                                <img src="/assets/img/coin.png" alt="" width="13px" class="me-1">
                                <span style="font-size: 13px"><?= $prize ?></span>
                            </div>
                        </span>
                    </div>
                    <?php
                }
                ?>

            </div>

            <?php

$sessionEndTime = (int)$session['end_time']; 
?>
<div class="text-center" style="margin-top: 32px;">
    <span class="badge bg-dark m-auto text-center align-items-center d-flex gap-1" style="width: fit-content"
          x-data="timer(<?= $sessionEndTime ?>)"
          x-init="init()">
        <svg width="20px" class="text-primary me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd"></path>
        </svg> Ends in
        <span x-text="timeLeft">Loading...</span>
    </span>
</div>

<script>
function timer(endTime) {
    return {
        timeLeft: '',
        init() {
            const update = () => {
                const now = Math.floor(Date.now() / 1000);
                let diff = endTime - now;

                if(diff <= 0){
                    this.timeLeft = "Ended";
                    return;
                }

                const days = Math.floor(diff / 86400);
                const hours = Math.floor((diff % 86400) / 3600);
                const minutes = Math.floor((diff % 3600) / 60);
                const seconds = diff % 60;

                this.timeLeft = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            };
            update();
            setInterval(update, 1000);
        }
    }
}
</script>



            <div class="row justify-content-center mt-5">
                <div class="col">
                    <div class="table-responsive">
                        <?php
                        
                        $perPage = 10;

                        
                        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                        if ($page < 1)
                            $page = 1;

                        
                        $total = count($leaderboard);

                        
                        $start = ($page - 1) * $perPage;
                        $end = min($start + $perPage, $total);

                        
                        $currentPageData = array_slice($leaderboard, $start, $perPage, true);

                        
                        $totalPages = ceil($total / $perPage);
                        ?>
                        <?php if (!empty($leaderboard)): ?>
                            <table class="table align-middle mb-0 small" style="font-weight: 600">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>payment info</th>
                                        <th>total withdrawals</th>
                                        <th>total amount</th>
                                        <th>Prize</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rank = 1;
                                    foreach ($leaderboard as $row) {
                                        $prize = isset($prizeList[$rank]) ? $prizeList[$rank] : "-";

                                        
                                        if ($rank == 1) {
                                            $rankDisplay = "<img src='/assets/img/leaderboard/1.png' alt='First Place' style='width: 20px'>";
                                        } elseif ($rank == 2) {
                                            $rankDisplay = "<img src='/assets/img/leaderboard/2.png' alt='Second Place' style='width: 20px'>";
                                        } elseif ($rank == 3) {
                                            $rankDisplay = "<img src='/assets/img/leaderboard/3.png' alt='Third Place' style='width: 20px'>";
                                        } else {
                                            $rankDisplay = "<span class='badge bg-label-primary m-0 p-2'>{$rank}</span>";
                                        }

                                        echo "<tr>
            <td>{$rankDisplay}</td>
            <td>{$row['payment_info']}</td>
            <td>{$row['total_amount']}</td>
            <td>{$row['total_withdrawals']}</td>
            <td class = 'd-flex align-items-center f-md'><img src='/assets/img/coin.png' alt='' width='10' class='me-1' x-show='is_coin == '1''> {$prize}</td>
        </tr>";

                                        $rank++;
                                    }
                                    ?>
                                </tbody>

                            </table>
                            <div class="d-flex justify-content-center mt-4">
                                <div>
                                    <nav class="d-flex justify-items-center justify-content-between">
                                 <!--       <ul class="pagination">
                                            
                                            <li class="page-item <?php if ($page <= 1)
                                                echo 'disabled'; ?>">
                                                <a class="page-link" href="?page=<?php echo $page - 1; ?>">«</a>
                                            </li>

                                            
                                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                <li class="page-item <?php if ($i == $page)
                                                    echo 'active'; ?>">
                                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                                </li>
                                            <?php endfor; ?>

                                            
                                            <li class="page-item <?php if ($page >= $totalPages)
                                                echo 'disabled'; ?>">
                                                <a class="page-link" href="?page=<?php echo $page + 1; ?>">»</a>
                                            </li>
                                        </ul> -->
                                    </nav>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- / Content -->



        <div class="content-backdrop fade"></div> <?php elseif (isset($session)): ?>
        <div class="alert alert-info text-center">لا يوجد بيانات لهذا الرانك</div>
    <?php endif; ?>
</div>