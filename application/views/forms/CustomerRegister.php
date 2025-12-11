
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Customer</h3>
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
                  <a href="#">Customer</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Customer Register Form</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Customer Details</div>
                    <p><span class="text-danger">*</span> All fields are mandatory</p>
                  </div>
                  <div class="card-body">
                    <form action="<?php echo base_url('Customer');?>" method="POST" autocomplete="Off">
                        <?php if($this->session->flashdata('success')){ ?>
                            <div class="alert alert-success "> <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Success!</strong>&nbsp;&nbsp;<?php echo $this->session->flashdata('success'); ?> </div>
                        <?php }else if($this->session->flashdata('error')){  ?>
                            <div class="alert alert-danger"> &nbsp;&nbsp;<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Danger!</strong>&nbsp;&nbsp;<?php echo $this->session->flashdata('error'); ?></div>
                        <?php } ?>
                        <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                            <label for="FirmName">Firm Name</label>
                            <input
                                type="text"
                                class="form-control"
                                id="FirmName"
                                name="FirmName"
                                placeholder="Enter Firm Name(Shop Name)"
                                value="<?php echo set_value('FirmName'); ?>"
                            />
                            <span style="color:red;"><?php echo form_error('FirmName'); ?></span>
                            </div> 
                            <div class="form-group">
                            <label for="CustomerName"> Owner Name</label>
                            <input
                                type="text"
                                class="form-control"
                                id="CustomerName"
                                name="CustomerName"
                                placeholder="Owner Name"
                                value="<?php echo set_value('CustomerName'); ?>"
                            />
                            <span style="color:red;"><?php echo form_error('CustomerName'); ?></span>
                            </div>                        
                            <div class="form-group">
                            <label for="mobilenumber"> Mobile No.</label>
                            <input
                                type="number"
                                class="form-control"
                                id="mobilenumber"
                                name="mobilenumber"
                                placeholder="Enter Mobile Number"
                                value="<?php echo set_value('mobilenumber'); ?>"
                            />
                            <span style="color:red;"><?php echo form_error('mobilenumber'); ?></span>
                            </div>
                            
                        </div>
                        <div class="col-md-6 col-lg-4">
                          
                          <div class="form-group">
                            <label for="City">City.</label>
                            <input
                                type="text"
                                class="form-control"
                                id="city"
                                name="city"
                                placeholder="Enter City"
                                value="<?php echo set_value('city'); ?>"
                            />
                            <span style="color:red;"><?php echo form_error('city'); ?></span>
                            </div>
                          <div class="form-group">
                            <label for="state"
                                >State</label
                            >
                            <select
                                class="form-select"
                                id="State"
                                name="State"
                            >
                                <option disabled selected>Select state</option>
                               <?php
                                  $states = ['Andaman and Nicobar Islands', 'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh', 'Goa', 'Gujarat', 'Haryana', 'Maharashtra', 'Punjab', 'Rajasthan', 'Tamil Nadu', 'Telangana', 'West Bengal'];
                                  $selected_state = set_value('State', isset($row->DB_Cust__State) ? $row->DB_Cust__State : '');
                                  foreach ($states as $state) {
                                      $sel = ($selected_state == $state) ? 'selected' : '';
                                      echo "<option value='{$state}' {$sel}>{$state}</option>";
                                  }
                                  ?>

                            </select> 
                            <span style="color:red;"><?php echo form_error('State'); ?></span>                         
                            </div>
                            <div class="form-group">
                            <label for="Address"> Address</label>
                            <textarea class="form-control" id="Address" Name="Address" rows="2" value="<?php echo set_value('Address'); ?>"></textarea>

                            <span style="color:red;"><?php echo form_error('Address'); ?></span>                         
                          </div>
                                                
                        
                        </div>
                        <div class="col-md-6 col-lg-4">
                          <div class="form-group">
                            <label for="serialnumber">Tally Serial No.</label>
                            <input
                                type="number"
                                class="form-control"
                                id="serialnumber"
                                name="serialnumber"
                                placeholder="Enter Tally Serial number"
                                maxlength="8"
                                value="<?php echo set_value('serialnumber'); ?>"
                            />
                            <span style="color:red;"><?php echo form_error('serialnumber'); ?></span>
                            <span id="serialnumber_error" style="color:red;"></span>
                            </div>
                            <div class="form-group">
                                <label for="partnerno">Select Partner Name</label>

                                <select class="form-select" id="partnerno" name="partnerno"
                                    <?php echo ($this->session->userdata('user_Role') == 'Partner') ? 'readonly disabled' : ''; ?>>

                                    <?php if ($this->session->userdata('user_Role') == 'Partner') { ?>
                                        <!-- Partner can only see their own name -->
                                        <?php foreach ($partner as $cust) { ?>
                                            <option value="<?php echo $cust->DB_UserId; ?>" 
                                                    <?php echo set_select('partnerno', $cust->DB_UserId, TRUE); ?>>
                                                <?php echo $cust->DB_UserName; ?>
                                            </option>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <!-- Admin/User/SuperAdmin can select from all -->
                                        <option value="1" <?php echo set_select('partnerno', '1', TRUE); ?>>SELF</option>
                                        <?php foreach ($partner as $cust) { ?>
                                            <option value="<?php echo $cust->DB_UserId; ?>"
                                                    <?php echo set_select('partnerno', $cust->DB_UserId); ?>>
                                                <?php echo $cust->DB_UserName; ?>
                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <span style="color:red;"><?php echo form_error('partnerno'); ?></span>
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


    