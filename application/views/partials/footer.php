<?php
/**
 * Shared footer + JS partial.
 * Optional: $currentYear  — defaults to current year.
 */
$footYear = isset($currentYear) ? $currentYear : date('Y');
?>
  <footer class="footer footer-alt tpg-footer">
    <?php echo $footYear; ?> &copy; Faculty of Engineering, The University of Hong Kong
  </footer>

  <!-- App js -->
  <script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/tpg-premium.js?v=4"></script>
</body>
</html>
