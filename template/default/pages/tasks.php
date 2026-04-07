<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }

	// Load Sidebar
	require(BASE_PATH.'/template/'.$config['theme'].'/common/sidebar.php');

	$errMessage = '';
	if(isset($_POST['submit']))
	{
		$job_id = $db->EscapeString($_POST['job_id']);
		$requirement = $db->EscapeString($_POST['requirement']);

		$job = $db->QueryFetchArray("SELECT * FROM `jobs` WHERE `id`='".$job_id."' LIMIT 1");
		if(empty($job['id']))
		{
			$errMessage = '<div class="alert alert-danger" role="alert"><b>ERROR:</b> This task doesn\'t exist.</div>';
		}
		elseif(empty($requirement))
		{
			$errMessage = '<div class="alert alert-danger" role="alert"><b>ERROR:</b> Please complete all fields!</div>';
		}
		elseif($job['url_required'] == 1 && !preg_match('/^(http|https):\/\/[a-z0-9_]+([\-\.]{1}[a-z_0-9]+)*\.[_a-z]{2,6}'.'((:[0-9]{1,6})?\/.*)?$/i', $requirement))
		{
			$errMessage = '<div class="alert alert-danger" role="alert"><b>ERROR:</b> Please enter a valid URL (including http://)</div>';
		}
		else
		{
			$check_job = $db->QueryFetchArray("SELECT * FROM `jobs_done` WHERE `uid`=".$data['id']." AND `job_id`='".$job_id."' ORDER BY `time` DESC LIMIT 1");
			if(empty($check_job['id']) || $check_job['status'] == 2)
			{
				$db->Query("INSERT INTO `jobs_done` (`job_id`, `uid`, `requirement`, `reward`,`time`) VALUES ('".$job_id."','".$data['id']."','".$requirement."','".$job['reward']."','".time()."')");
				$errMessage = '<div class="alert alert-success" role="alert"><b>SUCCESS:</b> task was submited and is pending approval.</div>';
			}
			elseif($check_job['status'] == 1)
			{
				$errMessage = '<div class="alert alert-danger" role="alert"><b>ERROR:</b> This task is pending review.</div>';
			}
			else
			{
				$errMessage = '<div class="alert alert-danger" role="alert"><b>ERROR:</b> You have already completed this task.</div>';
			}
		}
	}
?>
<main id="main" class="main">
<div class="pagetitle">
  <h1>Tasks</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="/">Home</a></li>
	  <li class="breadcrumb-item active">Tasks</li>
	</ol>
  </nav>
</div>
<section class="section">
  <div class="row">
	<div class="col-lg-12">
	  <?php
		echo $errMessage;
	  
		$jobs = $db->QueryFetchArrayAll("SELECT * FROM `jobs` ORDER BY `time` DESC");

		foreach($jobs as $job) {
			$job_status = $db->QueryFetchArray("SELECT * FROM `jobs_done` WHERE `job_id`='".$job['id']."' AND `uid`='".$data['id']."' LIMIT 1");
			$description = htmlspecialchars_decode($job['description']);
	  ?>
		<div class="card mb-2">
		  <div class="card-header">
			<h3 class="text-success text-center"><?php echo $job['title']; ?></h3>
			<p class="text-danger text-center mb-0">Task ID: <b>#<?php echo $job['id']; ?></b> - Reward: <b><?php echo $job['reward']; ?> coins</b></p>
		  </div>
		  <div class="card-body text-dark">
			<?php 
				echo $description;

				if(empty($job_status['id']) || $job_status['status'] == 2) {
			?>
				<form method="post">
				  <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
				  <div class="form-row">
					<div class="form-group col-md-12">
					  <div class="input-group mt-3 mb-0">
						<div class="input-group-text"><i class="bi bi-info-circle"></i></div>
						<input type="text" class="form-control" name="requirement" placeholder="<?php echo $job['requirement']; ?>">
						<input type="submit" class="btn btn-primary d-inline" name="submit" value="Send" />
					  </div>
					</div>
				  </div>
				</form>
			<?php
				} elseif($job_status['status'] == 0) {
					echo '<div class="alert alert-info text-center mb-0" role="alert">This task is pending review. Please wait!</div>';
				} else { 
					echo '<div class="alert alert-success text-center mb-0" role="alert">This task is completed and approved and you received <b>'.$job_status['reward'].' coins</b>.</div>';
				}
			?>
		  </div>
		</div>
	  <?php } ?>
	</div>
  </div>
</section>
</main>