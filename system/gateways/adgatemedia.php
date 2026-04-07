<?php
	define('BASEPATH', true);
	require('../init.php');

	// Hash Key
	$secret = $db->QueryFetchArray("SELECT config_value FROM `offerwall_config` WHERE `config_name`='adgate_hash'");
	$secret = $secret['config_value'];

	// Validate Postback IP
	if(VisitorIP() !== '52.42.57.125')
	{
		echo 'ERROR: Postback received from unauthorised IP Address.';
		exit;
	}

	// Validate Postback Hash Key
	if($_REQUEST['hash'] !== $secret)
	{
		echo 'ERROR: Wrong Postback Hash KEY.';
		exit;
	}

	// Get postback
	$userId = $db->EscapeString($_REQUEST['user_id']);
	$app_id = $db->EscapeString($_REQUEST['app_id']);
	$reward = $db->EscapeString($_REQUEST['amount']);
	$payout = $db->EscapeString($_REQUEST['payout']);
	$name = $db->EscapeString($_REQUEST['offer_title']);
	$offer_id = $db->EscapeString($_REQUEST['offer_id']);
	$transaction = $db->EscapeString($_REQUEST['conversion_id']);
	$status = $db->EscapeString($_REQUEST['status']);
	$ip = $db->EscapeString($_REQUEST['ip']);
	$country = detectCountry($ip);
	
	// Load Website Data
	$user = $db->QueryFetchArray("SELECT `id`,`ref` FROM `users` WHERE `id` = '".$userId."'");
	$offer = $db->QueryFetchArray("SELECT * FROM `completed_offers` WHERE `transaction_id`='".$transaction."' AND `method`='adgatemedia' LIMIT 1");

	// Proccess Postback
	if($status != 1 && !empty($user['id']) && !empty($offer['id']))
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
		$checkProxy = detectProxy($ip);
		$status = ($checkProxy['status'] == 1 ? 4 : $status);

		$db->Query("INSERT INTO `completed_offers` (`user_id`,`transaction_id`,`campaign_id`,`campaign_name`,`user_country`,`user_ip`,`revenue`,`reward`,`method`,`status`,`timestamp`) VALUES ('".$user['id']."','".$transaction."','".$offer_id."','".$name."','".$country."','".$ip."','".$payout."','".$reward."','adgatemedia','".$status."','".time()."')");
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

    echo "OK";