<?php
$pageTitle = 'FAQ';
$bodyAttrs = 'onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload=""';
include(APPPATH.'views/partials/head.php');
?>
<script type="text/javascript">
  window.history.forward();
  function noBack() {
    window.history.forward();
  }
</script>

<?php include(APPPATH.'views/partials/hub_top.php'); ?>

      <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

          <!-- start page title -->
          <div class="row">
            <div class="col-12">
              <div class="page-title-box">
                <h4 class="page-title">Frequently Asked Questions</h4>
                <p class="lead mb-0">Contact points for general and programme-specific enquiries.</p>
              </div>
            </div>
          </div>
          <!-- end page title -->

          <div class="row mb-4">
            <div class="col-12">
              <div class="card">
                <div class="card-body p-4">
                  <h5 class="tp-card-heading mt-0"><i class="mdi mdi-help-circle-outline"></i> General enquiries</h5>
                  <div class="table-responsive-sm">
                    <table class="table table-hover table-sm table-centered mb-0">
                      <thead>
                        <tr>
                          <th>Department</th>
                          <th>Programme</th>
                          <th>email</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td colspan="2">Faculty of Engineering</td>
                          <td>ENGG_TPg_admission@hku.hk</td>
                        </tr>
                        <tr>
                          <td>Department of Civil Engineering</td>
                          <td>MSc(Eng) in Environmental Engineering<br/>
                            MSc(Eng) in Geotechnical Engineering<br/>
                            MSc(Eng) in Infrastructure Project Management<br/>
                            MSc(Eng) in Structural Engineering<br/>
                          MSc(Eng) in Transportation Engineering</td>
                          <td>ymwonga@hku.hk</td>
                        </tr>
                        <tr>
                          <td>Department of Electrical and Electronic Engineering</td>
                          <td>MSc(Eng) in Electrical and Electronic Engineering<br/>
                          MSc(Eng) in Energy Engineering</td>
                          <td>tpg-admission@eee.hku.hk</td>
                        </tr>
                        <tr>
                          <td>Department of Industrial and Manufacturing Systems Engineering</td>
                          <td>MSc(Eng) in Industrial Engineering and Logistics Management</td>
                          <td>brendale@hku.hk</td>
                        </tr>
                        <tr>
                          <td>Department of Mechanical Engineering</td>
                          <td>MSc(Eng) in Building Services Engineering<br/>
                          MSc(Eng) in Mechanical Engineering</td>
                          <td>kkilo@hku.hk<br/>apang@hku.hk</td>
                        </tr>
                        <tr>
                          <td rowspan="2">Department of Computer Science</td>
                          <td>MSc in Computer Science</td>
                          <td>msccs@cs.hku.hk</td>
                        </tr>
                        <tr>
                          <td>MSc in Electronic Commerce and Internet Computing</td>
                          <td>admission@ecom-icom.hku.hk</td>
                        </tr>
                      </tbody>
                    </table>
                  </div> <!-- end table-responsive-->
                </div>  <!-- end card-body -->
              </div>
            </div>
          </div>

          <!--
          <div class="row mb-4">
            <div class="col-12">
              <div class="card mt-0 mb-0 shadow-sm">
                <div class="card-header shadow-sm">
                  <a href="https://engg.hku.hk/Portals/0/TPG/faq.pdf" target="_blank">More ...</a>
                </div>
              </div>
            </div>
          </div>
        -->
          <!-- end faq -->

        </div>
      </div> <!-- content -->

<?php include(APPPATH.'views/partials/hub_foot.php'); ?>
