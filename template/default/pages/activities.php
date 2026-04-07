<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }

	// Load Sidebar
	require(BASE_PATH.'/template/'.$config['theme'].'/common/sidebar.php');
?>
<main id="main" class="main">
<div class="pagetitle">
  <h1>Recent Activity</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="/">Home</a></li>
	  <li class="breadcrumb-item active">Recent Activity</li>
	</ol>
  </nav>
</div>
<section class="section">
  <div class="row">
	<div class="col-lg-12">
	  <div class="card">
		<div class="card-body p-2">
		  <div class="table-responsive">
			<table class="table table-sm table-condensed table-striped table-hover mb-0">
			  <tbody>
				<?php
					$activities = $db->QueryFetchArrayAll("SELECT * FROM `users_activities` WHERE `user_id`='".$data['id']."' ORDER BY `time` DESC LIMIT 50");
					if(empty($activities)) {
						echo '<div class="alert alert-light" role="alert">You don\'t have any notifications yet!</div>';
					} else {
						foreach($activities as $activity) {
							echo get_activity($activity['notify_id'], $activity['value'], $activity['time'], $activity['read']);
						}
					}
					
					$db->Query("UPDATE `users_activities` SET `read`='1' WHERE `user_id`='".$data['id']."' AND `read`='0'");
				?>
			  </tbody>
			</table>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</section>
</main>