<?php
/**
 * Opens the sidebar-app shell used by signed-in pages:
 * .wrapper + left sidebar + .content-page + mobile menu button.
 * Requires $menu (see side_menu.php). Close the shell with hub_foot.php.
 */
?>
  <a name="top"></a>

  <!-- Begin page -->
  <div class="wrapper">

    <?php include(APPPATH.'views/partials/side_menu.php'); ?>

    <!-- Start Page Content here -->
    <div class="content-page">

      <div class="row m-2 d-md-none d-lg-none d-xl-none"> <!-- visible sm and down -->
        <button class="button-menu-mobile open-left disable-btn">
          <i class="mdi mdi-menu"></i>
        </button>
      </div>
