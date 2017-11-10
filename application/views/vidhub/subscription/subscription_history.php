<?php $this->load->view(THEME_VM_DIR.'/includes/header');?>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
<table>
  <tr>
    <th>Date</th>
    <th>Amount</th>
    <th>Card Number</th>
  </tr>
  <?php 
  for ($subscriptions as $subscription) {
  ?>
  <tr>
    <td><?php ?></td>
    <td><?php echo $subscription['amount'] ?></td>
    <td><?php echo $subscription['card_number'] ?></td>
  </tr>
  <?php
  }
  ?>
  <tr>
    <td>Alfreds Futterkiste</td>
    <td>Maria Anders</td>
    <td>Germany</td>
  </tr>
  <tr>
    <td>Centro comercial Moctezuma</td>
    <td>Francisco Chang</td>
    <td>Mexico</td>
  </tr>
</table>

