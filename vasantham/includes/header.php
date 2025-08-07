<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<header id="navbar-spy" class="header header-1 header-transparent header-fixed" style="background-color:#260844;">
    <nav id="primary-menu" class="navbar navbar-fixed-top" style="background-color:#260844;">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="logo" href="index.php">
                    <img src="assets/images/logo/vr_logo.jpg" alt="REMS Logo" style="height:80px; width:80px; border-radius:50%; margin-top:-10px; margin-left:30px;">
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right" style="float:right;">
                    <!-- Home Menu -->
                    <li>
                        <a href="index.php" style="color:#fff">home</a>
                    </li>
                    <!-- li end -->

                    <li><a href="about.php" style="color:#fff">about us</a></li>

                    <li><a href="services.php" style="color:#fff">services</a></li>

                    <li><a href="contact.php" style="color:#fff">Blog</a></li>

                    <li><a href="properties-grid.php" style="color:#fff">properties</a></li>

                    <li><a href="contact.php" style="color:#fff">contact</a></li>

                    <?php if (empty($_SESSION['remsuid'])) { ?>
                        <div class="module module-property pull-left" style="margin-right:18px;">
                            <a href="add-property.php" class="btn"><i class="fa fa-phone"></i> For Enquiry</a>
                        </div>
                    <?php } ?>
                    
                    <!-- Profile Menu-->
                    <li class="has-dropdown">
                        <?php if (!empty($_SESSION['remsuid'])) { ?>
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle menu-item" style="color:#fff !important; font-weight:600;">
                                <i class="fa fa-user-circle" style="margin-right:6px;"></i> My Account
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="user-profile.php" style="color:#222;">
                                        <i class="fa fa-user" style="margin-right:6px;"></i> Agent Profile
                                    </a>
                                </li>
                                <li>
                                    <a href="change-password.php" style="color:#222;">
                                        <i class="fa fa-lock" style="margin-right:6px;"></i> Change Password
                                    </a>
                                </li>
                                <li>
                                    <a href="logout.php" style="color:#222;">
                                        <i class="fa fa-sign-out" style="margin-right:6px;"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        <?php } ?>
                    </li>
                    
                    <?php if (strlen($_SESSION['remsuid']==0)) { ?>
                        <li>
                            <a href="agent_login.php" style="color:#fff; cursor:pointer;">Login</a>
                        </li>
                        <li>
                            <a href="agent_register.php" style="color:#fff; cursor:pointer;">Register</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
</header>