<?php
if (!defined('BASEPATH')) {
    exit('Unable to view file.');
}

	// Load Sidebar
	require(BASE_PATH.'/template/admin/common/sidebar.php');

// ✅ نجيب آخر رانك شغال
$session = $db->QueryFetchArray("
    SELECT * FROM rank_sessions 
    WHERE status = '1' 
    ORDER BY id DESC 
    LIMIT 1
");

if(!$session) {
    echo '<div class="alert alert-warning text-center" style="
    margin-top: 200px;
">⚠️ مفيش رانك شغال دلوقتي</div>';
} else {
    // ✅ نجيب بيانات الـ Leaderboard
    $leaderboard = $db->QueryFetchArrayAll("
    SELECT 
        w.payment_info,
        SUM(w.amount) AS total_amount,
        COUNT(w.id) AS total_withdrawals
    FROM withdrawals w
    WHERE w.time >= '".$session['start_time']."' 
      AND (w.time <= '".$session['end_time']."' OR '".$session['end_time']."' = 0)
    GROUP BY w.payment_info
    ORDER BY total_amount DESC, total_withdrawals DESC
    LIMIT 20
");

// نجيب الجوايز
$prizes = $db->QueryFetchArrayAll("SELECT rank_position, prize FROM rank_prizes WHERE status = 1");
$prizeList = [];
foreach($prizes as $p){
    $prizeList[$p['rank_position']] = $p['prize'];
}


}
?>

<div class="content-wrapper">
    <h2 class="text-center mt-3">🏆 Leaderboard</h2>
    <?php if(!empty($leaderboard)): ?>
        <table class="table table-bordered table-striped text-center" style="width:80%;margin:20px auto;">
    <thead>
        <tr>
            <th>الترتيب</th>
            <th>عنوان الدفع</th>
            <th>إجمالي المبلغ</th>
            <th>عدد السحوبات</th>
            <th>الجائزة</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $rank = 1;
        foreach($leaderboard as $row){
            $prize = isset($prizeList[$rank]) ? $prizeList[$rank] : "-";
            echo "<tr>
                <td>{$rank}</td>
                <td>{$row['payment_info']}</td>
                <td>{$row['total_amount']}</td>
                <td>{$row['total_withdrawals']}</td>
                <td>{$prize}</td>
            </tr>";
            $rank++;
        }
        ?>
    </tbody>
</table>

    <?php elseif(isset($session)): ?>
        <div class="alert alert-info text-center">لا يوجد بيانات لهذا الرانك</div>
    <?php endif; ?>
</div>
