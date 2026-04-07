<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }
	
	// Load Sidebar
	require(BASE_PATH.'/template/'.$config['theme'].'/common/sidebar.php');

	$refs = $db->QueryFetchArray("SELECT COUNT(*) AS `total` FROM `users` WHERE `ref`='".$data['id']."'");
	$cms = $db->QueryFetchArray("SELECT SUM(`commission`) AS `total` FROM `ref_commissions` WHERE `user`='".$data['id']."'");
?>
<main id="main" class="main">
<div class="pagetitle">
  <h1>Invite Friends</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="/">Home</a></li>
	  <li class="breadcrumb-item">Invite Friends</li>
	</ol>
  </nav>
</div>
<section class="section">
  <div class="row">
	<div class="col-lg-12">
	  <div class="card">
		<div class="card-body p-2">
			<div class="infobox">
				<h1>Invite your friends to get more coins!</h1>
				<p><center>Invite your friends using your special affiliate URL and receive <b><?php echo $config['ref_com']; ?>% of their earnings</b> for life!</center></p>
				<div class="affiliate-url d-flex justify-content-center mb-3">
					<div class="form-group">
						<i class="bi bi-link"></i>
						<input type="text" class="form-control text-center" value="<?php echo $config['secure_url']; ?>/?ref=<?php echo $data['ref_code']; ?>" onclick="this.select()" readonly>
					</div>
				</div>
				<div class="sharethis-inline-share-buttons" data-title="Join now to earn FREE Gift Cards!" data-description="Register for FREE and win Gift Cards!" data-url="<?php echo $config['secure_url']; ?>/?ref=<?php echo $data['ref_code']; ?>"></div>
			</div>
			<div id="aff-block" class="infobox pb-4">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="50%">
							<p class="aff_block_p">Total Referrals:</p>
							<a class="aff_block_p2" href="<?=GenerateURL('referrals')?>"><?php echo number_format($refs['total']); ?> referrals</a>
						</td>
						<td width="50%">
							<p class="aff_block_p">Referrals Earnings:</p>
							<a class="aff_block_p2" href="<?=GenerateURL('collected')?>"><?php echo number_format($cms['total'], 2); ?> <font class="text-success">coins</font></a>
						</td>
					</tr>
				</table>
			</div>
			<div class="clearfix"></div>
			<div class="infobox w-100">              
				<div class="aff-banner-title w-50">Banner (468x60)</div><br> 
				<table width="100%" border="0" cellpadding="3" cellspacing="1">
					<tr>
						<td valign="top" align="center">
							<img src="<?=$config['secure_url']?>/promo/468x60.png" class="img-fluid" border="0" />
						</td>
					</tr>
					<tr>    
						<td valign="top" align="center">
							<b>HTML Code</b><br>
							<textarea class="form-control w-75" onclick="this.select()" row="3" readonly="true"><a href="<?=$config['secure_url']?>/?ref=<?=$data['ref_code']?>" target="_blank"><img src="<?=$config['secure_url']?>/promo/468x60.png" alt="<?=$config['site_name']?>" border="0" /></a></textarea>
						</td>
					</tr>
					<tr>    
						<td valign="top" align="center">
							<b>BB Code</b><br>
							<textarea class="form-control w-75" onclick="this.select()" row="1" readonly="true">[url=<?=$config['secure_url']?>/?ref=<?=$data['ref_code']?>][img]<?=$config['secure_url']?>/promo/468x60.png[/img][/url]</textarea>                        
						</td>
					</tr>                   
				</table>
			</div>
		</div>
	  </div>
	</div>
  </div>
</section>
</main>
<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=6139fc40fb5a650012810e9c&product=inline-share-buttons" async="async"></script>