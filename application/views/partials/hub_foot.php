<?php
/**
 * Closes the sidebar-app shell opened by hub_top.php and loads the JS.
 * Optional: $currentYear — defaults to current year.
 */
$footYear = isset($currentYear) ? $currentYear : date('Y');
?>
      <!-- Footer Start -->
      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <?php echo $footYear; ?> &copy; Faculty of Engineering, The University of Hong Kong
            </div>
            <div class="col-md-6">
              <div class="text-md-right footer-links d-none d-md-block">
                <a href="#top"><i class="mdi mdi-chevron-double-up h3"></i></a>
              </div>
            </div>
          </div>
        </div>
      </footer>
      <!-- end Footer -->

    </div>
    <!-- End Page content -->

  </div>
  <!-- END wrapper -->

  <!-- App js -->
  <script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/tpg-premium.js?v=4"></script>

  <?php include(APPPATH.'views/partials/demo_bar.php'); ?>
</body>
</html>
