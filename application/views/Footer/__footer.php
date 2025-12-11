<footer class="footer">
          <div class="container-fluid d-flex justify-content-between">
            <nav class="pull-left">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link" href="http://www.sugamsofttech.com">
                    Sugam Softtech
                  </a>
                </li>
              </ul>
            </nav>
            <div class="copyright">
              <?php echo date('Y'); ?>, made with <i class="fa fa-heart heart text-danger"></i> by
              <a href="http://sugamsofttech.com">Sugam</a>
            </div>
            <div>
              Distributed by
              <a target="_blank" href="https://SugamSofttech.com/">Sugam</a>.
            </div>
          </div>
        </footer>
      </div>

      <!-- Custom template | don't include it in your project! -->
      <div class="custom-template">

  <div class="custom-content text-center" style="padding: 20px;">
    <h4 style="margin: 10px 0;">Sugam Softtech</h4>
    <a href="https://sugamsofttech.com" target="_blank" class="btn btn-primary btn-sm">
      Visit Website
    </a>
  </div>

  <div class="custom-toggle">
    <i class="icon-globe"></i>
  </div>
</div>
<!-- Customer Details Modal -->
<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="customerModalLabel">Customer Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="customerModalBody">
        <p>Loading...</p>
      </div>
    </div>
  </div>
</div>

      <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
    <script src="<?php echo base_url('assets/js/core/jquery-3.7.1.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/core/popper.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/core/bootstrap.min.js');?>"></script>

    <!-- jQuery Scrollbar -->
    <script src="<?php echo base_url('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js');?>"></script>

    <!-- Chart JS -->
    <script src="<?php echo base_url('assets/js/plugin/chart.js/chart.min.js');?>"></script>

    <!-- jQuery Sparkline -->
    <script src="<?php echo base_url('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js');?>"></script>

    <!-- Chart Circle -->
    <script src="<?php echo base_url('assets/js/plugin/chart-circle/circles.min.js');?>"></script>

    <!-- Datatables -->
    <script src="<?php echo base_url('assets/js/plugin/datatables/datatables.min.js');?>"></script>

    <!-- Bootstrap Notify -->
    <script src="<?php echo base_url('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js');?>"></script>

    <!-- jQuery Vector Maps -->
    <script src="<?php echo base_url('assets/js/plugin/jsvectormap/jsvectormap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugin/jsvectormap/world.js');?>"></script>

    <!-- Sweet Alert -->
    <script src="<?php echo base_url('assets/js/plugin/sweetalert/sweetalert.min.js');?>"></script>

    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script> 

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="<?php echo base_url('assets/js/setting-demo.js');?>"></script>
    <script src="<?php echo base_url('assets/js/demo.js');?>"></script>
    <script src="<?php echo base_url('assets/MyAssetLib.js');?>"></script>
    <script>
      $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.14)",
      });

      $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#f3545d",
        fillColor: "rgba(243, 84, 93, .14)",
      });

      $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#ffa534",
        fillColor: "rgba(255, 165, 52, .14)",
      });
    </script>
  </body>
</html>
