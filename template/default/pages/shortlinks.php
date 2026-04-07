<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }

	// Load Sidebar
	require(BASE_PATH.'/template/'.$config['theme'].'/common/sidebar.php');

	$errMessage = '';
	if(isset($_GET['x']) && $_GET['x'] == 'success')
	{
		if(isset($_SESSION['shortlink_reward']))
		{
			$errMessage = '<div class="alert alert-success mt-0" role="alert">Congratulations! You received '.$_SESSION['shortlink_reward'].' Coins.</div>';
			unset($_SESSION['shortlink_reward']);
		}
	}
	elseif(isset($_GET['x']) && $_GET['x'] == 'time')
	{
		if(isset($_SESSION['shortlink_time']))
		{
			$errMessage = '<div class="alert alert-danger" role="alert"><b>WARNING!</b> Please don\'t try to bypass shortlinks otherwise, you won\'t be rewarded!</div>';
			unset($_SESSION['shortlink_time']);
		}
	}
	
	// Define Lang Var
	$reset1 = 'Solve these shortlinks and earn Coins for every shortlink passed. You must solve one shortlink at the time, you can\'t solve more than one shortlinks at once. You can visit each shortlink daily, your <b>views reset every day at 00:00</b>.';
	$reset2 = 'Solve these shortlinks and earn Coins for every shortlink passed. You must solve one shortlink at the time, you can\'t solve more than one shortlinks at once. <b>Each shortlink reset after 24 hours since your last visit</b>, if you complete a shortlink now, you\'ll be able to solve the same shortlink again after 24 hours.';
?>
<main id="main" class="main">
<div class="pagetitle">
  <h1>Shortlinks</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="/">Home</a></li>
	  <li class="breadcrumb-item active">Shortlinks</li>
	</ol>
  </nav>
</div>
<section class="section">
  <div class="alert alert-warning">
	<i class="fa fa-info-circle"></i> <?php echo ($config['shortlink_reset'] == 1 ? $reset2 : $reset1); ?><br /><br />
	<small><i class="fa fa-exclamation-triangle"></i> <i>We have no control over these shortlinks, if you see any error on any of those shortlinks, it\'s from the respective shortlink and we can\'t do nothing to fix it. If you don\'t know how to complete shortlinks, please follow this short tutorial: <a href="https://youtu.be/vWkAI55iMPw" target="_blank">https://youtu.be/vWkAI55iMPw</a></i></small>
  </div>
  <div class="row">
	<div class="col-lg-12">
	  <span id="status"><?php echo $errMessage; ?></span>
	  <div class="table-responsive card">
		<table class="table table-striped table-hover table-sm table-responsive-sm m-0">
			<thead>
			  <tr>
				<th scope="col"></th>
				<th scope="col" class="text-center">Reward</th>
				<th scope="col" class="text-center">Views Left</th>
				<th scope="col" class="text-center">Rating</th>
				<th scope="col"></th>
			  </tr>
			</thead>
			<tbody>
				<?php
					$remTime = (strtotime(date('j F Y'))+86460) - time();
					$shortlinks = $db->QueryFetchArrayAll("SELECT a.*, b.count, b.time, c.vote FROM shortlinks_config a LEFT JOIN shortlinks_done b ON b.short_id = a.id AND b.user_id = '".$data['id']."' LEFT JOIN shortlinks_votes c ON c.short_id = a.id AND c.user_id = '".$data['id']."' WHERE a.status = '1' ORDER BY a.rating DESC, a.reward DESC");

					if(empty($shortlinks))
					{
						echo '<tr><td colspan="5">There is nothing here yet!</td></tr>';
					}
					else
					{
						$counters = array();
						$totalBits = 0;
						$totalVisits = 0;
						if($proxy === true)
						{
							echo '<div class="alert alert-warning text-center mb-0" role="alert"><i class="bi bi-exclamation-triangle-fill"></i> <b>WARNING</b> <i class="bi bi-exclamation-triangle-fill"></i><br />You\'ve been detected using VPN / Proxy server, which is forbidden as per our <a href="'.GenerateURL('tos').'">Terms of Service</a>.<br />Please disable your VPN / Proxy service, otherwise your account will be permanently suspended and your earnings will be voided.</div>';
						}

						foreach($shortlinks as $shortlink) {
							$remain = ($shortlink['daily_limit']-$shortlink['count']);
							$remain = ($remain < 0 ? 0 : $remain);
							$totalBits = $totalBits + ($shortlink['reward']*$shortlink['daily_limit']);
							$totalVisits = $totalVisits + $shortlink['daily_limit'];
							
							if($config['shortlink_reset'] == 1)
							{
								$remTime = ($shortlink['time']+86400) - time();
								$remTime = ($remTime <= 0 ? ($remTime+60) : $remTime);
							}

							if($remain <= 0)
							{
								$counters[] = $shortlink['id'];
							}
							
							if($proxy === false)
							{
								echo '<tr>
									<td class="align-middle">'.$shortlink['name'].'</td>
									<td class="align-middle text-center"><b>'.$shortlink['reward'].' Coins</b></td>
									<td class="align-middle text-center"><b>'.$remain.'/'.$shortlink['daily_limit'].'</b></td>
									<td class="align-middle text-center">
										<div class="btn-group" id="vote_'.$shortlink['id'].'" role="group">
										  <button type="button" id="up_'.$shortlink['id'].'" class="btn btn-sm btn-success" onclick="voteSL(\''.$shortlink['id'].'\',\'up\')"'.($shortlink['vote'] == 1 ? ' disabled' : '').'><i class="bi bi-hand-thumbs-up-fill"></i></button>
										  <button type="button" id="down_'.$shortlink['id'].'" class="btn btn-sm btn-danger" onclick="voteSL(\''.$shortlink['id'].'\',\'down\')"'.($shortlink['vote'] == 2 ? ' disabled' : '').'><i class="bi bi-hand-thumbs-down-fill"></i></button>
										  <button type="button" id="stats_'.$shortlink['id'].'" class="btn btn-sm btn-light">'.$shortlink['rating'].'</button>
										</div>
									</td>
									<td class="align-middle text-right">'.($remain > 0 ? '<button onclick="goShortlink(\''.$shortlink['id'].'\');" class="btn btn-success btn-sm" type="submit">Visit <i class="bi bi-box-arrow-up-right"></i></button>' : '<span id="short_'.$shortlink['id'].'" class="badge bg-dark p-2" data-seconds-left="'.$remTime.'"></span><div class="badge bg-dark p-2" id="staticTime_'.$shortlink['id'].'">'.gmdate('H:i:s', $remTime).'</div>').'</td>
								</tr>';
							}
						}
					}
				  ?>
			</tbody>
			<tfoot>
				<tr><td colspan="5" class="text-center">Get up to <b><?php echo number_format($totalBits, 2); ?> Coins</b> by visiting <b><?php echo number_format($totalVisits); ?> Shortlinks</b></td></tr>
			</tfoot>
		</table>
	  </div>
	</div>
  </div>
</section>
</main>
<?php
	if($proxy === false) 
	{
		$load_scripts = array('assets/js/simple.timer.js');
		
		$footer_js = "var waitMsg = 'Please wait...';
		function goShortlink(sid){
			$('#status').html('<div class=\"alert alert-info\" role=\"alert\"><div class=\"spinner-border spinner-border-sm\"></div> '+waitMsg+'</div>').fadeIn('fast');

			$.post('system/ajax.php',
			{
				a: 'getShortlink',
				data: sid,
				token: '".$token."'
			},
			function(response) {
				if(response.status == '600') {
					$('#status').html(response.message).fadeIn('slow');
				} else if(response.status == '500') {
					$('#captchaBox').hide();
					$('#status').html(response.message).fadeIn('slow');
				} else {
					$('#status').html(response.message).fadeIn('slow');
					window.setTimeout(function(){window.location.replace(response.shortlink);}, 500);
				}
			},'json');
		}
		
		function voteSL(sid, vote) {
			$.post('system/ajax.php',
			{
				a: 'shortlinkVote',
				data: sid,
				vote: vote,
				token: '".$token."'
			},
			function(response) {
				if(response.status == '0') {
					$('#status').html(response.message).fadeIn('slow');
				} else {
					if(vote == 'up') {
						$('#up_' + sid).attr('disabled','disabled');
					}
					if(vote == 'down') {
						$('#down_' + sid).attr('disabled','disabled');
					}
					$('#stats_' + sid).html(response.count);
				}
			},'json');
		}";

		if(count($counters) > 0)
		{
			$footer_js .= '$(document).ready(function(){';
			foreach($counters as $counter)
			{
				$footer_js .= "$('#staticTime_".$counter."').hide(); $('#short_".$counter."').startTimer({onComplete: function(element){window.location.reload();}}); $('#short_".$counter." div').css('display','inline');";
			}
			$footer_js .= '});';
		}
	}
?>