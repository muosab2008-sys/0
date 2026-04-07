<?php

if (!defined('BASEPATH')) {
	exit('Unable to view file.');
}

// Load Sidebar
require(BASE_PATH . '/template/' . $config['theme'] . '/common/sidebar.php');

$coins_value = number_format($data['account_balance'] / $config['coins_rate'], 2, '.', '');
?>
<main id="main" class="main">
	<div class="pagetitle margin-top">
		<h1>Withdraw </h1>
		
	</div>
	<section class="section">
		<div class="row">
<div class="col-lg-12">
    <div class="card" style="overflow:hidden;">
        <?php
        if ($proxy) {
            echo '<div class="alert alert-warning text-center mb-0" role="alert"><i class="bi bi-exclamation-triangle-fill"></i> <b>WARNING</b> <i class="bi bi-exclamation-triangle-fill"></i><br />You\'ve been detected using VPN / Proxy server, which is forbidden as per our <a href="' . GenerateURL('tos') . '">Terms of Service</a>.<br />Please disable your VPN / Proxy service, otherwise your account will be permanently suspended and your earnings will be voided.</div>';
        } else {
        ?>
            <div class="alert alert-warning text-center">
                <i class="bi bi-info-circle-fill"></i>
                You have <b><?php echo number_format($data['account_balance'], 2); ?> Coins</b>
                which are worth <b>$<?php echo number_format($coins_value, 2); ?></b>
            </div>
            <div class="card-header mb-0 pb-0">
                <h5 class="card-title fw-bold text-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                            <svg width="25px" class="text-primary" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path
                                    d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z">
                                </path>
                                <path
                                    d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z">
                                </path>
                            </svg> Withdraw Methods
                        </div>
                    </div>
                </h5>
            </div>
            <div class="card-body mb-0 pb-0">
                <form class="row g-3" method="POST" id="withdrawForm">
                    <div class="d-flex flex-row flex-nowrap overflow-auto" id="methods">
                        <div class="swiper mySwiper py-3 swiper-initialized swiper-horizontal swiper-backface-hidden"
                            x-init="new window.swiper($el, { slidesPerView: 'auto' })">
                            <div class="swiper-wrapper d-flex gap-2">
                                <?php
                                $methods = $db->QueryFetchArrayAll("SELECT * FROM `withdraw_methods` ORDER BY `minimum` ASC");
                                foreach ($methods as $method) {
                                    $disabled = ($coins_value < $method['minimum']) ? 'disabled' : '';
                                    $bg = !empty($method['bg_color']) ? $method['bg_color'] : 'linear-gradient(rgb(0, 184, 255), rgba(85, 164, 203, 0.36))';
                                    $img = !empty($method['image']) ? 'storage/' . $method['image'] : 'assets/img/default.png';

                                    echo '
                                    <div class="withdraw-card swiper-slide card text-white d-flex mx-2 shop-card" 
                                         style="background: ' . $bg . '; width: 140px; height: 232px;" 
                                         data-id="' . $method['id'] . '" ' . $disabled . '>
                                        <div class="card-body text-center align-items-center d-flex justify-content-center pb-0 mb-0">
                                            <img src="/assets/img/withdraw/' . $method['method'] . '.png" class="w-100 my-3 object-fit-contain mw-100" alt="">
                                        </div>
                                        <div class="card-footer text-center px-0 pt-0 mt-0">
                                            <span class="mb-1 fw-normal text-white h6 text-truncate d-block text-center" 
                                                  >' . $method['method'] . '</span>
                                        </div>
                                    </div>
                                    ';
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="method" name="method">

                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="amount" placeholder="Coins Amount" disabled>
                            <label for="amount">Coins Amount</label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-floating">
                            <textarea class="form-control" id="info" placeholder="Payment Info" disabled></textarea>
                            <label for="info" id="labelInfo">Payment Info</label>
                        </div>
                    </div>

                    <div class="col-md-8 mx-auto text-center" id="result">
                        Please select your withdrawal method!
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" style="margin-bottom: 24px;">Submit</button>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const methodCards = document.querySelectorAll("#methods .partner-card");
    const methodInput = document.getElementById("method");
    const amountInput = document.getElementById("amount");
    const infoInput = document.getElementById("info");
    const resultDiv = document.getElementById("result");

    methodCards.forEach(card => {
        card.addEventListener("click", function () {
            
            methodCards.forEach(c => c.classList.remove("border", "border-3", "border-primary"));

            
            this.classList.add("border", "border-3", "border-primary");

            
            methodInput.value = this.getAttribute("data-id");

            
            amountInput.removeAttribute("disabled");
            infoInput.removeAttribute("disabled");

            
            resultDiv.innerHTML = `<span class="text-success fw-bold">You selected: ${this.querySelector("span").innerText}</span>`;
        });
    });
});
</script>

			<div class="col-lg-12">
				<div class="table-responsive">
					<table class="table align-middle mb-0 small " style="font-weight: 600">
						<thead>
							<tr>
								<th>ID</th>
								<th>Method</th>
								<th>Time</th>
								<th>Amount</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
<?php
$requests = $db->QueryFetchArrayAll("SELECT * FROM `withdrawals` WHERE `user_id`='" . $data['id'] . "' ORDER BY `id` DESC");

if (count($requests) == 0) {
    echo '<tr><td colspan="5" class="text-center">There is nothing here yet!</td></tr>';
} else {
    foreach ($requests as $request) {
        $date  = date('d M Y - h:i', $request['time']);
        $coins = number_format($request['coins']);

        
        if ($request['status'] == 0) {
            $status = '<span class="spinner-border spinner-border-sm text-primary" title="Pending"></span>';
        } elseif ($request['status'] == 1) {
            $status = '<i class="bi bi-patch-check-fill text-success" title="Sent"></i>';
        } elseif ($request['status'] == 3) {
            $status = '<i class="bi bi-arrow-counterclockwise text-warning" title="Returned"></i>';
        } else {
            $reason = htmlspecialchars($request['reason']);
            $status = '<i class="bi bi-x-octagon-fill text-danger" title="Rejected: ' . $reason . '"></i>';
        }

        echo "
        <tr>
            <td class='d-flex align-items-center gap-2'>
                {$request['id']}
            </td>
            <td>{$request['method_name']}</td>
            <td>{$date}</td>
            <td class='text-truncate'>
                <div class='d-flex align-items-center'>
                    <img src='assets/img/coin.png' alt='' width='13' class='me-1'>
                    <span style='font-size: 13px'>{$coins}</span>
                </div>
            </td>
            <td>{$status}</td>
        </tr>";
    }
}
?>





						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
</main>

<?php
$footer_js = '$(document).ready(function() {
  var minWithdraw = 0;

  function calculateAmount(amount) {
    $.ajax({
      type: "GET",
      url: "system/ajax.php",
      data: { a: "calculateWithdraw", amount: amount },
      success: function(a) {
        $("#result").html(a);
      }
    });
  }

  // اختيار كرت طريقة السحب
  $(document).on("click", ".shop-card:not(.disabled)", function() {
    $(".shopcard").removeClass("active");
    $(this).addClass("active");
    var method = $(this).data("id");
    $("#method").val(method);

    $.ajax({
      type: "GET",
      url: "system/ajax.php",
      data: { a: "getWithdraw", id: method },
      dataType: "json",
      success: function(a) {
        $("#info").attr("placeholder", a.payInfo);
        $("#labelInfo").html(a.payInfo);
        $("#info").prop("disabled", false);
        $("#amount").prop("disabled", false);
        $("#amount").val(a.min);
        $("#amount").attr("min", a.min);
        calculateAmount(a.min);
        minWithdraw = a.min;
      }
    });
  });

  // تغيير المبلغ
  $(document).on("input change", "#amount", function() {
    calculateAmount($(this).val());
  });

  // ارسال الفورم
  $(document).on("submit", "#withdrawForm", function(e) {
    e.preventDefault();
    var info = $("#info").val();
    var method = $("#method").val();
    var amount = $("#amount").val();

    $("#result").html(\'<div class="alert alert-info"><div class="spinner-border spinner-border-sm"></div> Please wait...</div>\');

    if (!info || !method || !amount) {
      $("#result").html(\'<div class="alert alert-danger">Please complete all fields!</div>\');
      return;
    }

    if (parseFloat(amount) < parseFloat(minWithdraw)) {
      $("#result").html(\'<div class="alert alert-danger">You should withdraw at least \' + minWithdraw + \' Coins!</div>\');
      return;
    }

    $.ajax({
      type: "POST",
      url: "system/ajax.php",
      data: { a: "sendWithdraw", method: method, amount: amount, info: info },
      dataType: "json",
      success: function(a) {
        $("#result").html(a.message);
      }
    });
  });
});';
?>