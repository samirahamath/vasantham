<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['remsaid']==0)) {
  header('location:logout.php');
}

// Check if banner table exists
$tableExists = false;
$checkTable = mysqli_query($con, "SHOW TABLES LIKE 'tblbanner'");
if($checkTable && mysqli_num_rows($checkTable) > 0) {
    $tableExists = true;
    include('../includes/banner-functions.php');
}

$allBanners = [];
$filteredBanners = [];
$paginatedBanners = [];
$stats = ['total' => 0, 'active' => 0, 'inactive' => 0];

if($tableExists) {
    // Handle status toggle (delete is now handled by separate file)
    if(isset($_GET['action']) && isset($_GET['id'])) {
        $bannerId = intval($_GET['id']);
        $bannerManager = new BannerManager($con);
        $banner = $bannerManager->getBannerById($bannerId);
        
        if($banner && $_GET['action'] == 'activate') {
            if($bannerManager->toggleBannerStatus($bannerId, 'Active')) {
                $msg = "Banner \"{$banner['BannerName']}\" has been activated successfully.";
            } else {
                $error = "Failed to activate banner. Please try again.";
            }
        } elseif($banner && $_GET['action'] == 'deactivate') {
            if($bannerManager->toggleBannerStatus($bannerId, 'Inactive')) {
                $msg = "Banner \"{$banner['BannerName']}\" has been deactivated successfully.";
                
                // Check if all banners are now inactive
                if($bannerManager->areAllBannersInactive()) {
                    $msg .= " <strong>Warning:</strong> All banners are now inactive. Your homepage may not display any banners.";
                }
            } else {
                $error = "Failed to deactivate banner. Please try again.";
            }
        }
    }
    
    // Handle messages from delete operation
    if(isset($_SESSION['success_msg'])) {
        $msg = $_SESSION['success_msg'];
        unset($_SESSION['success_msg']);
    }
    if(isset($_SESSION['error_msg'])) {
        $error = $_SESSION['error_msg'];
        unset($_SESSION['error_msg']);
    }

    // Get filter parameters
    $statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';
    $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

    // Initialize banner manager and get banners
    $bannerManager = new BannerManager($con);
    $allBanners = $bannerManager->getAllBanners();

    // Filter banners based on search and status
    $filteredBanners = [];
    foreach($allBanners as $banner) {
        // Status filter
        if($statusFilter != 'all' && $banner['Status'] != $statusFilter) {
            continue;
        }
        
        // Search filter
        if(!empty($searchTerm)) {
            if(stripos($banner['BannerName'], $searchTerm) === false && 
               stripos($banner['BannerDescription'], $searchTerm) === false) {
                continue;
            }
        }
        
        $filteredBanners[] = $banner;
    }

    // Pagination
    $recordsPerPage = 10;
    $totalRecords = count($filteredBanners);
    $totalPages = ceil($totalRecords / $recordsPerPage);
    $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $offset = ($currentPage - 1) * $recordsPerPage;
    $paginatedBanners = array_slice($filteredBanners, $offset, $recordsPerPage);

    // Get banner statistics
    $stats = $bannerManager->getBannerStatistics();
    
    // Check for edge case warning
    $allInactiveWarning = $bannerManager->areAllBannersInactive();
} else {
    $statusFilter = 'all';
    $searchTerm = '';
    $totalRecords = 0;
    $totalPages = 0;
    $currentPage = 1;
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
    <title>Banner Management || REMS</title>
    <style>
        .banner-thumbnail {
            width: 80px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
        .status-badge {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
            font-weight: 600;
        }
        .status-badge.badge-success {
            background-color: #28a745 !important;
            color: white !important;
            box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
        }
        .status-badge.badge-secondary {
            background-color: #6c757d !important;
            color: white !important;
        }
        .action-buttons .btn {
            margin-right: 5px;
            margin-bottom: 5px;
        }
        .toggle-status-btn {
            transition: all 0.3s ease;
        }
        .toggle-status-btn:hover {
            transform: scale(1.05);
        }
        .banner-row.active {
            background-color: rgba(40, 167, 69, 0.05);
        }
        .banner-row.inactive {
            opacity: 0.8;
        }
        .bulk-actions {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 1rem;
            display: none;
        }
        .status-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 5px;
        }
        .status-indicator.active {
            background-color: #28a745;
            box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.3);
        }
        .status-indicator.inactive {
            background-color: #6c757d;
        }
        
        /* Enhanced status styling */
        .banner-row.active {
            border-left: 4px solid #28a745;
        }
        
        .banner-row.inactive {
            border-left: 4px solid #6c757d;
            background-color: rgba(108, 117, 125, 0.05);
        }
        
        .toggle-status-btn {
            min-width: 100px;
            font-weight: 500;
        }
        
        .toggle-status-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .bulk-actions {
            border-left: 4px solid #007bff;
        }
        
        .bulk-actions .btn {
            font-weight: 500;
        }
        
        /* Animation for status changes */
        .banner-row {
            transition: all 0.3s ease;
        }
        
        .status-badge {
            transition: all 0.3s ease;
        }
        
        .toggle-status-btn {
            transition: all 0.2s ease;
        }
        
        /* Delete confirmation modal styling */
        #deleteBannerModal .modal-header.bg-danger {
            border-bottom: 1px solid #dc3545;
        }
        
        #deleteBannerModal .alert {
            margin-bottom: 1rem;
        }
        
        #deleteBannerModal .form-check {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        
        #deleteBannerModal .btn-danger:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php include_once('includes/header.php');?>
        <?php include_once('includes/sidebar.php');?>
        
        <div class="dashboard-wrapper">
            <div class="dashboard-finance">
                <div class="container-fluid dashboard-content">
                    <!-- Page header -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h3 class="mb-2">Banner Management</h3>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="dashboard.php" class="breadcrumb-link">Dashboard</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Manage Banners</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card border-info">
                                <h5 class="card-header bg-info text-white">Total Banners</h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1 text-info"><?php echo $stats['total']; ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card border-success">
                                <h5 class="card-header bg-success text-white">Active Banners</h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1 text-success"><?php echo $stats['active']; ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card border-warning">
                                <h5 class="card-header bg-warning text-white">Inactive Banners</h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1 text-warning"><?php echo $stats['inactive']; ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <a href="add-banner.php" class="btn btn-primary btn-lg">
                                        <i class="fas fa-plus"></i> Add New Banner
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edge Case Warning -->
                    <?php if($tableExists && isset($allInactiveWarning) && $allInactiveWarning) { ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Warning:</strong> All banners are currently inactive. Your homepage may not display any banners to visitors.
                            <a href="#" class="alert-link" onclick="activateFirstBanner()">Click here to activate a banner</a>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>

                    <!-- Messages -->
                    <?php if(isset($msg)) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $msg; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>

                    <?php if(isset($error)) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>

                    <!-- Search and Filter -->
                    <div class="row mb-3">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="GET" action="">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Search Banners</label>
                                                    <input type="text" name="search" class="form-control" 
                                                           placeholder="Search by name or description..." 
                                                           value="<?php echo htmlspecialchars($searchTerm); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Filter by Status</label>
                                                    <select name="status" class="form-control">
                                                        <option value="all" <?php echo $statusFilter == 'all' ? 'selected' : ''; ?>>All Banners</option>
                                                        <option value="Active" <?php echo $statusFilter == 'Active' ? 'selected' : ''; ?>>Active Only</option>
                                                        <option value="Inactive" <?php echo $statusFilter == 'Inactive' ? 'selected' : ''; ?>>Inactive Only</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <button type="submit" class="btn btn-primary form-control">
                                                        <i class="fas fa-search"></i> Search
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <a href="manage-banners.php" class="btn btn-secondary form-control">
                                                        <i class="fas fa-refresh"></i> Clear Filters
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Banner List -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <h5 class="card-header">
                                    Banner List 
                                    <span class="badge badge-secondary ml-2"><?php echo $totalRecords; ?> banners</span>
                                </h5>
                                <div class="card-body">
                                    <?php if(empty($paginatedBanners)) { ?>
                                        <div class="text-center py-4">
                                            <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No banners found</h5>
                                            <p class="text-muted">
                                                <?php if(!empty($searchTerm) || $statusFilter != 'all') { ?>
                                                    Try adjusting your search criteria or <a href="manage-banners.php">view all banners</a>
                                                <?php } else { ?>
                                                    <a href="add-banner.php" class="btn btn-primary">Add your first banner</a>
                                                <?php } ?>
                                            </p>
                                        </div>
                                    <?php } else { ?>
                                        <!-- Bulk Actions -->
                                        <div class="bulk-actions">
                                            <div class="row align-items-center">
                                                <div class="col-md-6">
                                                    <strong><span class="bulk-count">0</span> banner(s) selected</strong>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <button type="button" class="btn btn-success btn-sm bulk-activate-btn">
                                                        <i class="fas fa-eye"></i> Activate Selected
                                                    </button>
                                                    <button type="button" class="btn btn-warning btn-sm bulk-deactivate-btn">
                                                        <i class="fas fa-eye-slash"></i> Deactivate Selected
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="40">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="selectAllBanners">
                                                                <label class="form-check-label" for="selectAllBanners"></label>
                                                            </div>
                                                        </th>
                                                        <th>Image</th>
                                                        <th>Banner Name</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Order</th>
                                                        <th>Created</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($paginatedBanners as $banner) { ?>
                                                        <tr data-banner-id="<?php echo $banner['ID']; ?>" class="banner-row <?php echo strtolower($banner['Status']); ?>">
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input banner-checkbox" 
                                                                           type="checkbox" 
                                                                           id="banner_<?php echo $banner['ID']; ?>"
                                                                           data-banner-id="<?php echo $banner['ID']; ?>">
                                                                    <label class="form-check-label" for="banner_<?php echo $banner['ID']; ?>"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($banner['BannerImage'])) { ?>
                                                                    <img src="../assets/images/banners/<?php echo htmlspecialchars($banner['BannerImage']); ?>" 
                                                                         alt="<?php echo htmlspecialchars($banner['BannerName']); ?>" 
                                                                         class="banner-thumbnail">
                                                                <?php } else { ?>
                                                                    <span class="text-muted">No image</span>
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <strong><?php echo htmlspecialchars($banner['BannerName']); ?></strong>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                $desc = htmlspecialchars($banner['BannerDescription']);
                                                                echo strlen($desc) > 50 ? substr($desc, 0, 50) . '...' : $desc;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php if($banner['Status'] == 'Active') { ?>
                                                                    <span class="badge badge-success status-badge">
                                                                        <span class="status-indicator active"></span>
                                                                        Active
                                                                    </span>
                                                                <?php } else { ?>
                                                                    <span class="badge badge-secondary status-badge">
                                                                        <span class="status-indicator inactive"></span>
                                                                        Inactive
                                                                    </span>
                                                                <?php } ?>
                                                            </td>
                                                            <td><?php echo $banner['DisplayOrder']; ?></td>
                                                            <td>
                                                                <?php echo date('M d, Y', strtotime($banner['CreationDate'])); ?>
                                                                <?php if($banner['CreatedByName']) { ?>
                                                                    <br><small class="text-muted">by <?php echo htmlspecialchars($banner['CreatedByName']); ?></small>
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <div class="action-buttons">
                                                                    <a href="edit-banner.php?id=<?php echo $banner['ID']; ?>" 
                                                                       class="btn btn-sm btn-primary" title="Edit">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    
                                                                    <?php if($banner['Status'] == 'Active') { ?>
                                                                        <button type="button" 
                                                                                class="btn btn-sm btn-warning toggle-status-btn" 
                                                                                title="Deactivate Banner"
                                                                                data-banner-id="<?php echo $banner['ID']; ?>"
                                                                                data-banner-name="<?php echo htmlspecialchars($banner['BannerName']); ?>"
                                                                                data-current-status="Active"
                                                                                data-new-status="Inactive"
                                                                                data-action="deactivate">
                                                                            <i class="fas fa-eye-slash"></i> Deactivate
                                                                        </button>
                                                                    <?php } else { ?>
                                                                        <button type="button" 
                                                                                class="btn btn-sm btn-success toggle-status-btn" 
                                                                                title="Activate Banner"
                                                                                data-banner-id="<?php echo $banner['ID']; ?>"
                                                                                data-banner-name="<?php echo htmlspecialchars($banner['BannerName']); ?>"
                                                                                data-current-status="Inactive"
                                                                                data-new-status="Active"
                                                                                data-action="activate">
                                                                            <i class="fas fa-eye"></i> Activate
                                                                        </button>
                                                                    <?php } ?>
                                                                    
                                                                    <button type="button" 
                                                                            class="btn btn-sm btn-danger delete-banner-btn" 
                                                                            title="Delete"
                                                                            data-banner-id="<?php echo $banner['ID']; ?>"
                                                                            data-banner-name="<?php echo htmlspecialchars($banner['BannerName']); ?>"
                                                                            data-is-active="<?php echo $banner['Status'] == 'Active' ? 'true' : 'false'; ?>">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Pagination -->
                                        <?php if($totalPages > 1) { ?>
                                            <nav aria-label="Banner pagination">
                                                <ul class="pagination justify-content-center">
                                                    <?php if($currentPage > 1) { ?>
                                                        <li class="page-item">
                                                            <a class="page-link" href="?page=<?php echo $currentPage-1; ?>&status=<?php echo $statusFilter; ?>&search=<?php echo urlencode($searchTerm); ?>">Previous</a>
                                                        </li>
                                                    <?php } ?>
                                                    
                                                    <?php for($i = 1; $i <= $totalPages; $i++) { ?>
                                                        <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                                                            <a class="page-link" href="?page=<?php echo $i; ?>&status=<?php echo $statusFilter; ?>&search=<?php echo urlencode($searchTerm); ?>"><?php echo $i; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                    
                                                    <?php if($currentPage < $totalPages) { ?>
                                                        <li class="page-item">
                                                            <a class="page-link" href="?page=<?php echo $currentPage+1; ?>&status=<?php echo $statusFilter; ?>&search=<?php echo urlencode($searchTerm); ?>">Next</a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </nav>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php include_once('includes/footer.php');?>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="assets/libs/js/main-js.js"></script>
    <script src="assets/js/banner-delete.js"></script>
    <script src="assets/js/banner-status.js"></script>
</body>
</html>