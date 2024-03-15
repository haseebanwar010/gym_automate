<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
         
          <?php $user = $this->session->get_userdata(); 
		
		  ?>
          
         
         <ul class="sidebar-menu" data-widget="tree">
      
              
              
           
            <li class="<?php if(isset($page) && $page=="dashboard"){echo 'active'; }?>">
          <a href="<?php echo site_url(); ?>superadmin">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            
          </a>
        </li>
            
     
               <li class="treeview <?php if(isset($page) && ($page=="gyms" || $page=="gymsadd") ){echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-hospital-o"></i>
            <span>Gyms</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(isset($page) && $page=="gyms"){echo 'active'; }?>"><a href="<?php echo site_url('gyms'); ?>"><i class="fa fa-circle-o"></i> All Gyms</a></li>
            <li class="<?php if(isset($page) && $page=="gymsadd"){echo 'active'; }?>"><a href="<?php echo site_url('superadmin/gym/add'); ?>"><i class="fa fa-circle-o"></i> Add Gym</a></li>
          </ul>
        </li>
             
             
             <li class="treeview <?php if(isset($page) && ($page=="country" || $page=="countryadd") ){echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-flag-checkered"></i>
            <span>Countries</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(isset($page) && $page=="country"){echo 'active'; }?>"><a href="<?php echo site_url('countries'); ?>"><i class="fa fa-circle-o"></i> All Countries</a></li>
            <li class="<?php if(isset($page) && $page=="countryadd"){echo 'active'; }?>"><a href="<?php echo site_url('superadmin/countries/add'); ?>"><i class="fa fa-circle-o"></i> Add Country</a></li>
          </ul>
        </li>
             
             <li class="treeview <?php if(isset($page) && ($page=="cities" || $page=="citiesadd") ){echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-map"></i>
            <span>Cities</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(isset($page) && $page=="country"){echo 'active'; }?>"><a href="<?php echo site_url('cities'); ?>"><i class="fa fa-circle-o"></i> All Cities</a></li>
            <li class="<?php if(isset($page) && $page=="countryadd"){echo 'active'; }?>"><a href="<?php echo site_url('superadmin/cities/add'); ?>"><i class="fa fa-circle-o"></i> Add City</a></li>
          </ul>
        </li>
             
             <li class="treeview <?php if(isset($page) && ($page=="currency" || $page=="currencyadd") ){echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-money"></i>
            <span>Currencies</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(isset($page) && $page=="country"){echo 'active'; }?>"><a href="<?php echo site_url('currencies'); ?>"><i class="fa fa-circle-o"></i> All Currencies</a></li>
            <li class="<?php if(isset($page) && $page=="countryadd"){echo 'active'; }?>"><a href="<?php echo site_url('superadmin/currencies/add'); ?>"><i class="fa fa-circle-o"></i> Add Currency</a></li>
          </ul>
        </li>
              
           
          </ul>
          
          <!-- sidebar menu: : style can be found in sidebar.less -->
          
        </section>
        <!-- /.sidebar -->
      </aside>