
    <?php

    // Handle hold/unhold actions (must be before any output)
    if (isset($_GET['action']) && isset($_GET['id'])) {
        $action = $_GET['action'];
        $id = intval($_GET['id']);
        // dbconnection.php will be included below, so only note the intent now
        if ($action == 'hold') {
            $GLOBALS['hold_id'] = $id;
        } elseif ($action == 'unhold') {
            $GLOBALS['unhold_id'] = $id;
        }
    }


    session_start();
    error_reporting(0);
    include('includes/dbconnection.php');
    include('../includes/approval-functions.php');

    // Now handle hold action after $con is defined
if (isset($GLOBALS['hold_id'])) {
    $id = intval($GLOBALS['hold_id']);
    // Set ApprovedBy to NULL to satisfy FOREIGN KEY constraint (tbladmin.ID)
    $sql = "UPDATE tblproperty SET ApprovedBy=NULL WHERE ID=$id";
    $holdQuery = mysqli_query($con, $sql);
    if ($holdQuery) {
        echo '<script>alert("Property put on hold (ApprovedBy set to NULL).");window.location.href="approve-properties.php";</script>';
        exit();
    } else {
        $dberr = addslashes(mysqli_error($con));
        // Log the error on server and show a helpful alert for debugging
        error_log("Failed to hold property ID $id: " . mysqli_error($con));
        echo '<script>alert("Failed to hold property. DB error: ' . $dberr . '");window.location.href="approve-properties.php";</script>';
        exit();
    }
}

    // Now handle unhold action after $con is defined
    if (isset($GLOBALS['unhold_id'])) {
        $id = intval($GLOBALS['unhold_id']);
        // Ensure admin session is available
        $adminId = isset($_SESSION['remsaid']) ? intval($_SESSION['remsaid']) : 0;
        if (!$adminId) {
            echo '<script>alert("Unable to unhold: admin not authenticated.");window.location.href="approve-properties.php";</script>';
            exit();
        }

        // Use the existing approveProperty helper so approval bookkeeping remains consistent
        if (function_exists('approveProperty')) {
            if (approveProperty($id, $adminId, $con)) {
                echo '<script>alert("Property unheld: ApprovedBy set to your admin account.");window.location.href="approve-properties.php";</script>';
                exit();
            } else {
                $dberr = addslashes(mysqli_error($con));
                error_log("Failed to unhold property ID $id: " . mysqli_error($con));
                echo '<script>alert("Failed to unhold property. DB error: ' . $dberr . '");window.location.href="approve-properties.php";</script>';
                exit();
            }
        } else {
            // Fallback: directly set ApprovedBy to current admin (should satisfy FK)
            $sql = "UPDATE tblproperty SET ApprovedBy=$adminId WHERE ID=$id";
            $unholdQuery = mysqli_query($con, $sql);
            if ($unholdQuery) {
                echo '<script>alert("Property unheld (ApprovedBy set to your admin account).");window.location.href="approve-properties.php";</script>';
                exit();
            } else {
                $dberr = addslashes(mysqli_error($con));
                error_log("Failed to unhold (fallback) property ID $id: " . mysqli_error($con));
                echo '<script>alert("Failed to unhold property. DB error: ' . $dberr . '");window.location.href="approve-properties.php";</script>';
                exit();
            }
        }
    }

    // Handle delete action (must be before any output)
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $deleteQuery = mysqli_query($con, "DELETE FROM tblproperty WHERE ID = $id");
        if ($deleteQuery) {
            echo '<script>alert("Property deleted successfully.");window.location.href="approve-properties.php";</script>';
            exit();
        } else {
            echo '<script>alert("Failed to delete property. Please try again.");window.location.href="approve-properties.php";</script>';
            exit();
        }
    }

if (strlen($_SESSION['remsaid']==0)) {
  header('location:logout.php');
} else {
  
  // Handle approve action
  if (isset($_GET['action']) && $_GET['action'] == 'approve' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $adminId = $_SESSION['remsaid'];
    
    if (approveProperty($id, $adminId, $con)) {
      echo '<script>alert("Property approved successfully.");window.location.href="approve-properties.php";</script>';
    } else {
      echo '<script>alert("Failed to approve property. Please try again.");</script>';
    }
  }
  
  // Handle reject action
  if (isset($_POST['action']) && $_POST['action'] == 'reject' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $adminId = $_SESSION['remsaid'];
    $reason = isset($_POST['rejection_reason']) ? $_POST['rejection_reason'] : 'No reason provided';
    
    if (rejectProperty($id, $adminId, $reason, $con)) {
      echo '<script>alert("Property rejected successfully.");window.location.href="approve-properties.php";</script>';
    } else {
      echo '<script>alert("Failed to reject property. Please try again.");</script>';
    }
  }
  
  // Handle bulk approve action
  if (isset($_POST['bulk_action']) && $_POST['bulk_action'] == 'approve' && isset($_POST['selected_properties'])) {
    $adminId = $_SESSION['remsaid'];
    $selectedProperties = $_POST['selected_properties'];
    $successCount = 0;
    
    foreach ($selectedProperties as $propertyId) {
      if (approveProperty(intval($propertyId), $adminId, $con)) {
        $successCount++;
      }
    }
    
    echo '<script>alert("' . $successCount . ' properties approved successfully.");window.location.href="approve-properties.php";</script>';
  }
  
  // Get filter parameters
  $statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
  $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
    $propertyIdFilter = isset($_GET['propertyid']) ? trim($_GET['propertyid']) : '';
    $typeFilter = isset($_GET['type']) ? $_GET['type'] : '';
  
  // Get properties based on filters
  if ($statusFilter) {
    $properties = getAllPropertiesWithStatus($con, $statusFilter);
  } else {
    $properties = getAllPropertiesWithStatus($con);
  }
  
  // Apply additional filters
  if (!empty($searchTerm) || !empty($typeFilter)) {
    $properties = array_filter($properties, function($property) use ($searchTerm, $typeFilter) {
      $matchesSearch = empty($searchTerm) || 
                      stripos($property['PropertyTitle'], $searchTerm) !== false ||
                      stripos($property['Location'], $searchTerm) !== false ||
                      stripos($property['AgentName'], $searchTerm) !== false;
      
      $matchesType = empty($typeFilter) || $property['Type'] == $typeFilter;
      
      return $matchesSearch && $matchesType;
    });
  }

  // Apply PropertyID filter if provided (exact match)
  if (!empty($propertyIdFilter)) {
      $properties = array_filter($properties, function($property) use ($propertyIdFilter) {
          return isset($property['PropertyID']) && trim((string)$property['PropertyID']) === $propertyIdFilter;
      });
  }
?>
<!doctype html>
<html lang="en">
 
<head>
   
    <title>Real Estate Management System || Approve Properties</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/buttons.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/select.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/fixedHeader.bootstrap4.css">
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
         <!-- ============================================================== -->
         <?php include_once('includes/header.php');?>
        
        <?php include_once('includes/sidebar.php');?>
       
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Approve Properties</h2>
                           
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="dashboard.php" class="breadcrumb-link">Dashboard</a></li>
                                        
                                        <li class="breadcrumb-item active" aria-current="page">Approve Properties</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->
                <!-- Search and Filter Section -->
                <div class="row mb-3">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="GET" action="approve-properties.php" class="row">
                                    <div class="col-md-2">
                                        <input type="text" name="search" class="form-control" placeholder="Search properties..." 
                                               value="<?php echo htmlspecialchars($searchTerm); ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="propertyid" class="form-control" placeholder="Property ID" 
                                               value="<?php echo htmlspecialchars($propertyIdFilter); ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status" class="form-control">
                                            <option value="">All Status</option>
                                            <option value="Pending" <?php echo $statusFilter == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="Approved" <?php echo $statusFilter == 'Approved' ? 'selected' : ''; ?>>Approved</option>
                                            <option value="Rejected" <?php echo $statusFilter == 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="type" class="form-control">
                                            <option value="">All Types</option>
                                            <?php
                                            $typeQuery = mysqli_query($con, "SELECT DISTINCT Type FROM tblproperty WHERE Type IS NOT NULL");
                                            while($typeRow = mysqli_fetch_array($typeQuery)) {
                                                $selected = $typeFilter == $typeRow['Type'] ? 'selected' : '';
                                                echo "<option value='{$typeRow['Type']}' $selected>{$typeRow['Type']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2 d-flex">
                                        <button type="submit" class="btn btn-primary mr-2">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                        <a href="approve-properties.php" class="btn btn-secondary">
                                            <i class="fas fa-refresh"></i> Reset
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- ============================================================== -->
                    <!-- enhanced properties table  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">
                                Property Approval Management 
                                <span class="badge badge-info ml-2"><?php echo count($properties); ?> Properties</span>
                            </h5>
                            <div class="card-body">
                                <!-- Bulk Actions -->
                                <form method="POST" action="approve-properties.php" id="bulkForm">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <button type="submit" name="bulk_action" value="approve" class="btn btn-success btn-sm" 
                                                    onclick="return confirmBulkAction('approve');">
                                                <i class="fas fa-check"></i> Bulk Approve Selected
                                            </button>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <small class="text-muted">Select properties using checkboxes for bulk actions</small>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="30">
                                                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                                    </th>
                                                    <th>S.No</th>
                                                    <th>Agent Name</th>
                                                    <th>Property Name</th>
                                                    <th>Property Type</th>
                                                    <th>Location</th>
                                                    <th>Price</th>
                                                    <th>Submitted</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <?php
                                              $cnt = 1;
                                              foreach ($properties as $row) {
                                                  $approvalStatus = $row['ApprovalStatus'] ? $row['ApprovalStatus'] : 'Pending';
                                              ?>
                                                <tr>
                                                    <td>
                                                        <?php if($approvalStatus == 'Pending') { ?>
                                                            <input type="checkbox" name="selected_properties[]" value="<?php echo $row['ID']; ?>" class="property-checkbox">
                                                        <?php } ?>
                                                    </td>
                                                    <td><?php echo $cnt; ?></td>
                                                    <td>
                                                        <?php echo $row['AgentName'] ? $row['AgentName'] : 'N/A'; ?>
                                                        <?php if($row['AgentEmail']) { ?>
                                                            <br><small class="text-muted"><?php echo $row['AgentEmail']; ?></small>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <strong><?php echo htmlspecialchars($row['PropertyTitle']); ?></strong>
                                                        <?php if($row['RejectionReason']) { ?>
                                                            <br><small class="text-danger">
                                                                <i class="fas fa-exclamation-triangle"></i> 
                                                                <?php echo htmlspecialchars(substr($row['RejectionReason'], 0, 50)) . '...'; ?>
                                                            </small>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?php echo $row['PropertyTypeName'] ? $row['PropertyTypeName'] : $row['Type']; ?></td>
                                                    <td><?php echo htmlspecialchars($row['Location']); ?></td>
                                                    <td>
                                                        <strong class="text-success">₹<?php echo $row['RentorsalePrice']; ?></strong>
                                                        <br><small class="text-muted"><?php echo $row['Status']; ?></small>
                                                    </td>
                                                    <td>
                                                        <?php echo date('M d, Y', strtotime($row['ListingDate'])); ?>
                                                        <br><small class="text-muted"><?php echo date('h:i A', strtotime($row['ListingDate'])); ?></small>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        if($approvalStatus == 'Approved') {
                                                            echo '<span class="badge badge-success">Approved</span>';
                                                            if($row['ApprovalDate']) {
                                                                echo '<br><small class="text-muted">'.date('M d, Y', strtotime($row['ApprovalDate'])).'</small>';
                                                            }
                                                            // If property is Approved
                                                            // - show Hold button when ApprovedBy is set (not NULL)
                                                            // - show Unhold button when ApprovedBy is NULL (property currently on hold)
                                                            if (isset($row['ApprovedBy']) && $row['ApprovedBy'] !== null && $row['ApprovedBy'] != 0) {
                                                                echo '<br><a href="approve-properties.php?action=hold&id=' . $row['ID'] . '" class="btn btn-warning btn-sm mt-1" onclick="return confirm(\'Are you sure you want to hold this property?\');"><i class="fas fa-pause"></i> Hold</a>';
                                                            } else {
                                                                // If ApprovedStatus is Approved but ApprovedBy is NULL => currently on hold; show Unhold
                                                                if ($approvalStatus == 'Approved') {
                                                                    echo '<br><a href="approve-properties.php?action=unhold&id=' . $row['ID'] . '" class="btn btn-success btn-sm mt-1" onclick="return confirm(\'Are you sure you want to unhold (re-approve) this property?\');"><i class="fas fa-play"></i> Unhold</a>';
                                                                }
                                                            }
                                                        } elseif($approvalStatus == 'Rejected') {
                                                            echo '<span class="badge badge-danger">Rejected</span>';
                                                            if($row['RejectionDate']) {
                                                                echo '<br><small class="text-muted">'.date('M d, Y', strtotime($row['RejectionDate'])).'</small>';
                                                            }
                                                        } else {
                                                            echo '<span class="badge badge-warning">Pending</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                                          <?php if($approvalStatus == 'Pending') { ?>
                                                                                <a href="approve-properties.php?action=approve&id=<?php echo $row['ID']; ?>" 
                                                                                    class="btn btn-success btn-sm mb-1" 
                                                                                    onclick="return confirm('Are you sure you want to approve this property?');">
                                                                                    <i class="fas fa-check"></i> Approve
                                                                                </a>
                                                                                <button type="button" class="btn btn-danger btn-sm mb-1" 
                                                                                          onclick="showRejectModal(<?php echo $row['ID']; ?>, '<?php echo addslashes($row['PropertyTitle']); ?>')">
                                                                                     <i class="fas fa-times"></i> Reject
                                                                                </button>
                                                                          <?php } ?>
                                                                          <a href="view-property-details.php?viewid=<?php echo $row['ID']; ?>" 
                                                                              class="btn btn-info btn-sm mb-1">
                                                                              <i class="fas fa-eye"></i> View
                                                                          </a>
                                                                          <a href="approve-properties.php?action=delete&id=<?php echo $row['ID']; ?>" 
                                                                              class="btn btn-danger btn-sm mb-1" 
                                                                              onclick="return confirm('Are you sure you want to delete this property? This action cannot be undone.');">
                                                                              <i class="fas fa-trash"></i> Delete
                                                                          </a>
                                                    </td>
                                                </tr>
                                              <?php 
                                              $cnt++;
                                              } 
                                              if (empty($properties)) {
                                              ?>
                                                <tr>
                                                    <td colspan="10" class="text-center">
                                                        <div class="py-4">
                                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                            <h5 class="text-muted">No properties found</h5>
                                                            <p class="text-muted">Try adjusting your search criteria or filters.</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                              <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end enhanced properties table  -->
                    <!-- ============================================================== -->
                </div>
               
               
                
                
            </div>
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
    <script src="assets/vendor/multi-select/js/jquery.multi-select.js"></script>
    <script src="assets/libs/js/main-js.js"></script>
    <script src="../../../../../cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../../../../cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="assets/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
     <script src="assets/vendor/datatables/js/data-table.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Rejection Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Property</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="approve-properties.php">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="reject">
                        <input type="hidden" name="id" id="rejectPropertyId">
                        <p>Are you sure you want to reject the property: <strong id="rejectPropertyTitle"></strong>?</p>
                        <div class="form-group">
                            <label for="rejection_reason">Rejection Reason *</label>
                            <textarea class="form-control" name="rejection_reason" id="rejection_reason" rows="3" 
                                      placeholder="Please provide a reason for rejection..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject Property</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Function to show reject modal
        function showRejectModal(propertyId, propertyTitle) {
            document.getElementById('rejectPropertyId').value = propertyId;
            document.getElementById('rejectPropertyTitle').textContent = propertyTitle;
            document.getElementById('rejection_reason').value = '';
            $('#rejectModal').modal('show');
        }

        // Function to toggle select all checkboxes
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.property-checkbox');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
        }

        // Function to confirm bulk actions
        function confirmBulkAction(action) {
            const selectedCheckboxes = document.querySelectorAll('.property-checkbox:checked');
            
            if (selectedCheckboxes.length === 0) {
                alert('Please select at least one property to ' + action + '.');
                return false;
            }
            
            const actionText = action === 'approve' ? 'approve' : 'reject';
            return confirm('Are you sure you want to ' + actionText + ' ' + selectedCheckboxes.length + ' selected properties?');
        }

        // Update select all checkbox based on individual selections
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.property-checkbox');
            const selectAll = document.getElementById('selectAll');
            
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const totalCheckboxes = checkboxes.length;
                    const checkedCheckboxes = document.querySelectorAll('.property-checkbox:checked').length;
                    
                    selectAll.checked = totalCheckboxes === checkedCheckboxes;
                    selectAll.indeterminate = checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes;
                });
            });
        });
    </script>
    
</body>
 
</html>
<?php }  ?>