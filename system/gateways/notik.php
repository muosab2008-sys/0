<?php
	define('BASEPATH', true);
	require('../init.php');
	
	// Security Check
	$secret = $db->QueryFetchArray("SELECT config_value FROM `offerwall_config` WHERE `config_name`='notik_secret'");
	$secret = $secret['config_value'];

	// Get postback values
	$userId = $db->EscapeString($_REQUEST['user_id']);
	$payout = $db->EscapeString($_REQUEST['payout']);
    $name = $db->EscapeString($_REQUEST['offer_name']);
    $offer_id = $db->EscapeString($_REQUEST['offer_id']);
    $reward = $db->EscapeString($_REQUEST['amount']);
	$transaction = $db->EscapeString($_REQUEST['txn_id']);
	$ip_address = $db->EscapeString($_REQUEST['conversion_ip']);
	$country = detectCountry($ip_address);

	// Create validation hash
	$protocol = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on" ? "https" : "http");
    $url = $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $urlWithoutHash = substr($url, 0, -strlen("&hash=".$_REQUEST['hash']));
    $generatedHash = hash_hmac("sha1", $urlWithoutHash, $secret); 

	if ($_REQUEST['hash'] != $generatedHash) {
		echo '0';
		exit;
	}

	// Load Website Data
	$user = $db->QueryFetchArray("SELECT `id`,`ref` FROM `users` WHERE `id` = '".$userId."'");
	$offer = $db->QueryFetchArray("SELECT * FROM `completed_offers` WHERE `transaction_id`='".$transaction."' AND `method`='notik' LIMIT 1");

	if(!empty($user['id']) && empty($offer['id']))
    {
		$status = ($config['hold_days'] == 0 ? 1 : 0);
		
		// Check Proxy / VPN
		$checkProxy = detectProxy($ip_address);
		$status = ($checkProxy['status'] == 1 ? 4 : $status);

		$db->Query("INSERT INTO `completed_offers` (`user_id`,`transaction_id`,`campaign_id`,`campaign_name`,`user_country`,`user_ip`,`revenue`,`reward`,`method`,`status`,`timestamp`) VALUES ('".$user['id']."','".$transaction."','".$offer_id."','".$name."','".$country."','".$ip_address."','".$payout."','".$reward."','notik','".$status."','".time()."')");
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

    echo '1';
?>