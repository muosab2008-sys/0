<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }

	$errMessage = '';
	if(isset($_POST['change_pass']))
	{
		if (securePassword($_POST['old_password']) != $data['password']) {
			$errMessage = '<div class="alert alert-danger" role="alert"><b>ERROR:</b> Your current password doesn\'t match our records!</div>';
		}elseif(!checkPwd($_POST['password'],$_POST['password2'])) {
			$errMessage = '<div class="alert alert-danger" role="alert"><b>ERROR:</b> Your new password is to easy or passwords doesn\'t match!</div>';
		}else{
			$enpass = securePassword($_POST['password']);
			$db->Query("UPDATE `users` SET `password`='".$enpass."' WHERE `id`='".$data['id']."'");
			$errMessage = '<div class="alert alert-success" role="alert"><b>SUCCESS!</b> Your password was successfully updated!</div>';
		}
	}
	
	if(isset($_POST['change_email']))
	{
		$email = $db->EscapeString($_POST['email']);
		$password = $db->EscapeString($_POST['password']);

		if (securePassword($_POST['password']) != $data['password']) {
			$errMessage = '<div class="alert alert-danger" role="alert"><b>ERROR:</b> Your current password doesn\'t match our records!</div>';
		}elseif(!isEmail($email)) {
			$errMessage = '<div class="alert alert-danger" role="alert"><b>ERROR:</b> Please enter a valid email address!</div>';
		}elseif($db->QueryGetNumRows("SELECT id FROM `users` WHERE `email`='".$email."' LIMIT 1") > 0 && $data['email'] != $email){
			$errMessage = '<div class="alert alert-danger" role="alert"><b>ERROR:</b> This email address is already registered!</div>';
		}else{
			$db->Query("UPDATE `users` SET `email`='".$email."' WHERE `id`='".$data['id']."'");
			$errMessage = '<div class="alert alert-success" role="alert"><b>SUCCESS!</b> Your email address was successfully updated!</div>';
		}
	}

    if(isset($_POST['del_acc'])){
        $pass = securePassword($_POST['password']);
        if($db->QueryGetNumRows("SELECT id FROM `users` WHERE `id`='".$data['id']."' AND `password`='".$pass."'") == 0){
            $errMessage = '<div class="alert alert-danger" role="alert"><b>ERROR:</b> Your current password doesn\'t match!</div>';
        }else{
            $db->Query("INSERT INTO `users_deleted` (`id`,`email`,`login`,`pass`,`sex`,`country_id`,`time`) values('".$data['id']."','".$data['email']."','".$data['username']."','".$data['password']."','".$data['gender']."','".$data['country_id']."',NOW())");
            $db->Query("DELETE FROM `users` WHERE `id` = '".$data['id']."' AND `password`='".$pass."'");
            if(isset($_COOKIE['SesToken'])){
                setcookie('SesToken', '0', time()-604800);
            }
            session_destroy();
            redirect($config['secure_url']);
        }
    }
		
	// Load Sidebar
	require(BASE_PATH.'/template/'.$config['theme'].'/common/sidebar.php');
?> 
<main id="main" class="main">
<div class="pagetitle margin-top">
  <h1> Account Information</h1>
  
</div>
<section class="section">
  <div class="row">
	<div class="col-lg-12">
	<?=$errMessage?>
	  <div class="card">
		<div class="card-body p-2">
			<h5 class="card-title">Change Email Address</h5>
			<form method="post">
			  <div class="row">
				<div class="form-group col-md-6">
				  <label for="email" class="form-label">Email Address</label>
				  <div class="input-group mb-3">
					<span class="input-group-text"><i class="bi bi-envelope"></i></span>
					<input type="email" id="email" name="email" class="form-control" placeholder="<?=$data['email']?>">
				  </div>
				</div>
				<div class="form-group col-md-6">
				  <label for="password" class="form-label">Password</label>
				  <div class="input-group mb-3">
					<div class="input-group-text"><i class="bi bi-file-earmark-lock2"></i></div>
					<input type="password" class="form-control" id="password" name="password" placeholder="******">
					<input type="submit" class="btn btn-primary d-inline" name="change_email" value="Save" />
				  </div>
				</div>
			  </div>
			</form>
		</div>
	  </div>
	  <div class="card" style ="margin-top: 17px;">
		<div class="card-body p-2">
		  <h5 class="card-title">Change Password</h5>
		  <div class="content">
			<form method="post">
			  <div class="row">
				<div class="form-group col-md-6">
				  <label for="password" class="form-label">New Password</label>
				  <div class="input-group mb-3">
					<div class="input-group-text"><i class="bi bi-file-earmark-lock2"></i></div>
					<input type="password" class="form-control" id="password" name="password" placeholder="Shd67SHB">
				  </div>
				</div>
				<div class="form-group col-md-6">
				  <label for="password2" class="form-label">Repeat Password</label>
				  <div class="input-group mb-3">
					<div class="input-group-text"><i class="bi bi-file-earmark-lock2"></i></div>
					<input type="password" class="form-control" id="password2" name="password2" placeholder="Shd67SHB">
				  </div>
				</div>
			  </div>
			  <div class="form-row">
				<div class="form-group col-md-6">
				  <label for="old_password" class="form-label">Old Password</label>
				  <div class="input-group mb-3">
					<div class="input-group-text"><i class="bi bi-file-earmark-lock2"></i></div>
					<input type="password" class="form-control" id="old_password" name="old_password" placeholder="*******">
					<input type="submit" class="btn btn-primary d-inline" name="change_pass" value="Save" />
				  </div>
				</div>
			  </div>
			</form>
		  </div>
		</div>
	  </div>
	  <div class="card" style ="margin-top: 17px;">
	    <div class="card-body p-2">
		  <h5 class="card-title">Delete Account</h5>
		  <form method="post">
			<div class="form-group col-md-6">
			  <label for="password" class="form-label">Password</label>
			  <div class="input-group mb-3">
				<div class="input-group-text"><i class="bi bi-file-earmark-lock2"></i></div>
				<input type="password" class="form-control" id="password" name="password" placeholder="Shd67SHB">
				<input type="submit" class="btn btn-danger d-inline" name="del_acc" value="Delete" onclick="return confirm('You sure you want to delete your account?');" />
			  </div>
			</div>
		  </form>
	    </div>
	  </div>
    </div>
  </div>
</section>
</main>