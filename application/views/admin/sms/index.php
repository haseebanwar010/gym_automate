<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php 
    
    ?>
    
         
   
          <section class="content-header">
      <h1>
        SMS
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>sms">SMS</a></li>
        <li class="active">Type SMS</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
  
   <section class="content alertcontent smsvalidation">    
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4>
                <div id="errormsg" class="errormsg">
                </div>
            </div>
        </section>

          
            <div class="alert alert-success alert-dismissible smssuccess">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                SMS Send Successfully!
              </div>     
            
        
        <div class="box box-warning">
        
  <div class="box-header customer">
                <h3 class="box-title">Type SMS</h3>
      <p class="smsmp"><span class="pull-left smslabeltext">Total Available SMS: </span><small class="label pull-left bg-green customavailablessmsspan smscounterlimit"><?php echo $totalsms_available; ?></small></p>
                </div>
        <div class="box-body">
            <form id="smsform">
            <div class="col-md-12">
            <div class="form-group customrgroup">
                <label>
                  <input type="radio" name="member_group" value="all" class="flat-red">
                    All Members
                </label>
                <label>
                  <input type="radio" name="member_group" value="active" class="flat-red">
                    Active Members
                </label>
                <label>
                  <input type="radio" name="member_group" value="inactive" class="flat-red">
                    Inactive Members
                </label>
               
              </div>
              </div>
            <div class="col-md-6">
            <div class="form-group">
                  <label>Subject</label>
                  <input type="text" name="subject" class="form-control" placeholder="Enter Subject">
                </div>
            </div>
            <div class="col-md-12">
            <div class="form-group">
                  <label>Message</label>
                  <textarea maxlength="300" name="message" class="form-control messagetext" rows="3" placeholder="Enter Message"></textarea>
                </div>
            </div>
                <div class="col-md-12">
            <div class="form-group">
                  <label>Signature</label>
                  <textarea maxlength="300" name="signature" class="form-control signaturetext" rows="3" placeholder="Enter Signature"><?php echo $_SESSION["username"]."\n".$_SESSION["phone"]."\n".$_SESSION["address"]; ?></textarea>
                </div>
            </div>
            </form>
            <div class="col-lg-12">
                    <div class="form-group">
                        <button id="sendsmsbtn" class="btn bg-navy margin submitbtn" type="submit">Send</button>
                    </div>
                </div>
        </div>
        </div>
    </section><!-- /.content -->
</div>


<script>
    $('document').ready(function(){
        var baseurl="<?php echo $baseUrl; ?>";
        
        function sendsmsfunction(members,messageparam,subject,signature){
            var message=subject;
            message+="\n\n";
            
            message+=messageparam;
            message+="\n\n";
            message+=signature;
            var msg=encodeURI(message);
            for(var k=0;k<members.length;k++){
                
            
            var url="http://api.bizsms.pk/api-send-branded-sms.aspx?username=abaskatech@bizsms.pk&pass=ab3sth99&text="+message+"&masking=SMS Alert&destinationnum="+members[k].phone+"&language=English";
            var url=encodeURI(url);
            console.log(msg);
            console.log(url);
            console.log(members);
            console.log(subject);
            
            $.ajax({
                url: url,
                type: 'POST',
                success: function(data){
                    console.log(data);
                },
                error: function(){
                }
            });
            }
        }
        
        
        
        $('#sendsmsbtn').click(function(){
            $("#sendsmsbtn").html('Sending..');
     $('#sendsmsbtn').attr('disabled', 'disabled');
            var membergroup = $('#smsform').find('input[name="member_group"]:checked').val();
            var subject = $('#smsform').find('input[name="subject"]').val();
            var message = $('.messagetext').val();
            var signature = $('.signaturetext').val();
            var total_messages_send=0;
            var error_flag=true;
            var errormsg="<p>";
            if(membergroup==undefined){
                errormsg+="Please select member group<br>";
                error_flag=false;
            }
            if(subject==""){
                errormsg+="Please enter subject<br>";
                error_flag=false;
            }
            if(message==""){
                errormsg+="Please enter message<br>";
                error_flag=false;
            }
            errormsg+="</p>";
            if(error_flag==false){
                $("#errormsg").html(errormsg);
                $('.smsvalidation').show();
                 $("#sendsmsbtn").html('Send');
     $('#sendsmsbtn').attr('disabled', false);
            }
            else{
                $("#errormsg").html("");
                $('.smsvalidation').hide();
                
                
                var url=baseurl+"admin/sms/get_members_bygroup/";
            $.ajax({
                url: url,
                dataType: 'json',
                type: 'POST',
                data: { membergroup:membergroup } ,

                success: function(data){
                    total_messages_send=data.members.length;
                    total_available_messsages=data.totalsms_available.sms_counter_limit;
                    if(total_available_messsages<total_messages_send){
                        var errormsg="<p>The group you have selected contains "+total_messages_send+" members and your remaining sms bucket contains "+total_available_messsages+" sms. <br>Please contact your service provider.</p>";
                        $("#errormsg").html(errormsg);
                        $('.smsvalidation').show();
                         $("#sendsmsbtn").html('Send');
     $('#sendsmsbtn').attr('disabled', false);
                    }
                    else{
                        $("#errormsg").html("");
                        $('.smsvalidation').hide();
                    sendsmsfunction(data.members,message,subject,signature);
                        
                        var url=baseurl+"admin/sms/decrease_sms_numbers/";
                        $.ajax({
                url: url,
                dataType: 'json',
                type: 'POST',
                data: { total_messages_send:total_messages_send } ,

                success: function(data){
                    
                    $('#smsform').trigger("reset");
                        $("#sendsmsbtn").html('Send');
     $('#sendsmsbtn').attr('disabled', false);
                    
                    $('.smscounterlimit').html(total_available_messsages-total_messages_send);
                    total_available_messsages=total_available_messsages-total_messages_send;
                    $('.smssuccess').show();
                },
                error: function(){
                }
            });
                        
                        
                        
                        
                        
                        
                        
                        console.log("after function");
                    }
                    
                },
                error: function(){

                }
            });
                
                
                
            }
        });
            
    });
</script>