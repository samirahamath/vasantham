<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('../includes/approval-functions.php');
if (strlen($_SESSION['remsaid']==0)) {
  header('location:logout.php');
  } 
     ?>
<!doctype html>
<html lang="en">

<head>
   
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="assets/vendor/vector-map/jqvmap.css">
    <link href="assets/vendor/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/vendor/charts/chartist-bundle/chartist.css">
    <link rel="stylesheet" href="assets/vendor/charts/c3charts/c3.css">
    <link rel="stylesheet" href="assets/vendor/charts/morris-bundle/morris.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/daterangepicker/daterangepicker.css" />
    <title>Real Estate Management System || Dashboard</title>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
       
     <?php include_once('includes/header.php');?>
       
      <?php include_once('includes/sidebar.php');?>
       
        <div class="dashboard-wrapper">
            <div class="dashboard-finance">
                <div class="container-fluid dashboard-content">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h3 class="mb-2">Dashboard </h3>
                                
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="dashboard.php" class="breadcrumb-link">Dashboard</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Admin Dashboard</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                   
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <?php $query=mysqli_query($con,"Select * from tblpropertytype");
$totalprptype=mysqli_num_rows($query);
?>
                                <h5 class="card-header">Total Property Type</h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?php echo $totalprptype;?></h1>
                                    </div>
                                    
                                </div>
                                
                                <div class="card-footer text-center bg-white">
                                    <a href="manage-propertytype.php" class="card-link">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <?php $query1=mysqli_query($con,"Select * from tblcountry");
$totalcountry=mysqli_num_rows($query1);
?>
                                <h5 class="card-header">Total Country</h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?php echo $totalcountry;?></h1>
                                    </div>
                                  
                                </div>
                                
                                <div class="card-footer text-center bg-white">
                                    <a href="manage-country.php" class="card-link">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                 <?php $query2=mysqli_query($con,"Select * from tblstate");
$totalstate=mysqli_num_rows($query2);
?>
                                <h5 class="card-header">Total State</h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?php echo $totalstate;?></h1>
                                    </div>
                                   
                                </div>
                               
                                <div class="card-footer text-center bg-white">
                                    <a href="manage-state.php" class="card-link">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <?php $query3=mysqli_query($con,"Select * from tblcity");
$totalcity=mysqli_num_rows($query3);
?>
                                <h5 class="card-header">Total City</h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?php echo $totalcity;?></h1>
                                    </div>
                                    
                                </div>
                                
                                <div class="card-footer text-center bg-white">
                                    <a href="manage-city.php" class="card-link">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                   
           <div class="row">
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <?php $query4=mysqli_query($con,"Select * from tbluser where UserType='1'");
$totalagents=mysqli_num_rows($query4);
?>
                                <h5 class="card-header">Total Agents Listed</h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?php echo $totalagents;?></h1>
                                    </div>
                                    
                                </div>
                                
                                <div class="card-footer text-center bg-white">
                                    <a href="manage-agents.php" class="card-link">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <?php $query5=mysqli_query($con,"Select * from tbluser where UserType='2'");
$totalowners=mysqli_num_rows($query5);
?>
                                <h5 class="card-header">Total Owners Listed</h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?php echo $totalowners;?></h1>
                                    </div>
                                  
                                </div>
                                
                                <div class="card-footer text-center bg-white">
                                    <a href="manage-owners.php" class="card-link">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                 <?php $query6=mysqli_query($con,"Select * from tbluser where UserType='3'");
$totalusers=mysqli_num_rows($query6);
?>
                                <h5 class="card-header">Total Users</h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?php echo $totalusers;?></h1>
                                    </div>
                                   
                                </div>
                               
                                <div class="card-footer text-center bg-white">
                                    <a href="manage-users.php" class="card-link">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <?php $query7=mysqli_query($con,"Select * from tblproperty");
$totalpropertylisted=mysqli_num_rows($query7);
?>
                                <h5 class="card-header">Total Property Listed</h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?php echo $totalpropertylisted;?></h1>
                                    </div>
                                    
                                </div>
                                
                                <div class="card-footer text-center bg-white">
                                    <a href="listed-properties.php" class="card-link">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Property Approval Statistics -->
                    <?php 
                    // Initialize default values
                    $pendingCount = 0;
                    $approvedCount = 0;
                    $rejectedCount = 0;
                    $approvalStats = array();
                    
                    // Check if approval functions are available and database has approval columns
                    if (function_exists('getApprovalStatistics')) {
                        try {
                            $approvalStats = getApprovalStatistics($con);
                            $pendingCount = isset($approvalStats['by_status']['Pending']) ? $approvalStats['by_status']['Pending'] : 0;
                            $approvedCount = isset($approvalStats['by_status']['Approved']) ? $approvalStats['by_status']['Approved'] : 0;
                            $rejectedCount = isset($approvalStats['by_status']['Rejected']) ? $approvalStats['by_status']['Rejected'] : 0;
                        } catch (Exception $e) {
                            // If approval system is not set up yet, show basic property count
                            $basicQuery = mysqli_query($con, "SELECT COUNT(*) as total FROM tblproperty");
                            if ($basicQuery) {
                                $basicResult = mysqli_fetch_assoc($basicQuery);
                                $approvedCount = $basicResult['total']; // Assume all existing properties are approved
                            }
                        }
                    } else {
                        // Fallback if approval functions are not available
                        $basicQuery = mysqli_query($con, "SELECT COUNT(*) as total FROM tblproperty");
                        if ($basicQuery) {
                            $basicResult = mysqli_fetch_assoc($basicQuery);
                            $approvedCount = $basicResult['total'];
                        }
                    }
                    ?>
                    
                    <div class="row mt-4">
                        <div class="col-xl-12">
                            <h4 class="mb-3">Property Approval Statistics</h4>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card border-warning">
                                <h5 class="card-header bg-warning text-white">Pending Approval</h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1 text-warning"><?php echo $pendingCount; ?></h1>
                                    </div>
                                    <div class="metric-label d-inline-block float-right text-secondary font-weight-bold">
                                        <span class="icon-circle-small icon-box-xs text-warning bg-warning-light">
                                            <i class="fa fa-clock"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-footer text-center bg-white">
                                    <a href="approve-properties.php?status=Pending" class="card-link">Review Properties</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card border-success">
                                <h5 class="card-header bg-success text-white">Approved Properties</h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1 text-success"><?php echo $approvedCount; ?></h1>
                                    </div>
                                    <div class="metric-label d-inline-block float-right text-secondary font-weight-bold">
                                        <span class="icon-circle-small icon-box-xs text-success bg-success-light">
                                            <i class="fa fa-check-circle"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-footer text-center bg-white">
                                    <a href="approve-properties.php?status=Approved" class="card-link">View Approved</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card border-danger">
                                <h5 class="card-header bg-danger text-white">Rejected Properties</h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1 text-danger"><?php echo $rejectedCount; ?></h1>
                                    </div>
                                    <div class="metric-label d-inline-block float-right text-secondary font-weight-bold">
                                        <span class="icon-circle-small icon-box-xs text-danger bg-danger-light">
                                            <i class="fa fa-times-circle"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-footer text-center bg-white">
                                    <a href="approve-properties.php?status=Rejected" class="card-link">View Rejected</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card border-info">
                                <h5 class="card-header bg-info text-white">Approval Rate</h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <?php 
                                        $totalProcessed = $approvedCount + $rejectedCount;
                                        $approvalRate = $totalProcessed > 0 ? round(($approvedCount / $totalProcessed) * 100, 1) : 0;
                                        ?>
                                        <h1 class="mb-1 text-info"><?php echo $approvalRate; ?>%</h1>
                                    </div>
                                    <div class="metric-label d-inline-block float-right text-secondary font-weight-bold">
                                        <span class="icon-circle-small icon-box-xs text-info bg-info-light">
                                            <i class="fa fa-chart-line"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-footer text-center bg-white">
                                    <a href="approve-properties.php" class="card-link">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Approval Activity -->
                    <div class="row mt-4">
                        <div class="col-xl-12">
                            <div class="card">
                                <h5 class="card-header">Recent Approval Activity</h5>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Property</th>
                                                    <th>Agent</th>
                                                    <th>Action</th>
                                                    <th>Admin</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if (isset($approvalStats['recent_activity']) && !empty($approvalStats['recent_activity'])) {
                                                    foreach ($approvalStats['recent_activity'] as $activity) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <strong><?php echo htmlspecialchars(substr($activity['PropertyTitle'], 0, 30)) . '...'; ?></strong>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($activity['AgentName']); ?></td>
                                                    <td>
                                                        <?php if($activity['Action'] == 'APPROVED') { ?>
                                                            <span class="badge badge-success">Approved</span>
                                                        <?php } elseif($activity['Action'] == 'REJECTED') { ?>
                                                            <span class="badge badge-danger">Rejected</span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-info"><?php echo $activity['Action']; ?></span>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($activity['AdminName']); ?></td>
                                                    <td><?php echo date('M d, Y H:i', strtotime($activity['ActionDate'])); ?></td>
                                                </tr>
                                                <?php 
                                                    }
                                                } else { ?>
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">No recent activity</td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer text-center bg-white">
                                    <a href="approve-properties.php" class="card-link">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
           <?php include_once('includes/footer.php');?>
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- jquery 3.3.1  -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- chart chartist js -->
    <script src="assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
    <script src="assets/vendor/charts/chartist-bundle/Chartistjs.js"></script>
    <script src="assets/vendor/charts/chartist-bundle/chartist-plugin-threshold.js"></script>
    <!-- chart C3 js -->
    <script src="assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <!-- chartjs js -->
    <script src="assets/vendor/charts/charts-bundle/Chart.bundle.js"></script>
    <script src="assets/vendor/charts/charts-bundle/chartjs.js"></script>
    <!-- sparkline js -->
    <script src="assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <!-- dashboard finance js -->
    <script src="assets/libs/js/dashboard-finance.js"></script>
    <!-- main js -->
    <script src="assets/libs/js/main-js.js"></script>
    <!-- gauge js -->
    <script src="assets/vendor/gauge/gauge.min.js"></script>
    <!-- morris js -->
    <script src="assets/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="assets/vendor/charts/morris-bundle/morris.js"></script>
    <script src="assets/vendor/charts/morris-bundle/morrisjs.html"></script>
    <!-- daterangepicker js -->
    <script src="../../../../cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="../../../../cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });
    </script>
</body>
</html>
                    
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->