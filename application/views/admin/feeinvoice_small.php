<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
<style>
           @media print {
  body * {
    visibility: hidden;
  }
  #section-to-print, #section-to-print * {
    visibility: visible;
  }
  #section-to-print {
    position: absolute;
    left: 0;
    top: 0;
  }
}
</style>
<script language="javascript">
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
    <?php
        $user = $this->session->get_userdata();
   
        ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gymautomate | Dashboard</title>
</head>
<body>
<div id="printableArea" style="background-color:#FFF;">

<div style="font-size:60px;font-weight:bold"><?php echo $user['log_username']; ?></div><br />
<div style="font-size:35px;"><?php echo $user['address']; ?></div> <br />
<div style="font-size:35px;">Contact: <?php echo $user['phone']; ?> </div><br />
<div style="font-size:35px;">Date:<?php echo date('d/m/Y'); ?> Due Date:<?php echo date("d/m/Y",strtotime($feepostdata['payment_date'])); ?> <br /><br /> </div>
<div style="font-size:40px;font-weight:bold">
Name:<?php echo $memberdetail[0]['name']; ?> <br /> 

Member No:<?php echo $memberdetail[0]['id']; ?> <br /> </div>
---------------------------------------------------------------------------------------------------------------------------------------- <br />
<div style="font-size:40px;">
<table width="100%" border="0">
  <tr>
    <td width="325" style="font-size:40px !important;">Gym Package Fee</td>
    <td width="295" style="font-size:40px !important;"><?php echo $this->session->userdata['currency_symbol']."".$feepostdata['fees']; ?></td>
  </tr>
  <tr>
    <td style="font-size:40px !important;">Arrears</td>
    <td style="font-size:40px !important;"><?php echo $this->session->userdata['currency_symbol']; ?>0</td>
  </tr>
  <tr>
    <td style="font-size:40px !important;">Others</td>
    <td style="font-size:40px !important;"><?php echo $this->session->userdata['currency_symbol']; ?>0</td>
  </tr>
</table>
</div> <br />
----------------------------------------------------------------------------------------------------------------------------------------
<div class="customlargediv" style="font-size:40pt !important;">
<table width="100%" border="0">
  <tr>
    <td width="325" style="font-size:40px !important;">Total Amount:</td>
    <td width="295" style="font-size:40px !important;"><?php echo $this->session->userdata['currency_symbol']."".$feepostdata['fees']; ?></td>
  </tr>
  <tr>
    <td style="font-size:40px !important;">Total Recieved:</td>
    <td style="font-size:40px !important;"><?php echo $this->session->userdata['currency_symbol']."".$feepostdata['fees']; ?></td>
  </tr>
</table>
</div>
----------------------------------------------------------------------------------------------------------------------------------------

<br />
<br/>
<br />
<br/><br />
<br/>

<div style="font-size:35px;"> Note:<br />
i-Rights of admission Reserved. <br/>
ii-Please pay your dues on time. <br/>
iii-Exercise with gym apparel only. </div>
  
 

<br/><br/><br/><br/>
<div style="font-size:40px;text-align:center">
Thanks For Choosing </div>
<div style="font-size:40px;font-weight:bold;text-align:center">
<?php echo $user['log_username']; ?>
 </div>
 
 <br/>
 
 <div style="font-size:33px;text-align:center">
 Designed & Developed By Gym Automate <br/>
Phone# <?php echo $user['phone']; ?> 
 </div>
 </div>
 </br> </br> </br>

 </body>
</html>
