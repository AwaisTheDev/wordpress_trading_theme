
<?php
/**
 *
 */

$menu_class = LYRA_THEME\Includes\Menus::get_instance();

$menu_id = $menu_class->get_nav_menu_id('lyra-header-menu');
//echo $menu_id;
$menu_items = wp_get_nav_menu_items($menu_id);

//  echo '<pre>';
//   print_r($menu_items);
//  echo '</pre>';

?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">

    <?php if (has_custom_logo()) {
    the_custom_logo();
} else {
    echo bloginfo('name');
}
?>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <?php if (!empty($menu_items) && is_array($menu_items)) {?>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <?php foreach ($menu_items as $menu_item) {
    if (!$menu_item->menu_item_parent) {
        $child_menu_items = $menu_class->get_child_menu_items($menu_items, $menu_item->ID);
        if (empty($child_menu_items)) {
            ?>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo esc_url($menu_item->url) ?>">
                  <?php echo esc_html($menu_item->title) ?>
                </a>
              </li>

            <?php
} else {

            ?>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo esc_html($menu_item->title) ?>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

              <?php foreach ($child_menu_items as $child_menu) {?>
                <li>
                  <a class="dropdown-item" href="<?php echo esc_url($child_menu->url) ?>">
                    <?php echo esc_html($child_menu->title) ?>
                  </a>
                </li>
              <?php }?>
              </ul>
            </li>

            <?php
}
    }
    ?>

      <?php }?>
      </ul>
      <?php } else {
    echo "There is no menu a";
}?>
    </div>
  </div>
</nav>