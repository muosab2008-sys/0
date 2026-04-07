<?php
define('BASEPATH', true);
require(realpath(dirname(__FILE__)).'/../init.php');

/* Define functions */
function write_cron($timestamp, $cron_name, $var_name){
	$filename = realpath(dirname(__FILE__)).'/times/'.$cron_name.'.php';
	$content = file_put_contents($filename, '<? $'.$var_name.'[\'time\'] = \''.$timestamp.'\'; ?>');

	$return = true;
	if(!$content){
		die('<center><b>System ERROR</b><br /><i>system/cron/times/'.$cron_name.'.php</i> must be writable (change permissions to 777)</center>');
		$return = false;
	}
	return $return;
}

/* Times */
$timestamp = time();
$daily_time = strtotime(date('j F Y'));

/* ---------------Starting Crons------------------ */
$realPath = realpath(dirname(__FILE__));
if(!is_writable($realPath.'/times')){
	die('<center><b>System ERROR</b><br /><i>system/cron/times/</i> directory must be writable (change permissions to 777)</center>');
}

// Check pending offers
$holdTime = (time() - ($config['hold_days']*86400));
$offers = $db->QueryFetchArrayAll("SELECT * FROM `completed_offers` WHERE `status`='0' AND `timestamp`<'".$holdTime."'");

foreach($offers as $offer)
{
	$db->Query("UPDATE `users` SET `account_balance`=`account_balance`+'".$offer['reward']."' WHERE `id`='".$offer['user_id']."'");
	$notify_value = serialize(array('id' => $offer['id'], 'reward' => $offer['reward']));
	add_activity($offer['user_id'], 1, $notify_value);
	
	$referral = $db->QueryFetchArray("SELECT `ref` FROM `users` WHERE `id`='".$offer['user_id']."' AND `ref`>'0' LIMIT 1");
	if(!empty($referral['ref']))
	{
		$commission = ($config['ref_com']/100)*$offer['reward'];
		ref_commission($referral['ref'], $offer['user_id'], $commission);
	}
}

$db->Query("UPDATE `completed_offers` SET `status`='1' WHERE `status`='0' AND `timestamp`<'".$holdTime."'");
$db->Query("DELETE FROM `shortlinks_session` WHERE `time`<'".(time()-300)."'");
$db->Query("UPDATE `shortlinks_done` SET `count`='0' WHERE `time`<'".(time()-86400)."'");

/* Cron 5 minutes */
if(file_exists($realPath.'/times/5min_cron.php')){
	include($realPath.'/times/5min_cron.php');
}

if($cron_5min['time'] < ($timestamp-300)){
	$write = write_cron($timestamp, '5min_cron', 'cron_5min');
	if($write){
		$db->Query("DELETE FROM `wrong_logins` WHERE `time`<'".(time()-$config['login_wait_time'])."'");
	}
}

/* Daily Cron */
if(file_exists($realPath.'/times/daily_cron.php')){
	include($realPath.'/times/daily_cron.php');
}

if($cron_day['time'] < $daily_time){
	$write = write_cron($daily_time, 'daily_cron', 'cron_day');
	if($write && $cron_day['time'] > 0){
		$db->Query("UPDATE `shortlinks_config` SET `today_views`='0' WHERE `today_views`>'0'");
		$db->Query("UPDATE `users` SET `sl_today`='0'");
		
		// Update Shortlinks
		if($config['shortlink_reset'] != 1)
		{
			$db->Query("UPDATE `shortlinks_done` SET `count`='0'");
		}

		// Delete Inactive Users
		if($config['cron_users'] > 0) {
			$del_time = (time() - (86400*$config['cron_users']));
			$db->Query("DELETE FROM `users` WHERE `last_activity`< '".$del_time."'");
		}
	}
}
?>