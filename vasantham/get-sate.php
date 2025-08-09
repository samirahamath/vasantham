<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');


 if(isset($_POST['countryid'])){
  $cid=mysqli_real_escape_string($con, $_POST['countryid']);
  $query=mysqli_query($con,"select * from tblstate where CountryID='$cid' order by StateName asc");
  echo '<option value="">Select State</option>';
  while($rw=mysqli_fetch_assoc($query)){
    echo '<option value="'.htmlspecialchars($rw['ID']).'">'.htmlspecialchars($rw['StateName']).'</option>';
  }
  exit();
 }

 //code for city
 if(isset($_POST['stateid'])){
  $sid=mysqli_real_escape_string($con, $_POST['stateid']);
  $query=mysqli_query($con,"select * from tblcity where StateID='$sid' order by CityName asc");
  echo '<option value="">Select City / Locality</option>';
  while($rw=mysqli_fetch_assoc($query)){
    $name = htmlspecialchars($rw['CityName']);
    echo '<option value="'.$name.'">'.$name.'</option>';
  }
  exit();
 }