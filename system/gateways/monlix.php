<?php
    define('BASEPATH', true);
    require('../init.php');

	// Grab Postback Data
    $userId = isset($_REQUEST['userid']) ? $db->EscapeString($_REQUEST['userid']) : null;
    $transaction = isset($_REQUEST['transactionid']) ? $db->EscapeString($_REQUEST['transactionid']) : null;
    $name = isset($_REQUEST['name']) ? $db->EscapeString($_REQUEST['name']) : null;
    $reward = isset($_REQUEST['reward']) ? $db->EscapeString($_REQUEST['reward']) : null;
	$payout = isset($_REQUEST['payout']) ? $db->EscapeString($_REQUEST['payout']) : null;
    $action = isset($_REQUEST['status']) ? $db->EscapeString($_REQUEST['status']) : null;
    $userIP = isset($_REQUEST['userip']) ? $db->EscapeString($_REQUEST['userip']) : '0.0.0.0';
    $country = isset($_REQUEST['country']) ? $db->EscapeString($_REQUEST['country']) : null;
	
	// Security Check
	$secret = $db->QueryFetchArray("SELECT config_value FROM `offerwall_config` WHERE `config_name`='monlix_secret'");
	$secret = $secret['config_value'];
	
    // Validate signature
    if ($secret != $db->EscapeString($_REQUEST['secret'])) {
        echo "ERROR: Signature doesn't match";
        return;
    }

	// Load Website Data
	$user = $db->QueryFetchArray("SELECT `id`,`ref` FROM `users` WHERE `id`='".$userId."'");
	$offer = $db->QueryFetchArray("SELECT * FROM `completed_offers` WHERE `transaction_id`='".$transaction."' AND `method`='monlix' LIMIT 1");

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
		$status = ($config['hold_days'] == 0 ? 1 : 0);
		if($payout < 0.01)
		{
			$name = (empty($name) ? 'Monlix PTC Ad' : $name);
			$status = 1;
		}
		
		// Check Proxy / VPN
		$checkProxy = detectProxy($userIP);
		$status = ($checkProxy['status'] == 1 ? 4 : $status);
		
		$db->Query("INSERT INTO `completed_offers` (`user_id`,`transaction_id`,`campaign_name`,`user_country`,`user_ip`,`revenue`,`reward`,`method`,`status`,`timestamp`) VALUES ('".$user['id']."','".$transaction."','".$name."','".$country."','".$userIP."','".$payout."','".$reward."','monlix','".$status."','".time()."')");
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