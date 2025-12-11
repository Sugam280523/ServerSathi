
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
                    <form action="<?php echo base_url('EmployeeRegister');?>" method="POST" autocomplete="Off" enctype="multipart/form-data">
                        <?php if($this->session->flashdata('success')){ ?>
                            <div class="alert alert-success "> <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Success!</strong>&nbsp;&nbsp;<?php echo $this->session->flashdata('success'); ?> </div>
                        <?php }else if($this->session->flashdata('error')){  ?>
                            <div class="alert alert-danger"> &nbsp;&nbsp;<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Danger!</strong>&nbsp;&nbsp;<?php echo $this->session->flashdata('error'); ?></div>
                        <?php } ?>
                        <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="EmployeeName"> Employee Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="EmployeeName"
                                    name="EmployeeName"
                                    placeholder="Employee Name"
                                    value="<?php echo set_value('EmployeeName'); ?>"
                                />
                                <span style="color:red;"><?php echo form_error('EmployeeName'); ?></span>
                            </div>                        
                            <div class="form-group">
                                <label for="UserPassword"> Password</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="UserPassword"
                                    name="UserPassword"
                                    placeholder="Enter User Password"
                                    value="<?php echo set_value('UserPassword'); ?>"
                                />
                                <span style="color:red;"><?php echo form_error('UserPassword'); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="CUserPassword">Confirm Password</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="CUserPassword"
                                    name="CUserPassword"
                                    placeholder="Enter Confirm Password"
                                    value="<?php echo set_value('CUserPassword'); ?>"
                                />
                                <span style="color:red;"><?php echo form_error('CUserPassword'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            
                            
                            <div class="form-group">
                                <label for="EmployeeEmailId">Email ID</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="EmployeeEmailId"
                                    name="EmployeeEmailId"
                                    placeholder="Enter Employee Email ID"
                                    value="<?php echo set_value('EmployeeEmailId'); ?>"
                                />
                                <span style="color:red;"><?php echo form_error('EmployeeEmailId'); ?></span>
                            </div>                     
                        <div class="form-group">
                                <label for="EmployeeMobileNo">Mobile No.</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    id="EmployeeMobileNo"
                                    name="EmployeeMobileNo"
                                    placeholder="Enter Mobile Number"
                                    value="<?php echo set_value('EmployeeMobileNo'); ?>"
                                />
                                <span style="color:red;"><?php echo form_error('EmployeeMobileNo'); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="EDesignation">Designation</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="EDesignation"
                                    name="EDesignation"
                                    placeholder="Enter Desigation"
                                    value="<?php echo set_value('EDesignation'); ?>"
                                />
                                <span style="color:red;"><?php echo form_error('EDesignation'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                            <label for="EmployeeRole"
                                >Employee Role</label
                            >
                            <select
                                class="form-select"
                                id="EmployeeRole"
                                name="EmployeeRole"
                            >
                                <option disabled selected>Select Employee Role </option>
                                <option selected value="Admin" <?= set_select('EmployeeRole', 'Admin', isset($row->DB_UserRole) && $row->DB_UserRole == 'Admin'); ?>>Admin</option>
                                <option value="User" <?= set_select('EmployeeRole', 'User', isset($row->DB_UserRole) && $row->DB_UserRole == 'User'); ?>>User</option>
                                <option value="Partner" <?= set_select('EmployeeRole', 'Partner', isset($row->DB_UserRole) && $row->DB_UserRole == 'Partner'); ?>>Partner</option>
                            </select> 
                            <span style="color:red;"><?php echo form_error('EmployeeRole'); ?></span>                         
                            </div>
                            
                            <div class="form-group">
                            <label for="EmployeeProfile">User Profile</label>
                            <input
                                type="file"
                                class="form-control"
                                id="EmployeeProfile"
                                name="EmployeeProfile"
                                
                            />
                            </div>
                            <div class="form-group">
                            <div class="card-action">
                                <button class="btn btn-success">Submit</button>
                                <button class="btn btn-danger" onclick="location.reload();">Cancel</button>
                            </div>
                            
                            </div>
                        </div>
                        </div>
                    </form>
                  </div>                  
                </div>
              </div>
            </div>
          </div>
        </div>


    