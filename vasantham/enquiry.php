<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['remsuid']==0 || $_SESSION['ut']==3)) {
  header('location:logout.php');
  } else{

if(isset($_GET['del']))
{
mysqli_query($con,"delete from tblenquiry where ID = '".$_GET['id']."'");
echo "<script>alert('Data Deleted');</script>";
echo "<script>window.location.href='enquiry.php'</script>";
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <!-- Custom Pagination CSS -->
    <style>
        /* Hide default DataTables pagination */
        .dataTables_paginate {
            display: none !important;
        }
        
        /* Custom Pagination Styles */
        .custom-pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
            gap: 5px;
        }
        
        .custom-pagination .page-btn {
            padding: 8px 12px;
            border: 2px solid #260844;
            background: #fff;
            color: #260844;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            min-width: 40px;
            text-align: center;
        }
        
        .custom-pagination .page-btn:hover {
            background: #260844;
            color: #fff;
            text-decoration: none;
        }
        
        .custom-pagination .page-btn.active {
            background: #260844;
            color: #fff;
        }
        
        .custom-pagination .page-btn.disabled {
            background: #f8f9fa;
            color: #6c757d;
            border-color: #dee2e6;
            cursor: not-allowed;
        }
        
        .custom-pagination .page-btn.disabled:hover {
            background: #f8f9fa;
            color: #6c757d;
        }
        
        .custom-pagination .page-info {
            margin: 0 15px;
            color: #6c757d;
            font-size: 14px;
        }
        
        .custom-pagination .page-btn.first,
        .custom-pagination .page-btn.last {
            font-size: 12px;
            padding: 8px 10px;
        }
        
        .custom-pagination .page-btn.prev,
        .custom-pagination .page-btn.next {
            font-size: 14px;
            padding: 8px 10px;
        }
    </style>
      
    <title>Real Estate Managment System|| Enquiry</title>
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
                                    <h1>Received Enquiry</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="active">Received Enquiry</li>
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

        <!-- #Add Property
============================================= -->
        <section id="add-property" class="add-property">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-box">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <h4 class="form--title">Total Received Enquiry</h4>
                                        
                                        <table id="dtBasicExample" class="table">
                <thead>
                                        <tr>
                  <th>S.NO</th>
                  <th>Property ID</th>
                  <th>Property Name</th>
                  <th>Enquiry Number</th>
                  <th>Mobile Number</th>
                  <th>Email</th>
                  <th>Enquiry Date</th>
                  <th>Action</th>
                </tr>
                                        </thead>
                                        <tbody>
               <?php
               $uid=$_SESSION['remsuid'];
$ret=mysqli_query($con,"select tblenquiry.*, tblproperty.PropertyTitle, tblproperty.ID as PropertyID from tblenquiry join tblproperty on tblproperty.Id=tblenquiry.PropertyID where tblenquiry.Status is null and tblproperty.UserID='$uid' ORDER BY tblenquiry.EnquiryDate DESC");
$num=mysqli_num_rows($ret);
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>
              
                <tr>
                  <td><?php echo $cnt;?></td>
                  <td><?php echo $row['PropertyID'];?></td>
                  <td><?php echo $row['PropertyTitle'];?></td>
                  <td><?php echo $row['EnquiryNumber'];?></td>
                  <td><?php echo $row['MobileNumber'];?></td>
                  <td><?php echo $row['Email'];?></td>
                  <td><?php echo date('M d, Y', strtotime($row['EnquiryDate']));?></td>
                  <td>
                    <a href="view-enquiry-detail.php?viewid=<?php echo $row['ID'];?>" target="_blank">View</a> |
                    <a href="enquiry.php?id=<?php echo $row['ID']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')" style="color:red">Delete</a>
                  </td>
                </tr>
                <?php 
$cnt=$cnt+1;
} ?>
                                        </tbody>
              </table>
                                        
                                        <!-- Custom Pagination -->
                                        <div id="customPagination" class="custom-pagination">
                                            <a href="#" class="page-btn first" onclick="goToPage(1)">First</a>
                                            <a href="#" class="page-btn prev" onclick="previousPage()">‹ Prev</a>
                                            <div id="pageNumbers"></div>
                                            <div class="page-info">
                                                <span id="pageInfo"></span>
                                            </div>
                                            <a href="#" class="page-btn next" onclick="nextPage()">Next ›</a>
                                            <a href="#" class="page-btn last" onclick="goToLastPage()">Last</a>
                                        </div>
                                        
                                        <?php if($num == 0) { ?>
                                        <div style="text-align: center; padding: 20px;">
                                            <p>No new enquiries received yet.</p>
                                        </div>
                                        <?php } ?>
                                        
                            </div>
                                    <!-- .col-md-12 end -->
                                </div>
                                <!-- .row end -->
                            </div>
                    </div>
                    <!-- .col-md-12 end -->
                </div>
                <!-- .row end -->
            </div>
        </section>
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

        <!-- Footer #1
============================================= -->
        <?php include_once('includes/footer.php');?>
    </div>
    <!-- #wrapper end -->

    <!-- Footer Scripts
============================================= -->
    <script src="assets/js/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/functions.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    <script type="text/javascript">
        let dataTable;
        let currentPage = 1;
        let recordsPerPage = 5;
        let totalRecords = 0;
        let totalPages = 0;

        $(document).ready(function () {
            // Initialize DataTable without pagination
            dataTable = $('#dtBasicExample').DataTable({
                "order": [[ 6, "desc" ]], 
                "paging": false, // Disable DataTables pagination
                "info": false, // Disable DataTables info
                "responsive": true,
                "searching": true,
                "ordering": true
            });
            
            $('.dataTables_length').addClass('bs-select');
            
            // Initialize custom pagination
            initCustomPagination();
        });

        function initCustomPagination() {
            totalRecords = dataTable.rows({ search: 'applied' }).count();
            totalPages = Math.ceil(totalRecords / recordsPerPage);
            
            if (totalRecords <= recordsPerPage) {
                $('#customPagination').hide();
                dataTable.rows().show();
                return;
            }
            
            $('#customPagination').show();
            updatePagination();
            showPage(1);
        }

        function showPage(page) {
            currentPage = page;
            let start = (page - 1) * recordsPerPage;
            let end = start + recordsPerPage;
            
            // Hide all rows
            dataTable.rows().nodes().to$().hide();
            
            // Show rows for current page
            dataTable.rows({ search: 'applied' }).nodes().to$().slice(start, end).show();
            
            updatePagination();
        }

        function updatePagination() {
            // Update page numbers
            let pageNumbersHtml = '';
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, currentPage + 2);
            
            if (startPage > 1) {
                pageNumbersHtml += '<a href="#" class="page-btn" onclick="goToPage(1)">1</a>';
                if (startPage > 2) {
                    pageNumbersHtml += '<span class="page-btn disabled">...</span>';
                }
            }
            
            for (let i = startPage; i <= endPage; i++) {
                pageNumbersHtml += '<a href="#" class="page-btn ' + (i === currentPage ? 'active' : '') + '" onclick="goToPage(' + i + ')">' + i + '</a>';
            }
            
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    pageNumbersHtml += '<span class="page-btn disabled">...</span>';
                }
                pageNumbersHtml += '<a href="#" class="page-btn" onclick="goToPage(' + totalPages + ')">' + totalPages + '</a>';
            }
            
            $('#pageNumbers').html(pageNumbersHtml);
            
            // Update page info
            let start = ((currentPage - 1) * recordsPerPage) + 1;
            let end = Math.min(currentPage * recordsPerPage, totalRecords);
            $('#pageInfo').text('Showing ' + start + ' to ' + end + ' of ' + totalRecords + ' entries');
            
            // Update navigation buttons
            $('.page-btn.first, .page-btn.prev').toggleClass('disabled', currentPage === 1);
            $('.page-btn.last, .page-btn.next').toggleClass('disabled', currentPage === totalPages);
        }

        function goToPage(page) {
            if (page >= 1 && page <= totalPages && page !== currentPage) {
                showPage(page);
            }
        }

        function previousPage() {
            if (currentPage > 1) {
                showPage(currentPage - 1);
            }
        }

        function nextPage() {
            if (currentPage < totalPages) {
                showPage(currentPage + 1);
            }
        }

        function goToLastPage() {
            if (currentPage !== totalPages) {
                showPage(totalPages);
            }
        }

        // Reinitialize pagination when search is performed
        $('#dtBasicExample_filter input').on('keyup', function() {
            setTimeout(function() {
                initCustomPagination();
            }, 100);
        });
    </script>
</body>

</html>
 <?php } ?>