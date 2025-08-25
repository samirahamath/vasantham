<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Get user ID from URL parameter
$user_id = isset($_GET['uid']) ? intval($_GET['uid']) : 0;

if($user_id == 0) {
    echo "<script>alert('Invalid user ID');</script>";
    echo "<script>window.location.href='properties-grid.php'</script>";
    exit;
}

// Get user details
$user_query = mysqli_query($con, "SELECT FullName, Email, MobileNumber, AgentID, UserType FROM tbluser WHERE ID='$user_id'");
if(mysqli_num_rows($user_query) == 0) {
    echo "<script>alert('User not found');</script>";
    echo "<script>window.location.href='properties-grid.php'</script>";
    exit;
}
$user_data = mysqli_fetch_array($user_query);
$user_name = $user_data['FullName'];
$user_type = $user_data['UserType'];
$agent_id = $user_data['AgentID'];
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i%7CPoppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Stylesheets -->
    <link href="assets/css/external.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <title>Real Estate Management System - <?php echo $user_name; ?>'s Properties</title>
    
    <style>
    /* Property Card Styles */
    .property-item {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 6px 32px rgba(38,8,68,0.10);
        margin-bottom: 30px;
        padding: 0;
        overflow: hidden;
        border: 1px solid #ece9f3;
        transition: box-shadow 0.25s, transform 0.18s;
        display: flex;
        flex-direction: row;
        align-items: stretch;
        position: relative;
        min-height: 200px;
    }
    .property-item:hover {
        box-shadow: 0 12px 40px rgba(38,8,68,0.18);
        transform: translateY(-2px);
    }
    .property--img {
        width: 300px;
        min-width: 300px;
        max-width: 300px;
        height: 200px;
        overflow: hidden;
        position: relative;
        border-radius: 18px 0 0 18px;
        background: #f2f2f2;
        flex-shrink: 0;
    }
    .property--img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.3s;
        border-radius: 18px 0 0 18px;
    }
    .property-item:hover .property--img img {
        transform: scale(1.06);
    }
    .property--status {
        position: absolute;
        top: 16px;
        left: 16px;
        background: #260844;
        color: #fff;
        border-radius: 8px;
        padding: 5px 16px;
        font-size: 0.95rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(38,8,68,0.10);
        z-index: 2;
        letter-spacing: 0.5px;
    }
    .property--content {
        padding: 24px 28px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex: 1;
        min-height: 200px;
    }
    .property--info {
        margin-bottom: 16px;
    }
    .property--title a {
        color: #260844;
        font-weight: 700;
        font-size: 1.3rem;
        letter-spacing: 0.5px;
        text-decoration: none;
        transition: color 0.2s;
        line-height: 1.3;
        display: block;
        margin-bottom: 8px;
    }
    .property--title a:hover {
        color: #C29425;
    }
    .property--location {
        color: #666;
        font-size: 1.05rem;
        margin-bottom: 8px;
        line-height: 1.4;
    }
    .property--price {
        color: #C29425;
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 16px;
    }
    .property--features ul {
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }
    .property--features li {
        color: #444;
        font-size: 1rem;
        background: #f7f6fb;
        border-radius: 8px;
        padding: 8px 14px;
        border: 1px solid #ece9f3;
    }
    .property--features .feature {
        font-weight: 600;
        color: #260844;
        margin-right: 4px;
    }
    .property--features .feature-num {
        font-weight: 500;
        color: #555;
    }
    
    .page-header {
        background: linear-gradient(135deg, #260844 0%, #3d0e7e 100%);
        color: #fff;
        padding: 60px 0;
        margin-bottom: 50px;
    }
    .page-header h1 {
        color: #FFD700;
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 10px;
    }
    .page-header .breadcrumb {
        background: transparent;
        margin-bottom: 0;
    }
    .page-header .breadcrumb > li + li:before {
        color: #ccc;
    }
    .page-header .breadcrumb a {
        color: #ccc;
    }
    .page-header .breadcrumb .active {
        color: #FFD700;
    }
    
    .user-info-card {
        background: #fff;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        display: flex;
        align-items: center;
        gap: 20px;
    }
    
    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #260844;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: bold;
    }
    
    .user-details h3 {
        color: #260844;
        margin-bottom: 5px;
        font-weight: 700;
    }
    
    .user-details p {
        color: #666;
        margin-bottom: 3px;
    }
    
    .properties-count {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 30px;
        text-align: center;
    }
    .properties-count h3 {
        color: #260844;
        margin-bottom: 5px;
    }
    .properties-count p {
        color: #666;
        margin-bottom: 0;
    }

    /* Responsive Styles */
    @media (max-width: 991px) {
        .property-item {
            flex-direction: column;
            min-height: auto;
        }
        .property--img {
            width: 100%;
            min-width: 100%;
            max-width: 100%;
            height: 180px;
            border-radius: 18px 18px 0 0;
        }
        .property--img img {
            border-radius: 18px 18px 0 0;
        }
        .property--content {
            padding: 18px 20px;
            min-height: auto;
        }
        .user-info-card {
            flex-direction: column;
            text-align: center;
        }
    }
    @media (max-width: 768px) {
        .property--img {
            height: 160px;
        }
        .property--content {
            padding: 16px 18px;
        }
        .property--title a {
            font-size: 1.2rem;
        }
        .property--features ul {
            gap: 10px;
        }
        .page-header h1 {
            font-size: 1.8rem;
        }
    }
    </style>
</head>

<body>
    <div id="wrapper" class="wrapper clearfix">
        <?php include_once('includes/header.php');?>
        
        <!-- Page Header -->
        <section class="page-header">
            <div class="container">
                <div class="row mt-100">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="text-center">
                            <h1><?php echo $user_name; ?>'s Properties</h1>
                            <ol class="breadcrumb">
                                <li><a href="index.php">Home</a></li>
                                <li><a href="properties-grid.php">Properties</a></li>
                                <li class="active"><?php echo $user_name; ?>'s Properties</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Properties Section -->
        <section id="user-properties" class="pt-50 pb-90">
            <div class="container">
                <!-- User Info Card -->
                

                <?php
                // Get properties count for this user (only approved properties)
                $count_query = mysqli_query($con, "SELECT COUNT(*) as total FROM tblproperty WHERE UserID='$user_id' AND ApprovalStatus='Approved' AND ApprovedBy IS NOT NULL");
                $count_data = mysqli_fetch_array($count_query);
                $total_properties = $count_data['total'];
                ?>
                
                <div class="properties-count">
                    <h3><?php echo $total_properties; ?> Properties Found</h3>
                    <p>Properties listed by <?php echo $user_name; ?></p>
                </div>

                <div class="row">
                    <?php
                    // Fetch only approved properties for this user
                    $query = mysqli_query($con, "SELECT * FROM tblproperty WHERE UserID='$user_id' AND ApprovalStatus='Approved' AND ApprovedBy IS NOT NULL ORDER BY ID DESC");
                    $num = mysqli_num_rows($query);
                    
                    if($num > 0) {
                        while($row = mysqli_fetch_array($query)) {
                    ?>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="property-item">
                            <div class="property--img">
                                <a href="single-property-detail.php?proid=<?php echo $row['ID'];?>">
                                    <img src="propertyimages/<?php echo $row['FeaturedImage'];?>" alt="<?php echo $row['PropertyTitle'];?>">
                                    <span class="property--status"><?php echo $row['Status'];?></span>
                                </a>
                            </div>
                            <div class="property--content">
                                <div class="property--info">
                                    <h5 class="property--title">
                                        <a href="single-property-detail.php?proid=<?php echo $row['ID'];?>">
                                            <?php echo $row['PropertyTitle'];?>
                                        </a>
                                    </h5>
                                    <p class="property--location">
                                        <?php echo $row['Address'];?>, 
                                        <?php echo $row['City'];?>, 
                                        <?php echo $row['State'];?>, 
                                        <?php echo $row['Country'];?>
                                    </p>
                                    <p class="property--price"><?php echo $row['RentorsalePrice'];?></p>
                                </div>
                                <!-- <div class="property--features">
                                    <ul class="list-unstyled mb-0">
                                        <li><span class="feature">Beds:</span><span class="feature-num"><?php echo $row['Bedrooms'];?></span></li>
                                        <li><span class="feature">Baths:</span><span class="feature-num"><?php echo $row['Bathrooms'];?></span></li>
                                        <li><span class="feature">Area:</span><span class="feature-num"><?php echo $row['Area'];?></span></li>
                                    </ul>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <?php 
                        }
                    } else { 
                    ?>
                    <div class="col-xs-12">
                        <div class="text-center" style="padding: 60px 0;">
                            <i class="fa fa-home" style="font-size: 4rem; color: #ccc; margin-bottom: 20px;"></i>
                            <h3 style="color: #666;">No Properties Found</h3>
                            <p style="color: #999;">This user hasn't listed any approved properties yet.</p>
                            <a href="properties-grid.php" class="btn btn-primary" style="background: #260844; border-color: #260844; margin-top: 20px;">
                                <i class="fa fa-arrow-left"></i> Back to All Properties
                            </a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section>

        <?php include_once('includes/footer.php');?>
    </div>

    <!-- Footer Scripts -->
    <script src="assets/js/jquery-2.2.4.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/functions.js"></script>
</body>
</html>