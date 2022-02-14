<?php
require_once __DIR__ . "/../../etc/config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Placewise Loyalty</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?php echo root_path ."/assets/plugins/fontawesome-free/css/all.min.css";?>">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo root_path ."/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css";?>">
  <link rel="stylesheet" href="<?php echo root_path ."/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css";?>">
  <link rel="stylesheet" href="<?php echo root_path ."/assets/plugins/jqvmap/jqvmap.min.css";?>">
  <link rel="stylesheet" href="<?php echo root_path ."/assets/dist/css/adminlte.min.css";?>">
  <link rel="stylesheet" href="<?php echo root_path ."/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css";?>">
  <link rel="stylesheet" href="<?php echo root_path ."/assets/plugins/daterangepicker/daterangepicker.css";?>">
  <link rel="stylesheet" href="<?php echo root_path ."/assets/plugins/summernote/summernote-bs4.min.css";?>">
  <link rel="stylesheet" href="<?php echo root_path ."/assets/plugins/daterangepicker/daterangepicker.css";?>">
</head>
<body class="sidebar-mini layout-fixed sidebar-closed sidebar-collapse control-sidebar-slide-open layout-navbar-fixed text-sm sidebar-mini-md">
<div class="wrapper">
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?php echo root_path ."/assets/dist/img/placewise.jpg";?>" alt="Placewise Logo" height="60" width="60">
  </div>
  <?php if(pageName != "login_loyalty" && pageName != "create_member"){ ?>
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo root_path ."/view/iframe?customer_id=".$_GET['customer_id']."&shop=".$_GET['shop'];?>" class="nav-link">Information</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php  echo root_path ."/view/iframe/tabs/edit_member.php?customer_id=".$_GET['customer_id']."&shop=".$_GET['shop'];?>" class="nav-link">Edit Member</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php  echo root_path ."/view/iframe/tabs/rewards_member.php?customer_id=".$_GET['customer_id']."&shop=".$_GET['shop'];?>" class="nav-link">Rewards</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php  echo root_path ."/view/iframe/tabs/store_member.php?customer_id=".$_GET['customer_id']."&shop=".$_GET['shop'];?>" class="nav-link">Store</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
    <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <img src="<?php  echo root_path ."/assets/dist/img/avatar.png";?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $data_loyalty['properties']['first_name'] . " " . $data_loyalty['properties']['last_name']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php  echo root_path ."/assets/dist/img/avatar.png";?>" class="img-circle" alt="User Image">
                <p>
                <?php echo $data_loyalty['properties']['first_name'] . " " . $data_loyalty['properties']['last_name']; ?> - <?php echo $data_loyalty['properties']['msisdn']; ?>
                  <small><?php echo $data_loyalty['properties']['email']; ?></small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left" style="float: left!important;">
                  <a href="<?php echo root_path ."/view/iframe?customer_id=".$_GET['customer_id']."&shop=".$_GET['shop'];?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right" style="float: right!important;">
                  <a href="<?php echo root_path ."/view/iframe/tabs/logout.php?customer_id=".$_GET['customer_id']."&shop=".$_GET['shop'];?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
              <i class="fas fa-th-large"></i>
            </a>
          </li> -->
    </ul>
  </nav>
  <?php } ?>

  <?php if(pageName != "login_loyalty" && pageName != "create_member"){ ?>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?php echo root_path ."/view/iframe?customer_id=".$_GET['customer_id']."&shop=".$_GET['shop'];?>" class="brand-link">
      <img src="<?php echo root_path ."/assets/dist/img/placewise.jpg";?>" alt="Placewise Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Placewise Loyalty</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php  echo root_path ."/assets/dist/img/avatar.png";?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $data_loyalty['properties']['first_name'] . " " . $data_loyalty['properties']['last_name']; ?></a>
        </div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?php echo root_path ."/view/iframe?customer_id=".$_GET['customer_id']."&shop=".$_GET['shop'];?>" class="nav-link <?php if(pageName == "index")echo "active";?>">
              <i class="nav-icon fas fa-info-circle"></i>
              <p>
                Information
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php  echo root_path ."/view/iframe/tabs/edit_member.php?customer_id=".$_GET['customer_id']."&shop=".$_GET['shop'];?>" class="nav-link <?php if(pageName == "edit_member")echo "active";?>">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Edit
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php  echo root_path ."/view/iframe/tabs/rewards_member.php?customer_id=".$_GET['customer_id']."&shop=".$_GET['shop'];?>" class="nav-link <?php if(pageName == "rewards_member")echo "active";?>">
              <i class="nav-icon fas fa-user-tag"></i>
              <p>
                Rewards
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php  echo root_path ."/view/iframe/tabs/store_member.php?customer_id=".$_GET['customer_id']."&shop=".$_GET['shop'];?>" class="nav-link <?php if(pageName == "store_member")echo "active";?>">
              <i class="nav-icon fas fa-store"></i>
              <p>
                Store
              </p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
  <?php } ?>
  <!-- <aside class="control-sidebar control-sidebar-dark">
  </aside> -->

