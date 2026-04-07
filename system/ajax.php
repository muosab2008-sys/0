<?php
define('BASEPATH', true);
define('IS_AJAX', true);
require('init.php');

if($is_online)
{
	if(isset($_GET['a']))
	{
		switch ($_GET['a']) {
			case 'calculateWithdraw':
				$amount = $db->EscapeString($_GET['amount']);
				
				$value = number_format($amount / $config['coins_rate'], 2);

				echo '<b>$'.$value.'</b> will be sent to your selected withdrawal method.';

				break;
			case 'getWithdraw':
				$id = $db->EscapeString($_GET['id']);
				$method = $db->QueryFetchArray("SELECT * FROM `withdraw_methods` WHERE `id`='".$id."' LIMIT 1");

				$result = '';
				if(empty($method))
				{
					$resultData = array('message' => '<div class="col-12 mt-3"><div class="alert alert-warning">Please select a valid withdrawal method!</div></div>', 'status' => 500);
				}
				else
				{
					$resultData = array('payInfo' => $method['info'], 'min' => ($method['minimum']*$config['coins_rate']), 'status' => 200);
				}

				header('Content-type: application/json');
				echo json_encode($resultData);

				break;
			case 'scriptVersion':
				echo get_data(base64_decode('aHR0cDovL3NjcmlwdHN0b3JlLnh5ei92ZXJzaW9ucy9wYWlkb2ZmZXJzLmh0bWw='), 4);

				break;
		}
	}
	elseif(isset($_GET['offerwall']))
	{
		// Load offerwall settings
		$ow_config = array();
		$ow_configs = $db->QueryFetchArrayAll("SELECT `config_name`,`config_value` FROM `offerwall_config`");
		foreach ($ow_configs as $con)
		{
			$ow_config[$con['config_name']] = $con['config_value'];
		}
		unset($ow_configs);
		
		$title = 'Offerwall';
		$offer_wall = '<div class="alert alert-info mb-0 text-center" role="alert">This offerwall is not available for the moment!</div>';
		$offerwall_status = false;
		switch ($_GET['offerwall']) {
			case 'cpx' :
				if(!empty($ow_config['cpx_id']) && !empty($ow_config['cpx_hash'])) {
					$title = 'CPX Research';
					$offer_wall = 'https://offers.cpx-research.com/index.php?app_id='.$ow_config['cpx_id'].'&ext_user_id='.$data['id'].'&secure_hash='.md5($data['id'].'-'.$ow_config['cpx_hash']).'&username='.$data['username'].'&email='.$data['email'];
					$offerwall_status = true;
				}
				break;
			case 'lootably' :
				if(!empty($ow_config['lootably_id'])) {
					$title = 'Lootably';
					$offer_wall = 'https://wall.lootably.com/?placementID='.$ow_config['lootably_id'].'&sid='.$data['id'];
					$offerwall_status = true;
				}
				break;
			case 'admantium' :
				if(!empty($ow_config['admantium_uuid'])) {
					$title = 'Admantium';
					$offer_wall = 'https://offerwall.admantium.net?offerwall='.$ow_config['admantium_uuid'].'&user_id='.$data['id'];
					$offerwall_status = true;
				}
				break;
			case 'wannads' :
				if(!empty($ow_config['wannads_key'])) {
					$title = 'Wannads';
					$offer_wall = 'https://wall.wannads.com/wall?apiKey='.$ow_config['wannads_key'].'&userId='.$data['id'];
					$offerwall_status = true;
				}
				break;
			case 'offerwall' :
				if(!empty($ow_config['offerwall_url']) && !empty($ow_config['offerwall_key']) && !empty($ow_config['offerwall_secret'])) {
					$title = 'OfferWall';
					$offer_wall = $ow_config['offerwall_url'].'/offerwall/'.$ow_config['offerwall_key'].'/'.$data['id'];
					$offerwall_status = true;
				}
				break;
			case 'offertoro' :
				if(!empty($ow_config['offertoro_pub']) && !empty($ow_config['offertoro_app'])) {
					$title = 'Torox';
					$offer_wall = 'https://www.offertoro.com/ifr/show/'.$ow_config['offertoro_pub'].'/'.$data['id'].'/'.$ow_config['offertoro_app'];
					$offerwall_status = true;
				}
				break;
			case 'monlix' :
				if(!empty($ow_config['monlix_api'])) {
					$title = 'Monlix';
					$offer_wall = 'https://offers.monlix.com/?appid='.$ow_config['monlix_api'].'&userid='.$data['id'];
					$offerwall_status = true;
				}
				break;
			case 'adgatemedia' :
				if(!empty($ow_config['adgate_id'])) {
					$title = 'AdGateMedia';
					$offer_wall = 'https://wall.adgaterewards.com/'.$ow_config['adgate_id'].'/'.$data['id'];
					$offerwall_status = true;
				}
				break;
			case 'notik' :
				if(!empty($ow_config['notik_api']) && !empty($ow_config['notik_id']) && !empty($ow_config['notik_app'])) {
					$title = 'Notik';
					$offer_wall = 'https://notik.me/coins?api_key='.$ow_config['notik_api'].'&pub_id='.$ow_config['notik_id'].'&app_id='.$ow_config['notik_app'].'&user_id='.$data['id'];
					$offerwall_status = true;
				}
				break;
			case 'timewall' :
				if(!empty($ow_config['timewall_id']) && !empty($ow_config['timewall_secret'])) {
					$title = 'Timewall';
					$offer_wall = 'https://timewall.io/users/login?oid='.$ow_config['timewall_id'].'&uid='.$data['id'];
					$offerwall_status = true;
				}
				break;
			case 'upwall' :
				if(!empty($ow_config['upwall_id'])) {
					$title = 'Upwall';
					$offer_wall = 'https://offerwall.upwall.net/?app_id='.$ow_config['upwall_id'].'&userid='.$data['id'];
					$offerwall_status = true;
				}
				break;
			case 'taskwall' :
				if(!empty($ow_config['taskwall_id'])) {
					$title = 'Taskwall';
					$offer_wall = 'https://wall.taskwall.io/?app_id='.$ow_config['taskwall_id'].'&userid='.$data['id'];
					$offerwall_status = true;
				}
				break;
			case 'clickwall' :
				if(!empty($ow_config['clickwall_id'])) {
					$title = 'Clickwall';
					$offer_wall = 'https://clickwall.net/app/iframe/'.$ow_config['clickwall_id'].'/'.$data['id'];
					$offerwall_status = true;
				}
				break;
			case 'adtowall' :
				if(!empty($ow_config['adtowall_id'])) {
					$title = 'Adtowall';
					$offer_wall = 'https://adtowall.com/'.$ow_config['adtowall_id'].'/'.$data['id'];
					$offerwall_status = true;
				}
				break;
			case 'pubscale' :
				if(!empty($ow_config['pubscale_id'])) {
					$title = 'Pubscale';
					$offer_wall = 'https://wow.pubscale.com?app_id='.$ow_config['pubscale_id'].'&user_id='.$data['id'];
					$offerwall_status = true;
				}
				break;
			case 'offery' :
				if(!empty($ow_config['offery_id'])) {
					$title = 'Offery';
					$offer_wall = 'https://offery.io/offerwall/'.$ow_config['offery_id'].'/'.$data['id'];
					$offerwall_status = true;
				}
				break;
			case 'flexwall' :
				if(!empty($ow_config['flexwall_id'])) {
					$title = 'Flexwall';
					$offer_wall = 'https://flexwall.net/iframe/index.php?app_id='.$ow_config['flexwall_id'].'&user_id='.$data['id'];
					$offerwall_status = true;
				}
				break;
			case 'sushiads' :
				if(!empty($ow_config['sushiads_api'])) {
					$title = 'Sushiads';
					$offer_wall = 'https://offerwall.sushiads.com/wall?apiKey='.$ow_config['sushiads_api'].'&userId='.$data['id'];
					$offerwall_status = true;
				}
				break;
		}
		
		$resultData = array('title' => $title, 'status' => $offerwall_status, 'offerwall' => $offer_wall);
		header('Content-type: application/json');
		echo json_encode($resultData);
	}

	if(isset($_POST['a']) && $_POST['a'] == 'sendWithdraw')
	{
		$amount = max($_POST['amount'], 0);
		$info = $db->EscapeString($_POST['info']);
		$method = $db->EscapeString($_POST['method']);
		$method = $db->QueryFetchArray("SELECT * FROM `withdraw_methods` WHERE `id`='".$method."' LIMIT 1");
		
		$coinsValue = number_format($amount / $config['coins_rate'], 2, '.', '');
		
		if(empty($method['id']))
		{
			$resultData = array('status' => 500, 'message' => '<div class="alert alert-danger">Please select a valid withdrawal method!</div>');
		}
		elseif($data['account_balance'] < $amount)
		{
			$resultData = array('status' => 500, 'message' => '<div class="alert alert-danger">You don\'t have enough coins!</div>');
		}
		elseif($coinsValue < $method['minimum'])
		{
			$resultData = array('status' => 500, 'message' => '<div class="alert alert-danger">You should withdraw at least $'.$method['minimum'].' worth of coins!</div>');
		}
		elseif(empty($info) || strlen($info) < 5)
		{
			$resultData = array('status' => 500, 'message' => '<div class="alert alert-danger">Please complete your payment details!</div>');
		}
		else
		{
			$db->Query("UPDATE `users` SET `account_balance`=`account_balance`-'".$amount."' WHERE `id`='".$data['id']."'");
			$db->Query("INSERT INTO `withdrawals` (`user_id`,`coins`,`amount`,`method_id`,`method_name`,`payment_info`,`ip_address`,`time`) VALUES ('".$data['id']."', '".$amount."', '".$coinsValue."', '".$method['id']."', '".$method['method']."', '".$info."', '".$ip_address."', '".time()."')");
		
			$resultData = array('status' => 200, 'message' => '<div class="alert alert-success"><b>SUCCESS!</b> Your withdrawal request was successfully received!</div>');
		}
		
		header('Content-type: application/json');
		echo json_encode($resultData);
	}
	elseif(isset($_POST['a']) && $_POST['a'] == 'getShortlink')
	{
		if(!isset($_SERVER['HTTP_USER_AGENT']) || empty($_SERVER['HTTP_USER_AGENT']))
		{
			$resultData = array('message' => '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> System wasn\'t able to validate your browser. Please change your browser and try again!</div>', 'status' => 500); 
		}
		elseif(isset($_POST['token']) && $_POST['token'] === $_SESSION['token'])
		{
			$sid = $db->EscapeString($_POST['data']);
			$linkData = $db->QueryFetchArray("SELECT * FROM `shortlinks_config` WHERE `id`='".$sid."' AND `status`='1' LIMIT 1");
			if(empty($linkData['shortlink']) || empty($linkData['password']))
			{
				$resultData = array('message' => '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> This shortlink is no longer available!</div>', 'status' => 500);
			}
			else
			{
				$validate = $db->QueryFetchArray("SELECT `count` FROM `shortlinks_done` WHERE `user_id`='".$data['id']."' AND `short_id`='".$linkData['id']."' LIMIT 1");
				if($validate['count'] >= $linkData['daily_limit'])
				{
					$resultData = array('message' => '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> This shortlink is no longer available!</div>', 'status' => 500);
				}
				else
				{
					$shortLink = false;
					$short_key = false;
					$countLinks = $db->QueryFetchArray("SELECT COUNT(*) AS `total` FROM `shortlinks` WHERE `short_id`='".$linkData['id']."'");
					if($countLinks['total'] < 10) 
					{
						$short_key = GenerateKey(32);
						$return_url = urlencode($config['secure_url'].'/shortlink.php?short_key='.$short_key);
						$api_url = 'http://'.$linkData['shortlink'].'/api?api='.$linkData['password'].'&url='.$return_url.'&alias=PO'.GenerateKey(9);
						$getLink = get_data($api_url);

						if(empty($getLink))
						{
							$resultData = array('message' => '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> Unexpected error occurred, refresh this page and try again!</div>', 'status' => 500);
						}
						else
						{
							$getLink = json_decode($getLink, true);
							if($getLink['status'] === 'error' || empty($getLink['shortenedUrl'])) 
							{
								$resultData = array('message' => '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> Unexpected error occurred, refresh this page and try again!</div>', 'status' => 500);
							}
							else
							{
								$shortLink = $db->EscapeString($getLink['shortenedUrl']);
								$db->Query("INSERT INTO `shortlinks` (`short_id`,`shortlink`,`hash`,`time`) VALUES ('".$linkData['id']."','".$shortLink."','".$short_key."','".time()."')");
							}
						}
					}
					else
					{
						$getLink = $db->QueryFetchArray("SELECT `shortlink`, `hash` FROM `shortlinks` WHERE `short_id`='".$linkData['id']."' ORDER BY rand() LIMIT 1");
						$shortLink = $getLink['shortlink'];
						$short_key = $getLink['hash'];
					}

					if(!$shortLink || !$short_key)
					{
						$resultData = array('message' => '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> Unexpected error occurred, refresh this page and try again!</div>', 'status' => 500);
					}
					else
					{
						$_SESSION['shortlink_key'] = $short_key;
						$db->Query("INSERT INTO `shortlinks_session` (`user_id`,`short_id`,`time`) VALUES ('".$data['id']."','".$linkData['id']."','".time()."') ON DUPLICATE KEY UPDATE `time`='".time()."'");

						$resultData = array('message' => '<div class="alert alert-success" role="alert"><i class="fa fa-check-circle"></i> Success, you\'re being redirected...</div>', 'shortlink' => $shortLink, 'status' => 200);
					}
				}
			}
		}
		else
		{
			$resultData = array('message' => '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> <b>ERROR:</b> Session expired, please refresh the page and try again!</div>', 'status' => 500); 
		}

		header('Content-type: application/json');
		echo json_encode($resultData);
	}
	elseif(isset($_POST['a']) && $_POST['a'] == 'shortlinkVote')
	{
		if(!isset($_SERVER['HTTP_USER_AGENT']) || empty($_SERVER['HTTP_USER_AGENT']))
		{
			$resultData = array('message' => '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> System wasn\'t able to validate your browser. Please change your browser and try again!</div>', 'status' => 0); 
		}
		elseif(isset($_POST['token']) && $_POST['token'] === $_SESSION['token'])
		{
			$sid = $db->EscapeString($_POST['data']);
			$linkData = $db->QueryFetchArray("SELECT * FROM `shortlinks_config` WHERE `id`='".$sid."' AND `status`='1' LIMIT 1");
			if(empty($linkData['shortlink']) || empty($linkData['password']))
			{
				$resultData = array('message' => '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> This shortlink is no longer available!</div>', 'status' => 0);
			}
			else
			{
				$vote = ($_POST['vote'] == 'down' ? 2 : 1);
				$checkVote = $db->QueryFetchArray("SELECT `vote` FROM `shortlinks_votes` WHERE `short_id`='".$linkData['id']."' AND `user_id`='".$data['id']."' LIMIT 1");

				if(empty($checkVote['vote']) || $checkVote['vote'] != $vote)
				{
					$rating = ($vote == 2 ? -1 : 1);
					$db->Query("INSERT INTO `shortlinks_votes` (`short_id`,`user_id`,`vote`,`time`)VALUES('".$linkData['id']."','".$data['id']."','".$vote."','".time()."') ON DUPLICATE KEY UPDATE `vote`='".$vote."', `time`='".time()."'");
					$db->Query("UPDATE `shortlinks_config` SET `rating`=`rating`+'".$rating."' WHERE `id`='".$linkData['id']."'");
					$linkData = $db->QueryFetchArray("SELECT * FROM `shortlinks_config` WHERE `id`='".$sid."' AND `status`='1' LIMIT 1");
				}

				$resultData = array('count' => $linkData['rating'], 'status' => 200);
			}
		}
		else
		{
			$resultData = array('message' => '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> <b>ERROR:</b> Session expired, please refresh the page and try again!</div>', 'status' => 0); 
		}

		header('Content-type: application/json');
		echo json_encode($resultData);
	}
}
else
{
	if(isset($_POST['a']) && $_POST['a'] == 'login' && isset($_POST['username']) && isset($_POST['password']))
	{
		if(isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])
		{
			// validate recaptcha
			$captcha_valid = 1;
			if(!empty($config['recaptcha_sec'])){
				if(!isset($_POST['recaptcha'])) {
					$captcha_valid = 0;
				}
				else
				{
					$recaptcha = new \ReCaptcha\ReCaptcha($config['recaptcha_sec']);
					$recaptcha = $recaptcha->verify($_POST['recaptcha'], $_SERVER['REMOTE_ADDR']);
				
					if(!$recaptcha->isSuccess()){
						$captcha_valid = 0;
					}
				}
			}
			
			if(!$captcha_valid)
			{
				$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">Please confirm you\'re not a robot!</div>'); 
			}
			else
			{
				$ip_address = VisitorIP();
				$attempts = $db->QueryFetchArray("SELECT `count`,`time` FROM `wrong_logins` WHERE `ip_address`='".$ip_address."' LIMIT 1");

				if($attempts['count'] >= $config['login_attempts'] && $attempts['time'] > (time() - (60*$config['login_wait_time'])))
				{
					$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">You\'ve tried to login too many times. Try again in '.$config['login_wait_time'].' minutes!</div>'); 
				}
				else
				{
					$login = $db->EscapeString($_POST['username']);
					$data = $db->QueryFetchArray("SELECT id,disabled,activate FROM `users` WHERE (`username`='".$login."' OR `email`='".$login."') AND `password`='".securePassword($_POST['password'])."' LIMIT 1");

					if(empty($data['id']))
					{
						$db->Query("INSERT INTO `wrong_logins` (`ip_address`,`count`,`time`) VALUES ('".$ip_address."','1','".time()."') ON DUPLICATE KEY UPDATE `count`=`count`+'1', `time`='".time()."'");
						$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">Wrong username or password!</div>'); 
					}
					elseif($data['disabled'] > 0)
					{
						$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">Your account was disabled. Contact us for more details!</div>'); 
					}
					elseif($data['activate'] != '0')
					{
						$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">You need to confirm your email address!</div>'); 
					}
					else
					{
						$db->Query("UPDATE `users` SET `log_ip`='".$ip_address."', `last_activity`='".time()."' WHERE `id`='".$data['id']."'");
						$db->Query("DELETE FROM `wrong_logins` WHERE `ip_address`='".$ip_address."'");
			
						// Store login info
						$browser = $db->EscapeString($_SERVER['HTTP_USER_AGENT']);
						$db->Query("INSERT INTO `user_logins` (`uid`,`ip`,`info`,`time`) VALUES ('".$data['id']."','".$ip_address."','".$browser."',NOW())");
						
						// Update Session Token
						$hash_key = GenerateKey(16);
						$db->Query("INSERT INTO `users_sessions` (`uid`,`hash`,`browser`,`ip_address`,`timestamp`) VALUES ('".$data['id']."','".$hash_key."','".$browser."','".$ip_address."','".time()."') ON DUPLICATE KEY UPDATE `hash`='".$hash_key."', `browser`='".$browser."', `ip_address`='".$ip_address."', `timestamp`='".time()."'");
						$_SESSION['SesHashKey'] = $hash_key;
						
						// Auto-login user
						if(isset($_POST['remember'])){
							setcookie('SesHashKey', $hash_key, time()+604800, '/');
							setcookie('SesToken', 'ses_id='.$data['id'].'&ses_key='.$hash_key, time()+604800, '/');
						}
						
						// Set Session
						$_SESSION['PT_User'] = $data['id'];
						
						// Multi-account prevent
						setcookie('AccExist', $data['id'], time()+604800, '/');
						
						$resultData = array('status' => 1, 'msg' => '<div class="alert alert-success" role="alert"><b>SUCCESS:</b> You\'re being redirected...</div>'); 
					}
				}
			}
		} else {
			$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert"><b>ERROR:</b> Session expired, please refresh the page and try again!</div>'); 
		}
		
		header('Content-type: application/json');
		echo json_encode($resultData);
	}
	elseif(isset($_POST['a']) && $_POST['a'] == 'register')
	{
		if(isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])
		{
			$ip_address = VisitorIP();
			$username = $db->EscapeString($_POST['username']);
			$gender = $db->EscapeString($_POST['gender']);
			$email = $db->EscapeString($_POST['email']);
			
			// validate recaptcha
			$captcha_valid = 1;
			if(!empty($config['recaptcha_sec']))
			{
				if(!isset($_POST['recaptcha']))
				{
					$captcha_valid = 0;
				}
				else
				{
					$recaptcha = new \ReCaptcha\ReCaptcha($config['recaptcha_sec']);
					$recaptcha = $recaptcha->verify($_POST['recaptcha'], $_SERVER['REMOTE_ADDR']);
				
					if(!$recaptcha->isSuccess()){
						$captcha_valid = 0;
					}
				}
			}
			
			if(!$captcha_valid)
			{
				$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">Please confirm you\'re not a robot!</div>'); 
			}
			elseif(!$_POST['tos'])
			{
				$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">Please read and agree our <a href="'.GenerateURL('tos').'" target="_blank">Terms & Conditions</a> before registration!</div>'); 
			}
			elseif(!isUserID($username))
			{
				$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">Please complete your username!</div>'); 
			}
			elseif(!isEmail($email))
			{
				$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">Please enter a valid e-mail address!</div>'); 
			}
			elseif(!validatePassword($_POST['password']))
			{
				$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">Your password must contain at least 8 characters, 1 lowercase letter, 1 capital letter and 1 number!</div>'); 
			}
			elseif($gender < 1 && $gender > 2) 
			{
				$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">Please select your gender!</div>'); 
			}
			else
			{
				$country = detectCountry($ip_address);
				$country = $db->QueryFetchArray("SELECT `id` FROM `list_countries` WHERE `code`='".$country."' LIMIT 1");
				$country = $country['id'];

				if($db->QueryGetNumRows("SELECT id FROM `users` WHERE `username`='".$username."' OR `email`='".$email."' LIMIT 1") > 0)
				{
					$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">Username or email already registered!</div>');
				}
				elseif($config['more_per_ip'] != 1 && isset($_COOKIE['AccExist']) || $config['more_per_ip'] != 1 && $db->QueryGetNumRows("SELECT id FROM `users` WHERE `reg_ip`='".$ip_address."' OR `log_ip`='".$ip_address."' LIMIT 1") > 0)
				{
					$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">We allow just 1 account per IP address!</div>');
				}
				else
				{
					$referal = 0;
					if(isset($_COOKIE['PT_REF_ID']))
					{
						$refCode = $db->EscapeString($_COOKIE['PT_REF_ID']);
						$getRef = $db->QueryFetchArray("SELECT `id` FROM `users` WHERE `ref_code`='".$refCode."' LIMIT 1");
						
						if(!empty($getRef['id']))
						{
							$referal = $getRef['id'];
						}
					}

					$ref_source = 0;
					if(isset($_COOKIE['RefSource'])){
						$ref_source = $db->EscapeString($_COOKIE['RefSource']);
					}

					$activate = 0;
					if($config['reg_reqmail'] == 1){
						$activate = GenerateKey(32);
						$activate_url = GenerateURL('login&activate='.$activate, true);
						if($config['mail_delivery_method'] == 1){
							$mailer->isSMTP();
							$mailer->Host = $config['smtp_host'];
							$mailer->Port = $config['smtp_port'];

							if(!empty($config['smtp_auth'])){
								$mailer->SMTPSecure = $config['smtp_auth'];
							}
							$mailer->SMTPAuth = (empty($config['smtp_username']) || empty($config['smtp_password']) ? false : true);
							if($mailer->SMTPAuth){
								$mailer->Username = $config['smtp_username'];
								$mailer->Password = $config['smtp_password'];
							}
						}
						
						$mailer->AddAddress($email, $username);
						$mailer->SetFrom((!empty($config['noreply_email']) ? $config['noreply_email'] : $config['site_email']), $config['site_name']);
						$mailer->Subject = $config['site_logo'].' - Activate your account';
						$mailer->MsgHTML('<html>
											<body style="font-family: Verdana; color: #333333; font-size: 12px;">
												<table style="width: 400px; margin: 0px auto;">
													<tr style="text-align: center;">
														<td style="border-bottom: solid 1px #cccccc;"><h1 style="margin: 0; font-size: 20px;"><a href="'.$config['site_url'].'" style="text-decoration:none;color:#333333"><b>'.$config['site_name'].'</b></a></h1><h2 style="text-align: right; font-size: 14px; margin: 7px 0 10px 0;">Activate your account</h2></td>
													</tr>
													<tr style="text-align: justify;">
														<td style="padding-top: 15px; padding-bottom: 15px;">
															Hello '.$username.',
															<br /><br />
															Click on this link to activate your account:<br />
															<a href="'.$activate_url.'">'.$activate_url.'</a>
														</td>
													</tr>
													<tr style="text-align: right; color: #777777;">
														<td style="padding-top: 10px; border-top: solid 1px #cccccc;">
															Best Regards!
														</td>
													</tr>
												</table>
											</body>
										</html>');
						$mailer->Send();
					}

					$refCode = GenerateKey(16);
					$db->Query("INSERT INTO `users`(`email`,`username`,`country_id`,`gender`,`reg_ip`,`ref_code`,`password`,`ref`,`reg_time`,`activate`,`ref_source`) VALUES ('".$email."','".$username."','".$country."','".$gender."','".$ip_address."','".$refCode."','".securePassword($_POST['password'])."','".$referal."','".time()."','".$activate."','".$ref_source."')");
					$user_id = $db->GetLastInsertId();
					
					if(empty($user_id))
					{
						$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">Unexcepted error occured, refresh this page and try again!</div>');
					}
					else
					{
						if($referal > 0)
						{
							add_activity($referal, 4, serialize(array('id' => $user_id)));
						}
						
						if(!isset($_COOKIE['AccExist'])){
							setcookie('AccExist', $user_id, time()+604800, '/');
						}
						
						if($config['reg_reqmail'] != 1 && $user_id > 0) {
							$browser = $db->EscapeString($_SERVER['HTTP_USER_AGENT']);
							$db->Query("INSERT INTO `user_logins` (`uid`,`ip`,`info`,`time`) VALUES ('".$user_id."','".ip2long($ip_address)."','".$browser."',NOW())");
							$db->Query("UPDATE `users` SET `log_ip`='".$ip_address."', `last_activity`='".time()."' WHERE `id`='".$user_id."'");
						
							// Update Session Token
							$hash_key = GenerateKey(16);
							$browser = $db->EscapeString($_SERVER['HTTP_USER_AGENT']);
							$db->Query("INSERT INTO `users_sessions` (`uid`,`hash`,`browser`,`ip_address`,`timestamp`) VALUES ('".$user_id."','".$hash_key."','".$browser."','".$ip_address."','".time()."') ON DUPLICATE KEY UPDATE `hash`='".$hash_key."', `browser`='".$browser."', `ip_address`='".$ip_address."', `timestamp`='".time()."'");

							// Save Sessions
							$_SESSION['SesHashKey'] = $hash_key;
							$_SESSION['PT_User'] = $user_id;
							
							$resultData = array('status' => 1, 'loggedin' => 1, 'msg' => '<div class="alert alert-success" role="alert">Registered with success! Please wait...</div>'); 
						}
						else
						{
							$resultData = array('status' => 1, 'loggedin' => 0, 'msg' => '<div class="alert alert-success" role="alert">We\'ve sent a confirmation email! If you don\'t see our confirmation email, please check your SPAM mailbox.</div>'); 
						}
					}
				}
			}
		} else {
			$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">Session expired, please refresh the page and try again!</div>'); 
		}
		
		header('Content-type: application/json');
		echo json_encode($resultData);
	}
	elseif(isset($_POST['a']) && $_POST['a'] == 'recover')
	{
		if(isset($_POST['token']) && $_POST['token'] === $_SESSION['token'])
		{
			$email = $db->EscapeString($_POST['email']);

			// validate recaptcha
			$captcha_valid = 1;
			if(!empty($config['recaptcha_sec']))
			{
				if(!isset($_POST['recaptcha']))
				{
					$captcha_valid = 0;
				}
				else
				{
					$recaptcha = new \ReCaptcha\ReCaptcha($config['recaptcha_sec']);
					$recaptcha = $recaptcha->verify($_POST['recaptcha'], $_SERVER['REMOTE_ADDR']);
				
					if(!$recaptcha->isSuccess()){
						$captcha_valid = 0;
					}
				}
			}
			
			if(!$captcha_valid)
			{
				$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">Please confirm you\'re not a robot!</div>'); 
			}
			elseif(!isEmail($email))
			{
				$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">Please enter a valid e-mail address!</div>'); 
			}
			else
			{
				$recUser = $db->QueryFetchArray("SELECT `id`,`username` FROM `users` WHERE `email`='".$email."' LIMIT 1");
				if(empty($recUser['id']))
				{
					$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">This email address in not registered!</div>'); 
				}
				else
				{
					$newhash = GenerateKey(32);
					$recover_url = GenerateURL('login&recover='.$newhash, true);

					$db->Query("INSERT INTO `users_recovery` (`user_id`, `hash_key`, `time`) VALUES ('".$recUser['id']."', '".$newhash."', '".time()."') ON DUPLICATE KEY UPDATE `hash_key`='".$newhash."', `time`='".time()."'");
					
					// SMTP Mail Config
					if($config['mail_delivery_method'] == 1){
						$mailer->isSMTP();
						$mailer->Host = $config['smtp_host'];
						$mailer->Port = $config['smtp_port'];

						if(!empty($config['smtp_auth'])){
							$mailer->SMTPSecure = $config['smtp_auth'];
						}
						$mailer->SMTPAuth = (empty($config['smtp_username']) || empty($config['smtp_password']) ? false : true);
						if($mailer->SMTPAuth){
							$mailer->Username = $config['smtp_username'];
							$mailer->Password = $config['smtp_password'];
						}
					}

					// Mail Config
					$mailer->AddAddress($email, $recUser['username']);
					$mailer->SetFrom((!empty($config['noreply_email']) ? $config['noreply_email'] : $config['site_email']), $config['site_name']);
					$mailer->Subject = $config['site_name'].' - Password Recovery';
					
					// Mail content
					$mailer->isHTML(true);
					$mailer->Body = '<html>
								<body style="font-family: Verdana; color: #333333; font-size: 12px;">
									<table style="width: 600px; margin: 0px auto;">
										<tr style="text-align: center;">
											<td style="border-bottom: solid 1px #cccccc;"><h1 style="margin: 0; font-size: 20px;"><a href="'.$config['secure_url'].'" style="text-decoration:none;color:#333333"><b>'.$config['site_name'].'</b></a></h1><h2 style="text-align: right; font-size: 14px; margin: 7px 0 10px 0;">Password Recovery</h2></td>
										</tr>
										<tr style="text-align: justify;">
											<td style="padding-top: 15px; padding-bottom: 15px;">
												Hello '.$recUser['username'].',
												<br /><br />
												You asked to recover your password. To set your new password, access following URL:<br />
												<a href="'.$recover_url.'">'.$recover_url.'</a><br /><br />
												Wasn\'t you? No worries, just delete this email.
											</td>
										</tr>
										<tr style="text-align: right; color: #777777;">
											<td style="padding-top: 10px; border-top: solid 1px #cccccc;">
												Best Regards!
											</td>
										</tr>
									</table>
								</body>
							</html>';
					$mailer->AltBody = 'You asked to recover your password. To set your new password, access following URL: '.$recover_url;
					
					// Mail Send
					$mailer->Send();

					$resultData = array('status' => 200, 'msg' => '<div class="alert alert-success" role="alert">We\'ve sent you an email! Check your mailbox to carry on with the proccess.</div>'); 
				}
			}
		} else {
			$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert"><b>ERROR:</b> Session expired, please refresh the page and try again!</div>'); 
		}
		
		header('Content-type: application/json');
		echo json_encode($resultData);
	}
	elseif(isset($_POST['a']) && $_POST['a'] == 'changePass')
	{
		if(isset($_POST['token']) && $_POST['token'] === $_SESSION['token'])
		{
			// validate recaptcha
			$captcha_valid = 1;
			if(!empty($config['recaptcha_sec']))
			{
				if(!isset($_POST['recaptcha']))
				{
					$captcha_valid = 0;
				}
				else
				{
					$recaptcha = new \ReCaptcha\ReCaptcha($config['recaptcha_sec']);
					$recaptcha = $recaptcha->verify($_POST['recaptcha'], $_SERVER['REMOTE_ADDR']);
				
					if(!$recaptcha->isSuccess()){
						$captcha_valid = 0;
					}
				}
			}
			
			if(!$captcha_valid)
			{
				$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">Please confirm you\'re not a robot!</div>'); 
			}
			else
			{
				$getKey = $db->EscapeString($_POST['hash_key']);
				$checkKey = $db->QueryFetchArray("SELECT `user_id` FROM `users_recovery` WHERE `hash_key`='".$getKey."' LIMIT 1");

				if(empty($checkKey['user_id']))
				{
					$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">This password recovery URL expired or is not valid!</div>'); 
				}
				elseif(!validatePassword($_POST['pass1']))
				{
					$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">Your password must contain at least 8 characters, 1 lowercase letter, 1 capital letter and 1 number!</div>'); 
				}
				elseif($_POST['pass1'] != $_POST['pass2'])
				{
					$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">Your confirmation password doesn\'t match!</div>'); 
				}
				else
				{
					$password = securePassword($_POST['pass1']);
					$db->Query("UPDATE `users` SET `password`='".$password."' WHERE `id`='".$checkKey['user_id']."'");
					$db->Query("DELETE FROM `users_recovery` WHERE `user_id`='".$checkKey['user_id']."'");

					$resultData = array('status' => 200, 'msg' => '<div class="alert alert-success" role="alert">Your password was successfully changed, please login...</div>'); 
				}
			}
		} else {
			$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert"><b>ERROR:</b> Session expired, please refresh the page and try again!</div>'); 
		}
		
		header('Content-type: application/json');
		echo json_encode($resultData);
	}
	elseif(isset($_POST['a']) && $_POST['a'] == 'contact')
	{
		if(isset($_POST['token']) && $_POST['token'] === $_SESSION['token'])
		{
			$name = $db->EscapeString($_POST['name']);
			$email = $db->EscapeString($_POST['email']);

			if(empty($name))
			{
				$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">Please complete your full name!</div>'); 
			}
			elseif(!isEmail($email))
			{
				$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">Please enter a valid e-mail address!</div>'); 
			}
			elseif(strlen($_POST['message']) < 10)
			{
				$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert">Please complete your message!</div>'); 
			}
			else
			{
				// SMTP Mail Config
				if($config['mail_delivery_method'] == 1){
					$mailer->isSMTP();
					$mailer->Host = $config['smtp_host'];
					$mailer->Port = $config['smtp_port'];

					if(!empty($config['smtp_auth'])){
						$mailer->SMTPSecure = $config['smtp_auth'];
					}
					$mailer->SMTPAuth = (empty($config['smtp_username']) || empty($config['smtp_password']) ? false : true);
					if($mailer->SMTPAuth){
						$mailer->Username = $config['smtp_username'];
						$mailer->Password = $config['smtp_password'];
					}
				}

				// Mail Config
				$mailer->AddAddress($config['site_email'], $config['site_name']);
				$mailer->SetFrom((!empty($config['noreply_email']) ? $config['noreply_email'] : $config['site_email']), $config['site_name']);
				$mailer->addReplyTo($email, $name);
				$mailer->Subject = $config['site_name'].' - New message received';
				
				// Mail content
				$mailer->isHTML(true);
				$mailer->Body = '<html>
									<body style="font-family: Verdana; color: #333333; font-size: 12px;">
										<table style="width: 600px; margin: 0px auto;">
											<tr style="text-align: center;">
												<td style="border-bottom: solid 1px #cccccc;"><h1 style="margin: 0; font-size: 20px;"><a href="'.$config['site_url'].'" style="text-decoration:none;color:#333333"><b>'.$config['site_name'].'</b></a></h1><h2 style="text-align: right; font-size: 14px; margin: 7px 0 10px 0;">New Message Received</h2></td>
											</tr>
											<tr style="text-align: justify;">
												<td style="padding-top: 15px; padding-bottom: 15px;">
													<b>Sender Name:</b> '.$name.'<br />
													<b>Sender Email:</b> '.$email.'<br />
													<b>Message:</b><br /><br />
													'.nl2br($_POST['message']).'
												</td>
											</tr>
										</table>
									</body>
								</html>';
				$mailer->AltBody = 'Message from '.$name.' ('.$email.'): '.$_POST['message'];
				
				// Mail Send
				$mailer->Send();

				$resultData = array('status' => 200, 'msg' => '<div class="alert alert-success" role="alert">Your message was successfully sent, thank you!</div>'); 
			}
		} else {
			$resultData = array('status' => 0, 'msg' => '<div class="alert alert-danger" role="alert"><b>ERROR:</b> Session expired, please refresh the page and try again!</div>'); 
		}
		
		header('Content-type: application/json');
		echo json_encode($resultData);
	}
}
if (isset($_POST['a']) && $_POST['a'] == 'approvedAllWithdrawls') {
    $method_name = $db->EscapeString($_POST['method_name']);
    $payment_info = $db->EscapeString($_POST['payment_info']);

   
    $withdrawals = $db->QueryFetchArray("
        SELECT COUNT(*) AS rowCount,
               COALESCE(SUM(coins),0) AS total_coins,
               COALESCE(SUM(amount),0) AS total_amount,
               '".$method_name."' AS method_name,
               '".$payment_info."' AS payment_info
        FROM withdrawals
        WHERE status = '0'
          AND method_name = '".$method_name."'
          AND payment_info = '".$payment_info."'
    ");

    echo json_encode([
        "status" => true,
        "withdrawals" => $withdrawals
    ]);
    exit;
}
if (isset($_POST['a']) && $_POST['a'] == 'approvedAllSubmit') {
    $method_name = $db->EscapeString($_POST['method_name']);
    $payment_info = $db->EscapeString($_POST['payment_info']);

    
    $db->Query("
        UPDATE withdrawals
        SET status = '1'
        WHERE status = '0'
          AND method_name = '".$method_name."'
          AND payment_info = '".$payment_info."'
    ");

    echo json_encode([
        "status" => true,
        "msg" => "All withdrawals have been approved successfully!"
    ]);
    exit;
}

?>