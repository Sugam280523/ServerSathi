<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SATHI - Sugam Softtech</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />

    <link rel="icon" href="<?php echo base_url('assets/img/kaiadmin/favicon.ico');?>" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="<?php echo base_url('assets/js/plugin/webfont/webfont.min.js');?>"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["../assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/plugins.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/kaiadmin.min.css');?>" />

    <!-- Extra Style for Centering -->
    <style>
      body {
        background-color: #f7f9fc;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
      }
      .card {
        width: 100%;
        max-width: 420px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 12px;
      }
      .card-header {
        text-align: center;
      }
      .page-header h3 {
        text-align: center;
        font-weight: 700;
        color: #2c3e50;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="page-inner">
        <div class="page-header mb-4">
          <h3>SUGAM SOFTTECH</h3>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card">
              <div class="card-header">
                <div class="card-title">SATHI</div>
                <h5>Hello! let's get started</h5>
                <h6 class="font-weight-light">Sign in to continue.</h6>
                <?php if($this->session->flashdata('success')){ ?>
                        <div class="alert alert-success "> <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Success!</strong>&nbsp;&nbsp;<?php echo $this->session->flashdata('success'); ?> </div>
                    <?php }else if($this->session->flashdata('error')){  ?>
                        <div class="alert alert-danger"> &nbsp;&nbsp;<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Danger!</strong>&nbsp;&nbsp;<?php echo $this->session->flashdata('error'); ?></div>
                    <?php } ?>
              </div>
              <form method="Post" action="<?php echo base_url();?>" autocomplete="off">
              <div class="card-body">
                <div class="form-group mb-3">
                  <label for="UserName">Email Address<em style="color:red;">*</em></label>
                  <input type="email" class="form-control" name="UserName" id="UserName" placeholder="Enter Email" />
                  <span style="color:red;"><?php echo form_error('UserName'); ?></span>
                </div>
                <div class="form-group mb-4">
                  <label for="PassWord">Password<em style="color:red;">*</em></label>
                  <input type="password" class="form-control" name="PassWord" id="PassWord" placeholder="Password" />
                   <span style="color:red;"><?php echo form_error('PassWord'); ?></span>
                </div>
                <div class="d-flex justify-content-between">
                  <button class="btn btn-success w-50 me-2">Submit</button>
                  <button class="btn btn-danger w-50">Cancel</button>
                </div>
              </div>
        </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- JS Files -->
    <script src="<?php echo base_url('assets/js/core/jquery-3.7.1.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/core/popper.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/core/bootstrap.min.js');?>"></script>
  </body>
</html>

