<?php
	define('BASEPATH', true);

	// Load System Files
	require('system/init.php');

	// Redirect to Secure Page (HTTPS)
	if($config['force_secure'] == 1 && !isset($_SERVER['HTTPS']) || $config['force_secure'] == 1 && $_SERVER['HTTPS'] != 'on')
	{
		header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		exit;
	}

	// Logout system
	if(isset($_GET['logout']))
	{
		if(isset($_COOKIE['SesToken'])){
			unset($_COOKIE['SesToken']); 
			setcookie('SesToken', '', time(), '/');
		}

		// Delete user Session
		$db->Query("DELETE FROM `users_sessions` WHERE `uid`='".$data['id']."'");
		if(isset($_COOKIE['SesHashKey'])){
			unset($_COOKIE['SesHashKey']); 
			setcookie('SesHashKey', '', time(), '/');
		}

		// Destroy Sessions
		session_destroy();

		redirect($config['secure_url']);
	}

	// Referral System
	if(!$is_online && isset($_GET['ref']))
	{
		setcookie('PT_REF_ID', $db->EscapeString($_GET['ref']), time()+7200);
	}
	
	// Detect visitor referrer
	if(!$is_online && isset($_SERVER['HTTP_REFERER']) && !isset($_COOKIE['RefSource'])){
		$main_domain = parse_url($config['site_url']);
		$http_referer = parse_url($_SERVER['HTTP_REFERER']);
		if(isset($http_referer['host']) && $http_referer['host'] != $main_domain['host']){
			setcookie('RefSource', $db->EscapeString($_SERVER['HTTP_REFERER']), time()+1800);
		}
	}
	
	// Check Proxy
	$proxy = false;
	if($is_online)
	{
		$checkProxy = detectProxy($ip_address);
		$proxy = ($checkProxy['status'] == 1 ? true : false);
		
		if($proxy)
		{
			$db->Query("INSERT IGNORE INTO `users_proxy` (`user_id`,`ip_address`,`country_code`) VALUES ('".$data['id']."','".$ip_address."','".$checkProxy['country']."')");
		}
	}

	// Remove Footer Branding
	if(file_exists(BASE_PATH.'/system/copyright.php')) {
		include(BASE_PATH.'/system/copyright.php');
	}

	/*
		Load Website
	*/

	// Starting compression
	ob_start();

	// Content Settings
	$pages = array(
			// script name => (1 = valid, 0 = disabled), (0 = offline, 1 = online, 2 = doesn't matter), File Location, Page name
			'contact' => array(1, 2, 'pages/contact', 'Contact Us'),
			'faq' => array(1, 2, 'pages/faq', 'FAQ'),
			'offers' => array(1, 1, 'pages/offers', 'Earn Coins'),
			'activities' => array(1, 1, 'pages/activities', 'Activities'),
			'completed' => array(1, 1, 'pages/completed', 'Completed Offers'),
			'pending' => array(1, 1, 'pages/pending', 'Pending Offers'),
			'rejected' => array(1, 1, 'pages/rejected', 'Rejected Offers'),
			'canceled' => array(1, 1, 'pages/canceled', 'Canceled Offers'),
			'tos' => array(1, 2, 'pages/tos', 'Terms & Conditions'),
			'privacy' => array(1, 2, 'pages/privacy', 'Privacy Policy'),
			'affiliates' => array(1, 1, 'pages/affiliates', 'Affiliates'),
			'referrals' => array(1, 1, 'pages/referrals', 'Referrals'),
			'account' => array(1, 1, 'pages/account', 'Edit Account'),
			'tasks' => array(1, 1, 'pages/tasks', 'Tasks'),
			'shortlinks' => array(1, 1, 'pages/shortlinks', 'Shortlinks'),
			'withdraw' => array(1, 1, 'pages/withdraw', 'Withdraw'),
			'offerwalls' => array(1, 1, 'pages/offerwalls', 'offerwalls'),
			'leaderboard' => array(1, 1, 'pages/leaderboard', 'leaderboard'),
			'register' => array(1, 0, 'register', 'Register', 1),
			'login' => array(1, 0, 'login', 'Login', 1)
		);
		
	$valid = false;
	if (isset($_GET['page']) && $pages[$_GET['page']][0] == 1) {
		if($is_online && $pages[$_GET['page']][1] == 1){
			$valid = true;
		}elseif(!$is_online && $pages[$_GET['page']][1] == 0){
			$valid = true;
		}elseif($pages[$_GET['page']][1] == 2){
			$valid = true;
		}
	}

	$page = ($is_online ? 'pages/offers' : 'home');
	$page_title = '';
	if($valid)
	{
		if(file_exists(BASE_PATH.'/template/'.$config['theme'].'/'.$pages[$_GET['page']][2].'.php'))
		{
			$page = $pages[$_GET['page']][2];
			$page_title = $pages[$_GET['page']][3];
		}
	}
	
	// Generate Security Token
	$token = GenGlobalToken();

	// Load Header
	if($is_online || isset($_GET['page']) && $pages[$_GET['page']][1] == 2)
	{
		require(BASE_PATH.'/template/'.$config['theme'].'/common/header.php');
	}
	
	// Load Page
	require(BASE_PATH.'/template/'.$config['theme'].'/'.$page.'.php');
	
	// Load Footer
	if($is_online || isset($_GET['page']) && $pages[$_GET['page']][1] == 2)
	{
		require(BASE_PATH.'/template/'.$config['theme'].'/common/footer.php');
	}
	
	// Show website
	ob_end_flush();
?>