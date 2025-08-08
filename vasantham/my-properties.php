<?php
session_start();
include('includes/dbconnection.php');
error_reporting(0);
if (strlen($_SESSION['remsuid']==0 || $_SESSION['ut']==3)) {
  header('location:logout.php');
  } else{

if(isset($_GET['del']))
{
mysqli_query($con,"delete from tblproperty where ID ='".$_GET['id']."'");
echo "<script>alert('Data Deleted');</script>";
echo "<script>window.location.href='my-properties.php'</script>";
}


    ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    
    <!-- Fonts
    ============================================= -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i%7CPoppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Stylesheets
    ============================================= -->
    <link href="assets/css/external.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->

    <!-- Document Title
    ============================================= -->
    <title>Real Estate Management System-My Properties</title>
    <style>
/* --- My Properties Card Styles --- */
.property-item {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(38,8,68,0.10);
    margin-bottom: 32px;
    padding: 0;
    overflow: hidden;
    border: 1px solid #f2f2f2;
    transition: box-shadow 0.2s;
    display: flex;
    flex-direction: row;
}
.property-item:hover {
    box-shadow: 0 8px 32px rgba(38,8,68,0.16);
}
.property--img {
    flex: 0 0 180px;
    max-width: 180px;
    overflow: hidden;
    position: relative;
}
.property--img img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    border-radius: 0 0 0 0;
    transition: transform 0.3s;
}
.property-item:hover .property--img img {
    transform: scale(1.05);
}
.property--status {
    position: absolute;
    top: 12px;
    left: 12px;
    background: #260844;
    color: #fff;
    border-radius: 8px;
    padding: 4px 14px;
    font-size: 0.95rem;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(38,8,68,0.10);
}
.property--content {
    flex: 1;
    padding: 18px 22px 12px 22px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.property--title a {
    color: #260844;
    font-weight: 700;
    font-size: 1.15rem;
    letter-spacing: 0.5px;
    text-decoration: none;
    transition: color 0.2s;
}
.property--title a:hover {
    color: #C29425;
}
.property--location {
    color: #555;
    font-size: 1rem;
    margin-bottom: 4px;
}
.property--price {
    color: #C29425;
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 8px;
}
.property--features ul {
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
    display: flex;
    gap: 18px;
}
.property--features li {
    color: #444;
    font-size: 0.98rem;
}
.property--features .feature {
    font-weight: 600;
    color: #260844;
}
.edit--btn, .delete--btn {
    font-weight: 600;
    font-size: 1rem;
    border-radius: 6px;
    padding: 4px 14px;
    text-decoration: none;
    margin-right: 10px;
    transition: background 0.2s, color 0.2s;
    display: inline-block;
}
.edit--btn {
    color: #fff !important;
    background: #260844;
}
.edit--btn:hover {
    background: #3d0e7e;
    color: #fff !important;
}
.delete--btn {
    color: #fff !important;
    background: #d32f2f;
}
.delete--btn:hover {
    background: #b71c1c;
    color: #fff !important;
}
.property--features p {
    margin-bottom: 0;
    display: inline-block;
}
.property--features {
    margin-top: 10px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
}

/* Responsive Styles */
@media (max-width: 991px) {
    .property-item {
        flex-direction: column;
    }
    .property--img {
        max-width: 100%;
        width: 100%;
    }
    .property--img img {
        height: 180px;
    }
    .property--content {
        padding: 14px 10px 10px 10px;
    }
}
@media (max-width: 600px) {
    .property-item {
        margin-bottom: 18px;
    }
    .property--img img {
        height: 120px;
    }
    .property--title a {
        font-size: 1rem;
    }
    .property--features ul {
        gap: 8px;
    }
}
</style>
</head>

<body>
    <!-- Document Wrapper
	============================================= -->
    <div id="wrapper" class="wrapper clearfix">
        <?php include_once('includes/header.php');?>
          <hr />
        <!-- Page Title #1
============================================ -->
        <section id="page-title" style="margin-top:-3%" class="page-title bg-overlay bg-overlay-dark2">
            <div class="bg-section">
                <img src="assets/images/page-titles/1.jpg" alt="Background" />
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
                        <div class="title title-1 text-center">
                            <div class="title--content">
                                <div class="title--heading">
                                    <h1>my properties</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="active">my properties</li>
                                </ol>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- .title end -->
                    </div>
                    <!-- .col-md-12 end -->
                </div>
                <!-- .row end -->
            </div>
            <!-- .container end -->
        </section>
        <!-- #page-title end -->

        <!-- #my properties
============================================= -->
        <section id="my-properties" class="my-properties properties-list">
            <div class="container">
                <div class="row">
                    <?php include_once('includes/sidebar.php');?>
                    <!-- .col-md-4 -->
                    <div class="col-xs-12 col-sm-8 col-md-8">
                      <?php
                      $uid=$_SESSION['remsuid'];
$query=mysqli_query($con,"select * from tblproperty where UserID='$uid' ORDER BY ListingDate DESC");
$num=mysqli_num_rows($query);
if($num>0){
while($row=mysqli_fetch_array($query))
{
    // Get approval status, default to 'Approved' for backward compatibility
    $approvalStatus = isset($row['ApprovalStatus']) ? $row['ApprovalStatus'] : 'Approved';
?>
                        <div class="property-item">

                            <div class="property--img">
                                <a href="single-property-detail.php?proid=<?php echo $row['ID'];?>">
                        <img src="propertyimages/<?php echo $row['FeaturedImage'];?>" alt="property image" class="img-responsive" >
                        <span class="property--status"><?php echo $row['Status'];?></span>
						</a>
                            </div>
                            <div class="property--content">
                                <div class="property--info">
                                    <h5 class="property--title">
<a href="single-property-detail.php?proid=<?php echo $row['ID'];?>">
    <?php echo $row['PropertyTitle'];?></a></h5>
                                
                                    <p class="property--location"><?php echo $row['Address'];?>&nbsp;
<?php echo $row['City'];?>&nbsp;
<?php echo $row['State'];?>&nbsp;  
<?php echo $row['Country'];?></p>
<p class="property--price"><?php echo $row['RentorsalePrice'];?></p>

                                    <!-- Approval Status Display -->
                                    <div class="approval-status" style="margin: 10px 0;">
                                        <?php if($approvalStatus == 'Approved') { ?>
                                            <span class="badge" style="background-color: #28a745; color: white; padding: 5px 10px; border-radius: 15px;">
                                                <i class="fa fa-check-circle"></i> Approved
                                            </span>
                                            <?php if($row['ApprovalDate']) { ?>
                                                <small style="color: #666; display: block; margin-top: 5px;">
                                                    Approved on <?php echo date('M d, Y', strtotime($row['ApprovalDate'])); ?>
                                                </small>
                                            <?php } ?>
                                        <?php } elseif($approvalStatus == 'Rejected') { ?>
                                            <span class="badge" style="background-color: #dc3545; color: white; padding: 5px 10px; border-radius: 15px;">
                                                <i class="fa fa-times-circle"></i> Rejected
                                            </span>
                                            <?php if($row['RejectionDate']) { ?>
                                                <small style="color: #666; display: block; margin-top: 5px;">
                                                    Rejected on <?php echo date('M d, Y', strtotime($row['RejectionDate'])); ?>
                                                </small>
                                            <?php } ?>
                                            <?php if($row['RejectionReason']) { ?>
                                                <div style="background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 8px; border-radius: 5px; margin-top: 8px;">
                                                    <strong>Rejection Reason:</strong><br>
                                                    <?php echo htmlspecialchars($row['RejectionReason']); ?>
                                                </div>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <span class="badge" style="background-color: #ffc107; color: #212529; padding: 5px 10px; border-radius: 15px;">
                                                <i class="fa fa-clock"></i> Pending Review
                                            </span>
                                            <small style="color: #666; display: block; margin-top: 5px;">
                                                Submitted on <?php echo date('M d, Y', strtotime($row['ListingDate'])); ?>
                                            </small>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- .property-info end -->
                                <div class="property--features">
                                    <ul>
                                        <li><span class="feature">Beds:</span><span class="feature-num"><?php echo $row['Bedrooms'];?></span></li>
                                        <li><span class="feature">Baths:</span><span class="feature-num"><?php echo $row['Bathrooms'];?></span></li>
                                        <li><span class="feature">Area:</span><span class="feature-num"><?php echo $row['Area'];?></span></li>

                                    </ul>
                                   
                                   <!-- Action buttons based on approval status -->
                                   <div class="property-actions" style="margin-top: 15px;">
                                       <?php if($approvalStatus == 'Rejected') { ?>
                                           <p><a href="edit-property.php?editid=<?php echo $row['ID'];?>" class="edit--btn" style="background-color: #007bff;">
                                               <i class="fa fa-edit"></i> Edit & Resubmit
                                           </a></p>
                                       <?php } else { ?>
                                           <p><a href="edit-property.php?editid=<?php echo $row['ID'];?>" class="edit--btn" style="color:blue;">
                                               <i class="fa fa-edit"></i> Edit
                                           </a></p>
                                       <?php } ?>
                                       
                                       <p style="margin-top: 5%;">
                                           <a href="my-properties.php?id=<?php echo $row['ID']?>&del=delete" 
                                              onClick="return confirm('Are you sure you want to delete?')" 
                                              style="color:red;">
                                               <i class="fa fa-trash"></i> Delete
                                           </a>
                                       </p>
                                       
                                       <?php if($approvalStatus == 'Pending') { ?>
                                           <p style="margin-top: 5%;">
                                               <small style="color: #666; font-style: italic;">
                                                   <i class="fa fa-info-circle"></i> Your property is under review by our admin team.
                                               </small>
                                           </p>
                                       <?php } ?>
                                   </div>
                                </div>
                                <!-- .property-features end -->
                            </div>
                        </div>
                        <!-- .property item end -->
<?php } } else { ?>
   <h3 style="color:red" align="center"> No Properties added yet </h3>
        <?php } ?>               
                       
                    
                        <!-- .pagination end -->
                    </div>
                    <!-- .col-md-8 end -->
                </div>
                <!-- .row end -->
            </div>
            <!-- .container end -->
        </section>
        <!-- #my properties  end -->

        <!-- cta #1
============================================= -->
        <section id="cta" class="cta cta-1 text-center bg-overlay bg-overlay-dark pt-90">
            <div class="bg-section"><img src="assets/images/cta/bg-1.jpg" alt="Background"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
                        <h3>Join our professional team & agents to start selling your house</h3>
                         <a href="contact.php" class="btn btn--primary">Contact</a>
                    </div>
                    <!-- .col-md-6 -->
                </div>
                <!-- .row -->
            </div>
            <!-- .container -->
        </section>
        <!-- #cta1 end -->


        <!-- Footer #1
============================================= -->
        <?php include_once('includes/footer.php');?>
    </div>
    <!-- #wrapper end -->

    <!-- Footer Scripts
============================================= -->
    <script src="assets/js/jquery-2.2.4.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/functions.js"></script>
</body>

</html>
<?php } ?>
