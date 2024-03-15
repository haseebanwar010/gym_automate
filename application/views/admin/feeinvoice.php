<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fitness Club</title>
    <link rel="stylesheet" href="<?php echo base_url()?>frontend/css/style_print_wic.css" media="all" />
    <style>
        .left-sign{
            margin-top:60px;


        }
    </style>
</head>
<body>
<header class="clearfix">
    <div id="logo">

        <?php
        $user = $this->session->get_userdata();
        ?>
        
        <?php if(isset($user['image']) && !empty($user['image'])){ ?>
        <img src="<?php echo site_url('uploads/thumb/'.$user['image']); ?>"/></div>
        <?php } else{ ?>
        <img src="<?php echo base_url()?>frontend/images/gymlogo.png"/></div>
    <?php } ?>
    <h1>FEE DETAILS</h1>

    <div id="project">
        <div class="headings">Payment To</div>

        <div><?php echo $gymdetail[0]['name']; ?></div>
        <div><?php echo $gymdetail[0]['address']; ?></div>
        <div><?php echo $gymdetail[0]['phone']; ?></div>


    </div>
    <div id="company" class="clearfix">
        <div class="headings hds">Bill To</div>
        <div><?php echo $memberdetail[0]['name']; ?></div>
        <div><?php echo $memberdetail[0]['address']; ?></div>
        <div><?php echo $memberdetail[0]['phone']; ?></div>

    </div>

    <div id="project" class="track_status" style="font-weight: bold;
  		font-size: 1em;">

        <div><span>Status: </span> <span class="track_span">Paid</span></div>

    </div>
</header>
<main>
    <table>
        <thead>
        <tr>
            <!--<th class="service">SERVICE</th>
            <th class="desc">DESCRIPTION</th>
            <th>PRICE</th>
            <th>QTY</th>
            <th>TOTAL</th>-->
            <th>FEE DETAILS</th>
            <th></th>

        </tr>

        </thead>
        <tbody>
        <tr>
            <td class="unit">Fee</td>
            <td class="unit"><?php echo $this->session->userdata['currency_symbol']."".$feepostdata['fees']; ?></td>
        </tr>
        <tr>
            <td class="unit">Date</td>
            <td class="qty"><?php echo date("d-M-Y",strtotime($feepostdata['payment_date'])); ?></td>
        </tr>
        <tr>
            <td class="unit">Description</td>
            <td class="qty"><?php echo $feepostdata['comment']; ?></td>
        </tr>






   
        <tr>
            <td style="font-style: bold;" class="unit">Total</td>
            <td class="qty"><?php echo $this->session->userdata['currency_symbol']."".$feepostdata['fees']; ?></td>
        </tr>


        </tbody>
    </table>

</main>


<div class="footer_detail">
<?php $user = $this->session->get_userdata(); 
    
    ?>
    
    <p><?php echo $user['address']; ?></p>
    <p class="detail_width"><?php echo $user['phone']; ?>, <a href="mailto:<?php echo $user['email']; ?>"><?php echo $user['email']; ?></a></p>

</div>


<!--<header class="clearfix">

      <!--<div id="project">
      	<div class="headings">From</div>

        <div><?php echo $shipments[0]['sender_name']." ". $shipments[0]['sender_last_name'];?></div>
        <div><?php echo $shipments[0]['sender_address']; ?></div>
        <div><?php echo $shipments[0]['sender_phone'];?></div>
        <div><?php echo $shipments[0]['company_name'];?></div>
        <div><?php echo $shipments[0]['created_date'];?></div>
        <!--<div><span>DUE DATE</span> September 17, 2015</div>--
      </div>
      <div id="company" class="clearfix">
      	<div class="headings hds">To</div>
        <div><?php echo  $shipments[0]['receiver_first_name']." ". $shipments[0]['receiver_last_name'];?></div>
        <div><?php echo  $shipments[0]['receiver_address'];?></div>
        <div><?php echo  $shipments[0]['receiver_phone'];?></div>

      </div>
    </header>-->

<!-- <div class="signature left-sign"><span class="sign_heading">Signature:</span><span class="sign_text"></span></div>-->
<!--  <div class="signature right-sign"><span class="sign_heading">Signature:</span><span class="sign_text"></span></div>-->
</body>
</body>
</html>