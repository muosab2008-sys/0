<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }
	
	// Load Sidebar
	require(BASE_PATH.'/template/'.$config['theme'].'/common/sidebar.php');

	$refs = $db->QueryFetchArray("SELECT COUNT(*) AS `total` FROM `users` WHERE `ref`='".$data['id']."'");
	
	$bpp = 25;
	$page = (isset($_GET['x']) ? intval($_GET['x']) : 0);
	$begin = ($page >= 0 ? ($page*$bpp) : 0);
	$users = $db->QueryFetchArrayAll("SELECT a.id,a.username,a.reg_time,b.commission FROM users a LEFT JOIN ref_commissions b ON b.referral = a.id WHERE a.ref = '".$data['id']."' ORDER BY a.reg_time DESC LIMIT ".$begin.",".$bpp);
?>
<main id="main" class="main">
<div class="pagetitle">
  <h1>Referrals</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="/">Home</a></li>
	  <li class="breadcrumb-item">Referrals</li>
	</ol>
  </nav>
</div>
<section class="section">
  <div class="row">
	<div class="col-lg-12">
	  <div class="table-responsive card">
		<table class="table table-striped table-sm table-responsive-sm text-center m-0">
			<thead>
				<tr>
					<th scope="col">Referral ID</th>
					<th scope="col">Registered</th>
					<th scope="col">Commission</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Referral ID</th>
					<th>Registered</th>
					<th>Commission</th>
				</tr>
			</tfoot>
			<tbody class="table-primary text-dark">
			<?php
				if(empty($users)){
					echo '<tr><td colspan="3" class="text-center">There is nothing here yet!</td></tr>';
				}

				foreach($users as $user)
				{
			?>	
				<tr>
					<td>#<?=$user['id']?></td>
					<td><?=date('d M Y - H:i', $user['reg_time'])?></td>
					<td class="text-success"><b><?php echo number_format($user['commission'], 2); ?> coins</b></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<?php
			if(ceil($refs['total']/$bpp) > 1) {
				if($page == 0) {
					$left = '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)">Previous</a></li>';
				}else{
					$left = '<li class="page-item"><a class="page-link" href="'.GenerateURL('referrals&x='.($page-1)).'">Previous</a></li>';
				}
				
				$total_pages = (number_format(($refs['total']/$bpp), 0)-1);
				$middle = '<li class="page-item active"><a class="page-link" href="javascript:void(0)">'.($page+1).' - '.($total_pages+1).'</a></li>';

				if($page >= $total_pages) {
					$right = '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)">Next</a></li>';
				}else{
					$right = '<li class="page-item"><a class="page-link" href="'.GenerateURL('referrals&x='.($page+1)).'">Next</a></li>';
				}
				
				echo '<nav aria-label="navigation"><ul class="pagination justify-content-center">'.$left.$middle.$right.'</ul></nav>';
			}
		?>
	  </div>
	</div>
  </div>
</section>
</main>