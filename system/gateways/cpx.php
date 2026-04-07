<?php
	define('BASEPATH', true);
	require('../init.php');

	// Security Check
	$secret = $db->QueryFetchArray("SELECT config_value FROM `surveys_config` WHERE `offerwall_config`='cpx_hash'");
	$secret = $secret['config_value'];

	// Get postback values
	$userId = isset($_GET['user_id']) ? $db->EscapeString($_GET['user_id']) : null;
	$action = isset($_GET['status']) ? $db->EscapeString($_GET['status']) : null;
	$transaction = isset($_GET['trans_id']) ? $db->EscapeString($_GET['trans_id']) : null;
	$payout = isset($_GET['amount_usd']) ? $db->EscapeString($_GET['amount_usd']) : null;
	$reward = isset($_GET['amount_local']) ? $db->EscapeString($_GET['amount_local']) : null;
	$ip_address = isset($_GET['ip_click']) ? $db->EscapeString($_GET['ip_click']) : '0.0.0.0';
	$signature = isset($_GET['hash']) ? $db->EscapeString($_GET['hash']) : null;
	$country = detectCountry($ip_address);

	// Check signature
	if (md5($transaction.'-'.$secret) != $signature) {
		echo "ERROR: Signature doesn't match";
		exit;
	}

	// Load Website Data
	$user = $db->QueryFetchArray("SELECT `id`,`ref` FROM `users` WHERE `id`='".$userId."'");
	$offer = $db->QueryFetchArray("SELECT * FROM `completed_offers` WHERE `transaction_id`='".$transaction."' AND `method`='cpx' LIMIT 1");

	// Proccess Postback
	if($action == 2 && !empty($user['id']) && !empty($offer['id']))
	{
		if($offer['status'] == 1)
		{
			$db->Query("UPDATE `completed_offers` SET `status`='3' WHERE `id`='".$offer['id']."'");
			$db->Query("UPDATE `users` SET `account_balance`=`account_balance`-'".$offer['reward']."' WHERE `id`='".$user['id']."'");
		
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
		$name = 'CPX Survey';
		$status = ($config['hold_days'] == 0 ? 1 : 0);

		// Check Proxy / VPN
		$checkProxy = detectProxy($ip_address);
		$status = ($checkProxy['status'] == 1 ? 4 : $status);
		
		$db->Query("INSERT INTO `completed_offers` (`user_id`,`transaction_id`,`campaign_name`,`user_country`,`user_ip`,`revenue`,`reward`,`method`,`status`,`timestamp`) VALUES ('".$user['id']."','".$transaction."','".$name."','".$country."','".$ip_address."','".$payout."','".$reward."','cpx','".$status."','".time()."')");
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
?>