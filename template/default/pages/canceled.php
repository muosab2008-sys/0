<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }

	// Load Sidebar
	require(BASE_PATH.'/template/'.$config['theme'].'/common/sidebar.php');
	
	$page = (isset($_GET['x']) ? $_GET['x'] : 0);
	$limit = 25;
	$start = (is_numeric($page) && $page > 0 ? ($page-1)*$limit : 0);
	
	$total_pages = $db->QueryGetNumRows("SELECT `id` FROM `completed_offers` WHERE `user_id`='".$data['id']."' AND `status`='3'");
	include(BASE_PATH.'/system/libs/paginator.php');

	$urlPattern = GenerateURL('canceled&x=(:num)');
	$paginator = new Paginator($total_pages, $limit, $page, $urlPattern);
	$paginator->setMaxPagesToShow(5);
?> 
<style>.footer {position: fixed;
    bottom: 0px;
    left: 0px;
    right: 0px;}
	</style>
<main id="main" class="main">
<div class="pagetitle margin-top">
  <h1>Canceled Transactions (<?php echo number_format($total_pages); ?>)</h1>
</div>
<section class="section">
  <div class="row">
	<div class="col-lg-12">
	  <div class="table-responsive card">
		<table class="table table-striped table-hover table-sm table-responsive-sm m-0">
			<thead>
			  <tr>
				<th scope="col">#</th>
				<th scope="col">Offer Name</th>
				<th scope="col" class="text-center">Offer Provider</th>
				<th scope="col" class="text-center">Reward</th>
				<th scope="col" class="text-center">Status</th>
				<th scope="col" class="text-center">Time</th>
			  </tr>
			</thead>
			<tbody>
				<?php
					$offers = $db->QueryFetchArrayAll("SELECT * FROM `completed_offers` WHERE `user_id`='".$data['id']."' AND `status`='3' ORDER BY `id` DESC LIMIT ".$start.",".$limit);

					if(empty($offers))
					{
						echo '<tr><td colspan="6" class="text-center">There is nothing here yet!</td></tr>';
					}

					foreach($offers as $offer)
					{
						echo '<tr>
							<th scope="row">'.$offer['id'].'</th>
							<td>'.(empty($offer['campaign_name']) ? 'Unknown' : $offer['campaign_name']).'</td>
							<td class="text-center"><span class="badge bg-light text-dark">'.ucfirst($offer['method']).'</span></td>
							<td class="text-center"><b class="text-danger">-'.$offer['reward'].' coins</b></td>
							<td class="text-center"><span class="badge bg-danger">Chargeback</span></td>
							<td class="text-center">'.date('d M Y H:i', $offer['timestamp']).'</td>
						  </tr>';
					}
				?>
			  
			</tbody>
		</table>
		<?php if($total_pages > $limit){ ?>
			<nav class="m-3">
				<ul class="pagination justify-content-center mb-0">
				<?php 
					if ($paginator->getPrevUrl()) {
						echo '<li class="page-item"><a class="page-link" href="'.$paginator->getPrevUrl().'">&laquo; Previous</a></li>';
					} else {
						echo '<li class="page-item disabled"><a class="page-link" href="#">&laquo; Previous</a><li>';
					}

					foreach ($paginator->getPages() as $page) {
						if ($page['url']) {
							echo '<li class="page-item'.($page['isCurrent'] ? ' active' : '').'"><a class="page-link" href="'. $page['url'].'">'.$page['num'].'</a></li>';
						} else {
							echo '<li class="page-item disabled"><a class="page-link" href="#">'.$page['num'].'</a></li>';
						}
					}

					if ($paginator->getNextUrl()) {
						echo '<li class="page-item"><a class="page-link" href="'.$paginator->getNextUrl().'">Next &raquo;</a></li>';
					}
				?>
				</ul>
			</nav>
		<?php } ?>
	  </div>
	</div>
  </div>
</section>
</main>