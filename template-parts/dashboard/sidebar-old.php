<?php
$custom_logo_id = get_theme_mod('custom_logo');
$image = wp_get_attachment_image_src($custom_logo_id, 'full');

?>
<nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-md-none">
    <a class="navbar-brand me-lg-5" href="<?php echo site_url(); ?>">
        <img class="navbar-brand-dark" src="<?php echo $image[0] ?>" alt="Money n Care logo" />
    </a>
    <div class="d-flex align-items-center">
        <button class="navbar-toggler d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<nav id="sidebarMenu" class="sidebar d-md-block bg-dark text-white collapse" data-simplebar>
  <div class="sidebar-inner px-4 pt-3">
    <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
      <div class="d-flex align-items-center">
        <div class="user-avatar lg-avatar me-4">
          <img src="" class="card-img-top rounded-circle border-white"
            alt="">
        </div>
        <div class="d-block">
          <h2 class="h6">Hello</h2>
          <?php $login_page_link = get_page_link(get_option('login_page_link'));?>

          <a href="<?php echo wp_logout_url($login_page_link) ?>" class="btn btn-secondary text-dark btn-xs"><span
              class="me-2"><span class="fas fa-sign-out-alt"></span></span><a href="<?php echo wp_logout_url($login_page_link) ?>">Log out</a></a>
        </div>
      </div>
      <div class="collapse-close d-md-none">
        <a href="#sidebarMenu" class="fas fa-times" data-bs-toggle="collapse" data-bs-target="#sidebarMenu"
          aria-controls="sidebarMenu" aria-expanded="true" aria-label="Toggle navigation"></a>
      </div>
    </div>
    <ul class="nav flex-column pt-3 pt-md-0">
      <li class="nav-item">
        <a href="<?php echo site_url(); ?>" class="nav-link d-flex align-items-center">
          <span class="sidebar-icon">
            <img src="<?php echo $image[0] ?>" height="20" width="20" alt="Money n Care Logo">
          </span>
          <span class="mt-1 ms-1 sidebar-text"><?php echo bloginfo('name') ?></span>
        </a>
      </li>
      <li class="nav-item  active ">
        <a href="<?php echo site_url('dashboard') ?>" class="nav-link">
          <span class="sidebar-icon"><span class="fas fa-chart-pie"></span></span>
          <span class="sidebar-text">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo site_url('daily-profit') ?>"  class="nav-link d-flex justify-content-between">
          <span>
            <span class="sidebar-icon"><span class="fas fa-th"></span></span>
            <span class="sidebar-text">Daily Profit </span>
          </span>

        </a>
      </li>
      <li class="nav-item">
        <span class="nav-link d-flex justify-content-between align-items-center collapsed" data-bs-toggle="collapse" data-bs-target="#submenu_deposit" aria-expanded="false"><span><span class="sidebar-icon"><span class="fas fa-table"></span></span> <span class="sidebar-text">Deposit</span> </span><span class="link-arrow"><span class="fas fa-chevron-right"></span></span></span>
        <div class="multi-level collapse" role="list" id="submenu_deposit" aria-expanded="false" style="">
            <ul class="flex-column nav">
              <li class="nav-item"><a class="nav-link" href="<?php echo site_url('deposit-amount') ?>"><span class="sidebar-text">Deposit Amount</span></a></li>
              <li class="nav-item"><a class="nav-link" href="<?php echo site_url('my-deposited-amount') ?>"><span class="sidebar-text">My Deposits</span></a></li>
            </ul>
        </div>
      </li>
      <li class="nav-item">
        <span class="nav-link d-flex justify-content-between align-items-center collapsed" data-bs-toggle="collapse" data-bs-target="#submenu_withdraw" aria-expanded="false"><span><span class="sidebar-icon"><span class="fas fa-table"></span></span> <span class="sidebar-text">Withdraw</span> </span><span class="link-arrow"><span class="fas fa-chevron-right"></span></span></span>
        <div class="multi-level collapse" role="list" id="submenu_withdraw" aria-expanded="false" style="">
            <ul class="flex-column nav">
              <li class="nav-item"><a class="nav-link" href="<?php echo site_url('request-a-withdrawl') ?>"><span class="sidebar-text">Request A Withdraw</span></a></li>
              <li class="nav-item"><a class="nav-link" href="<?php echo site_url('my-withdrawl-requests') ?>"><span class="sidebar-text">My Withrawl Requests</span></a></li>
            </ul>
        </div>
      </li>
      <li class="nav-item ">
        <a href="" class="nav-link">
          <span class="sidebar-icon"><span class="fas fa-cog"></span></span>
          <span class="sidebar-text">Settings</span>
        </a>
      </li>

      <li role="separator" class="dropdown-divider mt-4 mb-3 border-black"></li>
      <li class="nav-item">
        <a href="" target="_blank"
          class="nav-link d-flex align-items-center">
          <span class="sidebar-icon"><span class="fas fa-book"></span></span>
          <span class="sidebar-text">About Us</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="" target="_blank"
          class="nav-link d-flex align-items-center">
          <span class="sidebar-icon"><span class="fas fa-book"></span></span>
          <span class="sidebar-text">How It Works</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="" target="_blank"
          class="nav-link d-flex align-items-center">
          <span class="sidebar-icon"><span class="fas fa-book"></span></span>
          <span class="sidebar-text">Get help</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo site_url(); ?>" class="nav-link d-flex align-items-center">
          <span class="sidebar-icon">
            <img src="<?php echo $image[0] ?>" height="20" width="20" alt="Themesberg Logo">
          </span>
          <span class="sidebar-text">M & C</span>
        </a>
      </li>

      <?php $login_page_link = get_page_link(get_option('login_page_link'));?>

      <li class="nav-item">
        <a href="<?php echo wp_logout_url($login_page_link) ?>" class="nav-link d-flex align-items-center">
          <span class="sidebar-icon"><span class="fas fa-sign-out-alt"></span></span>
          <span class="sidebar-text">Logout</span>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a href="../../pages/upgrade-to-pro.html"
          class="btn btn-secondary d-flex align-items-center justify-content-center btn-upgrade-pro">
          <span class="sidebar-icon"><span class="fas fa-rocket me-2"></span></span> <span>Upgrade to Pro</span>
        </a>
      </li> -->
    </ul>
  </div>
</nav>