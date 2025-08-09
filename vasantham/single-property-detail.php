<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['submit']))
  {
    $fullname=$_POST['fullname'];
    $email=$_POST['email'];
    $mobilenumber=$_POST['mobnum'];
    $message=$_POST['message'];
    $enquirynumber = mt_rand(100000000, 999999999);
$proid=$_GET['proid'];
    $query1=mysqli_query($con,"insert into  tblenquiry(PropertyID,FullName,Email,MobileNumber,Message,EnquiryNumber) value('$proid','$fullname','$email','$mobilenumber','$message','$enquirynumber')");
        if ($query1) {
 echo '<script>alert("Your enquiry successfully send. Your Enquiry number is "+"'.$enquirynumber.'")</script>';
echo "<script>window.location.href='properties-grid.php'</script>";
  }
  else
    {
echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }

  
}


//Submit Feedback
if(isset($_POST['submitreview']))
{
if (strlen($_SESSION['remsuid']==0)) 
{
 echo '<script>alert("Login required for publish review")</script>';
  } else {
$review=$_POST['reviewcomment'];
$uid=$_SESSION['remsuid'];
$pid=$_GET['proid'];
$query=mysqli_query($con,"insert into tblfeedback(UserId,PropertyId,UserRemark) value('$uid','$pid','$review')");
 echo '<script>alert("Your review successfully submited, after review it will publish")</script>';
 echo "<script>window.location.href='properties-grid.php'</script>";
}
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
    <title>Real Estate Management System || Single Property Detail</title>
</head>

<body>
    <!-- Document Wrapper
	============================================= -->
    <div id="wrapper" class="wrapper clearfix">
        <header id="navbar-spy" class="header header-1 header-transparent header-fixed">
            <?php include_once('includes/header.php');?>
        </header>
          <hr />
        <!-- Page Title #1
============================================ -->
        <!-- <section id="page-title" style="margin-top:-3%" class="page-title bg-overlay bg-overlay-dark2">
            <div class="bg-section">
                <img src="assets/images/page-titles/3.jpg" alt="Background" />
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
                        <div class="title title-1 text-center">
                            <div class="title--content">
                                <div class="title--heading">
                                    <h1>Single Property</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="active">Single Property</li>
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
        <!-- </section>  -->
        <!-- #page-title end -->

        <!-- property single gallery
============================================= -->
        <section id="property-single-gallery" class="property-single-gallery">
            <?php 

$proid=$_GET['proid'];
$query=mysqli_query($con,"select tblproperty.*,tblcountry.CountryName,tblstate.StateName 
    from tblproperty 
    left join tblcountry on tblcountry.ID=tblproperty.Country 
    left join tblstate on tblstate.ID=tblproperty.State 
    where tblproperty.ID='$proid' AND tblproperty.ApprovalStatus='Approved'");
$num=mysqli_num_rows($query);
if($num == 0) {
    echo '<script>alert("Property not found or not available.");</script>';
    echo '<script>window.location.href="properties-grid.php";</script>';
    exit();
}
while ($row=mysqli_fetch_array($query)) {
?>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="property-single-gallery-info">
                            <div class="property--info clearfix">
                                <div class="pull-left">
                                    <h5 class="property--title"><?php echo $row['PropertyTitle'];?></h5>
                                    <p class="property--location"><?php echo $row['Address'];?>, <?php echo $row['CountryName'];?>, <?php echo $row['StateName'];?>,<?php echo $row['City'];?>,<?php echo $row['ZipCode'];?></p>
                                </div>
                                <div class="pull-right">
                                    <span class="property--status"><?php echo $row['Status'];?></span>
                                    <p class="property--price"><?php echo $row['RentorsalePrice'];?></p>
                                </div>
                            </div>
                            <!-- .property-info end -->
                            <div class="property--meta clearfix">
                                <div class="pull-left">
                                    <ul class="list-unstyled list-inline mb-0">
                                        <li>
                                            Property ID:<span class="value"><?php echo $row['PropertyID'];?></span>
                                        </li>
                                       
                                    </ul>
                                </div>
                                
                            </div>
                            <!-- .property-info end -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-8">
                        <div class="property-single-carousel inner-box">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="heading">
                                        <h2 class="heading--title">Gallery</h2>
                                    </div>
                                </div>
                                <!-- .col-md-12 end -->
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="property-single-carousel-content">
                                        <div class="carousel carousel-thumbs slider-navs" data-slide="1" data-slide-res="1" data-autoplay="true" data-thumbs="true" data-nav="true" data-dots="false" data-space="30" data-loop="true" data-speed="800" data-slider-id="1">
                                            <img src="propertyimages/<?php echo $row['FeaturedImage'];?>" alt="Property Image">
                                            <img src="propertyimages/<?php echo $row['GalleryImage1'];?>" alt="Property Image">
                                            <img src="propertyimages/<?php echo $row['GalleryImage2'];?>" alt="Property Image">
                                            <img src="propertyimages/<?php echo $row['GalleryImage3'];?>" alt="Property Image">
                                            <img src="propertyimages/<?php echo $row['GalleryImage4'];?>" alt="Property Image">
                                             <img src="propertyimages/<?php echo $row['GalleryImage5'];?>" alt="Property Image">
                                        </div>
                                        <!-- .carousel end -->
                                        <div class="owl-thumbs thumbs-bg" data-slider-id="1">
                                            <button class="owl-thumb-item">
								<img src="propertyimages/<?php echo $row['FeaturedImage'];?>" alt="Property Image thumb" width="100" height='100'>
							</button>
                                            <button class="owl-thumb-item">
						   		<img src="propertyimages/<?php echo $row['GalleryImage1'];?>" alt="Property Image thumb" width="100" height='100'>
						   </button>
                                            <button class="owl-thumb-item">
								<img src="propertyimages/<?php echo $row['GalleryImage2'];?>" alt="Property Image thumb" width="100" height='100'>
							</button>
                                            <button class="owl-thumb-item">
								<img src="propertyimages/<?php echo $row['GalleryImage3'];?>" alt="Property Image thumb" width="100" height='100'>
							</button>
                                            <button class="owl-thumb-item">
								<img src="propertyimages/<?php echo $row['GalleryImage4'];?>" alt="Property Image thumb" width="100" height='100'>
							</button>
                            <button class="owl-thumb-item">
                                <img src="propertyimages/<?php echo $row['GalleryImage5'];?>" alt="Property Image thumb" width="100" height='100'>
                            </button>
                                        </div>
                                    </div>
                                    <!-- .col-md-12 end -->
                                </div>
                            </div>
                            <!-- .row end -->
                        </div>
                        <!-- .property-single-desc end -->
                        <div class="property-single-desc inner-box">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="heading">
                                        <h2 class="heading--title">Description</h2>
                                    </div>
                                </div>
                                <!-- feature-panel #1 -->
                                <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="feature-panel">
                                        <div class="feature--img">
                                            <img src="assets/images/property-single/features/1.png" alt="icon">
                                        </div>
                                        <div class="feature--content">
                                            <h5>Area:</h5>
                                            <p><?php echo $row['Area'];?></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- feature-panel end -->
                                <!-- feature-panel #2 -->
                                <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="feature-panel">
                                        <div class="feature--img">
                                            <img src="assets/images/property-single/features/2.png" alt="icon">
                                        </div>
                                        <div class="feature--content">
                                            <h5>Beds:</h5>
                                            <p><?php echo $row['Bedrooms'];?></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- feature-panel end -->
                                <!-- feature-panel #3 -->
                                <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="feature-panel">
                                        <div class="feature--img">
                                            <img src="assets/images/property-single/features/3.png" alt="icon">
                                        </div>
                                        <div class="feature--content">
                                            <h5>Baths:</h5>
                                            <p><?php echo $row['Bathrooms'];?></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- feature-panel end -->
                                <!-- feature-panel #4 -->
                                <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="feature-panel">
                                        <div class="feature--img">
                                            <img src="assets/images/property-single/features/4.png" alt="icon">
                                        </div>
                                        <div class="feature--content">
                                            <h5>Size:</h5>
                                            <p><?php echo $row['Size'];?></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- feature-panel end -->
                                <!-- feature-panel #5 -->
                                <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="feature-panel">
                                        <div class="feature--img">
                                            <img src="assets/images/property-single/features/5.png" alt="icon">
                                        </div>
                                        <div class="feature--content">
                                            <h5>Floors:</h5>
                                            <p><?php echo $row['Floors'];?></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- feature-panel end -->
                                <!-- feature-panel #6 -->
                                <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="feature-panel">
                                        <div class="feature--img">
                                            <img src="assets/images/property-single/features/6.png" alt="icon">
                                        </div>
                                        <div class="feature--content">
                                            <h5>Garage:</h5>
                                            <p><?php echo $row['Garages'];?></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- feature-panel end -->
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="property--details">
                                        <p><?php echo $row['PropertDescription'];?></p>
                                    </div>
                                    <!-- .property-details end -->
                                </div>
                                <!-- .col-md-12 end -->
                            </div>
                            <!-- .row end -->
                        </div>
                        <!-- .property-single-desc end -->


                        <div class="property-single-features inner-box">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="heading">
                                        <h2 class="heading--title">Features</h2>
                                    </div>
                                </div>
                                <!-- feature-item #1 -->
                                <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="feature-item">
                                    <p>    
<?php if($row['CenterCooling']==1){?>
<img src="assets/images/check.png" width="12" height="12">
<?php } else { ?>
    <img src="assets/images/close.png" width="12" height="12">               
<?php } ?>    Center Cooling</p>
                                    </div>
                                </div>
                                <!-- feature-item end -->
                                <!-- feature-item #2 -->
                                <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="feature-item">
  <p> 
<?php if($row['Balcony']==1){?>
<img src="assets/images/check.png" width="12" height="12">
<?php } else { ?>
    <img src="assets/images/close.png" width="12" height="12">               
<?php } ?>Balcony</p>
                                    </div>
                                </div>
                                <!-- feature-item end -->
                                <!-- feature-item #3 -->
                                <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="feature-item">
                                        <p>
<?php if($row['PetFriendly']==1){?>
<img src="assets/images/check.png" width="12" height="12">
<?php } else { ?>
    <img src="assets/images/close.png" width="12" height="12">               
<?php } ?>Pet Friendly</p>
                                    </div>
                                </div>
                                <!-- feature-item end -->
                                <!-- feature-item #4 -->

              <div class="col-xs-6 col-sm-4 col-md-4">
                <div class="feature-item">
                    <p>
 <?php if($row['Barbeque']==1){?>
<img src="assets/images/check.png" width="12" height="12">
<?php } else { ?>
    <img src="assets/images/close.png" width="12" height="12">               
<?php } ?>Barbeque</p>
                                    </div>
                                </div>


                                <div class="col-xs-6 col-sm-4 col-md-4">
                                <div class="feature-item">
                                    <p>
 <?php if($row['FireAlarm']==1){?>
<img src="assets/images/check.png" width="12" height="12">
<?php } else { ?>
    <img src="assets/images/close.png" width="12" height="12">               
<?php } ?>Fire Alarm</p>
                                    </div>
                                </div>
                                <!-- feature-item end -->
                                <!-- feature-item #5 -->
                                <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="feature-item">
                                        <p>
                                        <?php if($row['ModernKitchen']==1){?>
<img src="assets/images/check.png" width="12" height="12">
<?php } else { ?>
    <img src="assets/images/close.png" width="12" height="12">               
<?php } ?>Modern Kitchen</p>
                                    </div>
                                </div>
                                <!-- feature-item end -->
                                <!-- feature-item #6 -->
                                <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="feature-item">
                                        <p>
                                        <?php if($row['Storage']==1){?>
<img src="assets/images/check.png" width="12" height="12">
<?php } else { ?>
    <img src="assets/images/close.png" width="12" height="12">               
<?php } ?>Storage</p>
                                    </div>
                                </div>
                             <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="feature-item">
                                        <p>
                                        <?php if($row['Dryer']==1){?>
<img src="assets/images/check.png" width="12" height="12">
<?php } else { ?>
    <img src="assets/images/close.png" width="12" height="12">               
<?php } ?>Dryer</p>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="feature-item">
                                        <p>
                                        <?php if($row['Heating']==1){?>
<img src="assets/images/check.png" width="12" height="12">
<?php } else { ?>
    <img src="assets/images/close.png" width="12" height="12">               
<?php } ?>Heating</p>
                                    </div>
                                </div>
                                <!-- feature-item end -->
                                <!-- feature-item #8 -->
                                <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="feature-item">
                                        <p>
                                        <?php if($row['Pool']==1){?>
<img src="assets/images/check.png" width="12" height="12">
<?php } else { ?>
    <img src="assets/images/close.png" width="12" height="12">               
<?php } ?>Pool</p>
                                    </div>
                                </div>
                                <!-- feature-item end -->
                                <!-- feature-item #9 -->
                                <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="feature-item">
                                        <p>
                                        <?php if($row['Laundry']==1){?>
<img src="assets/images/check.png" width="12" height="12">
<?php } else { ?>
    <img src="assets/images/close.png" width="12" height="12">               
<?php } ?>Laundry</p>
                                    </div>
                                </div>
                                <!-- feature-item end -->
                                <!-- feature-item #10 -->
                                <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="feature-item">
                                        <p>
                                        <?php if($row['Gym']==1){?>
<img src="assets/images/check.png" width="12" height="12">
<?php } else { ?>
    <img src="assets/images/close.png" width="12" height="12">               
<?php } ?>Gym</p>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="feature-item">
                                        <p>
                                        <?php if($row['Sauna']==1){?>
<img src="assets/images/check.png" width="12" height="12">
<?php } else { ?>
    <img src="assets/images/close.png" width="12" height="12">               
<?php } ?>Sauna</p>
                                    </div>
                                </div>
                                <!-- feature-item end -->
                                <!-- feature-item #11 -->
                                <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="feature-item">
                                        <p>
                                        <?php if($row['Elevator']==1){?>
<img src="assets/images/check.png" width="12" height="12">
<?php } else { ?>
    <img src="assets/images/close.png" width="12" height="12">               
<?php } ?>Elevator</p>
                                    </div>
                                </div>
                                <!-- feature-item end -->
                                <!-- feature-item #12 -->
                                <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="feature-item">
                                        <p>
                                        <?php if($row['DishWasher']==1){?>
<img src="assets/images/check.png" width="12" height="12">
<?php } else { ?>
    <img src="assets/images/close.png" width="12" height="12">               
<?php } ?>Dish Washer</p>
                                    </div>
                                </div>
<div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="feature-item">
                                        <p>
                                        <?php if($row['EmergencyExit']==1){?>
<img src="assets/images/check.png" width="12" height="12">
<?php } else { ?>
    <img src="assets/images/close.png" width="12" height="12">               
<?php } ?>EmergencyExit</p>
                                    </div>
                                </div>

                                <!-- feature-item end -->
                            </div>
                            <!-- .row end -->
                        </div>
                        <!-- .property-single-features end -->

                        <div class="property-single-location inner-box">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="heading">
                                        <h2 class="heading--title">Location</h2>
                                    </div>
                                </div>
                                <!-- .col-md-12 end -->
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <ul class="list-unstyled mb-20">
                                        <li><span>Address:</span><?php echo $row['Address'];?></li>
                                        <li><span>City:</span><?php echo $row['City'];?></li>
                                        <li><span>Country:</span><?php echo $row['CountryName'];?></li>
                                        <li><span>State:</span><?php echo $row['StateName'];?></li>
                                        <li><span>Zip/Postal code:</span><?php echo $row['ZipCode'];?></li>
                                    </ul>
                                </div>
                                <!-- .col-md-12 end -->

                            </div>
                            <!-- .row end -->
                        </div>
                             <?php }?>
                        <!-- .property-single-location end -->
<?php //$pid=intval($_GET['proid']);
//$qry=mysqli_query($con,"select tblfeedback.UserRemark,tblfeedback.PostingDate,tbluser.FullName from tblfeedback join tbluser on tbluser.ID=tblfeedback.UserId where tblfeedback.PropertyId='$pid' and tblfeedback.Is_Publish='1'"); 
//$countreview=mysqli_num_rows($qry);
?>
                     
                        <?php /* 
                        <div class="property-single-reviews inner-box">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="heading">
<h2 class="heading--title"><?php echo $countreview;?> Reviews</h2>
                                    </div>
                                </div>
                                <!-- .col-md-12 end -->
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <ul class="property-review">


<?php
while($rw=mysqli_fetch_array($qry)){
?>


                                        <li class="review-comment">
<div class="avatar"><?php echo ucfirst(substr($rw['FullName'],1,1));?></div>
<div class="comment">
<h6><?php echo $rw['FullName'];?></h6>
<div class="date"><?php echo $rw['PostingDate'];?></div>
<p><?php echo $rw['UserRemark'];?></p>
                                            </div>
                                        </li>
                                    <?php } ?>
                                    </ul>
                                    <!-- .comments-list end -->
                                </div>
                                <!-- .col-md-12 end -->
                            </div>
                            <!-- .row end -->
                        </div>
                        <!-- .property-single-reviews end -->

                        <div class="property-single-leave-review inner-box">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="heading">
                                        <h2 class="heading--title">Leave a Review</h2>
                                    </div>
                                </div>
                                <!-- .col-md-12 end -->
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                  <form id="post-comment" class="mb-0" method="post">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="review-comment">Review*</label>
   <textarea class="form-control" id="reviewcomment" name="reviewcomment" rows="2" required></textarea>
                                                </div>
                                            </div>
                                            <!-- .col-md-12 -->
                                            <div class="col-xs-12 col-sm-12 col-md-12">
          <button type="submit" name="submitreview" class="btn btn--primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- .col-md-12 end -->
                            </div>
                            <!-- .row end -->
                        </div>
                        <!-- .property-single-leave-review end -->
                        */ ?>
                    </div>
                    <!-- .col-md-8 -->
                    <div class="col-xs-12 col-sm-12 col-md-4">
<!-- widget property agent=============================-->
                        <div class="widget widget-property-agent">
<?php                
$ret1=mysqli_query($con,"select * from tbluser join tblproperty on tblproperty.UserID=tbluser.ID where tblproperty.ID=$proid");
$cnt=1;
while ($row1=mysqli_fetch_array($ret1)) {

?>
                            <div class="widget--title">
                                <?php if($row1['UserType']=="1"){?>
                                <h5>Posted by <span class="agent--title"><?php echo $row1['FullName'];?></span></h5>
                            <?php } else{ ?>
                             <h5>Posted by  Owner</h5>
                         <?php } ?>
                            </div>
                            <div class="widget--content">
                                <a href="user-properties.php?uid=<?php echo $row1['ID'];?>">
                                    <div class="agent--img">
                                        <img src="propertyimages/images.png" alt="agent" class="img-responsive" height="100" width="100">
                                    </div>
   

                                    <div class="agent--info">
                                        <h5 class="agent--title">User ID :<?php echo $row1['AgentID'];?></h5>
                                    </div>
                                </a>
                                <!-- .agent-profile-details end -->
                                <div class="agent--contact">
                                    <!-- <ul class="list-unstyled">
                                        <li><i class="fa fa-phone"></i><?php echo $row1['MobileNumber'];?></li>
                                        <li><i class="fa fa-envelope-o"></i><?php echo $row1['Email'];?></li>
                                       
                                    </ul> -->
                                </div>
                                <!-- .agent-contact end -->
                              <?php }?>
                                <!-- .agent-social-links -->
                            </div>
                        </div>
                        <!-- . widget property agent end -->

<!-- For Guest User =============================-->
<?php if($_SESSION['remsuid']==0)
{ ?>
                        <div class="widget widget-request">
                            <div class="widget--title">
                                <h5>Request a Showing</h5>
                            </div>
                            <div class="widget--content">
                                <form class="mb-0" method="post">
                                    <div class="form-group">
                                        <label for="contact-name">Your Name*</label>
                                        <input type="text" class="form-control" name="fullname" id="fullname" required="true">
                                    </div>
                                    <!-- .form-group end -->
                                    <div class="form-group">
                                        <label for="contact-email">Email Address*</label>
                                        <input type="email" class="form-control" name="email" id="email" required="true">
                                    </div>
                                    <!-- .form-group end -->
                                    <div class="form-group">
                                        <label for="contact-phone">Phone Number</label>
                                        <input type="text" class="form-control" name="mobnum" id="mobnum" required="true" maxlength="10" pattern="[0-9]+">
                                    </div>
                                    <!-- .form-group end -->
                                    <div class="form-group">
                                        <label for="message">Message*</label>
                                        <textarea class="form-control" name="message" id="message" rows="2" required="true"></textarea>
                                    </div>
                                    <!-- .form-group end -->
                                    <input type="submit" value="Send Request" name="submit" class="btn btn--primary btn--block">
                                </form>
                            </div>
                        </div>
                        <!-- . widget request end -->
<?php } else {
//If user is logged in
$uid=$_SESSION['remsuid'];
$sqlq=mysqli_query($con,"select * from tbluser where ID='$uid'");
while($ret=mysqli_fetch_array($sqlq))
{
$fname=$ret['FullName'];
$uemail=$ret['Email'];
$mnumebr=$ret['MobileNumber'];
} 
?>

     <div class="widget widget-request">
                            <div class="widget--title">
                                <h5>Request a Showing</h5>
                            </div>
                            <div class="widget--content">
                                <form class="mb-0" method="post">
                                    <div class="form-group">
                                        <label for="contact-name">Your Name*</label>
<input type="text" class="form-control" name="fullname" id="fullname" required="true" >
                                    </div>
                                    <!-- .form-group end -->
                                    <div class="form-group">
                                        <label for="contact-email">Email Address*</label>
<input type="email" class="form-control" name="email" id="email" required="true" >
                                    </div>
                                    <!-- .form-group end -->
                                    <div class="form-group">
                                        <label for="contact-phone">Phone Number</label>
<input type="text" class="form-control" name="mobnum" id="mobnum" required="true" maxlength="10" pattern="[0-9]+" >
                                    </div>
                                    <!-- .form-group end -->
                                    <div class="form-group">
                                        <label for="message">Message*</label>
                                        <textarea class="form-control" name="message" id="message" rows="2" ></textarea>
                                    </div>
                                    <!-- .form-group end -->
                                    <input type="submit" value="Send Request" name="submit" class="btn btn--primary btn--block">
                                </form>
                            </div>
                        </div>


                     
<?php } ?>
<!-- widget mortgage calculator=============================-->

                        <!-- <div class="widget widget-mortgage-calculator">
                            <div class="widget--title">
                                <h5>Mortgage Calculator</h5>
                            </div>
                            <div class="widget--content">
                                <form class="mb-0" id="mortgage-calc-form">
                                    <div class="form-group">
                                        <label for="sale-price">Sale Price</label>
                                        <input type="number" class="form-control" name="saleprice" id="saleprice" placeholder="$" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="down-payment">Down Payment</label>
                                        <input type="number" class="form-control" name="downpayment" id="downpayment" placeholder="$" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="term">Term</label>
                                        <input type="number" class="form-control" name="term" id="term" placeholder="years" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="interest-rate">Interest Rate</label>
                                        <input type="number" step="0.01" class="form-control" name="interestrate" id="interestrate" placeholder="%" required>
                                    </div>
                                    <button type="submit" class="btn btn--primary">Calculate</button>
                                </form>
                                <div id="mortgage-result" style="margin-top:15px; font-weight:600; color:#260844;"></div>
                            </div>
                        </div>
                        <script>
                        document.getElementById('mortgage-calc-form').addEventListener('submit', function(e) {
                            e.preventDefault();
                            var salePrice = parseFloat(document.getElementById('saleprice').value) || 0;
                            var downPayment = parseFloat(document.getElementById('downpayment').value) || 0;
                            var term = parseFloat(document.getElementById('term').value) || 0;
                            var interestRate = parseFloat(document.getElementById('interestrate').value) || 0;

                            var principal = salePrice - downPayment;
                            var monthlyInterest = interestRate / 100 / 12;
                            var numberOfPayments = term * 12;

                            if (principal <= 0 || monthlyInterest <= 0 || numberOfPayments <= 0) {
                                document.getElementById('mortgage-result').innerText = "Please enter valid values.";
                                return;
                            }

                            var monthlyPayment = (principal * monthlyInterest * Math.pow(1 + monthlyInterest, numberOfPayments)) /
                                (Math.pow(1 + monthlyInterest, numberOfPayments) - 1);

                            if (isFinite(monthlyPayment)) {
                                document.getElementById('mortgage-result').innerText =
                                    "Estimated Monthly Payment: $" + monthlyPayment.toFixed(2);
                            } else {
                                document.getElementById('mortgage-result').innerText = "Calculation error. Please check your input.";
                            }
                        });
                        </script> -->
                    </div>
                    <!-- .col-md-4 -->
                </div>
                <!-- .row -->
            </div>
            <!-- .container -->
        </section>
        <!-- #property-single end -->


        <!-- properties-carousel
============================================= -->
        <section id="properties-carousel" class="properties-carousel pt-0">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="heading heading-2  mb-70">
                            <h2 class="heading--title">Similar Properties</h2>
                        </div>
                        <!-- .heading-title end -->
                    </div>
                    <!-- .col-md-12 end -->
                </div>
                <!-- .row end -->
               <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="carousel carousel-dots" data-slide="3" data-slide-rs="2" data-autoplay="true" data-nav="false" data-dots="true" data-space="25" data-loop="true" data-speed="800">
                            <!-- .property-item #1 -->
                            <?php
                      
$query=mysqli_query($con,"select * from tblproperty WHERE ApprovalStatus='Approved' order by rand() limit 9");
while($row=mysqli_fetch_array($query))
{
?>
                            <div class="property-item">
                                <div class="property--img">
                                    <a href="single-property-detail.php?proid=<?php echo $row['ID'];?>">
                        <img src="propertyimages/<?php echo $row['FeaturedImage'];?>" alt="<?php echo $row['PropertyTitle'];?>" width='380' height='300' >
                        <span class="property--status"><?php echo $row['Status'];?></span>
                        </a>
                                </div>
                                <div class="property--content">
                                    <div class="property--info">
                                        <h5 class="property--title"><a href="single-property-detail.php?proid=<?php echo $row['ID'];?>">
    <?php echo $row['PropertyTitle'];?></a></h5>
                                        <p class="property--location"><?php echo $row['Address'];?>&nbsp;
<?php echo $row['City'];?>&nbsp;
<?php echo $row['State'];?>&nbsp;  
<?php echo $row['Country'];?></p>
<p class="property--price"><?php echo $row['RentorsalePrice'];?></p>
</div>
                                    <!-- .property-info end -->
<div class="property--features">
<ul class="list-unstyled mb-0">
<li><span class="feature">Beds:</span><span class="feature-num"><?php echo $row['Bedrooms'];?></span></li>
<li><span class="feature">Baths:</span><span class="feature-num"><?php echo $row['Bathrooms'];?></span></li>
<li><span class="feature">Area:</span><span class="feature-num"><?php echo $row['Area'];?></span></li>
                                        </ul>
                                    </div>
                                    <!-- .property-features end -->
                                </div>
                            </div>
                            <?php } ?>


                        </div>
                        <!-- .carousel end -->
                    </div>
                    <!-- .col-md-12 -->
                </div>
                <!-- .row -->
            </div>
            <!-- .container -->
        </section>
        <!-- #properties-carousel  end  -->

        <!-- cta #1
============================================= -->
       
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
    <script src="http://maps.google.com/maps/api/js?sensor=true&amp;key=AIzaSyCiRALrXFl5vovX0hAkccXXBFh7zP8AOW8"></script>
    <script src="assets/js/plugins/jquery.gmap.min.js"></script>
    <script>
        $('#googleMap').gMap({
            address: "121 King St,Melbourne, Australia",
            zoom: 12,
            maptype: 'ROADMAP',
            markers: [{
                address: "Melbourne, Australia",
                maptype: 'ROADMAP',
                icon: {
                    image: "assets/images/gmap/marker1.png",
                    iconsize: [52, 75],
                    iconanchor: [52, 75]
                }
            }]
        });

    </script>
    <script src="assets/js/map-custom.js"></script>
</body>

</html>

<style>
/* Modern Card Styles */
.inner-box, .widget, .property-single-carousel-content, .property-single-desc, .property-single-features, .property-single-location, .property-single-reviews, .property-single-leave-review {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(38,8,68,0.08);
    padding: 32px 24px 24px 24px;
    margin-bottom: 32px;
    border: 1px solid #f2f2f2;
    transition: box-shadow 0.2s;
}
.inner-box:hover, .widget:hover {
    box-shadow: 0 8px 32px rgba(38,8,68,0.14);
}

.property--title, .heading--title {
    color: #260844;
    font-weight: 700;
    letter-spacing: 1px;
    margin-bottom: 12px;
    font-family: 'Poppins', 'Open Sans', Arial, sans-serif;
}

.property--location, .property--price, .property--status {
    font-size: 1.08rem;
    color: #555;
}

.property--price {
    color: #C29425;
    font-size: 1.2rem;
    font-weight: 700;
}

.property--status {
    background: #260844;
    color: #fff;
    border-radius: 8px;
    padding: 4px 14px;
    font-size: 0.95rem;
    margin-left: 10px;
}

.property-single-carousel-content img {
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(38,8,68,0.10);
    margin-bottom: 12px;
    max-height: 400px;
    object-fit: cover;
    width: 100%;
    height: auto;
    display: block;
}

.owl-thumbs {
    margin-top: 10px;
    text-align: center;
}
.owl-thumb-item img {
    border-radius: 8px;
    border: 2px solid #eee;
    margin: 0 4px;
    width: 70px !important;
    height: 70px !important;
    object-fit: cover;
    transition: border 0.2s;
}
.owl-thumb-item.active img, .owl-thumb-item:hover img {
    border: 2px solid #C29425;
}

.feature-panel, .feature-item {
    background: #faf9ff;
    border-radius: 10px;
    padding: 16px 10px;
    margin-bottom: 18px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(38,8,68,0.06);
}
.feature-panel h5, .feature-item p {
    margin-bottom: 6px;
    font-weight: 600;
    color: #260844;
}
.feature-panel img, .feature-item img {
    margin-bottom: 8px;
}

.property--details p {
    color: #444;
    font-size: 1.08rem;
    line-height: 1.7;
}

.property-single-reviews .review-comment {
    display: flex;
    align-items: flex-start;
    margin-bottom: 18px;
    background: #f7f6fb;
    border-radius: 10px;
    padding: 14px 16px;
}
.property-single-reviews .avatar {
    background: #260844;
    color: #fff;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.2rem;
    margin-right: 14px;
}
.property-single-reviews .comment h6 {
    margin: 0 0 4px 0;
    color: #260844;
    font-weight: 600;
}
.property-single-reviews .comment .date {
    font-size: 0.95rem;
    color: #888;
    margin-bottom: 6px;
}

.property-single-leave-review textarea.form-control {
    border-radius: 8px;
    border: 1.5px solid #e0e0e0;
    min-height: 60px;
    font-size: 1rem;
    transition: border 0.2s;
}
.property-single-leave-review textarea.form-control:focus {
    border: 1.5px solid #C29425;
    outline: none;
}

.btn--primary, .btn.btn--primary {
    background: #260844 !important;
    color: #fff !important;
    border: none;
    border-radius: 8px;
    font-weight: 700;
    padding: 10px 28px;
    font-size: 1.08rem;
    transition: background 0.2s, box-shadow 0.2s;
    box-shadow: 0 2px 8px rgba(38,8,68,0.10);
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}
.btn--primary:hover, .btn.btn--primary:hover {
    background: #3d0e7e !important;
    color: #fff !important;
}

.widget--title h5 {
    color: #260844;
    font-weight: 700;
    margin-bottom: 10px;
}

.agent--img img {
    border-radius: 50%;
    border: 3px solid #C29425;
    width: 90px;
    height: 90px;
    object-fit: cover;
    margin-bottom: 8px;
}

.agent--info h5 {
    color: #260844;
    font-weight: 600;
    margin-bottom: 4px;
}

.agent--contact ul {
    padding-left: 0;
    list-style: none;
}
.agent--contact li {
    color: #555;
    font-size: 1rem;
    margin-bottom: 4px;
}

.widget-request input[type="text"], .widget-request input[type="email"], .widget-request textarea,
.widget-mortgage-calculator input[type="text"] {
    border-radius: 8px;
    border: 1.5px solid #e0e0e0;
    font-size: 1rem;
    padding: 8px 12px;
    margin-bottom: 10px;
    transition: border 0.2s;
}
.widget-request input[type="text"]:focus, .widget-request input[type="email"]:focus, .widget-request textarea:focus,
.widget-mortgage-calculator input[type="text"]:focus {
    border: 1.5px solid #C29425;
    outline: none;
}

.widget-mortgage-calculator .btn--primary {
    width: 100%;
}

@media (max-width: 991px) {
    .inner-box, .widget, .property-single-carousel-content, .property-single-desc, .property-single-features, .property-single-location, .property-single-reviews, .property-single-leave-review {
        padding: 18px 8px 10px 8px;
    }
    .property-single-carousel-content img {
        max-height: 280px;
    }
    .owl-thumb-item img {
        width: 48px !important;
        height: 48px !important;
    }
}

@media (max-width: 767px) {
    .property-single-carousel-content img {
        max-height: 220px;
    }
    .property--title, .heading--title {
        font-size: 1.2rem;
    }
    .btn--primary, .btn.btn--primary {
        padding: 8px 12px;
        font-size: 1rem;
    }
}
</style>
