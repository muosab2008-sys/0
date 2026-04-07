<?php
	define('BASEPATH', true);
	require('../init.php');

	// Security Check
	$postback_password = $db->QueryFetchArray("SELECT config_value FROM `offerwall_config` WHERE `config_name`='timewall_secret'");
	$postback_password = $postback_password['config_value'];

	// Get parameters
	$transaction = $db->EscapeString($_REQUEST['transaction']);
	$userId = $db->EscapeString($_REQUEST['user_id']);
	$reward = $db->EscapeString($_REQUEST['reward']);
	$payout = $db->EscapeString($_REQUEST['revenue']);
	$reward = $db->EscapeString($_REQUEST['reward']);
	$userIP = $db->EscapeString($_REQUEST['ip']);
	$country = detectCountry($userIP);

	// Create validation signature
	$validation_signature = hash("sha256", $userId . $payout . $postback_password);
	if ($_REQUEST['hash'] != $validation_signature) {
		echo 'Invalid signature!';
		die();
	}
  
	// Load Website Data
	$user = $db->QueryFetchArray("SELECT `id`,`ref` FROM `users` WHERE `id`='".$userId."'");
	$offer = $db->QueryFetchArray("SELECT * FROM `completed_offers` WHERE `transaction_id`='".$transaction."' AND `method`='timewall' LIMIT 1");

	// Proccess Postback
	if(!empty($user['id']) && empty($offer['id']))
    {
		$name = 'Timewall';
		$status = ($config['hold_days'] == 0 ? 1 : 0);
		if($payout < 0.01)
		{
			$status = 1;
		}
		
		// Check Proxy / VPN
		$checkProxy = detectProxy($userIP);
		$status = ($checkProxy['status'] == 1 ? 4 : $status);
		
		$db->Query("INSERT INTO `completed_offers` (`user_id`,`transaction_id`,`campaign_name`,`user_country`,`user_ip`,`revenue`,`reward`,`method`,`status`,`timestamp`) VALUES ('".$user['id']."','".$transaction."','".$name."','".$country."','".$userIP."','".$payout."','".$reward."','timewall','".$status."','".time()."')");
		$offerID = $db->GetLastInsertId();
		
		if($status == 1)
		{
			$db->Query("UPDATE `users` SET `account_balance`=`account_balance`+'".$reward."' WHERE `id`='".$user['id']."'");
		
			$notify_value = serialize(array('id' => $offerID, 'reward' => $reward));
			add_activity($user['id'], 1, $notify_value);
			
			if(!empty($user['ref']))
			{
				$commission = ($config['ref_com']/100)*$reward;
				ref_commission($user['ref'], $user['id'], $commission);
			}
		}
		elseif($status != 4)
		{
			$notify_value = serialize(array('id' => $offerID, 'reward' => $reward));
			add_activity($user['id'], 2, $notify_value);
		}

        echo "OK";
    }
?>