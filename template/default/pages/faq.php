<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }

	// Load Sidebar
	require(BASE_PATH.'/template/'.$config['theme'].'/common/sidebar.php');
	
	$faqs = $db->QueryFetchArrayAll("SELECT * FROM `faq` ORDER BY `id` ASC");
?> 
<main id="main" class="main">
<div class="pagetitle margin-top">
  <h1>Frequently Asked Questions</h1>
</div>
<section class="section">
  <div class="row">
	<div class="col-lg-12">
	  <div class="card">
		<div class="card-body p-2">
			<?php
				if(count($faqs) == 0){
					echo '<div class="alert alert-info" role="alert">'.$lang['l_121'].'</div>';
				}
			?>
			<div class="accordion accordion-flush" id="faq-group">
			  <?php
				$j = 0;
				foreach($faqs as $faq){
					$j++;
			  ?>
				<div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-target="#faq-<?=$j?>" type="button" data-bs-toggle="collapse">
                      <?=$faq['question']?>
                    </button>
                  </h2>
                  <div id="faq-<?=$j?>" class="accordion-collapse collapse" data-bs-parent="#faq-group">
                    <div class="accordion-body">
                      <?=BBCode(nl2br($faq['answer']))?>
                    </div>
                  </div>
                </div>
			  <?php } ?>
			</div>
	  </div>
	</div>
  </div>
</section>
</main>