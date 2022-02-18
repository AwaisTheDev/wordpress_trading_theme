<?php
$custom_logo_id = get_theme_mod('custom_logo');
$image = wp_get_attachment_image_src($custom_logo_id, 'full');

?>
<nav class="sticky-top navbar navbar-dark navbar-theme-primary px-4 col-12 d-md-none">
    <a class="navbar-brand me-lg-5" href="<?php echo site_url(); ?>">
        <img class="navbar-brand-dark" src="<?php echo $image[0] ?>" alt="" />
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

    <!-- Start of menu -->

    <?php
$menu_class = LYRA_THEME\Includes\Menus::get_instance();
$menu_id = $menu_class->get_nav_menu_id('lyra-dashboard-menu');
$menu_items = wp_get_nav_menu_items($menu_id);

// echo "<pre>";
// print_r($menu_items);
// echo "</pre>";
// //echo $menu_id;

$menu_classes = $menu_items->classes;

// echo "<pre>";
// print_r($menu_classes);
// echo "</pre>";

?>
      <?php if (!empty($menu_items) && is_array($menu_items)) {?>
      <ul class="nav flex-column pt-3 pt-md-0">

      <!-- Home page Link hard coded -->
        <li class="nav-item">
          <a href="<?php echo site_url(); ?>" class="nav-link d-flex align-items-center">
            <span class="sidebar-icon">
              <img src="<?php echo $image[0] ?>" height="20" width="20" alt="Logo">
            </span>
            <span class="sidebar-text">M & C</span>
          </a>
        </li>
      <?php foreach ($menu_items as $menu_item) {
    if (!$menu_item->menu_item_parent) {
        $child_menu_items = $menu_class->get_child_menu_items($menu_items, $menu_item->ID);
        if (empty($child_menu_items)) {
            $menu_classes = $menu_item->classes;

            // echo "<pre>";
            // print_r($menu_classes);
            // echo "</pre>";

            ?>
            <li class="nav-item">
              <a href="<?php echo esc_url($menu_item->url) ?>" class="nav-link">
                <span class="sidebar-icon"><span class="<?php foreach ($menu_classes as $class) {echo $class . " ";}?>"></span></span>
                <span class="sidebar-text"><?php echo esc_html($menu_item->title) ?></span>
              </a>
            </li>
            <?php } else {?>

            <!-- Menu item if it has child menu   -->
            <li class="nav-item">
              <span class="nav-link d-flex justify-content-between align-items-center collapsed" data-bs-toggle="collapse" data-bs-target="#dropdown<?php echo $menu_item->ID ?>" aria-expanded="false">
                <span>
                  <span class="sidebar-icon">
                    <span class="fas fa-table"></span>
                  </span>
                  <span class="sidebar-text"><?php echo esc_html($menu_item->title) ?></span>
                </span>
                <span class="link-arrow">
                  <span class="fas fa-chevron-right"></span>
                </span>
              </span>

              <div class="multi-level collapse" role="list" id="dropdown<?php echo $menu_item->ID ?>" aria-expanded="false" style="">
                <!-- Submenu Starts -->
                 <ul class="flex-column nav">
                  <?php foreach ($child_menu_items as $child_menu) {?>
                    <li>
                      <li class="nav-item">
                        <a class="nav-link" href="<?php echo esc_url($child_menu->url) ?>">
                          <span class="sidebar-text"><?php echo esc_html($child_menu->title) ?></span>
                        </a>
                      </li>
                    </li>
                  <?php }?>
                </ul>
                <!-- Submenu Ends -->
              </div>
            </li>
            <!-- Menu item if it has child menu  ends  -->

            <?php }?>
            <?php }?>

      <?php }?>
      </ul>
      <?php } else {
    echo "No menu";
}?>
<!-- End of menu -->



<!-- Add separator -->
<li role="separator" class="dropdown-divider mt-4 mb-3 border-black"></li>


<!-- --------------------------Secondary menu------------------------------ -->

<?php

$menu_id = $menu_class->get_nav_menu_id('lyra-dashboard-secondry-menu');
$menu_items = wp_get_nav_menu_items($menu_id);

// echo "<pre>";
// print_r($menu_items);
// echo "</pre>";
// //echo $menu_id;

$menu_classes = $menu_items->classes;

echo "<pre>";
print_r($menu_classes);
echo "</pre>";

?>
      <?php if (!empty($menu_items) && is_array($menu_items)) {?>
      <ul class="nav flex-column pt-3 pt-md-0">
      <?php foreach ($menu_items as $menu_item) {
    if (!$menu_item->menu_item_parent) {
        $child_menu_items = $menu_class->get_child_menu_items($menu_items, $menu_item->ID);
        if (empty($child_menu_items)) {
            $menu_classes = $menu_item->classes;

            // echo "<pre>";
            // print_r($menu_classes);
            // echo "</pre>";

            ?>
            <li class="nav-item">
              <a href="<?php echo esc_url($menu_item->url) ?>" class="nav-link">
                <span class="sidebar-icon"><span class="<?php foreach ($menu_classes as $class) {echo $class . " ";}?>"></span></span>
                <span class="sidebar-text"><?php echo esc_html($menu_item->title) ?></span>
              </a>
            </li>
            <?php } else {?>

            <!-- Menu item if it has child menu   -->
            <li class="nav-item">
              <span class="nav-link d-flex justify-content-between align-items-center collapsed" data-bs-toggle="collapse" data-bs-target="#dropdown<?php echo $menu_item->ID ?>" aria-expanded="false">
                <span>
                  <span class="sidebar-icon">
                    <span class="fas fa-table"></span>
                  </span>
                  <span class="sidebar-text"><?php echo esc_html($menu_item->title) ?></span>
                </span>
                <span class="link-arrow">
                  <span class="fas fa-chevron-right"></span>
                </span>
              </span>

              <div class="multi-level collapse" role="list" id="dropdown<?php echo $menu_item->ID ?>" aria-expanded="false" style="">
                <!-- Submenu Starts -->
                 <ul class="flex-column nav">
                  <?php foreach ($child_menu_items as $child_menu) {?>
                    <li>
                      <li class="nav-item">
                        <a class="nav-link" href="<?php echo esc_url($child_menu->url) ?>">
                          <span class="sidebar-text"><?php echo esc_html($child_menu->title) ?></span>
                        </a>
                      </li>
                    </li>
                  <?php }?>
                </ul>
                <!-- Submenu Ends -->
              </div>
            </li>
            <!-- Menu item if it has child menu  ends  -->

            <?php }?>
            <?php }?>

      <?php }?>
      </ul>
      <?php } else {
    echo "No menu created. Please create a menu.";
}?>
    <!-- Hardcoded logout link -->
    <ul class="nav flex-column pt-3 pt-md-0">
      <?php $login_page_link = get_page_link(get_option('login_page_link'));?>

      <li class="nav-item">
        <a href="<?php echo wp_logout_url($login_page_link) ?>" class="nav-link d-flex align-items-center">
          <span class="sidebar-icon"><span class="fas fa-sign-out-alt"></span></span>
          <span class="sidebar-text">Logout</span>
        </a>
      </li>
    </ul>
  </div>
</nav>

<!-- Nav ends here -->

<main class="content">