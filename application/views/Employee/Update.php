
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Employee/Partner</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="#">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Employee</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Employee/Partner Register Form</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Employee/Partner Details</div>
                    <p><span class="text-danger">*</span> All fields are mandatory</p>
                  </div>
                  <div class="card-body">
                    <?php foreach($Employeedata as $row) { ?>
                        <form action="<?php echo base_url('EmployeeU/'.$row->DB_UserId); ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
                            
                            <?php if ($this->session->flashdata('success')) { ?>
                                <div class="alert alert-success">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                                </div>
                            <?php } elseif ($this->session->flashdata('error')) { ?>
                                <div class="alert alert-danger">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            <?php } ?>

                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="EmployeeName">Employee Name</label>
                                        <input type="text" class="form-control" id="EmployeeName" name="EmployeeName" placeholder="Employee Name" value="<?php echo set_value('EmployeeName', $row->DB_UserName); ?>">
                                        <span style="color:red;"><?php echo form_error('EmployeeName'); ?></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="EmployeeEmailId">Email ID</label>
                                        <input type="email" class="form-control" id="EmployeeEmailId" name="EmployeeEmailId" placeholder="Email ID" value="<?php echo set_value('EmployeeEmailId', $row->DB_UserEmailId); ?>">
                                        <span style="color:red;"><?php echo form_error('EmployeeEmailId'); ?></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="EmployeeMobileNo">Mobile No.</label>
                                        <input type="number" class="form-control" id="EmployeeMobileNo" name="EmployeeMobileNo" placeholder="Mobile Number" value="<?php echo set_value('EmployeeMobileNo', $row->DB_UserMobileNo); ?>">
                                        <span style="color:red;"><?php echo form_error('EmployeeMobileNo'); ?></span>
                                    </div>
                                </div>

                                <!-- Middle Column -->
                                <div class="col-md-6 col-lg-4">
                                    
                                    <div class="form-group">
                                        <label for="EDesignation">Designation</label>
                                        <input type="text" class="form-control" id="EDesignation" name="EDesignation" placeholder="Designation" value="<?php echo set_value('EDesignation', $row->DB_Designation); ?>">
                                        <span style="color:red;"><?php echo form_error('EDesignation'); ?></span>
                                    </div>
                                
                                    <div class="form-group">
                                        <label for="EmployeeRole">Employee Role</label>
                                        <select class="form-select" id="EmployeeRole" name="EmployeeRole">
                                            <option disabled>Select Employee Role</option>
                                            <option value="Admin" <?= set_select('EmployeeRole', 'Admin', $row->DB_UserRole == 'Admin'); ?>>Admin</option>
                                            <option value="User" <?= set_select('EmployeeRole', 'User', $row->DB_UserRole == 'User'); ?>>User</option>
                                            <option value="Partner" <?= set_select('EmployeeRole', 'Partner', $row->DB_UserRole == 'Partner'); ?>>Partner</option>
                                        </select>
                                        <span style="color:red;"><?php echo form_error('EmployeeRole'); ?></span>
                                    </div>
                                     
                                    </div>
                                <!-- Right Column -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="EmployeeProfile">Privous User Profile</label><br/>
                                        <img src="<?php echo base_url('assets/EmployeeProfile/' . $row->DB_UserProfile); ?>" alt="Profile" width="50" height="50">
                                        <input type="hidden" name="Prev_EmployeeProfile" value="<?php echo $row->DB_UserProfile; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="EmployeeProfile">User Profile </label>
                                        <input type="file" class="form-control" id="EmployeeProfile" name="EmployeeProfile">
                                    </div>

                                    <div class="form-group mt-3">
                                        <button class="btn btn-success">Update</button>
                                        <button type="button" class="btn btn-danger" onclick="location.reload();">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php } ?>

                  </div>                  
                </div>
              </div>
            </div>
          </div>
        </div>


    