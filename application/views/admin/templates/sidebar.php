<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<?php
    $authorization=$this->session->userdata('authorization');
?>




<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        
        <li class="<?php if(isset($page) && $page=="dashboard"){echo 'active'; }?>">
          <a href="<?php echo site_url(); ?>admin">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            
          </a>
        </li>
          <?php if( (isset($authorization['members_access']) && $authorization['members_access']==1 && $this->session->userdata('parent_gym')==0) || $this->session->userdata('parent_gym')==1){ ?>
         <li class="treeview <?php if(isset($page) && ($page=="members" || $page=="addmember" || $page=="editmember" || $page=="searchmember") ){echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Members</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(isset($page) && $page=="members"){echo 'active'; }?>"><a href="<?php echo site_url('members'); ?>"><i class="fa fa-circle-o"></i> All Members</a></li>
<!--            <li class="<?php if(isset($page) && $page=="searchmember"){echo 'active'; }?>"><a href="<?php echo site_url('admin/members/search'); ?>"><i class="fa fa-circle-o"></i> Search Member</a></li>-->
            <li class="<?php if(isset($page) && $page=="addmember"){echo 'active'; }?>"><a href="<?php echo site_url('admin/members/add'); ?>"><i class="fa fa-circle-o"></i> Add New</a></li>
            
          </ul>
        </li>
          <?php } ?>
          
          <?php if( (isset($authorization['packages_access']) && $authorization['packages_access']==1 && $this->session->userdata('parent_gym')==0) || $this->session->userdata('parent_gym')==1){ ?>
          <li class="treeview <?php if(isset($page) && ($page=="packages" || $page=="addpackage" || $page=="editpackage") ){echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-cubes"></i>
            <span>Packages</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(isset($page) && $page=="packages"){echo 'active'; }?>"><a href="<?php echo site_url('packages'); ?>"><i class="fa fa-circle-o"></i> All Packages</a></li>
            <li class="<?php if(isset($page) && $page=="addpackage"){echo 'active'; }?>"><a href="<?php echo site_url('admin/packages/add'); ?>"><i class="fa fa-circle-o"></i> Add New</a></li>
            
          </ul>
        </li>
          <?php } ?>
          
          <?php /* if( (isset($authorization['stats_access']) && $authorization['stats_access']==1 && $this->session->userdata('parent_gym')==0) || $this->session->userdata('parent_gym')==1){ ?>
          <li class="treeview <?php if(isset($page) && ($page=="chart") ){echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Stats</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(isset($page) && $page=="chart"){echo 'active'; }?>"><a href="<?php echo site_url('chart'); ?>"><i class="fa fa-circle-o"></i> All Stats</a></li>
           
            
          </ul>
        </li>
          <?php } */ ?>
          
          <?php if( (isset($authorization['users_access']) && $authorization['users_access']==1 && $this->session->userdata('parent_gym')==0) || $this->session->userdata('parent_gym')==1){ ?>
          <li class="treeview <?php if(isset($page) && ($page=="users" || $page=="adduser" || $page=="edituser") ){echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Users</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(isset($page) && $page=="users"){echo 'active'; }?>"><a href="<?php echo site_url('users'); ?>"><i class="fa fa-circle-o"></i> All Users</a></li>
            <li class="<?php if(isset($page) && $page=="adduser"){echo 'active'; }?>"><a href="<?php echo site_url('admin/users/addadminusers'); ?>"><i class="fa fa-circle-o"></i> Add New</a></li>
          </ul>
        </li>
          <?php } ?>
          <?php if( (isset($authorization['staffmembers_access']) && $authorization['staffmembers_access']==1 && $this->session->userdata('parent_gym')==0) || $this->session->userdata('parent_gym')==1){ ?>
          <li class="treeview <?php if(isset($page) && ($page=="staffmembers" || $page=="addstaffmember" || $page=="editstaffmember" || $page=="staffmemberdetail") ){echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Staff Members</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(isset($page) && $page=="staffmembers"){echo 'active'; }?>"><a href="<?php echo site_url('admin/staffmembers'); ?>"><i class="fa fa-circle-o"></i> All Staff Members</a></li>
            <li class="<?php if(isset($page) && $page=="addstaffmember"){echo 'active'; }?>"><a href="<?php echo site_url('admin/staffmembers/add'); ?>"><i class="fa fa-circle-o"></i>Add New</a></li>
          </ul>
        </li>
          <?php } ?>
          
          <?php if( (isset($authorization['expenses_access']) && $authorization['expenses_access']==1 && $this->session->userdata('parent_gym')==0) || $this->session->userdata('parent_gym')==1){ ?>
          <li class="treeview <?php if(isset($page) && ($page=="expenses") ){echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-money"></i>
            <span>Expenses</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(isset($page) && $page=="expenses"){echo 'active'; }?>"><a href="<?php echo site_url('expenses'); ?>"><i class="fa fa-circle-o"></i> All Expenses</a></li>
          </ul>
        </li>
          <?php } ?>
           <?php if( (isset($authorization['profitloss_access']) && $authorization['profitloss_access']==1 && $this->session->userdata('parent_gym')==0) || $this->session->userdata('parent_gym')==1){ ?>
          <li class="treeview <?php if(isset($page) && ($page=="balancesheet") ){echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-bar-chart"></i>
            <span>Profit & Loss</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(isset($page) && $page=="balancesheet"){echo 'active'; }?>"><a href="<?php echo site_url('balancesheet'); ?>"><i class="fa fa-circle-o"></i> All Profit & Loss</a></li>
          </ul>
        </li>
           <?php } ?>
          <?php if( (isset($authorization['attendences_access']) && $authorization['attendences_access']==1 && $this->session->userdata('parent_gym')==0) || $this->session->userdata('parent_gym')==1){ ?>
          <li class="treeview <?php if(isset($page) && ($page=="attendences" || $page=="manualattendence") ){echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-pencil-square-o"></i>
            <span>Attendences</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(isset($page) && $page=="attendences"){echo 'active'; }?>"><a href="<?php echo site_url('attendences'); ?>"><i class="fa fa-circle-o"></i> All Attendences</a></li>
            
            <li class="<?php if(isset($page) && $page=="attendencelist"){echo 'active'; }?>"><a href="<?php echo site_url('attendencelist'); ?>"><i class="fa fa-circle-o"></i> Attendence Chart</a></li>
             
              <li class="<?php if(isset($page) && $page=="manualattendence"){echo 'active'; }?>"><a href="<?php echo site_url('manual_attendednce'); ?>"><i class="fa fa-circle-o"></i> Add Attendence</a></li>
                          
              
              
          </ul>
        </li>
          <?php } ?>
          <?php if( (isset($authorization['logs_access']) && $authorization['logs_access']==1 && $this->session->userdata('parent_gym')==0) || $this->session->userdata('parent_gym')==1){ ?>
          <li class="treeview <?php if(isset($page) && ($page=="logs") ){echo 'active'; }?>">
          <a href="#">
            <i class="fa ion-clipboard"></i>
            <span>Logs</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(isset($page) && $page=="logs"){echo 'active'; }?>"><a href="<?php echo site_url('admin/logs/alllogs'); ?>"><i class="fa fa-circle-o"></i> All Logs</a></li>
          </ul>
        </li>
          <?php } ?>
          <?php if( (isset($authorization['charts_access']) && $authorization['charts_access']==1 && $this->session->userdata('parent_gym')==0) || $this->session->userdata('parent_gym')==1){ ?>
          <li class="treeview <?php if(isset($page) && ($page=="attendencecharts" || $page=="profitlosscharts" || $page=="profitlosscharts2" || $page=="reportscharts" || $page=="feesreport") ){echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-area-chart"></i>
            <span>Charts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(isset($page) && $page=="attendencecharts"){echo 'active'; }?>"><a href="<?php echo site_url('attendencecharts'); ?>"><i class="fa fa-circle-o"></i> All Attendence Charts</a></li>
              <li class="<?php if(isset($page) && $page=="profitlosscharts"){echo 'active'; }?>"><a href="<?php echo site_url('profitlosscharts'); ?>"><i class="fa fa-circle-o"></i> All Profit & Loss Charts</a></li>
              <li class="<?php if(isset($page) && $page=="profitlosscharts2"){echo 'active'; }?>"><a href="<?php echo site_url('profitlosscharts2'); ?>"><i class="fa fa-circle-o"></i> Profit & Loss Bar Chart</a></li>
              
              <li class="treeview <?php if(isset($page) && ($page=="reportscharts" || $page=="feesreport") ){echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-file-text-o"></i>
            <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
                  <ul class="treeview-menu"><li class="<?php if(isset($page) && $page=="reportscharts"){echo 'active'; }?>"><a href="<?php echo site_url('reports'); ?>"><i class="fa fa-circle-o"></i> Member Registrations</a></li>
              <li class="<?php if(isset($page) && $page=="feesreport"){echo 'active'; }?>"><a href="<?php echo site_url('feesreport'); ?>"><i class="fa fa-circle-o"></i> Fees Report</a></li></ul>
              </li>
              
          </ul>
        </li>
          <?php } ?>
          <?php if( (isset($authorization['calendar_access']) && $authorization['calendar_access']==1 && $this->session->userdata('parent_gym')==0) || $this->session->userdata('parent_gym')==1){ ?>
          <li class="treeview <?php if(isset($page) && ($page=="calendar") ){echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-calendar"></i>
            <span>Calendar</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(isset($page) && $page=="calendar"){echo 'active'; }?>"><a href="<?php echo site_url('calendar'); ?>"><i class="fa fa-circle-o"></i> All Calendar</a></li>
          </ul>
        </li>
          <?php } ?>
          <?php if( (isset($authorization['sms_access']) && $authorization['sms_access']==1 && $this->session->userdata('parent_gym')==0) || $this->session->userdata('parent_gym')==1){ ?>
          <li class="treeview <?php if(isset($page) && ($page=="sms") ){echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-envelope-o"></i>
            <span>SMS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(isset($page) && $page=="sms"){echo 'active'; }?>"><a href="<?php echo site_url('sms'); ?>"><i class="fa fa-circle-o"></i>Type SMS</a></li>
          </ul>
        </li>
          <?php } ?>
          <?php if( (isset($authorization['settings_access']) && $authorization['settings_access']==1 && $this->session->userdata('parent_gym')==0) || $this->session->userdata('parent_gym')==1){ ?>
          <li class="treeview <?php if(isset($page) && ($page=="settings") ){echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-gears"></i>
            <span>Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(isset($page) && $page=="settings"){echo 'active'; }?>"><a href="<?php echo site_url('settings'); ?>"><i class="fa fa-circle-o"></i> All Settings</a></li>
          </ul>
        </li>
          <?php } ?>
          
         
       
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

