
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
                  <a href="#">Customer Activation</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Customer Activation</div>
                    <p><span class="text-danger">*</span> All fields are mandatory</p>
                  </div>
                  <div class="card-body">
                    <form  action="<?php echo base_url('Customer-Activation');?>" method="POST" autocomplete="Off">
                        <?php if($this->session->flashdata('success')){ ?>
                            <div class="alert alert-success "> <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Success!</strong>&nbsp;&nbsp;<?php echo $this->session->flashdata('success'); ?> </div>
                        <?php }else if($this->session->flashdata('error')){  ?>
                            <div class="alert alert-danger"> &nbsp;&nbsp;<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Danger!</strong>&nbsp;&nbsp;<?php echo $this->session->flashdata('error'); ?></div>
                        <?php } ?>
                        <div class="row">
                          <!-- customerdata -->
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                            <label for="CustomerIDAct"
                                >Select Customer</label
                            >
                            <select
                                class="form-select"
                                id="CustomerIDAct"
                                name="CustomerIDAct"
                            >
                                <option disabled selected value="">Select Activation Customer </option>
                                <?php 
                                  foreach ($customerdata as $cust) {
                                      echo '<option value="'.$cust->DB_Cust__Id.'">'.$cust->DB_Cust__Name.' ['.$cust->DB_Cust__FirmName.']</option>';
                                  }
                                ?>
                            </select> 
                            <span style="color:red;"><?php echo form_error('CustomerIDAct'); ?></span>                         
                            </div>                        
                           <div class="form-group">
                              <label for="Customer-Profile-Details">Customer Lead  Details</label>
                              <span></span>
                              <div id="Customer-Profile-Details">   
                                </div>
                          </div>                                                     
                        </div>
                        <div class="col-md-6 col-lg-4">
                          <div class="form-group">
                              <label for="Customer-Apikeys-Details">Customer Key Details</label>
                              <span></span>
                              <div id="Customer-Apikeys-Details">   
                                </div>
                          </div>   
                           <div class="form-group">
                              <div class="card-action" id="Customer-Demo-Extends">
                              </div>                            
                            </div> 
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                            <label for="state"
                                >Payment Mode</label
                            >
                            <select
                                class="form-select"
                                id="PaymentMode"
                                name="paymentMode"
                            >
                                <option disabled >Select PaymentMode</option>
                               <?php
                                    $states = ['Cash', 'Online', 'Partner Collection'];
                                    $selected_state = set_value('PaymentMode'); 

                                    foreach ($states as $state) {
                                        echo $sel = ($selected_state == $state) ? 'selected' : '';
                                        echo "<option value='{$state}' {$sel}>{$state}</option>";
                                    }
                                    ?>

                            </select> 
                            <span style="color:red;"><?php echo form_error('PaymentMode'); ?></span>                         
                            </div>
                            <div class="form-group">
                            <label for="PaymentProof">Payment Received </label>
                            <input
                                type="text"
                                class="form-control"
                                id="PaymentProof"
                                name="PaymentProof"
                                placeholder="Enter UTR No/Receipt No/P.Name"
                                value="<?php echo set_value('PaymentProof'); ?>"
                            />
                            <span style="color:red;"><?php echo form_error('PaymentProof'); ?></span>
                            </div>
                                
                            <div class="form-group">
                              <div class="card-action">
                                  
                                  <button class="btn btn-success" value="submit">Active</button>
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


    