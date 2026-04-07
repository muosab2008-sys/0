<?php
if (!defined('BASEPATH')) {
    exit('Unable to view file.');
}

// Load Sidebar
require(BASE_PATH . '/template/' . $config['theme'] . '/common/sidebar.php');

// Load offerwall settings
$ow_config = array();
$ow_configs = $db->QueryFetchArrayAll("SELECT `config_name`,`config_value` FROM `offerwall_config`");
foreach ($ow_configs as $con) {
    $ow_config[$con['config_name']] = $con['config_value'];
}
unset($ow_configs);


$currentUser = $db->QueryFetchArray("
	SELECT id, username 
	FROM users 
	WHERE id='" . intval($_SESSION['PT_User']) . "'
");

?>
<div class="container-fluid margin-top" x-data="">
    <div class="d-flex justify-content-start mt-2 small">
        <div class="swiper"
            x-init="new window.swiper($el, { slidesPerView: 'auto', autoplay: { delay: 5000, disableOnInteraction: false } })">
            <div class="swiper-wrapper" wire:ignore.self>
                <?php
                function time_ago($ts)
                {
                    $t = is_numeric($ts) ? (int) $ts : strtotime($ts);
                    $diff = time() - $t;
                    if ($diff < 60)
                        return 'Just now';
                    $units = [
                        31536000 => 'year',
                        2592000 => 'month',
                        604800 => 'week',
                        86400 => 'day',
                        3600 => 'hour',
                        60 => 'minute'
                    ];
                    foreach ($units as $sec => $name) {
                        if ($diff >= $sec) {
                            $val = floor($diff / $sec);
                            return $val . ' ' . $name . ($val > 1 ? 's' : '') . ' ago';
                        }
                    }
                    return 'Just now';
                }

                $offers = $db->QueryFetchArrayAll("
      SELECT a.id, a.campaign_name, a.reward, a.user_id, a.method, a.timestamp, b.username 
      FROM completed_offers a
      LEFT JOIN users b ON b.id = a.user_id
      WHERE a.status = '1'
    ");

                $withdrawals = $db->QueryFetchArrayAll("
      SELECT w.id, w.coins, w.amount, w.method_name, w.time, u.username, u.id AS user_id
      FROM withdrawals w
      LEFT JOIN users u ON u.id = w.user_id
      WHERE w.status != '0'
    ");

                if (!is_array($offers))
                    $offers = [];
                if (!is_array($withdrawals))
                    $withdrawals = [];

                $merged = [];
                foreach ($offers as $o) {
                    $merged[] = [
                        'type' => 'offer',
                        'id' => $o['id'],
                        'username' => $o['username'],
                        'user_id' => $o['user_id'],
                        'campaign' => $o['campaign_name'],
                        'method' => $o['method'],
                        'coins' => $o['reward'],
                        'ts' => (int) $o['timestamp']
                    ];
                }
                foreach ($withdrawals as $w) {
                    $merged[] = [
                        'type' => 'withdrawal',
                        'id' => $w['id'],
                        'username' => $w['username'],
                        'user_id' => $w['user_id'],
                        'campaign' => 'Withdrawal',
                        'method' => $w['method_name'],
                        'coins' => '-' . $w['coins'],
                        'ts' => (int) $w['time']
                    ];
                }

                usort($merged, function ($a, $b) {
                    return $b['ts'] - $a['ts'];
                });

                foreach ($merged as $item):
                    $username = htmlspecialchars($item['username']);
                    $ago = time_ago($item['ts']);
                    $coins = number_format((float) $item['coins']);
                    ?>
                    <div class="swiper-slide fade-in-scale card text-white me-2 p-2 activity-offers"
                        style="cursor: pointer; width: auto !important;" data-username="<?= $username ?>"
                        data-campaign="<?= $item['campaign'] ?>" data-coins="<?= $coins ?>" data-time="<?= $ago ?>"
                        data-method="<?= $item['method'] ?>">
                        <div class="card-body p-0 pb-0 text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <div class="d-flex justify-content-center rounded-circle align-items-center bg-secondary bg-opacity-50 text-white"
                                    style="width: 30px; height: 30px;">
                                    <span class="fw-bold"><?= strtoupper(substr($username, 0, 1)) ?></span>
                                </div>
                                <div class="d-flex flex-column text-start align-items-start">
                                    <span class="mb-0 small" style="font-size: 12px;">    <?= $username ?></span>
                                    <h6 class="text-secondary pb-0 mb-0" style="font-size: 11px;"><?= $ago ?></h6>
                                </div>
                                <div class="p-1">
                                    <span
                                        class="rounded badge bg-secondary bg-opacity-50 text-white d-flex align-items-center gap-1"
                                        style="line-height:0">
                                        <img src="/assets/img/coin.png" width="11px" alt="">
                                        <span><?= $coins ?></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="activityModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-3 shadow-lg border-0" style="background: #1e1e1e; color: #fff;">

                    <!-- Header -->
                    <div class="modal-header border-0 d-flex justify-content-between align-items-center">
                        <h5 class="modal-title fw-bold text-success mb-0" id="modalUsername">
                        </h5>
                        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"
                            aria-label="Close" style="filter: invert(1);"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body">
                        <div class="p-3 bg-dark rounded-3">
                            <p class="mb-2"><strong>Name:</strong> <span id="modalCampaign" class="text-primary"></span>
                            </p>
                            <p class="mb-2"><strong>Coins:</strong> <span id="modalCoins" class="text-warning"></span>
                            </p>
                            <p class="mb-2"><strong>Time:</strong> <span id="modalTime" class="text-info"></span></p>
                            <p class="mb-0"><strong>Method:</strong> <span id="modalMethod" class="text-success"></span>
                            </p>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer border-0 d-flex justify-content-center">
                        <button type="button" class="btn btn-success px-4 rounded-pill fw-bold" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>

                </div>
            </div>
        </div>


        <script>
            function initSwiper() {
                return new Swiper(".swiper", {
                    slidesPerView: "auto",
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false
                    },
                    loop: false
                });
            }

            document.addEventListener("DOMContentLoaded", () => {
                initSwiper();

                document.querySelectorAll(".activity-offers").forEach(card => {
                    card.addEventListener("click", () => {
                        document.getElementById("modalUsername").innerText = card.dataset.username;
                        document.getElementById("modalCampaign").innerText = card.dataset.campaign;
                        document.getElementById("modalCoins").innerText = card.dataset.coins;
                        document.getElementById("modalTime").innerText = card.dataset.time;
                        document.getElementById("modalMethod").innerText = card.dataset.method;

                        new bootstrap.Modal(document.getElementById("activityModal")).show();
                    });
                });
            });

            document.addEventListener("livewire:update", () => {
                initSwiper();
            });
        </script>

    </div>
</div>
<main id="main" class="main">
    <section class="section" style="">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header mb-0 pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="h5 card-title fw-bold text-white d-flex align-items-center gap-1">
                            <svg width="25px" class="text-primary" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.963 2.286a.75.75 0 0 0-1.071-.136 9.742 9.742 0 0 0-3.539 6.176 7.547 7.547 0 0 1-1.705-1.715.75.75 0 0 0-1.152-.082A9 9 0 1 0 15.68 4.534a7.46 7.46 0 0 1-2.717-2.248ZM15.75 14.25a3.75 3.75 0 1 1-7.313-1.172c.628.465 1.35.81 2.133 1a5.99 5.99 0 0 1 1.925-3.546 3.75 3.75 0 0 1 3.255 3.718Z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>Featured Offers</span>
                        </div>
                    </div>
                </div>

                <div class="card-body mb-0 pb-0">
                    <div style="overflow: hidden;">
                        <div class="mt-4">
                            <div class="swiper mySwiper swiper-backface-hidden">
                                <div class="swiper-wrapper swiper-offer d-flex">
                                    <?php
                                    $offers = $db->QueryFetchArrayAll("
                SELECT id, name, price, url, logo, description, provider
                FROM offers 
                ORDER BY id DESC
              ");

                                    if (empty($offers)) {
                                        echo '<div class="col-12 text-center"><div class="alert alert-info">There is nothing here yet!</div></div>';
                                    }

                                    foreach ($offers as $offer) {
                                        $logo = !empty($offer['logo']) ? $offer['logo'] : 'https://via.placeholder.com/150';
                                        $decodedUrl = urldecode($offer['url']);
                                        $finalUrl = str_replace('{uid}', $currentUser['id'], $decodedUrl);

                                        echo <<<HTML
<div class="swiper-slide fade-in-scale mb-3 swiper-offer-card" style="width: 220px;">
  <a class="card bg-dark bg-opacity-100 offer-card p-2"
     style="cursor: pointer; border: none; background: rgba(var(--bs-dark-rgb), var(--bs-bg-opacity)) !important;"
     data-bs-toggle="modal"
     data-bs-target="#offerModal"
     data-id="{$offer['id']}"
     data-name="{$offer['name']}"
     data-price="{$offer['price']}"
     data-url="{$finalUrl}"
     data-logo="{$logo}"
     data-description="{$offer['description']}"
     data-provider="{$offer['provider']}">
    <div class="card-img-block text-center align-items-center d-flex justify-content-center">
      <img class="card-img-top" style="border-radius: 10px"
           src="{$logo}"
           alt="{$offer['name']}"
           onerror="this.src='assets/img/Image-not-found.png'">

      <div class="badge bg-label-dark position-absolute"
           style="top: 10px; right: 10px; padding: 5px 8px; background-color: rgba(7,8,9,0.56) !important">
        <div class="d-flex align-items-center justify-content-center gap-2">
          <span class="fa-brands fa-android text-white"></span>
        </div>
      </div>

      <i class="fa-solid fa-play position-absolute text-white text-primary rounded-circle"
         style="background: rgba(var(--bs-primary-rgb), 0.30) !important"></i>
    </div>

    <div class="card-body p-0 pt-0 pb-3 small text-start">
      <span class="text-truncate text-white d-block mt-2 fw-semibold">{$offer['name']}</span>
      <span class="text-truncate text-secondary d-block fw-semibold">{$offer['description']}</span>
    </div>

    <div class="card-footer justify-content-between border-0 pt-0 pb-1 p-0 text-start">
      <div class="f-w-600 text-white">
        <span class="d-flex align-items-center fw-semibold">
          <img src="assets/img/coin.png" alt="" width="17px" class="me-1">
          <span style="font-size: 15px">{$offer['price']}</span>
        </span>
      </div>
    </div>
  </a>
</div>
HTML;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="offerModal" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-md modal-fullscreen-sm-down modal-dialog-centered">
                <div class="modal-content" style="    max-height: 50%;
">
                    <div class="modal-header">
                        <h4 class="modal-title text-body f-md" id="offerName">Loading...</h4>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <div class="d-flex">
                            <div class="position-relative">
                                <img id="offerLogo" src="" width="149" style="aspect-ratio: 1 / 1; border-radius: 10px"
                                    alt="">



                            </div>

                            <div class="gap-2 d-flex flex-column justify-content-start ms-3">
                                <!-- Provider -->
                                <span class="d-flex align-items-center badge bg-primary">
                                    <i class="fa-solid fa-rocket me-2"></i>
                                    <span id="offerProvider"></span>
                                </span>

                                <!-- Coins -->
                                <div>
                                    <span class="badge bg-dark d-flex align-items-center fw-medium"
                                        style="font-size: 13px; line-height: 0">
                                        <img src="assets/img/coin.png" alt="" width="12px" class="me-1">
                                        <span id="offerPrice"></span>
                                    </span>
                                </div>

                            </div>
                        </div>

                        <!-- Start -->
                        <div class="mt-auto mt-md-4">
                            <a id="offerUrl" href="#" target="_blank" class="btn btn-primary w-100"
                                style="margin-top: 31px;">
                                <i class="fa-solid fa-play me-2"></i> Start Offer
                            </a>
                        </div>

                        <!-- Description -->
                        <div class="mt-4">
                            <div class="mt-2 px-4 p-2 bg-opacity-50 bg-dark" style="border-radius: 20px;">
                                <p class="text-center text-body m-0 p-0" style="font-size: 11px" id="offerDescription">
                                </p>
                            </div>
                        </div>

                        <!-- Rewards -->
                        <div class="mt-4" id="offerRewards" style="display:none;">
                            <p class="text-body fw-bold m-0 p-0 f-md" style="font-size: 14px; line-height: 160%">Rewards
                            </p>
                            <div id="rewardsList"></div>
                        </div>

                        <!-- Steps -->
                        <div class="mt-4" id="offerSteps" style="display:none;">
                            <p class="fw-bold m-0 p-0 f-md" style="font-size: 14px; line-height: 160%">Steps</p>
                            <div id="stepsList"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                new Swiper(".mySwiper", {
                    slidesPerView: "auto",
                    grabCursor: true,
                    freeMode: true,
                    spaceBetween: 8,
                    centeredSlidesBounds: true
                });
            });
        </script>



        <script>
            // JavaScript to fill modal data
            var offerModal = document.getElementById('offerModal');

            offerModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;

                // Collect data from button
                var name = button.getAttribute('data-name');
                var price = button.getAttribute('data-price');
                var url = button.getAttribute('data-url');
                var logo = button.getAttribute('data-logo');
                var description = button.getAttribute('data-description');
                var provider = button.getAttribute('data-provider');


                // Get data from Modal
                var modalTitle = offerModal.querySelector('#offerName');       
                var modalPrice = offerModal.querySelector('#offerPrice');      
                var modalLogo = offerModal.querySelector('#offerLogo');       
                var modalUrl = offerModal.querySelector('#offerUrl');        
                var modalDesc = offerModal.querySelector('#offerDescription');
                var modalprovider = offerModal.querySelector('#offerProvider');

                // Inject data
                if (modalTitle) modalTitle.textContent = name;
                if (modalPrice) modalPrice.textContent = price;
                if (modalLogo) {
                    modalLogo.src = logo;
                    modalLogo.alt = name;
                }
                if (modalUrl) modalUrl.href = url;
                if (modalDesc) modalDesc.textContent = description;
                if (modalprovider) modalprovider.textContent = provider;
            });
        </script>



        <div class="col-lg-12">
            <div class="card" style="overflow:hidden;">
                <?php
                if ($proxy) {
                    echo '<div class="alert alert-warning text-center mb-0" role="alert"><i class="bi bi-exclamation-triangle-fill"></i> <b>WARNING</b> <i class="bi bi-exclamation-triangle-fill"></i><br />You\'ve been detected using VPN / Proxy server, which is forbidden as per our <a href="' . GenerateURL('tos') . '">Terms of Service</a>.<br />Please disable your VPN / Proxy service, otherwise your account will be permanently suspended and your earnings will be voided.</div>';
                } else {
                    ?>
                    <div class="card-header mb-0 pb-0">
                        <h5 class="card-title fw-bold text-white ">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="">
                                    <svg width="25px" class="text-primary" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd"
                                            d="M9 4.5a.75.75 0 0 1 .721.544l.813 2.846a3.75 3.75 0 0 0 2.576 2.576l2.846.813a.75.75 0 0 1 0 1.442l-2.846.813a3.75 3.75 0 0 0-2.576 2.576l-.813 2.846a.75.75 0 0 1-1.442 0l-.813-2.846a3.75 3.75 0 0 0-2.576-2.576l-2.846-.813a.75.75 0 0 1 0-1.442l2.846-.813A3.75 3.75 0 0 0 7.466 7.89l.813-2.846A.75.75 0 0 1 9 4.5ZM18 1.5a.75.75 0 0 1 .728.568l.258 1.036c.236.94.97 1.674 1.91 1.91l1.036.258a.75.75 0 0 1 0 1.456l-1.036.258c-.94.236-1.674.97-1.91 1.91l-.258 1.036a.75.75 0 0 1-1.456 0l-.258-1.036a2.625 2.625 0 0 0-1.91-1.91l-1.036-.258a.75.75 0 0 1 0-1.456l1.036-.258a2.625 2.625 0 0 0 1.91-1.91l.258-1.036A.75.75 0 0 1 18 1.5ZM16.5 15a.75.75 0 0 1 .712.513l.394 1.183c.15.447.5.799.948.948l1.183.395a.75.75 0 0 1 0 1.422l-1.183.395c-.447.15-.799.5-.948.948l-.395 1.183a.75.75 0 0 1-1.422 0l-.395-1.183a1.5 1.5 0 0 0-.948-.948l-1.183-.395a.75.75 0 0 1 0-1.422l1.183-.395c.447-.15.799-.5.948-.948l.395-1.183A.75.75 0 0 1 16.5 15Z"
                                            clip-rule="evenodd"></path>
                                    </svg> Offers Partners
                                    <svg width="25px" data-bs-toggle="tooltip" data-bs-placement="top"
                                        class="text-secondary" role="img" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon"
                                        data-bs-original-title="Complete offers to earn rewards">
                                        <title>Complete offers to earn rewards</title>
                                        <path fill-rule="evenodd"
                                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 0 1-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 0 1-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 0 1-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584ZM12 18a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>

                                <div class="">

                                </div>
                            </div>
                        </h5>
                    </div>
                    <div class="card-body mb-0 pb-0">
                        <div class="d-flex flex-row flex-nowrap overflow-auto ">
                            <div class="swiper mySwiper py-3 swiper-initialized swiper-horizontal swiper-backface-hidden"
                                x-init="new window.swiper($el, { slidesPerView: 'auto' })">
                                <div class="swiper-wrapper swiper-offer d-flex gap-2" wire:ignore.self=""
                                    wire:loading.remove=""
                                    style="display: inline-block; transform: translate3d(0px, 0px, 0px); transition-duration: 0ms; transition-delay: 0ms;">

                                    <?php echo (empty($ow_config['wannads_key']) ? '' : '
                                        <div class="partner-card swiper-slide card text-white swiper-slide d-flex mx-2 swiper-slide-active"
                                            style="background: linear-gradient(#ff9711, #792717);"        
data-bs-toggle="modal" 
data-bs-target="#modalOffer" 
data-offerwall="wannads" 
alt="Wannads" title="Wannads">

                                            <div class="card-header mt-0"></div><div
                                                class="card-body text-center align-items-center d-flex justify-content-center position-relative pb-0">
                                                <img src="/assets/img/offerwalls/wannads.png" class="w-100 my-3"
                                                    alt="Adgem" loading="lazy">
                                                <i
                                                    class="fa-solid fa-play position-absolute text-white bg-primary rounded-circle"></i>
                                            </div>
                                            <div class="card-footer text-center px-0">
                                                <span class="mb-1 fw-normal text-white h6"
                                                    style="font-size: 14px">Wannads</span>
                                                <div class="text-warning" style="font-size: x-small">
                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                        </div>'); ?>










                                    <?php echo (empty($ow_config['monlix_api']) ? '' : '
                                        <div class="partner-card swiper-slide card text-white swiper-slide d-flex mx-2 swiper-slide-active"
                                            style="background: linear-gradient(#00ff84, #13492e);"        
data-bs-toggle="modal" 
data-bs-target="#modalOffer" 
data-offerwall="monlix" 
alt="Monlix" title="monlix">

                                            <div class="card-header mt-0"></div><div
                                                class="card-body text-center align-items-center d-flex justify-content-center position-relative pb-0">
                                                <img src="/assets/img/offerwalls/monlix.png" class="w-100 my-3"
                                                    alt="monlix" loading="lazy">
                                                <i
                                                    class="fa-solid fa-play position-absolute text-white bg-primary rounded-circle"></i>
                                            </div>
                                            <div class="card-footer text-center px-0">
                                                <span class="mb-1 fw-normal text-white h6"
                                                    style="font-size: 14px">Monlix</span>
                                                <div class="text-warning" style="font-size: x-small">
                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                        </div>'); ?>

                                    <?php echo (empty($ow_config['adgate_id']) ? '' : '
                                        <div class="partner-card swiper-slide card text-white swiper-slide d-flex mx-2 swiper-slide-active"
                                            style="background: linear-gradient(#00b8ff, #55a4cb5c);"        
data-bs-toggle="modal" 
        data-bs-target="#modalOffer" 
        data-offerwall="adgatemedia" 
        alt="Adgatemedia" title="Adgatemedia">

                                            <div class="card-header mt-0"></div><div
                                                class="card-body text-center align-items-center d-flex justify-content-center position-relative pb-0">
                                                <img src="/assets/img/offerwalls/adgatemedia.png" class="w-100 my-3"
                                                    alt="adgatemedia" loading="lazy">
                                                <i
                                                    class="fa-solid fa-play position-absolute text-white bg-primary rounded-circle"></i>
                                            </div>
                                            <div class="card-footer text-center px-0">
                                                <span class="mb-1 fw-normal text-white h6"
                                                    style="font-size: 14px">Adgatemedia</span>
                                                <div class="text-warning" style="font-size: x-small">
                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                        </div>'); ?>

                                    <?php echo (empty($ow_config['lootably_id']) ? '' : '
                                        <div class="partner-card swiper-slide card text-white swiper-slide d-flex mx-2 swiper-slide-active"
                                            style="background: linear-gradient(#e95f54, #53231c)"        
        data-bs-toggle="modal" 
        data-bs-target="#modalOffer" 
        data-offerwall="lootably" 
        alt="Lootably" title="Lootably">

                                            <div class="card-header mt-0"></div><div
                                                class="card-body text-center align-items-center d-flex justify-content-center position-relative pb-0">
                                                <img src="/assets/img/offerwalls/lootably.png" class="w-100 my-3"
                                                    alt="lootably" loading="lazy">
                                                <i
                                                    class="fa-solid fa-play position-absolute text-white bg-primary rounded-circle"></i>
                                            </div>
                                            <div class="card-footer text-center px-0">
                                                <span class="mb-1 fw-normal text-white h6"
                                                    style="font-size: 14px">Lootably</span>
                                                <div class="text-warning" style="font-size: x-small">
                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                        </div>'); ?>

                                    <?php echo (empty($ow_config['admantium_uuid']) ? '' : '
                                        <div class="partner-card swiper-slide card text-white swiper-slide d-flex mx-2 swiper-slide-active"
                                            style="background: linear-gradient(#00b8ff, #55a4cb5c)"        
         data-bs-toggle="modal" 
        data-bs-target="#modalOffer" 
        data-offerwall="admantium" 
        alt="Monlix" title="Admantium">

                                            <div class="card-header mt-0"></div><div
                                                class="card-body text-center align-items-center d-flex justify-content-center position-relative pb-0">
                                                <img src="/assets/img/offerwalls/admantium.png" class="w-100 my-3"
                                                    alt="admantium" loading="lazy">
                                                <i
                                                    class="fa-solid fa-play position-absolute text-white bg-primary rounded-circle"></i>
                                            </div>
                                            <div class="card-footer text-center px-0">
                                                <span class="mb-1 fw-normal text-white h6"
                                                    style="font-size: 14px">Admantium</span>
                                                <div class="text-warning" style="font-size: x-small">
                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                        </div>'); ?>

                                    <?php echo (empty($ow_config['offertoro_pub']) ? '' : '
                                        <div class="partner-card swiper-slide card text-white swiper-slide d-flex mx-2 swiper-slide-active"
                                            style="background: linear-gradient(#47359f, #1a133a)"        
         data-bs-toggle="modal" 
        data-bs-target="#modalOffer" 
        data-offerwall="offertoro" 
        alt="Offertoro" title="Torox">

                                            <div class="card-header mt-0"></div><div
                                                class="card-body text-center align-items-center d-flex justify-content-center position-relative pb-0">
                                                <img src="/assets/img/offerwalls/offertoro.png" class="w-100 my-3"
                                                    alt="offertoro" loading="lazy">
                                                <i
                                                    class="fa-solid fa-play position-absolute text-white bg-primary rounded-circle"></i>
                                            </div>
                                            <div class="card-footer text-center px-0">
                                                <span class="mb-1 fw-normal text-white h6"
                                                    style="font-size: 14px">Torox</span>
                                                <div class="text-warning" style="font-size: x-small">
                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                        </div>'); ?>

                                    <?php echo (empty($ow_config['offerwall_url']) ? '' : '
                                        <div class="partner-card swiper-slide card text-white swiper-slide d-flex mx-2 swiper-slide-active"
                                            style="background: linear-gradient(#ffffff, #737272)"       
         data-bs-toggle="modal" 
        data-bs-target="#modalOffer" 
        data-offerwall="offerwall" 
        alt="offerwall" title="Offerwall">

                                            <div class="card-header mt-0"></div><div
                                                class="card-body text-center align-items-center d-flex justify-content-center position-relative pb-0">
                                                <img src="/assets/img/offerwalls/offerwall.png" class="w-100 my-3"
                                                    alt="offerwall" loading="lazy">
                                                <i
                                                    class="fa-solid fa-play position-absolute text-white bg-primary rounded-circle"></i>
                                            </div>
                                            <div class="card-footer text-center px-0">
                                                <span class="mb-1 fw-normal text-white h6"
                                                    style="font-size: 14px">Offerwall</span>
                                                <div class="text-warning" style="font-size: x-small">
                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                        </div>'); ?>

                                    <?php echo (empty($ow_config['timewall_id']) ? '' : '
                                        <div class="partner-card swiper-slide card text-white swiper-slide d-flex mx-2 swiper-slide-active"
                                            style="background: linear-gradient(#00ff84, #13492e)"       
         data-bs-toggle="modal" 
        data-bs-target="#modalOffer" 
        data-offerwall="timewall" 
        alt="timewall" title="Timewall">

                                            <div class="card-header mt-0"></div><div
                                                class="card-body text-center align-items-center d-flex justify-content-center position-relative pb-0">
                                                <img src="/assets/img/offerwalls/timewall.png" class="w-100 my-3"
                                                    alt="timewall" loading="lazy">
                                                <i
                                                    class="fa-solid fa-play position-absolute text-white bg-primary rounded-circle"></i>
                                            </div>
                                            <div class="card-footer text-center px-0">
                                                <span class="mb-1 fw-normal text-white h6"
                                                    style="font-size: 14px">Timewall</span>
                                                <div class="text-warning" style="font-size: x-small">
                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                        </div>'); ?>

                                    <?php echo (empty($ow_config['timewall_id']) ? '' : '
                                        <div class="partner-card swiper-slide card text-white swiper-slide d-flex mx-2 swiper-slide-active"
                                            style="background: linear-gradient(#00adb4, #0f3361)"       
         data-bs-toggle="modal" 
        data-bs-target="#modalOffer" 
        data-offerwall="notik" 
        alt="notik" title="Notik">

                                            <div class="card-header mt-0"></div><div
                                                class="card-body text-center align-items-center d-flex justify-content-center position-relative pb-0">
                                                <img src="/assets/img/offerwalls/notik.png" class="w-100 my-3"
                                                    alt="notik" loading="lazy">
                                                <i
                                                    class="fa-solid fa-play position-absolute text-white bg-primary rounded-circle"></i>
                                            </div>
                                            <div class="card-footer text-center px-0">
                                                <span class="mb-1 fw-normal text-white h6"
                                                    style="font-size: 14px">Notik</span>
                                                <div class="text-warning" style="font-size: x-small">
                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                        </div>'); ?>

                                    <?php echo (empty($ow_config['upwall_id']) ? '' : '
                                        <div class="partner-card swiper-slide card text-white swiper-slide d-flex mx-2 swiper-slide-active"
                                            style="background: linear-gradient(rgb(37 198 252), rgb(34 62 76));"       
         data-bs-toggle="modal" 
        data-bs-target="#modalOffer" 
        data-offerwall="upwall" 
        alt="upwall" title="Upwall">

                                            <div class="card-header mt-0"></div><div
                                                class="card-body text-center align-items-center d-flex justify-content-center position-relative pb-0">
                                                <img src="/assets/img/offerwalls/upwall.png" class="w-100 my-3"
                                                    alt="upwall" loading="lazy">
                                                <i
                                                    class="fa-solid fa-play position-absolute text-white bg-primary rounded-circle"></i>
                                            </div>
                                            <div class="card-footer text-center px-0">
                                                <span class="mb-1 fw-normal text-white h6"
                                                    style="font-size: 14px">Upwall</span>
                                                <div class="text-warning" style="font-size: x-small">
                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                        </div>'); ?>
                                    <?php echo (empty($ow_config['taskwall_id']) ? '' : '
                                        <div class="partner-card swiper-slide card text-white swiper-slide d-flex mx-2 swiper-slide-active"
                                            style="background: linear-gradient(rgb(1 158 251), rgb(9 43 66));"       
         data-bs-toggle="modal" 
        data-bs-target="#modalOffer" 
        data-offerwall="taskwall" 
        alt="taskwall" title="taskwall">

                                            <div class="card-header mt-0"></div><div
                                                class="card-body text-center align-items-center d-flex justify-content-center position-relative pb-0">
                                                <img src="/assets/img/offerwalls/taskwall.png" class="w-100 my-3"
                                                    alt="taskwall" loading="lazy">
                                                <i
                                                    class="fa-solid fa-play position-absolute text-white bg-primary rounded-circle"></i>
                                            </div>
                                            <div class="card-footer text-center px-0">
                                                <span class="mb-1 fw-normal text-white h6"
                                                    style="font-size: 14px">Taskwall</span>
                                                <div class="text-warning" style="font-size: x-small">
                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                        </div>'); ?>
                                    <?php echo (empty($ow_config['clickwall_id']) ? '' : '
                                        <div class="partner-card swiper-slide card text-white swiper-slide d-flex mx-2 swiper-slide-active"
                                            style="background: linear-gradient(rgb(50 174 205), rgb(14 42 76));"       
         data-bs-toggle="modal" 
        data-bs-target="#modalOffer" 
        data-offerwall="clickwall" 
        alt="clickwall" title="clickwall">

                                            <div class="card-header mt-0"></div><div
                                                class="card-body text-center align-items-center d-flex justify-content-center position-relative pb-0">
                                                <img src="/assets/img/offerwalls/clickwall.png" class="w-100 my-3"
                                                    alt="clickwall" loading="lazy">
                                                <i
                                                    class="fa-solid fa-play position-absolute text-white bg-primary rounded-circle"></i>
                                            </div>
                                            <div class="card-footer text-center px-0">
                                                <span class="mb-1 fw-normal text-white h6"
                                                    style="font-size: 14px">Clickwall</span>
                                                <div class="text-warning" style="font-size: x-small">
                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                        </div>'); ?>
                                    <?php echo (empty($ow_config['adtowall_id']) ? '' : '
                                        <div class="partner-card swiper-slide card text-white swiper-slide d-flex mx-2 swiper-slide-active"
                                            style="background: linear-gradient(rgb(34 204 189), rgb(23 40 61));"       
         data-bs-toggle="modal" 
        data-bs-target="#modalOffer" 
        data-offerwall="adtowall" 
        alt="adtowall" title="adtowall">

                                            <div class="card-header mt-0"></div><div
                                                class="card-body text-center align-items-center d-flex justify-content-center position-relative pb-0">
                                                <img src="/assets/img/offerwalls/adtowall.png" class="w-100 my-3"
                                                    alt="adtowall" loading="lazy">
                                                <i
                                                    class="fa-solid fa-play position-absolute text-white bg-primary rounded-circle"></i>
                                            </div>
                                            <div class="card-footer text-center px-0">
                                                <span class="mb-1 fw-normal text-white h6"
                                                    style="font-size: 14px">Adtowall</span>
                                                <div class="text-warning" style="font-size: x-small">
                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                        </div>'); ?>
                                    <?php echo (empty($ow_config['pubscale_id']) ? '' : '
                                        <div class="partner-card swiper-slide card text-white swiper-slide d-flex mx-2 swiper-slide-active"
                                            style="background: linear-gradient(#00adb4, #0f3361)"       
         data-bs-toggle="modal" 
        data-bs-target="#modalOffer" 
        data-offerwall="pubscale" 
        alt="pubscale" title="pubscale">

                                            <div class="card-header mt-0"></div><div
                                                class="card-body text-center align-items-center d-flex justify-content-center position-relative pb-0">
                                                <img src="/assets/img/offerwalls/pubscale.png" class="w-100 my-3"
                                                    alt="pubscale" loading="lazy">
                                                <i
                                                    class="fa-solid fa-play position-absolute text-white bg-primary rounded-circle"></i>
                                            </div>
                                            <div class="card-footer text-center px-0">
                                                <span class="mb-1 fw-normal text-white h6"
                                                    style="font-size: 14px">Pubscale</span>
                                                <div class="text-warning" style="font-size: x-small">
                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                        </div>'); ?>
                                    <?php echo (empty($ow_config['offery_id']) ? '' : '
                                        <div class="partner-card swiper-slide card text-white swiper-slide d-flex mx-2 swiper-slide-active"
                                            style="background: linear-gradient(rgb(37 225 223), rgb(24 53 55));"       
         data-bs-toggle="modal" 
        data-bs-target="#modalOffer" 
        data-offerwall="offery" 
        alt="offery" title="offery">

                                            <div class="card-header mt-0"></div><div
                                                class="card-body text-center align-items-center d-flex justify-content-center position-relative pb-0">
                                                <img src="/assets/img/offerwalls/offery.png" class="w-100 my-3"
                                                    alt="offery" loading="lazy">
                                                <i
                                                    class="fa-solid fa-play position-absolute text-white bg-primary rounded-circle"></i>
                                            </div>
                                            <div class="card-footer text-center px-0">
                                                <span class="mb-1 fw-normal text-white h6"
                                                    style="font-size: 14px">Offery</span>
                                                <div class="text-warning" style="font-size: x-small">
                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                        </div>'); ?>
                                    <?php echo (empty($ow_config['flexwall_id']) ? '' : '
                                        <div class="partner-card swiper-slide card text-white swiper-slide d-flex mx-2 swiper-slide-active"
                                            style="background: linear-gradient(rgb(220 197 25), rgb(69 75 21));"       
         data-bs-toggle="modal" 
        data-bs-target="#modalOffer" 
        data-offerwall="flexwall" 
        alt="flexwall" title="flexwall">

                                            <div class="card-header mt-0"></div><div
                                                class="card-body text-center align-items-center d-flex justify-content-center position-relative pb-0">
                                                <img src="/assets/img/offerwalls/flexwall.png" class="w-100 my-3"
                                                    alt="flexwall" loading="lazy">
                                                <i
                                                    class="fa-solid fa-play position-absolute text-white bg-primary rounded-circle"></i>
                                            </div>
                                            <div class="card-footer text-center px-0">
                                                <span class="mb-1 fw-normal text-white h6"
                                                    style="font-size: 14px">Flexwall</span>
                                                <div class="text-warning" style="font-size: x-small">
                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                        </div>'); ?>
                                    <?php echo (empty($ow_config['sushiads_api']) ? '' : '
                                        <div class="partner-card swiper-slide card text-white swiper-slide d-flex mx-2 swiper-slide-active"
                                            style="background: linear-gradient(rgb(156, 90, 85), rgb(67, 36, 33));"       
         data-bs-toggle="modal" 
        data-bs-target="#modalOffer" 
        data-offerwall="sushiads" 
        alt="sushiads" title="sushiads">

                                            <div class="card-header mt-0"></div><div
                                                class="card-body text-center align-items-center d-flex justify-content-center position-relative pb-0">
                                                <img src="/assets/img/offerwalls/sushiads.png" class="w-100 my-3"
                                                    alt="saushiads" loading="lazy">
                                                <i
                                                    class="fa-solid fa-play position-absolute text-white bg-primary rounded-circle"></i>
                                            </div>
                                            <div class="card-footer text-center px-0">
                                                <span class="mb-1 fw-normal text-white h6"
                                                    style="font-size: 14px">SushiAds</span>
                                                <div class="text-warning" style="font-size: x-small">
                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                        </div>'); ?>


                                </div>
                            </div>
                        </div>
                        <!--[if BLOCK]><![endif]-->
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card" style="overflow:hidden;">
                <?php
                if ($proxy) {
                    echo '<div class="alert alert-warning text-center mb-0" role="alert"><i class="bi bi-exclamation-triangle-fill"></i> <b>WARNING</b> <i class="bi bi-exclamation-triangle-fill"></i><br />You\'ve been detected using VPN / Proxy server, which is forbidden as per our <a href="' . GenerateURL('tos') . '">Terms of Service</a>.<br />Please disable your VPN / Proxy service, otherwise your account will be permanently suspended and your earnings will be voided.</div>';
                } else {
                    ?>
                    <div class="card-header mb-0 pb-0">
                        <h5 class="card-title fw-bold text-white ">
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
                                    </svg> Survey Partners
                                    <svg width="25px" data-bs-toggle="tooltip" data-bs-placement="top"
                                        class="text-secondary" role="img" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon"
                                        data-bs-original-title="Complete surveys to earn rewards">
                                        <title>Complete surveys to earn rewards</title>
                                        <path fill-rule="evenodd"
                                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 0 1-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 0 1-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 0 1-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584ZM12 18a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>

                        </h5>
                    </div>
                    <div class="card-body mb-0 pb-0">
                        <div class="d-flex flex-row flex-nowrap overflow-auto ">
                            <div class="swiper mySwiper py-3 swiper-initialized swiper-horizontal swiper-backface-hidden"
                                x-init="new window.swiper($el, { slidesPerView: 'auto' })">
                                <div class="swiper-wrapper swiper-offer d-flex gap-2" wire:ignore.self=""
                                    wire:loading.remove=""
                                    style="display: inline-block; transform: translate3d(0px, 0px, 0px); transition-duration: 0ms; transition-delay: 0ms;">
                                    <?php echo (empty($ow_config['cpx_id']) ? '' : '
                                        <div class="partner-card swiper-slide card text-white swiper-slide d-flex mx-2 swiper-slide-active"
                                            style="background: linear-gradient(#1c4f91, #11243d)"        
data-bs-toggle="modal" 
        data-bs-target="#modalOffer" 
        data-offerwall="cpx" 
        alt="cpx" title="Cpx">

                                            <div class="card-header mt-0"></div><div
                                                class="card-body text-center align-items-center d-flex justify-content-center position-relative pb-0">
                                                <img src="/assets/img/offerwalls/Cpx.png" class="w-100 my-3"
                                                    alt="Cpx" loading="lazy">
                                                <i
                                                    class="fa-solid fa-play position-absolute text-white bg-primary rounded-circle"></i>
                                            </div>
                                            <div class="card-footer text-center px-0">
                                                <span class="mb-1 fw-normal text-white h6"
                                                    style="font-size: 14px">Cpx</span>
                                                <div class="text-warning" style="font-size: x-small">
                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>

                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            </div>
                                        </div>'); ?>
                                </div>
                            </div>
                        </div>
                        <!--[if BLOCK]><![endif]-->
                    </div>
                <?php } ?>
            </div>
        </div>
        </div>

        </div>
    </section>
</main>
<div class="modal fade" id="modalOffer" tabindex="-1">
    <div class="modal-dialog  modal-lg modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Offerwall</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-body-offerwall"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        new Swiper(".mySwiper", {
            slidesPerView: "auto",
            grabCursor: true,
            freeMode: true,
            spaceBetween: 8,        
        });
    });
</script>

<?php
$footer_js = '$(document).ready(function() {
	$(document).on("click", ".partner-card", function(b) {
		$(".modal-body-offerwall").html(\'<div class="alert alert-info" role="alert"><div class="spinner-border spinner-border-sm" role="status"></div> Please wait...</div>\');
		offerwall = $(this).data("offerwall");
		$.ajax({
			type: "GET",
			url: "system/ajax.php",
			data: {offerwall: offerwall},
			dataType: "json",
			success: function(a) {
				$(".modal-title").html(a.title);
				if(a.status == true) {
					setTimeout(function(){
						$(".modal-body-offerwall").html(\'<iframe src="\'+a.offerwall+\'" style="width:100%;height:100%;border:0;margin:0;border-radius:5px;"></iframe>\')
					}, 1000);
				} else {
					$(".modal-body-offerwall").html(a.offerwall);
				}
			}
		});
	});
});';
?>