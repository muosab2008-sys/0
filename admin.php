<?php
	define('BASEPATH', true);

	// Load System Files
	require('system/init.php');

	if(!$is_online || ($is_online && $data['admin'] != 1))
	{
		redirect($config['secure_url']);
	}

	// Redirect to Secure Page (HTTPS)
	if($config['force_secure'] == 1 && !isset($_SERVER['HTTPS']) || $config['force_secure'] == 1 && $_SERVER['HTTPS'] != 'on')
	{
		header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		exit;
	}

	/*
		Load Website
	*/

	// Starting compression
	ob_start();

	// Content Settings
	$pages = array(
			// script name => (1 = valid, 0 = disabled), File Location, Page name
			'users' => array(1, 'pages/users', 'Users'),
			'edituser' => array(1, 'pages/edit_user', 'Edit User'),
			'completed' => array(1, 'pages/completed', 'Complete Transactions'),
			'canceled' => array(1, 'pages/canceled', 'Canceled Transactions'),
			'pending' => array(1, 'pages/pending', 'Pending Transactions'),
			'rejected' => array(1, 'pages/rejected', 'Rejected Transactions'),
			'withdrawals' => array(1, 'pages/withdrawals', 'Complete Withdrawals'),
			'pendingwithdrawals' => array(1, 'pages/pendingwithdrawals', 'Pending Withdrawals'),
			'faq' => array(1, 'pages/faq', 'FAQ'),
			'tasks' => array(1, 'pages/tasks', 'Tasks'),
			'tasksdone' => array(1, 'pages/tasksdone', 'Completed Tasks'),
			'settings' => array(1, 'pages/settings', 'Website Settings'),
			'captcha' => array(1, 'pages/captcha', 'Captcha Settings'),
			'payset' => array(1, 'pages/payset', 'Reward Settings'),
			'proxy' => array(1, 'pages/proxy', 'Proxycheck Settings'),
			'shortlinks' => array(1, 'pages/shortlinks', 'Shortlinks Settings'),
			'offerwalls' => array(1, 'pages/offerwalls', 'Offers Settings'),
			'ads' => array(1, 'pages/ads', 'Ads'),
			'offers' => array(1, 'pages/offers', 'Offers Manager'),
			'admin_rank_prizes' => array(1, 'pages/admin_rank_prizes', 'admin_rank_prizes Manager'), 
			'admin_rank' => array(1, 'pages/admin_rank', 'admin_rank') 
		);
		
	$valid = false;
	if (isset($_GET['page']) && isset($pages[$_GET['page']][0]) && $pages[$_GET['page']][0] == 1) {
		$valid = true;
	}

	$page = 'pages/dashboard';
	$page_title = 'Admin Dashboard';
	if($valid)
	{
		if(file_exists(BASE_PATH.'/template/admin/'.$pages[$_GET['page']][1].'.php'))
		{
			$page = $pages[$_GET['page']][1];
			$page_title = $pages[$_GET['page']][2];
		}
	}
	
	// Define Global Variables
	$token = GenGlobalToken();
	$errMessage = '';

	// Load Header
	require(BASE_PATH.'/template/admin/common/header.php');
	
	// Load Page
	require(BASE_PATH.'/template/admin/'.$page.'.php');
	
	// Load Footer
	require(BASE_PATH.'/template/admin/common/footer.php');

	// Show website
	ob_end_flush();
?>
