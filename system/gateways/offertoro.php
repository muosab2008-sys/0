<?php
	define('BASEPATH', true);
	require('../init.php');

	// Validate Source
	$allowed_ip = array('54.175.173.245');
	if(!in_array(VisitorIP(), $allowed_ip))
	{
		echo "ERROR: Invalid source";
		die();
	}
	
	// Security Check
	$postback_password = $db->QueryFetchArray("SELECT config_value FROM `offerwall_config` WHERE `config_name`='offertoro_secret'");
	$postback_password = $postback_password['config_value'];

	// Get parameters
	$transaction = $db->EscapeString($_REQUEST['id']);
	$offer_id = $db->EscapeString($_REQUEST['oid']);
	$name = $db->EscapeString($_REQUEST['o_name']);
	$reward = $db->EscapeString($_REQUEST['amount']);
	$userId = $db->EscapeString($_REQUEST['user_id']);
	$ip_address = $db->EscapeString($_REQUEST['ip_address']);
	$payout = $db->EscapeString($_REQUEST['payout']);
	$country = detectCountry($ip_address);

	// Create validation signature
	$validation_signature = md5($offer_id . '-' . $userId . '-' . $postback_password);
	if ($_REQUEST['sig'] != $validation_signature) {
		echo "ERROR: Invalid signature";
		die();
	}

	// Load Website Data
	$user = $db->QueryFetchArray("SELECT `id`,`ref` FROM `users` WHERE `id` = '".$userId."'");
	$offer = $db->QueryFetchArray("SELECT * FROM `completed_offers` WHERE `transaction_id`='".$transaction."' AND `method`='offertoro' LIMIT 1");

	// Proccess Postback
	if($payout < 0 && !empty($user['id']) && !empty($offer['id']))
	{
		if($offer['status'] == 1)
		{
			$db->Query("UPDATE `completed_offers` SET `status`='3' WHERE `id`='".$offer['id']."'");
			$db->Query("UPDATE `users` SET `account_balance`=`account_balance`-'".$offer['reward']."' WHERE `id`='".$offer['user_id']."'");
		
			$notify_value = serialize(array('id' => $offer['id'], 'reward' => $offer['reward']));
			add_activity($user['id'], 3, $notify_value);
		}
		elseif($offer['status'] == 0)
		{
			$db->Query("UPDATE `completed_offers` SET `status`='2' WHERE `id`='".$offer['id']."'");
		}
	}
    elseif(!empty($user['id']) && empty($offer['id']))
    {
		$status = ($config['hold_days'] == 0 ? 1 : 0);
		
		// Check Proxy / VPN
		$checkProxy = detectProxy($ip_address);
		$status = ($checkProxy['status'] == 1 ? 4 : $status);

		$db->Query("INSERT INTO `completed_offers` (`user_id`,`transaction_id`,`campaign_id`,`campaign_name`,`user_country`,`user_ip`,`revenue`,`reward`,`method`,`status`,`timestamp`) VALUES ('".$user['id']."','".$transaction."','".$offer_id."','".$name."','".$country."','".$ip_address."','".$payout."','".$reward."','offertoro','".$status."','".time()."')");
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
    }

	echo 1;
	die();
?>