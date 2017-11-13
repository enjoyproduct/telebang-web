<?php $this->load->view(THEME_VM_DIR.'/includes/header');?>
<div id="is-content" class="is-content" data-is-full-width="true">
    <div class="content-area ">
        <div class="breadcrumb bg-category">
            <div class="container">
                <h3 class="headding-title">
                    Subscription History
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
                                  <legend>Subscription History</legend>
                                  <table class="table table-category table-bordered table-striped">
                                  <tr>
                                    <th>Time</th>
                                    <th>Amount</th>
                                    <th>Card Number</th>
                                  </tr>
                                  <?php foreach ($subscription_history as $subscription) {

                                  ?>
                                   <tr>

                                    <td><?php echo date('m/d/Y', $subscription['time']) ?></td>
                                    <td><?php echo $subscription['amount'] ?></td>
                                    <td><?php echo $subscription['card_number'] ?></td>
                                  </tr>
                                  <?php
                                  }
                                  ?>
                                 
                                  </table>
                                </fieldset>
                            </form>
                            
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



