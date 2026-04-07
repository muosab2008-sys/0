<?php
	define('BASEPATH', true);
	require('../init.php');

	// Security Check
	$secret = $db->QueryFetchArray("SELECT `config_value` FROM `offerwall_config` WHERE `config_name`='lootably_secret'");
	$secret = $secret['config_value'];

	// Get postback
	$userId = $db->EscapeString($_REQUEST['user_id']);
	$tx_id = $db->EscapeString($_REQUEST['transaction']);
    $name = $db->EscapeString($_REQUEST['name']);
	$ip_address = $db->EscapeString($_REQUEST['ip_address']);	
	$payout = $db->EscapeString($_REQUEST['payout']);
	$reward = $db->EscapeString($_REQUEST['reward']);
	$status = $db->EscapeString($_REQUEST['status']);
	$country = detectCountry($ip_address);

	// validate signature
	if ($_REQUEST['hash'] != hash("sha256",$userId.$ip_address.$payout.$reward.$secret)){
		echo 0;
		return;
	}

	// Proccess Reward
	$user = $db->QueryFetchArray("SELECT `id`,`ref` FROM `users` WHERE `id` = '".$userId."' LIMIT 1");
	$offer = $db->QueryFetchArray("SELECT * FROM `completed_offers` WHERE `transaction_id`='".$tx_id."' AND `method`='lootably' LIMIT 1");

	if(!empty($user['id']) && empty($offer['id']) && $status == 1)
	{
		$status = ($config['hold_days'] == 0 ? 1 : 0);
		
		// Check Proxy / VPN
		$checkProxy = detectProxy($ip_address);
		$status = ($checkProxy['status'] == 1 ? 4 : $status);

		$db->Query("INSERT INTO `completed_offers` (`user_id`,`transaction_id`,`campaign_name`,`user_country`,`user_ip`,`revenue`,`reward`,`method`,`status`,`timestamp`) VALUES ('".$user['id']."','".$tx_id."','".$name."','".$country."','".$ip_address."','".$payout."','".$reward."','lootably','".$status."','".time()."')");
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

	    echo 1;
	}
    elseif(!empty($offer['id']) && $status == 0)
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
        
        echo 1;
    }
    else
    {
        echo 0;
    }
?>