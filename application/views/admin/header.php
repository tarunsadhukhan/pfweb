
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Vow Supplement  </title>

 <!-- Font Awesome -->
 
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">



  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<style>
    .brand-text-wrapper {
        display: block; /* Makes it a block-level element, so it appears on a new line */
        margin-top: 5px; /* Adjust the top margin to control spacing */
        font-size: 14px; /* Adjust the font size as needed */
        /* Add any other styling you want here */
    }
</style>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>

    <!-- SEARCH FORM -->
    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      
        <a class="nav-link" data-toggle="dropdown" href="#">
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?php echo base_url()?>public/admin/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?php echo base_url()?>public/admin/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?php echo base_url()?>public/admin/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <?php 
                     $cmpname = $this->session->userdata('company_name');
                     $username = $this->session->userdata('username');
           ?>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
           Welcome,<strong><?php echo $username; ?></strong>
     
        </a>
       <div class ="dropdown-menu dropdown-menu-lg dropdown-menu right">
        <div class="dropdown-divider"></div>
        <a href="<?php echo base_url().'admin/login/logout'; ?>" class="dropdown-item">
            logout
        </a>  
      </div>
      </li>
     
    </ul>
  </nav>
  <!-- Main Sidebar Container -->

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
    <img src="<?php echo base_url()?>public/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
        style="opacity: .8">
    <div class="brand-text-wrapper">
        <span class="brand-text font-weight-light"><?php echo $cmpname; ?></span>
    </div>
</a>


     

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

               <li class="nav-item has-treeview ">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Masters
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
             <a href="<?php echo base_url().'admin/uandetails/Uanmaster'; ?>" class="nav-link active">
            <!--    <a href="<?php echo base_url().'admin/reports/Pfesidata'; ?>" class="nav-link active">
             -->             <i class="far fa-circle nav-icon"></i>
                  <p>UAN Masters</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="<?php echo base_url().'admin/esidetails/Esimaster'; ?>" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ESI Master</p>
                </a>
              </li>
            </ul>
          </li>


               <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
               Dashboard
               
              </p>
            </a>
          </li>
     
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                PF Genrations 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url().'admin/uandetails/Pfdatageneration'; ?>" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>PF Data Generation</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url().'admin/uandetails/Pfuploadfilegen'; ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>PF Upload File Generation</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url().'admin/uandetails/Pfuploadfileupd'; ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>PF Upload File Updation</p>
                </a>
              </li>
   <!--            <li class="nav-item">
                <a href="<?php echo base_url().'admin/uandetails/TabsController'; ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>PF Upload File tabshow</p>
                </a>
              </li>
    -->           <li class="nav-item">
                <a href="<?php echo base_url().'admin/uandetails/Pfuploadfileshow'; ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>PF Gen & Upload File  DATA</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url().'admin/uandetails/Pfoutstandingdata'; ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Out Standing Data(AC Wise)</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url().'admin/uandetails/Pfoutstandingdatae'; ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Out Standing Data(Emp/Empl wise)</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url().'admin/uandetails/Pfindividualdetails'; ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Individual PF Ledger</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url().'admin/uandetails/Pfindividualsummary'; ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Individual PF Summary</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview ">
         
         <a href="#" class="nav-link">
           <i class="far fa-circle nav-icon"></i>
           <p>Reports</p>
         </a>
     
   
   <ul class="nav nav-treeview">
    
       <li class="nav-item">
         <a href="<?php echo base_url().'admin/reports/Pfesidata'; ?>" class="nav-link active">
           <i class="far fa-circle nav-icon"></i>
           <p>PF ESI Reports</p>
         </a>
       </li>
       <li class="nav-item">
       <a href="<?php echo base_url().'admin/Pfesi'; ?>" class="nav-link ">
           <i class="far fa-circle nav-icon"></i>
           <p>View Articles</p>
         </a>
       </li>
     </ul>
   </li>


   <li class="nav-item has-treeview ">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                ESI File Generation 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="<?php echo base_url().'admin/esidetails/Esi_data_generation'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
              ESI Upload File Generation 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/esidetails/Esi_upload_file_generation'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
              ESI Online File Generation 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/esidetails/Esi_payment_updation'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                ESI Payment Updation 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/Doffmodexp'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                ESI Genration And Payment  
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/doff10report'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
              ESI Outstanding   
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
  
        </ul>
          </li>

//winding
<li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                <strong > Winding </strong>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="<?php echo base_url().'admin/Winding_doff_data'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Daily Winding Production Entry
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/Winding_jugar_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
              Daily Winding Jugar Entry  
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/winding_quality_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Daily Quality Entry 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/winding_data_reports'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Winding Data Reports 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo base_url().'admin/reports/winding_data_reports'; ?>" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Winding Data Reports</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url().'admin/reports/Winding_performance_report'; ?>" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Winder Performance Report</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3B</p>
                    </a>
                  </li>
                </ul>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/Winding_quality_wise_report'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Winding quality Wise Report 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/Winding_duplicate_mc_checking'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Winding Duplicate Mechine Checking 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>

        </ul>
          </li>



//winding


<li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                <strong > Weaving </strong>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="<?php echo base_url().'admin/weaving_daily_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Weaving Daily Entry 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="<?php echo base_url().'admin/reports/finishing_data_export'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Finishing Data Exports  
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/quality_act_count'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Daily Actual Count Entry 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/Doffmodexp'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Doff Modification 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/doff10report'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Doff 10 Report 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/onlinedoffreport'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                On Line Doff Report 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>

        </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                <strong > Data Exports </strong>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/weaving_data_export'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Weaving Data Exports
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="<?php echo base_url().'admin/reports/beaming_data_export'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Beaming Data Export  
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/item_master_report'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Item MasterS
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="<?php echo base_url().'admin/Daily_spell_spreader_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
              Spreader Meter Entry  
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/Daily_spell_drawing_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Daily Drawing Entry 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>

          </li>
          <li class="nav-item">
          <a href="<?php echo base_url().'admin/reports/Daily_batch_report'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
              Daily Batch Report
                             <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/Daily_spellwise_drawing_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Daily Spell Wise Drawing Entry 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="<?php echo base_url().'admin/Daily_vo'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
              Daily Vow Data Transfer
                             <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="<?php echo base_url().'admin/reports/Loom_data_exp'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Loom Data Export
                  <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>

    
        </ul>
          </li>


          

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Level 1N
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url().'admin/Students'; ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Level 2</p>
                </a>
              </li>

              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Level 2A
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3A</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3B</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Level 2N</p>
                </a>
              </li>
            </ul>
          </li>



    <li class="nav-item">
    <a href="<?php echo base_url().'admin/reports/weaving_data_export'; ?>" class="nav-link active">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Weaving Data Export 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
        </ul>




      </nav>
      <!-- /.sidebar-menu -->

      
    </div>

    <!-- /.sidebar -->
  </aside>
