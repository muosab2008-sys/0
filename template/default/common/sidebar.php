<?php
if (!defined('BASEPATH')) {
  exit('Unable to view file.');
}
?>
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <div class="app-brand demo">
      <a href="#" class="app-brand-link" style="
">
        
        <span class="app-brand-text demo menu-text fw-bold">
          <img src="assets/img/logo.png" alt="Logo" style="width: 186px;height: 67px;">
        </span>
      </a>

      <a href="javascript:void(0);" class="toggle-sidebar-btn layout-menu-toggle menu-link text-large ms-auto">
        <i class="fa-regular fa-circle  d-none align-middle"></i>
        <svg width="24" height="24" class="d-block d-xl-none align-middle" xmlns="http://www.w3.org/2000/svg"
          fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"></path>
        </svg> </a>


    </div>
    <?php
    if ($is_online) {
      ?>
      <li class="nav-item">
        <a class="nav-link<?php echo (!isset($_GET['page']) ? '' : ' collapsed'); ?>"
          href="<?php echo $config['secure_url']; ?>">
          <i class="bi bi-grid"></i>
          <span>Offers</span>
        </a>
      </li>
      <?php
    } else {
      ?>
      <li class="nav-item">
        <a class="nav-link<?php echo (!isset($_GET['page']) ? '' : ' collapsed'); ?>"
          href="#">
          <i class="bi bi-person-check"></i>
          <span>Login</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link<?php echo (!isset($_GET['page']) ? '' : ' collapsed'); ?>"
          href="#">
          <i class="bi bi-person-plus-fill"></i>
          <span>Register</span>
        </a>
      </li>
      <?php
    }

    if ($is_online) {
      ?>


      <li class="nav-item">
        <a class="nav-link<?php echo (isset($_GET['page']) && in_array($_GET['page'], array('completed', 'pending', 'rejected', 'canceled')) ? '' : ' collapsed'); ?>"
          data-bs-target="#trans-nav" data-bs-toggle="collapse" href="#">
          <i class="bx bx-list-ul"></i><span>Transactions</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="trans-nav"
          class="nav-content collapse<?php echo (isset($_GET['page']) && in_array($_GET['page'], array('completed', 'pending', 'rejected', 'canceled')) ? ' show' : ''); ?>"
          data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo GenerateURL('completed'); ?>" <?php echo (isset($_GET['page']) && $_GET['page'] == 'completed' ? ' class="active"' : ''); ?>>
              <i class="bi bi-circle"></i><span>Complete</span>
            </a>
          </li>
          <li>
            <a href="<?php echo GenerateURL('pending'); ?>" <?php echo (isset($_GET['page']) && $_GET['page'] == 'pending' ? ' class="active"' : ''); ?>>
              <i class="bi bi-circle"></i><span>Pending</span>
            </a>
          </li>
          <li>
            <a href="<?php echo GenerateURL('rejected'); ?>" <?php echo (isset($_GET['page']) && $_GET['page'] == 'rejected' ? ' class="active"' : ''); ?>>
              <i class="bi bi-circle"></i><span>Rejected</span>
            </a>
          </li>
          <li>
            <a href="<?php echo GenerateURL('canceled'); ?>" <?php echo (isset($_GET['page']) && $_GET['page'] == 'canceled' ? ' class="active"' : ''); ?>>
              <i class="bi bi-circle"></i><span>Canceled</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link<?php echo (isset($_GET['page']) && $_GET['page'] == 'withdraw' ? '' : ' collapsed'); ?>"
          href="<?= GenerateURL('withdraw') ?>">
          <i class="bi bi-credit-card-fill"></i>
          <span>Withdraw</span>
        </a>
      </li>      
      <li class="nav-item">
        <a class="nav-link<?php echo (isset($_GET['page']) && $_GET['page'] == 'leaderboard' ? '' : ' collapsed'); ?>"
          href="<?= GenerateURL('leaderboard') ?>">
          <i class="menu-icon fas fa-ranking-star"></i>
          <span>leaderboard</span>
        </a>
      </li>
      <?php
    }
    ?>
    <li class="nav-heading mt-auto">Help</li>
    <li class="nav-item">
      <a class="nav-link<?php echo (isset($_GET['page']) && in_array($_GET['page'], array('faq', 'tos', 'privacy')) ? '' : ' collapsed'); ?>"
        data-bs-target="#info-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-question-circle"></i><span>Info</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="info-nav"
        class="nav-content collapse<?php echo (isset($_GET['page']) && in_array($_GET['page'], array('faq', 'tos', 'privacy')) ? ' show' : ''); ?>"
        data-bs-parent="#sidebar-nav">
        <li>
          <a href="<?php echo GenerateURL('faq'); ?>" <?php echo (isset($_GET['page']) && $_GET['page'] == 'faq' ? ' class="active"' : ''); ?>>
            <i class="bi bi-circle"></i><span>F.A.Q.</span>
          </a>
        </li>
        <li>
          <a href="<?php echo GenerateURL('tos'); ?>" <?php echo (isset($_GET['page']) && $_GET['page'] == 'tos' ? ' class="active"' : ''); ?>>
            <i class="bi bi-circle"></i><span>Terms of Service</span>
          </a>
        </li>
        <li>
          <a href="<?php echo GenerateURL('privacy'); ?>" <?php echo (isset($_GET['page']) && $_GET['page'] == 'privacy' ? ' class="active"' : ''); ?>>
            <i class="bi bi-circle"></i><span>Privacy Policy</span>
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-item">
      <a class="nav-link<?php echo (isset($_GET['page']) && $_GET['page'] == 'contact' ? '' : ' collapsed'); ?>"
        href="<?= GenerateURL('contact') ?>">
        <i class="bi bi-envelope"></i>
        <span>Contact Us</span>
      </a>
    </li>
  </ul>
</aside>
