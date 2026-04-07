<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }
	
	// Load required files
	include(BASE_PATH.'/system/libs/geoip2/autoload.php');
	use MaxMind\Db\Reader;

	function executeSql($sqlFileToExecute){
		$templine = '';
		$lines    = file($sqlFileToExecute);
		$impError = 0;
		foreach($lines as $line) {
			if(substr($line, 0, 2) == '--' || $line == '')
				continue;
			$templine .= $line;
			if (substr(trim($line), -1, 1) == ';') {
				if (!mysql_query($templine)) {
					$impError = 1;
				}
				$templine = '';
			}
		}
		if ($impError == 0) {
			return 'Script is executed succesfully!';
		} else {
			return 'An error occured during SQL importing!';
		}
	}

	function redirect($location){
		$hs = headers_sent();
		if($hs === false){
			header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
			header('Location: '.$location);
		}elseif($hs == true){
			$location = strtr($location, array("'" => '', '"' => ''));
			echo "<script>document.location.href='".$location."'</script>";
		}
		exit(0);
	}

	function validatePassword($x){
		if(empty($x) || strlen($x) < 8) { return false; }
		if (!preg_match("#[0-9]+#",$x)) { return false; } 
		if (!preg_match("#[A-Z]+#",$x)) { return false; } 
		if (!preg_match("#[a-z]+#",$x)) { return false; } 

		return true;
	}
	
	function checkPwd($x,$y){
		if(empty($x) || empty($y) ) { return false; }
		if (strlen($x) < 8 || strlen($y) < 8) { return false; }
		if (strcmp($x,$y) != 0) { return false; } 
		if (!preg_match("#[0-9]+#",$x)) { return false; } 
		if (!preg_match("#[A-Z]+#",$x)) { return false; } 
		if (!preg_match("#[a-z]+#",$x)) { return false; } 

		return true;
	}

	function VisitorIP(){ 
		if(isset($_SERVER['HTTP_CLIENT_IP']) && filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
		{
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}

	function isEmail($email){
		return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? true : false;
	}

	function isUserID($username){
		return preg_match('/^[a-z\d_]{4,20}$/i', $username) ? true : false;
	}

	function GetHref($value){
		$qS = preg_replace(array('/p=[^&]*&?/', '/&$/'), array('', ''), $_SERVER['QUERY_STRING']);
		
		if (!empty($qS)){
			$qS.= '&';
		}
		
		return '?'.$qS.$value;
	}

	function truncate($str, $length, $trailing='...'){
		if(function_exists('mb_strlen') && function_exists('mb_substr')){
			$length-=mb_strlen($trailing);
			if(mb_strlen($str)> $length){
				return mb_substr($str,0,$length).$trailing;
			}else{
				return $str;
			}
		}else{
			return $str;
		}
	} 

	function get_data($url, $timeout = 15, $header = array(), $options = array()){
		if(!function_exists('curl_init')){
			return file_get_contents($url);
		}elseif(!function_exists('file_get_contents')){
			return '';
		}

		if(empty($options)){
			$options = array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
				CURLOPT_TIMEOUT => $timeout
			);
		}
		
		if(empty($header)){
			$header = array(
				"Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*\/*;q=0.5",
				"Accept-Language: en-us,en;q=0.5",
				"Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7",
				"Cache-Control: must-revalidate, max-age=0",
				"Connection: keep-alive",
				"Keep-Alive: 300",
				"Pragma: public"
			);
		}

		if($header != 'NO_HEADER'){
			$options[CURLOPT_HTTPHEADER] = $header;
		}
				
		$ch = curl_init();
		curl_setopt_array($ch, $options);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	function BBCode($string){
		$search = array(
				'/(\[b\])(.*?)(\[\/b\])/',
				'/(\[i\])(.*?)(\[\/i\])/',
				'/(\[u\])(.*?)(\[\/u\])/',
				'/(\[ul\])(.*?)(\[\/ul\])/',
				'/(\[li\])(.*?)(\[\/li\])/',
				'/(\[center\])(.*?)(\[\/center\])/',
				'/(\[img\])(.*?)(\[\/img\])/',
				'/(\[url=)(.*?)(\])(.*?)(\[\/url\])/',
				'/(\[url\])(.*?)(\[\/url\])/'
		);
		$replace = array(
				'<b>$2</b>',
				'<em>$2</em>',
				'<u>$2</u>',
				'<ul>$2</ul>',
				'<li>$2</li>',
				'<center>$2</center>',
				'<img src="$2" alt="" />',
				'<a href="$2" target="_blank">$4</a>',
				'<a href="$2" target="_blank">$2</a>'
		);
		return preg_replace($search, $replace, $string);
	}
	 
	function percent($num_amount, $num_total){
		$count = ($num_amount/$num_total)*100;
		return number_format($count,0);
	}

	function get_country($id){
		global $db;
		$id = $db->EscapeString($id);
		$country = $db->QueryFetchArray("SELECT country FROM `list_countries` WHERE `id`='".$id."' LIMIT 1");
		return $country['country'];
	}

	function get_gender($id, $man='Man', $woman='Woman', $unknow='Unknown'){
		$gender = ($id == 1 ? $man : ($id == 2 ? $woman : $unknow));
		return $gender;
	}

	function round_up($value, $precision) { 
		$pow = pow(10, $precision); 
		return (ceil($pow * $value) + ceil($pow * $value - ceil($pow * $value))) / $pow; 
	}

	// Calculate remaining time
	function remainingTime($seconds) {
		$measures = array(
			'day'=>24*60*60,
			'hour'=>60*60,
			'minute'=>60,
			'second'=>1,
		);
		foreach ($measures as $label=>$amount) {
			if ($seconds >= $amount) {  
				$howMany = floor($seconds / $amount);
				return $howMany." ".$label.($howMany > 1 ? "s" : "");
			}
		} 
	}

	// Notifications
	function add_activity($user_id, $notify, $value = null) {
		global $db;
		
		if(!empty($user_id) && !empty($notify)){
			$db->Query("INSERT INTO `users_activities` (`user_id`,`notify_id`,`value`,`time`) VALUES ('".$user_id."','".$notify."','".$value."','".time()."')");
		}
	}

	function get_activity($notify, $values, $time, $read = 1, $type = 0) {
		$message = '';
		$time = date('d M Y - H:i', $time);
		$value = unserialize($values);
		switch($notify) {
			case 1:
				if($type == 1)
				{
					$message = '<div class="activity-item d-flex">
								  <div class="activite-label">'.$time.'</div>
								  <i class="bi bi-circle-fill activity-badge text-success align-self-start"></i>
								  <div class="activity-content">
									Offer <b>#'.$value['id'].'</b> was completed! You received <b>'.number_format($value['reward']).' coins</b>.
								  </div>
								</div>';
				}
				else
				{
					$message = '<tr><td class="bg-success notify-icon"><i class="bi bi-check-circle-fill notify-icon-bi text-light"></i></td><td>Offer <b>#'.$value['id'].'</b> was completed! You received <b>'.number_format($value['reward']).' coins</b>.<br /><span class="small text-muted">'.$time.($read == 0 ? ' <span class="badge bg-info text-dark">New</span>' : '').'</span></td></tr>';
				}

				break;
			case 2:
				if($type == 1)
				{
					$message = '<div class="activity-item d-flex">
								  <div class="activite-label">'.$time.'</div>
								  <i class="bi bi-circle-fill activity-badge text-primary align-self-start"></i>
								  <div class="activity-content">
									Offer <b>#'.$value['id'].'</b> is pending validation! <b>'.number_format($value['reward']).' coins</b> are now in pending balance.
								  </div>
								</div>';
				}
				else
				{
					$message = '<tr><td class="bg-primary notify-icon"><i class="bi bi-check-circle notify-icon-bi text-light"></i></td><td>Offer <b>#'.$value['id'].'</b> is pending validation! <b>'.number_format($value['reward']).' coins</b> are now in pending balance.<br /><span class="small text-muted">'.$time.($read == 0 ? ' <span class="badge bg-info text-dark">New</span>' : '').'</span></td></tr>';
				}

				break;
			case 3:
				if($type == 1)
				{
					$message = '<div class="activity-item d-flex">
								  <div class="activite-label">'.$time.'</div>
								  <i class="bi bi-circle-fill activity-badge text-danger align-self-start"></i>
								  <div class="activity-content">
									Offer <b>#'.$value['id'].'</b> was cancelled! <b>'.$value['reward'].' coins</b> were deducted from your balance.
								  </div>
								</div>';
				}
				else
				{
					$message = '<tr><td class="bg-danger notify-icon"><i class="bi bi-x-circle-fill notify-icon-bi text-light"></i></td><td>Offer <b>#'.$value['id'].'</b> was cancelled! <b>'.$value['reward'].' coins</b> were deducted from your balance.<br /><span class="small text-muted">'.$time.($read == 0 ? ' <span class="badge bg-info text-dark">New</span>' : '').'</span></td></tr>';
				}

				break;
			case 4:
				if($type == 1)
				{
					$message = '<div class="activity-item d-flex">
								  <div class="activite-label">'.$time.'</div>
								  <i class="bi bi-circle-fill activity-badge text-warning align-self-start"></i>
								  <div class="activity-content">
									New referral (<b>#'.$value['id'].'</b>) successfully registered.
								  </div>
								</div>';
				}
				else
				{
					$message = '<tr><td class="bg-warning notify-icon"><i class="bi bi-person-plus-fill notify-icon-bi text-light"></i></td><td>New referral (<b>#'.$value['id'].'</b>) successfully registered.<br /><span class="small text-muted">'.$time.($read == 0 ? ' <span class="badge bg-info text-dark">New</span>' : '').'</span></td></tr>';
				}

				break;
			case 5:
				if($type == 1)
				{
					$message = '<div class="activity-item d-flex">
								  <div class="activite-label">'.$time.'</div>
								  <i class="bi bi-circle-fill activity-badge text-info align-self-start"></i>
								  <div class="activity-content">
									You withdrawn <b>'.$value['amount'].' coins</b>.
								  </div>
								</div>';
				}
				else
				{
					$message = '<tr><td class="bg-info notify-icon"><i class="bi bi-cart-dash-fill notify-icon-bi text-light"></i></td><td>You withdrawn <b>'.$value['amount'].' coins</b>.<br /><span class="small text-muted">'.$time.($read == 0 ? ' <span class="badge bg-info text-dark">New</span>' : '').'</span></td></tr>';
				}

				break;
			case 6:
				if($type == 1)
				{
					$message = '<div class="activity-item d-flex">
								  <div class="activite-label">'.$time.'</div>
								  <i class="bi bi-circle-fill activity-badge text-info align-self-start"></i>
								  <div class="activity-content">
									Task <b>#'.$value['id'].'</b> was approved and you received <b>'.$value['reward'].' coins</b>.
								  </div>
								</div>';
				}
				else
				{
					$message = '<tr><td class="bg-info notify-icon"><i class="bi bi-card-checklist notify-icon-bi text-light"></i></td><td>Task <b>#'.$value['id'].'</b> was approved and you received <b>'.$value['reward'].' coins.<br /><span class="small text-muted">'.$time.($read == 0 ? ' <span class="badge bg-info text-dark">New</span>' : '').'</span></td></tr>';
				}

				break;
		}
		
		return $message;
	}

	// Detect Proxy
	function detectProxy($ip_address)
	{
		global $config, $db;
		
		// Define default result
		$ip_result = array();
		$ip_result['status'] = 99;
		$ip_result['country'] = 'N/A';
		$ip_result['risk'] = 0;
		
		// Check with proxycheck.io
		if($config['proxycheck_status'] == 1)
		{
			$checkIP = $db->QueryFetchArray("SELECT * FROM `ip_checks` WHERE `ip_address`='".$ip_address."' LIMIT 1");
			if(empty($checkIP['ip_address']) || $checkIP['status'] == 99)
			{
				$result = get_data('https://proxycheck.io/v2/'.$ip_address.'?key='.$config['proxycheck'].'&vpn=1&asn=1&time=1&inf=1&risk=1&tag=OfferWall', 5, 'NO_HEADER');
				$result = json_decode($result, true);

				if(!empty($result['status']) && $result['status'] == 'ok')
				{
					$ip_result['status'] = ($result[$ip_address]['proxy'] == 'yes' ? 1 : 0);
					$ip_result['country'] = (empty($result[$ip_address]['isocode']) ? 'N/A' : $result[$ip_address]['isocode']);
					$ip_result['risk'] = (empty($result[$ip_address]['risk']) ? 0 : $result[$ip_address]['risk']);

					$db->Query("INSERT INTO `ip_checks` (`ip_address`,`country_code`,`status`,`risk_score`,`time`) VALUES ('".$ip_address."','".$ip_result['country']."','".$ip_result['status']."','".$ip_result['risk']."','".time()."') ON DUPLICATE KEY UPDATE `country_code`='".$ip_result['country']."', `status`='".$ip_result['status']."', `risk_score`='".$ip_result['risk']."', `time`='".time()."'");
				}
			}
			else
			{
				$ip_result['status'] = $checkIP['status'];
				$ip_result['country'] = $checkIP['country_code'];
				$ip_result['risk'] = $checkIP['risk_score'];
			}
		}
		
		return $ip_result;
	}

	// Detect Country
	function detectCountry($ip)
    {
        try {
            $reader = new Reader(BASE_PATH.'/system/libs/geoip2/maxmind-db/GeoLite2-Country.mmdb');
            $record = $reader->get($ip);
			$reader->close();
            $countryCode = (trim($record['country']['iso_code'])) ? $record['country']['iso_code'] : 'N/A';
        } catch (\Exception $ex) {
            $countryCode = 'N/A';
        }

        return $countryCode;
    }

	// Referral Commissions
	function ref_commission($user, $referral, $commission, $date = 0) {
		global $db;
		
		$date = (empty($date) ? time() : $date);
		
		if(!empty($user) && !empty($referral) && !empty($commission)){
			$db->Query("UPDATE `users` SET `account_balance`=`account_balance`+'".$commission."' WHERE `id`='".$user."'");
			$db->Query("INSERT INTO `ref_commissions` (`user`,`referral`,`commission`,`date`) VALUES ('".$user."','".$referral."','".$commission."','".$date."') ON DUPLICATE KEY UPDATE `commission`=`commission`+'".$commission."', `date`='".$date."'");
		}
	}

	// Unique Key
	function GenerateKey($n = 10, $specialChars = false)
	{
		$key = '';
		$pattern = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

		if($specialChars){
			$pattern .= '!@#$%^&*()=+';
		}

		$counter = strlen($pattern)-1;
		for($i=0; $i<$n; $i++)
		{
			$key .= $pattern[rand(0,$counter)];
		}

		return $key;
	}

	// Security Tokens
	function GenToken()
	{
		$token = md5(uniqid(mt_rand().microtime()));
		return $token;
	}

	function GenGlobalToken()
	{
		$_SESSION['token'] = GenToken();
		return $_SESSION['token'];
	}

	function GenRegisterToken()
	{
		$_SESSION['register_token'] = GenToken();
		return $_SESSION['register_token'];
	}

	// Encrypt Password
	function securePassword($pass)
	{
		$hash = md5(md5(sha1($pass).sha1(md5($pass))));

		return $hash;
	}

	// Generate URL
	function GenerateURL($page, $full = false, $admin = false) {
		global $config;

		$url = ($admin ? 'admin.php' : '').'?page='.$page;
		if($config['mod_rewrite'] == 1)
		{
			parse_str($url, $url_array);
			$url_vars = array('x','y','edit', 'delete', 'pay', 'refund', 'reject', 'confirm', 'recover', 'activate');
			
			$url = ($admin ? 'admin/page' : 'page');
			foreach($url_array as $var => $val)
			{
				if(in_array($var, $url_vars))
				{
					$url .= '/'.$var.'/'.$val;
				}
				else
				{
					$url .= '/'.$val;
				}
			}
			$url = $url.'.html';

			if($full == true) {
				$url = $config['secure_url'].'/'.$url;
			}
		}
		elseif($full == true)
		{
			$url = $config['secure_url'].'/'.$url;
		}
		
		return $url;
	}
?>