<?php $this->load->view(THEME_VM_DIR.'/includes/header');?>
<script src="https://js.paystack.co/v1/paystack.js"></script>
<div id="is-content" class="is-content" data-is-full-width="true">
    <div class="content-area ">
        <div class="breadcrumb bg-category">
            <div class="container">
                <h3 class="headding-title">
                    Subscription
                </h3>
            </div>
        </div>
        <div class="section ">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="container">
                            <form class="form-horizontal col-sm-8" role="form" id="card-form" action="" method="get">
                                <fieldset>
                                  <legend>Subscription</legend>
                                  <input type="text" class="hidden" name="user_id" id="user_id" value="<?php echo $customer_model['UserId'];?>">
                                  <!-- <div class="form-group">
                                    <label class="col-sm-3 control-label" for="card-holder-name">Name on Card</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="card-holder-name" id="card-holder-name" placeholder="Card Holder's Name">
                                    </div>
                                  </div> -->
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="subscription-type">Subscription Type</label>
                                    <div class="col-sm-9">
                                      <div class="row">
                                        <div class="col-xs-3">
                                          <select class="form-control col-sm-2" name="subscription-type" id="subscription-type">
                                            <option value="0">1 month</option>
                                            <option value="1">3 month</option>
                                            <option value="2">6 month</option>
                                            <option value="3">12 month</option>
                                          </select>
                                        </div>
                                        
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-3 control-label" for="number">Card Number</label>
                                    <div class="col-sm-9">
                                      <input type="number" class="form-control" name="number" id="number" data-paystack="number" placeholder="Debit/Credit Card Number">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-3 control-label" for="expiryMonth">Expiration Date</label>
                                    <div class="col-sm-9">
                                      <div class="row">
                                        <div class="col-xs-3">
                                          <select class="form-control col-sm-2" name="expiryMonth" id="expiryMonth" data-paystack="expiryMonth">
                                            <option value="01">Jan (01)</option>
                                            <option value="02">Feb (02)</option>
                                            <option value="03">Mar (03)</option>
                                            <option value="04">Apr (04)</option>
                                            <option value="05">May (05)</option>
                                            <option value="06">Jun (06)</option>
                                            <option value="07">Jul (07)</option>
                                            <option value="08">Aug (08)</option>
                                            <option value="09">Sep (09)</option>
                                            <option value="10">Oct (10)</option>
                                            <option value="11">Nov (11)</option>
                                            <option value="12">Dec (12)</option>
                                          </select>
                                        </div>
                                        <div class="col-xs-3">
                                          <select class="form-control" name="expiryYear" id="expiryYear" data-paystack="expiryYear">
                                            <option value="17">2017</option>
                                            <option value="18">2018</option>
                                            <option value="19">2019</option>
                                            <option value="20">2020</option>
                                            <option value="21">2021</option>
                                            <option value="22">2022</option>
                                            <option value="23">2023</option>
                                            <option value="23">2024</option>
                                            <option value="23">2025</option>
                                            <option value="23">2026</option>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-3 control-label" for="cvv">Card CVV</label>
                                    <div class="col-sm-3">
                                      <input type="number" class="form-control" name="cvv" id="cvv" data-paystack="cvv" placeholder="CVV" >
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                      <button type="submit" class="btn btn-success" id="btn_pay" data-paystack="submit">Pay Now</button>
                                      <!-- <button type="button" class="btn btn-success" id="btn_history">Subscription History</button> -->
                                      <a href="<?php echo site_url(SUBSCRIPTION_HISTORY.'/'.$customer_model['UserId']) ?>" class="btn btn-success"> Subscription History</a>
                                    </div>
                                  </div>
                                </fieldset>
                            </form>
                            <form class="form-horizontal col-sm-8" id="pin-form" style="display:none">
                                <div>To confirm you're the owner of this card, please enter your card pin</div>
                                <div class="col-sm-offset-3 col-sm-3">
                                    <input type="password" class="form-control col-sm-3" id="pin" data-paystack="pin" placeholder="pin">
                                </div>
                                <button type="submit" class="btn btn-success" data-paystack="submit">Continue</button>
                            </form>
                            <form class="form-horizontal col-sm-8" id="otp-form" style="display:none">
                                <div id="otp-message"></div>
                                <div class="col-sm-offset-3 col-sm-3">
                                    <input type="text" class="form-control col-sm-3" id="otp" data-paystack="otp" placeholder="otp">
                                </div>
                                <button type="submit" class="btn btn-success" data-paystack="submit">Continue</button>
                            </form>

                            <form class="form-horizontal col-sm-8" id="3ds-form" style="display:none">
                                <div id="3ds-message"></div>
                                <button type="submit" class="btn btn-success col-sm-offset-6" data-paystack="submit">Continue</button>
                            </form>

                            <form class="form-horizontal col-sm-8" id="phone-form" style="display:none">
                                <div id="phone-message"></div>
                                <div class="col-sm-offset-3 col-sm-3">
                                    <input type="text" class="form-control col-sm-3" id="phone" data-paystack="phone" placeholder="phone">
                                </div>
                                <button type="submit" class="btn btn-success" data-paystack="submit">Continue</button>
                            </form>

                            <div class="form-horizontal col-sm-8" id="timeout" style="display:none">
                                <div id="timeout-message"></div>
                            </div>

                            <div class="form-horizontal col-sm-8" id="success" style="display:none">
                                <div id="success-message"></div>
                                <div id="success-reference"></div>
                                <div id="success-gateway-response"></div>
                                <div id="verify-error"></div>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-4">
                        <?php $this->load->view(THEME_VM_DIR.'/includes/socical'); ?>
                        <div class="sider-bar">
                            <?php $this->load->view(THEME_VM_DIR.'/sidebar/banner'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view(THEME_VM_DIR.'/includes/footer'); ?>



