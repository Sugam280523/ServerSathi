
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
                  <a href="#">Customer Demo Activation</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Customer Demo Activation</div>
                    <p><span class="text-danger">*</span> All fields are mandatory</p>
                  </div>
                  <div class="card-body">
                    <form id="formId" action="<?php echo base_url('Customer-Demo');?>" method="POST" autocomplete="Off">
                        <?php if($this->session->flashdata('success')){ ?>
                            <div class="alert alert-success "> <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Success!</strong>&nbsp;&nbsp;<?php echo $this->session->flashdata('success'); ?> </div>
                        <?php }else if($this->session->flashdata('error')){  ?>
                            <div class="alert alert-danger"> &nbsp;&nbsp;<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Danger!</strong>&nbsp;&nbsp;<?php echo $this->session->flashdata('error'); ?></div>
                        <?php } ?>
                        <div class="row">
                          <!-- customerdata -->
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                            <label for="PaymentStatus"
                                >Select Customer</label
                            >
                            <select
                                class="form-select"
                                id="CustomerID"
                                name="CustomerID"
                            >
                                <option disabled selected value="">Select Activation Customer </option>
                                <?php 
                                  foreach ($customerdata as $cust) {
                                      echo '<option value="'.$cust->DB_Cust__Id.'">'.$cust->DB_Cust__Name.' ['.$cust->DB_Cust__FirmName.']</option>';
                                  }
                                ?>
                            </select> 
                            <span style="color:red;"><?php echo form_error('CustomerID'); ?></span>                         
                            </div>  
                            <div class="form-group">
                            <label for="ApiKey"> API Key</label>
                            <input
                                type="text"
                                class="form-control"
                                id="ApiKey"
                                name="ApiKey"
                                placeholder="Enter Api Key"
                                value="<?php echo set_value('ApiKey'); ?>"
                            />
                            <span style="color:red;"><?php echo form_error('ApiKey'); ?></span>
                            </div>                      
                           <div class="form-group">
                              <label for="Customer-Profile-Details">Customer Details</label>
                              <span></span>
                              <div id="Customer-Profile-Details">   
                                </div>
                          </div>
                            
                            
                            
                          
                            
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                              <label for="VoucherType">Voucher Type</label>
                              <select
                                  class="form-select"
                                  id="VoucherType"
                                  name="VoucherType[]"
                                  multiple
                              >
                                  <option disabled value="">Select Voucher Type</option>
                                  <?php
                                  // Define available voucher types
                                  $states = ['Credit Note', 'Debit Note', 'Sales', 'Purchase', 'Receipt', 'Payment'];

                                  // Get previously selected values (as array)
                                  $selected_states = set_value('VoucherType', isset($row->DB_VoucherType) ? explode(',', $row->DB_VoucherType) : []);

                                  foreach ($states as $state) {
                                      $sel = (is_array($selected_states) && in_array($state, $selected_states)) ? 'selected' : '';
                                      echo "<option value='{$state}' {$sel}>{$state}</option>";
                                  }
                                  ?>
                              </select>
                              <small class="form-text text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple options</small>
                              <span style="color:red;"><?php echo form_error('VoucherType[]'); ?></span>
                          </div>
                             <div class="form-group">
                            <label for="SaleApiKey"> Sales Key</label>
                            <input
                                type="text"
                                class="form-control"
                                id="SaleApiKey"
                                name="SaleApiKey"
                                placeholder="Enter Sale Api Key"
                                value="<?php echo set_value('SaleApiKey'); ?>"
                                readonly
                            />
                            <span style="color:red;"><?php echo form_error('SaleApiKey'); ?></span>
                            </div>
                            <div class="form-group">
                            <label for="PurchaseApiKey"> Purchase Key</label>
                            <input
                                type="text"
                                class="form-control"
                                id="PurchaseApiKey"
                                name="PurchaseApiKey"
                                placeholder="Enter Purchase Api Key"
                                readonly
                                value="<?php echo set_value('PurchaseApiKey'); ?>"
                            />
                            <span style="color:red;"><?php echo form_error('PurchaseApiKey'); ?></span>
                            </div>
                            
                            
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                            <label for="CreditNoteApiKey"> Credit Note Key</label>
                            <input
                                type="text"
                                class="form-control"
                                id="CreditNoteApiKey"
                                name="CreditNoteApiKey"
                                placeholder="Enter Credit Note Api Key"
                                readonly
                                value="<?php echo set_value('CreditNoteApiKey'); ?>"
                            />
                            <span style="color:red;"><?php echo form_error('CreditNoteApiKey'); ?></span>
                            </div>
                            <div class="form-group">
                            <label for="DebitNoteApiKey"> Debit Note Key</label>
                            <input
                                type="text"
                                class="form-control"
                                id="DebitNoteApiKey"
                                name="DebitNoteApiKey"
                                placeholder="Enter Debit Note Api Key"
                                readonly
                                value="<?php echo set_value('DebitNoteApiKey'); ?>"
                            />
                            <span style="color:red;"><?php echo form_error('DebitNoteApiKey'); ?></span>
                            </div>                    
                           <div class="form-group">
                            <label for="PaymentApiKey"> Payment Key</label>
                            <input
                                type="text"
                                class="form-control"
                                id="PaymentApiKey"
                                name="PaymentApiKey"
                                readonly
                                placeholder="Enter Payment Api Key"
                                value="<?php echo set_value('PaymentApiKey'); ?>"
                            />
                            <span style="color:red;"><?php echo form_error('PaymentApiKey'); ?></span>
                            </div>
                          <div class="form-group">
                            <label for="ReceiptApiKey"> Receipt Key</label>
                            <input
                                type="text"
                                class="form-control"
                                id="ReceiptApiKey"
                                name="ReceiptApiKey"
                                placeholder="Enter Receipt Api Key"
                                readonly
                                value="<?php echo set_value('ReceiptApiKey'); ?>"
                            />
                            <span style="color:red;"><?php echo form_error('ReceiptApiKey'); ?></span>
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


    