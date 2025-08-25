<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <!-- Document Meta
    ============================================= -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i%7CPoppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="assets/css/external.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <title>Real Estate Management System | Properties Grid</title>
     <style>
        /* Ensure property grid cards align: full-height cards and flex column content */
        .properties-grid .property-item {
            display: flex !important;
            flex-direction: column !important;
            height: 100% !important;
        }
        .properties-grid .property--content {
            flex: 1 1 auto !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
        }
        /* Keep price and meta pinned to bottom */
        .properties-grid .property--info { margin-bottom: 12px; }
        .properties-grid .property--price { margin-top: auto; }
        /* Stronger alignment rules */
        .properties-grid .property-item {
            min-height: 420px; /* ensure enough room for image + title + meta + price */
            flex: 1 1 auto !important;
        }
        .properties-grid .property--info {
            display: flex !important;
            flex-direction: column !important;
            height: 100%;
        }
        /* Force image area to fixed height so cards align */
        .properties-grid .property--img img {
            height: 200px !important;
            width: 100% !important;
            object-fit: cover !important;
            display: block;
        }
        /* Make sure the image container doesn't collapse and remains fixed size */
        .properties-grid .property--img { flex: 0 0 auto; }
        /* Reserve consistent space for title/location area */
        .properties-grid .property--info {
            min-height: 120px;
        }
        /* Clamp title to two lines so cards have predictable height */
        .properties-grid .property--title {
            display: block;
            line-height: 1.2em;
            max-height: 2.4em; /* ~2 lines */
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 6px;
        }
        /* More robust multiline clamp for title link */
        .properties-grid .property--title a {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        /* Prevent long location text from pushing card height — clamp to a single line */
        .properties-grid .property--location {
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #777;
            font-size: 0.95rem;
            margin-bottom: 8px;
        }
        .properties-grid .property--location {
            /* fallback in case other rules are removed */
        }
        .properties-grid .property--price {
            font-size: 1.4rem;
            color: #34c997;
            font-weight: 700;
            margin-top: auto !important;
        }
        /* Force bootstrap grid columns that contain property cards to stretch equally */
        .properties-grid .row > [class*="col-"] {
            display: flex;
            align-items: stretch;
        }
    </style>
</head>

<body>
    <!-- Document Wrapper
    ============================================= -->
    <div id="wrapper" class="wrapper clearfix">
        <header id="navbar-spy" class="header header-1 header-light header-fixed">
   <?php include_once('includes/header.php');?>

        </header>
        <!-- map
============================================ -->
      <?php include_once('includes/header-search.php');?>
        <!-- #map end -->

        <!-- properties-grid
============================================= -->
        <section id="properties-grid" style="margin-top:-14%;">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4" >
                        <!-- widget property type
=============================-->

                        <div class="widget widget-property">
                           
                            <div class="widget--title">
                                <h5>Property Type</h5>
                            </div>

                            <div class="widget--content">
                                <ul class="list-unstyled mb-0">
                                    <?php
$query3=mysqli_query($con,"select distinct Type from  tblproperty WHERE ApprovalStatus='Approved' AND ApprovedBy IS NOT NULL");
while($row3=mysqli_fetch_array($query3))
{
?>
                                    <li>
                                        <a href="protypewise-property-detail.php?protypeid=<?php echo $row3['Type'];?>"><?php echo $row3['Type'];?></a>

                                    </li>
                                    <?php } ?>
                                   
                                </ul>
                            </div>
                        </div>
                        
                        <!-- . widget property type end -->

                        <!-- widget property status
=============================-->
                        <div class="widget widget-property">
                            <div class="widget--title">
                                <h5>Property Status</h5>
                            </div>
                            <div class="widget--content">
                                <?php
$query4=mysqli_query($con,"select distinct Status from  tblproperty WHERE ApprovalStatus='Approved' AND ApprovedBy IS NOT NULL");
while($row4=mysqli_fetch_array($query4))
{
?>
                                <ul class="list-unstyled mb-0">
                                    <li>
                                       <a href="statuswise-property-detail.php?stproid=<?php echo $row4['Status'];?>"><?php echo $row4['Status'];?></a>
                                    </li>
                                    <?php } ?>
                                    
                                </ul>
                            </div>
                        </div>
                        <!-- . widget property status end -->


                        <!-- widget property city
=============================-->
                        <div class="widget widget-property">
                            <div class="widget--title">
                                <h5>Property By City</h5>
                            </div>
                            <div class="widget--content">
                                <ul class="list-unstyled mb-0">
                                    <?php
$query5=mysqli_query($con,"select distinct City from  tblproperty WHERE ApprovalStatus='Approved' AND ApprovedBy IS NOT NULL");
while($row5=mysqli_fetch_array($query5))
{
?>
                                    <li>
                                       <a href="citywise-property-detail.php?cityproid=<?php echo $row5['City'];?>"><?php echo $row5['City'];?></a>
                                    </li>
                                    
                                    <?php } ?>
                                   
                                </ul>
                            </div>
                        </div>
                      
                    </div>
                    <!-- .col-md-4 end -->
                    <div class="col-xs-12 col-sm-12 col-md-8">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="properties-filter clearfix">
                                  
                                    <!-- .select-box -->
                                    <div class="view--type pull-right">
                                        <a id="switch-list" href="#" class=""><i class="fa fa-th-list"></i></a>
                                        <a id="switch-grid" href="#" class="active"><i class="fa fa-th-large"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="properties properties-grid">
                                <!-- .col-md-12 end -->

<?php
$stproid=$_GET['stproid'];
$query=mysqli_query($con,"select * from tblproperty where Status='$stproid' AND ApprovalStatus='Approved' AND ApprovedBy IS NOT NULL");
$num=mysqli_num_rows($query);
while($row=mysqli_fetch_array($query))
{
?>

                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <!-- .property-item #1 -->
                                    <div class="property-item">
                                        <div class="property--img">
<a href="single-property-detail.php?proid=<?php echo $row['ID'];?>" target="_blank">
<img src="propertyimages/<?php echo $row['FeaturedImage'];?>" alt="property image" class="img-responsive" >
                                </a>
<span class="property--status"><?php echo $row['Status'];?></span>
 </div>
 <div class="property--content">
<div class="property--info">
 <h5 class="property--title">
<a href="single-property-detail.php?proid=<?php echo $row['ID'];?>" target="_blank">
    <?php echo $row['PropertyTitle'];?></a></h5>
<p class="property--location"><?php echo $row['Address'];?>&nbsp;
<?php echo $row['City'];?>&nbsp;
<?php echo $row['State'];?>&nbsp;  
<?php echo $row['Country'];?></p>
<p class="property--price"><?php echo $row['RentorsalePrice'];?></p>
 </div>
                                            <!-- .property-info end -->
<!-- <div class="property--features">
<ul class="list-unstyled mb-0">
<li><span class="feature">Beds:</span><span class="feature-num"><?php echo $row['Bedrooms'];?></span></li>
<li><span class="feature">Baths:</span><span class="feature-num"><?php echo $row['Bathrooms'];?></span></li>
<li><span class="feature">Area:</span><span class="feature-num"><?php echo $row['Area'];?></span></li>
</ul>
</div> -->
                                            <!-- .property-features end -->
                                        </div>
                                    </div>
                                </div>
<?php } ?>

                                <!-- .property item end -->

                              
                                <!-- .property item end -->
                            </div>
                             <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-50">
                        <div style="display: flex; justify-content: center; gap: 10px;">
                            <a href="?pageno=1"
                               style="padding:10px 24px; border:none; background:#007bff; color:#fff; border-radius:4px; font-weight:600; text-decoration:none; transition:background 0.2s;">
                                &laquo;
                            </a>
                            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"
                               style="padding:10px 24px; border:none; background:<?php echo ($pageno <= 1) ? '#6c757d' : '#007bff'; ?>; color:#fff; border-radius:4px; font-weight:600; text-decoration:none; transition:background 0.2s; pointer-events:<?php echo ($pageno <= 1) ? 'none' : 'auto'; ?>;">
                                &lt;
                            </a>
                            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>"
                               style="padding:10px 24px; border:none; background:<?php echo ($pageno >= $total_pages) ? '#6c757d' : '#007bff'; ?>; color:#fff; border-radius:4px; font-weight:600; text-decoration:none; transition:background 0.2s; pointer-events:<?php echo ($pageno >= $total_pages) ? 'none' : 'auto'; ?>;">
                                &gt;
                            </a>
                            <a href="?pageno=<?php echo $total_pages; ?>"
                               style="padding:10px 24px; border:none; background:#007bff; color:#fff; border-radius:4px; font-weight:600; text-decoration:none; transition:background 0.2s;">
                                &raquo;
                            </a>
                        </div>
                            </div>
                            <!-- .col-md-12 end -->
                        </div>
                        <!-- .row -->
                    </div>
                    <!-- .col-md-8 end -->
                </div>
                <!-- .row -->
            </div>
            <!-- .container -->
        </section>
        <!-- #properties-grid  end  -->

      
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
    <script src="assets/js/map-addresses.js"></script>
    <script src="assets/js/map-custom.js"></script>
</body>

</html>
