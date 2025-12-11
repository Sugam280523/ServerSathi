
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
                  <a href="#">Customer Updates</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Customer Details Updates</div>
                    
                  </div>
                  <div class="card-body">
                    <?php  foreach($customerdata as $row){ ?>
                    <form action="<?php echo base_url('CustomerU/' . $row->DB_Cust__Id); ?>" method="POST" autocomplete="off">
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
                                <div class="col-md-6 col-lg-4">
                                  <div class="form-group">
                                        <label for="FirmName">Firm Name</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="FirmName"
                                            name="FirmName"
                                            placeholder="Enter Firm Name (Shop Name)"
                                            value="<?php echo set_value('FirmName', $row->DB_Cust__FirmName); ?>"
                                        />
                                        <span style="color:red;"><?php echo form_error('FirmName'); ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="CustomerName">Owener Name</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="CustomerName"
                                            name="CustomerName"
                                            placeholder="Owner Name"
                                            value="<?php echo set_value('CustomerName', $row->DB_Cust__Name); ?>"
                                        />
                                        <span style="color:red;"><?php echo form_error('CustomerName'); ?></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="mobilenumber">Mobile No.</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="mobilenumber"
                                            name="mobilenumber"
                                            placeholder="Enter Mobile Number"
                                            value="<?php echo set_value('mobilenumber', $row->DB_Cust__MobileNo); ?>"
                                        />
                                        <span style="color:red;"><?php echo form_error('mobilenumber'); ?></span>
                                    </div>

                                    
                                </div>

                                <div class="col-md-6 col-lg-4">
                                  <div class="form-group">
                                        <label for="city">City </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="city"
                                            name="city"
                                            placeholder="Enter city"
                                            value="<?php echo set_value('city', $row->DB_Cust__city); ?>"
                                        />
                                        <span style="color:red;"><?php echo form_error('city'); ?></span>
                                    </div>
                                  <div class="form-group">
                                        <label for="State">State</label>
                                        <select class="form-select" id="State" name="State">
                                            <option disabled selected>Select state</option>
                                            <?php
                                            // List of states
                                            $states = [
                                                'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh',
                                                'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jharkhand', 'Karnataka',
                                                'Kerala', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram',
                                                'Nagaland', 'Odisha', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana',
                                                'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal'
                                            ];

                                                $selected_state = set_value('State', isset($row->DB_Cust__State) ? $row->DB_Cust__State : '');

                                            foreach ($states as $state) {
                                                $sel = ($selected_state === $state) ? 'selected' : '';
                                                echo "<option value='{$state}' {$sel}>{$state}</option>";
                                            }
                                            ?>
                                        </select>
                                        <span style="color:red;"><?php echo form_error('State'); ?></span>
                                    </div>


                                    <div class="form-group">
                                        <label for="Address">Address</label>
                                        <textarea
                                            class="form-control"
                                            id="Address"
                                            name="Address"
                                            rows="2"
                                        ><?php echo set_value('Address', $row->DB_Cust__Address); ?></textarea>
                                        <span style="color:red;"><?php echo form_error('Address'); ?></span>
                                    </div>
                                    

                                   
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="serialnumber">Tally Serial No.</label>
                                        <Br/>
                                        <span style="color:red;"><?php echo $row->DB_Cust__SerialKey; ?></span>
                                    </div>

                                    

                                    <div class="form-group">
                                        <label for="partnername">Partner Name</label>
                                        <Br/>
                                        <span style="color:red;"><?php echo $row->PartnerName; ?></span>
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


    