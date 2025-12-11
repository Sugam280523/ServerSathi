<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SATHI-Sugam Softtech</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="<?php echo base_url('assets/img/favicon/favicon.ico');?>"
      type="image/x-icon"
    />

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
          urls: ["assets/css/fonts.min.css"],
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

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/demo.css');?>" />
  </head>
  <body>
    <input type="hidden" id="base_url" value="<?php echo base_url(); ?>" />
    <input type="hidden" id="user_Role" value="<?php echo $this->session->userdata('user_Role'); ?>" />
    


    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="<?php echo base_url('DashBoard');?>" class="logo">
              <img
                src="<?php echo base_url('assets/Logo/Logo1.png');?>"
                alt="navbar brand"
                class="navbar-brand"
                height="50"
              />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a
                  data-bs-toggle="collapse"
                  href="#dashboard"
                  class="collapsed"
                  aria-expanded="false"
                >
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="dashboard">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="<?php echo base_url('DashBoard'); ?>">
                        <span class="sub-item">Dashboard</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Components</h4>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#Lead">
                  <i class="fas fa-th-list"></i>
                  <p>Lead</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="Lead">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="<?php echo base_url('Customer');?>">
                        <span class="sub-item">Lead Creation</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo base_url('LeadCT');?>">
                        <span class="sub-item">Lead Report</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#Demo">
                  <i class="fas fa-th-list"></i>
                  <p>Demo</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="Demo">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="<?php echo base_url('Customer-Demo');?>">
                        <span class="sub-item">Demo Creation</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo base_url('DemoCT');?>">
                        <span class="sub-item">Demo Report</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#Activation">
                  <i class="fas fa-th-list"></i>
                  <p>Activation</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="Activation">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="<?php echo base_url('Customer-Activation');?>">
                        <span class="sub-item">Activation</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo base_url('ActivationCustomerT');?>">
                        <span class="sub-item">Activation Report</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <?php
                $user_role = $this->session->userdata('user_Role');
 
              if ($user_role == 'Admin' || $user_role == 'SuperAdmin') {
              ?>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#CompanyEmployee">
                  <i class="fas fa-th-list"></i>
                  <p>User</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="CompanyEmployee">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="<?php echo base_url('EmployeeRegister');?>">
                        <span class="sub-item">User Creation</span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <span class="sub-item">User Access Configuration</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo base_url('EmployeeT');?>">
                        <span class="sub-item">User Report</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <?php } ?>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#MISReport">
                  <i class="fas fa-pen-square"></i>
                  <p>MIS Report </p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="MISReport">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="<?php echo base_url('LiveCT');?>">
                        <span class="sub-item">Total Live Customer</span>
                      </a>
                    </li>                    
                    <li>
                      <a href="<?php echo base_url('PaymentPCT');?>">
                        <span class="sub-item">Payment Pending</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo base_url('PaymentRCT');?>">
                        <span class="sub-item">Payment Recivied</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo base_url('AMCExpiredThirtyDaysT');?>">
                        <span class="sub-item">AMC expiry before 30 days</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo base_url('AMCExpiredT');?>">
                        <span class="sub-item">Expired AMC</span>
                      </a>
                    </li>            
                    <li>
                      <a href="<?php echo base_url('CustomerT');?>">
                        <span class="sub-item">Customer Details</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
               <li class="nav-item">
                <a  href="<?php echo base_url('LogOut');?>">
                  <i class="fas fa-th-list"></i>
                  <p>Logout</p>
                  <span class="caret"></span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="<?php echo base_url('DashBoard');?>" class="logo">
                <img
                  src="<?php echo base_url('assets/Logo/Logo1.png'); ?>"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">
              <nav
                class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
              >
                
              </nav>

              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                

                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <div class="avatar-sm">
                      <img
                        src="<?php echo base_url('assets/img/profile.jpg');?>"
                        alt="..."
                        class="avatar-img rounded-circle"
                      />
                    </div>
                    <span class="profile-username">
                      <span class="op-7">Hi,</span>
                      <span class="fw-bold"><?php echo (!empty($this->session->userdata('user_name'))) ?($this->session->userdata('user_name')):'Name' ?> </span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box">
                          <div class="avatar-lg">
                            <img
                              src="<?php echo base_url('assets/img/profile.jpg');?>"
                              alt="image profile"
                              class="avatar-img rounded"
                            />
                          </div>
                          <div class="u-text">
                            <h4><?php echo (!empty($this->session->userdata('user_name'))) ?($this->session->userdata('user_name')):'Name' ?></h4>
                            <p class="text-muted"><?php echo (!empty($this->session->userdata('user_email'))) ?($this->session->userdata('user_email')):'SugamSofttech@gmail.com' ?></p>
                            <a
                              href="<?php echo base_url('EmployeeU/'.$this->session->userdata('user_id')); ?>"
                              class="btn btn-xs btn-secondary btn-sm"
                              >View Profile</a
                            >
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo base_url('LogOut');?>">Logout</a>
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>