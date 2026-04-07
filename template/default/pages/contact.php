<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }

	$errMessage = '<div class="alert alert-info" role="alert">Please use English to send your message, otherwise we won\'t be able to answer!</div>';
	if(isset($_POST['send']))
	{
		$captcha_valid = 1;
		if(!empty($config['recaptcha_sec'])){
			$recaptcha = new \ReCaptcha\ReCaptcha($config['recaptcha_sec']);
			$recaptcha = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
		
			if($recaptcha->isSuccess()){
				$captcha_valid = 1;
			}else{
				$captcha_valid = 0;
			}
		}

		if(!$captcha_valid){
			$errMessage = '<div class="alert alert-danger" role="alert"><b>ERROR:</b> Please complete our security step!</div>';
		}elseif(empty($_POST['name'])){
			$errMessage = '<div class="alert alert-danger" role="alert"><b>ERROR:</b> Please enter a valid name!</div>';
		}elseif(empty($_POST['email'])){
			$errMessage = '<div class="alert alert-danger" role="alert"><b>ERROR:</b> Please enter a valid email address!</div>';
		}elseif(empty($_POST['subject'])){
			$errMessage = '<div class="alert alert-danger" role="alert"><b>ERROR:</b> Please complete your subject!</div>';
		}elseif(empty($_POST['message'])){
			$errMessage = '<div class="alert alert-danger" role="alert"><b>ERROR:</b> Your message must have at least 25 characters!</div>';
		}else{
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
			$mailer->addReplyTo($_POST['email'], $_POST['name']);
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
												<b>Sender Name:</b> '.$_POST['name'].'<br />
												<b>Sender Email:</b> '.$_POST['email'].'<br />
												<b>Subjectl:</b> '.$_POST['subject'].'<br />
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

			$errMessage = '<div class="alert alert-success" role="alert"><b>SUCCESS:</b> Thank you, we will reply to you as soon as possible!</div>';
		}
	}

	// Load Sidebar
	require(BASE_PATH.'/template/'.$config['theme'].'/common/sidebar.php');
?> 
<main id="main" class="main">
<div class="pagetitle margin-top">
  <h1>Contact Us</h1>
</div>
<section class="section">
  <div class="col-lg-12">
	<?=$errMessage?>
	<div class="card">
	  <div class="card-body p-2">
		<form method="post">
		  <div class="row">
			<div class="form-group col-md-6">
			  <label for="name" class="form-label">Your Name</label>
			  <div class="input-group mb-3">
				<div class="input-group-text"><i class="bi bi-file-person-fill"></i></div>
				<input type="text" class="form-control" id="name" name="name" placeholder="John_Doe" required="required">
			  </div>
			</div>
			<div class="form-group col-md-6">
			  <label for="email" class="form-label">Email Address</label>
			  <div class="input-group mb-3">
				<div class="input-group-text"><i class="bi bi-envelope-fill"></i></div>
				<input type="email" class="form-control" id="email" name="email" placeholder="name@domain.com" required="required">
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="form-group col-md-6">
			  <label for="subject" class="form-label">Subject</label>
			  <div class="input-group mb-3">
				<div class="input-group-text"><i class="bi bi-patch-question"></i></div>
				<input type="text" class="form-control" id="subject" name="subject" placeholder="How can we help you?" required="required">
			  </div>
			</div>
		  </div>
		  <div class="form-row mb-2">
			<div class="form-group col-md-12">
			  <label for="message" class="form-label">Message</label>
			  <textarea class="form-control" id="message" name="message" rows="3" required="required" placeholder="Message"></textarea>
			</div>
		  </div>
			<?php 
				if(!empty($config['recaptcha_pub'])){
					echo '<script src="https://www.google.com/recaptcha/api.js"></script><div class="g-recaptcha mb-2" data-sitekey="'.$config['recaptcha_pub'].'"></div>';
				}
			?>
		  <div class="col-md-12 text-center">
			<button type="submit" name="send" class="btn btn-lg btn-primary">Send Message</button>
		  </div>
		</form>
	  </div>
	</div>
  </div>
</section>
</main>