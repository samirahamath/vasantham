<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['remsaid']==0)) {
  header('location:logout.php');
  } else{

if(isset($_POST['submit']))
{
$uid=$_GET['viewid'];
$protitle=$_POST['propertytitle'];
$prodec=$_POST['propertydescription'];
$type=$_POST['type'];
$status=$_POST['status'];
$location=$_POST['location'];
$bedrooms=$_POST['bedrooms'];
$bathrooms=$_POST['bathrooms'];
$floors=$_POST['floors'];
$garages=$_POST['garages'];
$area=$_POST['area'];
$saleprice=$_POST['saleprice'];
$beforepricelabel=$_POST['beforepricelabel'];
$afterpricelabel=$_POST['afterpricelabel'];
$ccooling=isset($_POST['centercolling']) ? 1 : 0;
$balcony=isset($_POST['balcony']) ? 1 : 0;
$petfrndly=isset($_POST['petfrndly']) ? 1 : 0;
$barbeque=isset($_POST['barbeque']) ? 1 : 0;
$firealarm=isset($_POST['firealarm']) ? 1 : 0;
$storage=isset($_POST['storage']) ? 1 : 0;
$dryer=isset($_POST['dryer']) ? 1 : 0;
$heating=isset($_POST['heating']) ? 1 : 0;
$pool=isset($_POST['pool']) ? 1 : 0;
$laundry=isset($_POST['laundry']) ? 1 : 0;
$sauna=isset($_POST['sauna']) ? 1 : 0;
$gym=isset($_POST['gym']) ? 1 : 0;
$elevator=isset($_POST['elevator']) ? 1 : 0;
$dishwasher=isset($_POST['dishwasher']) ? 1 : 0;
$eexit=isset($_POST['eexit']) ? 1 : 0;
$address=$_POST['address'];
$zipcode=$_POST['zipcode'];
$neighborhood=$_POST['neighborhood'];

 $query=mysqli_query($con, "update tblproperty set PropertyTitle='$protitle',PropertDescription='$prodec',Type='$type',Status='$status',Location='$location',Bedrooms='$bedrooms',Bathrooms='$bathrooms',Floors='$floors',Garages='$garages',Area='$area',RentorsalePrice='$saleprice',BeforePricelabel='$beforepricelabel',AfterPricelabel='$afterpricelabel',CenterCooling='$ccooling',Balcony='$balcony',PetFriendly='$petfrndly',Barbeque='$barbeque',FireAlarm='$firealarm',Storage='$storage',Dryer='$dryer',Heating='$heating',Pool='$pool',Laundry='$laundry',Sauna='$sauna',Gym='$gym',Elevator='$elevator',DishWasher='$dishwasher',EmergencyExit='$eexit',Address='$address',ZipCode='$zipcode',Neighborhood='$neighborhood' where ID='$uid'");

    if ($query) {
    $msg="Property details has been updated.";
  }
  else
    {
      $msg="Something Went Wrong. Please try again";
    }
}

  ?>

<!doctype html>
<html lang="en">

 
<head>
    
    <title>Real Estate Management System || View Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
       
         <?php include_once('includes/header.php');?>
       
       <?php include_once('includes/sidebar.php');?>
       
        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">View Details </h2>
                            
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="dashboard.php" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="add-country.php" class="breadcrumb-link">View Details</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">View Details</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                
                    <div class="row">
                        <!-- ============================================================== -->
                        <!-- valifation types -->
                        <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">View Details</h5>
                                <div class="card-body">
                                    <form class="form-horizontal" method="post">
                            <p style="font-size:16px; color:red" align="center"> <?php if($msg){
    echo $msg;
  }  ?> </p>
  <?php
  $uid=$_GET['viewid'];

$ret=mysqli_query($con,"select tblproperty.*,tbluser.*,tblcountry.CountryName,tblstate.StateName from tblproperty
left join tbluser on tbluser.ID=tblproperty.UserID 
left join tblcountry on tblcountry.ID=tblproperty.Country 
left join tblstate on tblstate.ID=tblproperty.State where tblproperty.ID='$uid'");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>
                                
                                <table border="1" class="table table-striped table-bordered first" >
                                <tr>
                                    <th >Full Name </th>
                                    <td style="padding-left: 10px"><?php  echo $row['FullName'];?></td>
                                </tr>
                                <tr>
                                    <th>Mobile Number </th>
                                    <td style="padding-left: 10px"><?php  echo $row['MobileNumber'];?></td>
                                </tr>
                                <tr>
                                    <th>Email </th>
                                    <td style="padding-left: 10px"><?php  echo $row['Email'];?></td>
                                </tr>
                                <tr>
                                    <th>Property Title </th>
                                    <td><input type="text" name="propertytitle" class="form-control" required="true" value="<?php  echo $row['PropertyTitle'];?>"></td>
                                </tr>
                                <tr>
                                    <th>Property Description </th>
                                    <td><textarea name="propertydescription" class="form-control" required="true"><?php  echo $row['PropertDescription'];?></textarea></td>
                                </tr>
                                <tr>
                                    <th>Type </th>
                                    <td><input type="text" name="type" class="form-control" required="true" value="<?php  echo $row['Type'];?>"></td>
                                </tr>
                                <tr>
                                    <th>Status </th>
                                    <td><input type="text" name="status" class="form-control" required="true" value="<?php  echo $row['Status'];?>"></td>
                                </tr>
                                <tr>
                                    <th>Location </th>
                                    <td><input type="text" name="location" class="form-control" required="true" value="<?php  echo $row['Location'];?>"></td>
                                </tr>
                                <tr>
                                    <th>Bedrooms </th>
                                    <td><input type="text" name="bedrooms" class="form-control" required="true" value="<?php  echo $row['Bedrooms'];?>"></td>
                                </tr>
                                <tr>
                                    <th>Bathrooms </th>
                                    <td><input type="text" name="bathrooms" class="form-control" required="true" value="<?php  echo $row['Bathrooms'];?>"></td>
                                </tr>
                                <tr>
                                    <th>Floors </th>
                                    <td><input type="text" name="floors" class="form-control" required="true" value="<?php  echo $row['Floors'];?>"></td>
                                </tr>
                                <tr>
                                    <th>Garages </th>
                                    <td><input type="text" name="garages" class="form-control" required="true" value="<?php  echo $row['Garages'];?>"></td>
                                </tr>
                                <tr>
                                    <th>Area </th>
                                    <td><input type="text" name="area" class="form-control" required="true" value="<?php  echo $row['Area'];?>"></td>
                                </tr>
                                <tr>
                                    <th>Rent/salePrice </th>
                                    <td><input type="text" name="saleprice" class="form-control" required="true" value="<?php  echo $row['RentorsalePrice'];?>"></td>
                                </tr>
                                <tr>
                                    <th>Before Price label </th>
                                    <td><input type="text" name="beforepricelabel" class="form-control" value="<?php  echo $row['BeforePricelabel'];?>"></td>
                                </tr>
                                <tr>
                                    <th>After Price label </th>
                                    <td><input type="text" name="afterpricelabel" class="form-control" value="<?php  echo $row['AfterPricelabel'];?>"></td>
                                </tr>
                                <tr>
                                    <th>PropertyID </th>
                                    <td style="padding-left: 10px"><?php  echo $row['PropertyID'];?></td>
                                </tr>
                                <table border="1" class="table table-striped table-bordered first">
                                    <hr>
                                    <p style="color: red">Property Features</p>
                                <tr>
                                    <th>Center Cooling </th>
                                    <?php  if($row['CenterCooling']=="1"){ ?>

                                   <td > <input type="checkbox" name="centercolling" id="centercolling" value="1" checked="true"></td>
                                   <?php } else { ?>
                                    <td> <input type="checkbox" name="centercolling" id="centercolling" value="1"></td> <?php } ?>

                                </tr>

                                <tr>
                                    <th>Balcony </th>
                                    <?php  if($row['Balcony']=="1"){ ?>

                                   <td > <input type="checkbox" name="balcony" id="balcony" value="1" checked="true"></td>
                                   <?php } else { ?>
                                    <td> <input type="checkbox" name="balcony" id="balcony" value="1"></td> <?php } ?>
                                </tr>
                                <tr>
                                    <th>Pet Friendly </th>
                                    <?php  if($row['PetFriendly']=="1"){ ?>
                                    <td > <input type="checkbox" name="petfrndly" id="petfrndly" value="1" checked="true"></td>
                                   <?php } else { ?>
                                    <td> <input type="checkbox" name="petfrndly" id="petfrndly" value="1"></td> <?php } ?>
                                </tr>
                                <tr>
                                    <th>Barbeque </th>
                                    <?php  if($row['Barbeque']=="1"){ ?>
                                    <td > <input type="checkbox" name="barbeque" id="barbeque" value="1"checked='true'></td>
                                   <?php } else { ?>
                                    <td> <input type="checkbox" name="barbeque" id="barbeque" value="1"></td> <?php } ?>
                                </tr>
                                <tr>
                                    <th>Fire Alarm </th>
                                    <?php  if($row['FireAlarm']=="1"){ ?>
                                    <td > <input type="checkbox" name="firealarm" id="firealarm" value="1" checked="true"></td>
                                   <?php } else { ?>
                                    <td> <input type="checkbox" name="firealarm" id="firealarm" value="1"></td> <?php } ?>
                                </tr>
                                <tr>
                                    <th>Storage </th>
                                    <?php  if($row['Storage']=="1"){ ?>
                                    <td > <input type="checkbox" name="storage" id="storage" value="1" checked="true"></td>
                                   <?php } else { ?>
                                    <td> <input type="checkbox" name="storage" id="storage" value="1"></td> <?php } ?>
                                </tr>
                                <tr>
                                    <th>Dryer </th>
                                     <?php  if($row['Dryer']=="1"){ ?>
                                    <td > <input type="checkbox" name="dryer" id="dryer" value="1" checked="true"></td>
                                   <?php } else { ?>
                                    <td> <input type="checkbox" name="dryer" id="dryer" value="1">
                                            </td> <?php } ?>
                                </tr>
                                <tr>
                                    <th>Heating </th>
                                    <?php  if($row['Heating']=="1"){ ?>
                                    <td > <input type="checkbox" name="heating" id="heating" value="1" checked="true"></td>
                                   <?php } else { ?>
                                    <td> <input type="checkbox" name="heating" id="heating" value="1">
                                            </td> <?php } ?>
                                </tr>
                                <tr>
                                    <th>Pool </th>
                                    <?php  if($row['Pool']=="1"){ ?>
                                    <td > <input type="checkbox" name="pool" id="pool" value="1" checked="true"></td>
                                   <?php } else { ?>
                                    <td> <input type="checkbox" name="pool" id="pool" value="1">
                                            </td> <?php } ?>
                                </tr>
                                <tr>
                                    <th>Laundry </th>
                                    <?php  if($row['Laundry']=="1"){ ?>
                                    <td > <input type="checkbox" name="laundry" id="laundry" value="1" checked="true"></td>
                                   <?php } else { ?>
                                    <td> <input type="checkbox" name="laundry" id="laundry" value="1">
                                            </td> <?php } ?>
                                </tr>
                                <tr>
                                    <th>Sauna </th>
                                    <?php  if($row['Sauna']=="1"){ ?>
                                    <td > <input type="checkbox" name="sauna" id="sauna" value="1" checked="true"></td>
                                   <?php } else { ?>
                                    <td> <input type="checkbox" name="sauna" id="sauna" value="1">
                                            </td> <?php } ?>
                                </tr>
                                <tr>
                                    <th>Gym </th>
                                    <?php  if($row['Gym']=="1"){ ?>
                                    <td >  <input type="checkbox" name="gym" id="gym" value="1" checked="true"></td>
                                   <?php } else { ?>
                                    <td> <input type="checkbox" name="gym" id="gym" value="1">
                                            </td> <?php } ?>
                                </tr>
                                <tr>
                                    <th>Elevator </th>
                                    <?php  if($row['Elevator']=="1"){ ?>
                                    <td >  <input type="checkbox" name="elevator" id="elevator" value="1" checked="true"></td>
                                   <?php } else { ?>
                                    <td> <input type="checkbox" name="elevator" id="elevator" value="1">
                                            </td> <?php } ?>
                                </tr>
                                <tr>
                                    <th>Dish Washer </th>
                                    <?php  if($row['DishWasher']=="1"){ ?>
                                    <td >  <input type="checkbox" name="dishwasher" id="dishwasher" value="1" checked="true"></td>
                                   <?php } else { ?>
                                    <td> <input type="checkbox" name="dishwasher" id="dishwasher" value="1">
                                            </td> <?php } ?>
                                </tr>
                                <tr>
                                    <th>Emergency Exit </th>
                                     <?php  if($row['EmergencyExit']=="1"){ ?>
                                   <td >  <input type="checkbox" name="eexit" id="eexit" value="1" checked="true"></td>
                                   <?php } else { ?>
                                    <td> <input type="checkbox" name="eexit" id="eexit" value="1">
                                            </td> <?php } ?>
                                </tr>
                                </table>
                                <table border="1" class="table table-striped table-bordered first">
                                    <hr>
                                    <p style="color: red">Property Images</p>
                                <tr>
                                    <th>Featured Image </th>
                                    <td style="padding-left: 10px"><img src="../propertyimages/<?php echo $row['FeaturedImage'];?>" width="200" height="150" value="<?php  echo $row['FeaturedImage'];?>"></td>
                                </tr>
                                <tr>
                                    <th>Gallery Image1 </th>
                                    <td style="padding-left: 10px"><img src="../propertyimages/<?php echo $row['GalleryImage1'];?>" width="200" height="150" value="<?php  echo $row['GalleryImage1'];?>"></td>
                                </tr>
                                <tr>
                                    <th>Gallery Image2 </th>
                                    <td style="padding-left: 10px"><img src="../propertyimages/<?php echo $row['GalleryImage2'];?>" width="200" height="150" value="<?php  echo $row['GalleryImage2'];?>"></td>
                                </tr>
                                <tr>
                                    <th>Gallery Image3 </th>
                                    <td style="padding-left: 10px"><img src="../propertyimages/<?php echo $row['GalleryImage3'];?>" width="200" height="150" value="<?php  echo $row['GalleryImage3'];?>"></td>
                                </tr>
                                <tr>
                                    <th>Gallery Image4 </th>
                                    <td style="padding-left: 10px"><img src="../propertyimages/<?php echo $row['GalleryImage4'];?>" width="200" height="150" value="<?php  echo $row['GalleryImage4'];?>"></td>
                                </tr>
                                <tr>
                                    <th>Gallery Image5 </th>
                                    <td style="padding-left: 10px"><img src="../propertyimages/<?php echo $row['GalleryImage5'];?>" width="200" height="150" value="<?php  echo $row['GalleryImage5'];?>"></td>
                                </tr>
                            </table>
                            <table border="1" class="table table-striped table-bordered first"> <hr>
                                    <p style="color: red">Property Address</p>
                                <tr>
                                    <th>Address </th>
                                    <td><input type="text" name="address" class="form-control" required="true" value="<?php  echo $row['Address'];?>"></td>
                                </tr>
<tr>
<th>Country </th>
<td style="padding-left: 10px"><?php  echo $row['CountryName'];?></td>
</tr>

  <tr>
<th>State </th>
<td style="padding-left: 10px"><?php  echo $row['StateName'];?></td>
</tr>


<tr>
<th>City </th>
<td style="padding-left: 10px"><?php  echo $row['City'];?></td>
</tr>
                              
                               
                                <tr>
                                    <th>Zip Code </th>
                                    <td><input type="text" name="zipcode" class="form-control" required="true" value="<?php  echo $row['ZipCode'];?>"></td>
                                </tr>
                                <tr>
                                    <th>Neighborhood </th>
                                    <td><input type="text" name="neighborhood" class="form-control" required="true" value="<?php  echo $row['Neighborhood'];?>"></td>
                                </tr>
                                <tr>
                                    <th>Listing Date </th>
                                    <td style="padding-left: 10px"><?php  echo $row['ListingDate'];?></td>
                                </tr>
                                
                                
                                </table>
                                <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary" name="submit">Update</button>
                                        </div>
                                    </div>
                                
                            
                        
                        </div>
                    </div>
 <?php } ?>
    
    </form>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end valifation types -->
                        <!-- ============================================================== -->
                    </div>
           
            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
             <?php include_once('includes/footer.php');?>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="assets/vendor/parsley/parsley.js"></script>
    <script src="assets/libs/js/main-js.js"></script>
    <script>
    $('#form').parsley();
    </script>
    <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
    </script>
    <!-- Add inside <head> or before </body> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function getsate(val) {
    $.ajax({
        type: "POST",
        url: "get-sate.php",
        data: {countryid: val},
        success: function(data){
            $("#state").html(data);
        }
    });
}
function getcity(val) {
    $.ajax({
        type: "POST",
        url: "get-sate.php",
        data: {stateid: val},
        success: function(data){
            $("#city").html(data);
        }
    });
}
</script>
</body>
 
</html>
<?php }  ?>
