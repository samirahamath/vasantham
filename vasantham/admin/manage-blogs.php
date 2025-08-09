<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['remsaid']==0)) {
  header('location:logout.php');
  exit;
}

// Check if tblblogs exists
$tableExists = false;
$checkTable = mysqli_query($con, "SHOW TABLES LIKE 'tblblogs'");
if ($checkTable && mysqli_num_rows($checkTable) > 0) {
    $tableExists = true;
    include('includes/blog-functions.php');
}

$allBlogs = [];
$filteredBlogs = [];
$paginatedBlogs = [];
$stats = ['total' => 0, 'active' => 0, 'inactive' => 0];

if ($tableExists) {
    // Handle status toggle via action param (activate / deactivate)
    if (isset($_GET['action']) && isset($_GET['id'])) {
        $blogId = intval($_GET['id']);
        $blogManager = new BlogManager($con);
        $blog = $blogManager->getBlogById($blogId);

        if ($blog) {
            if ($_GET['action'] === 'activate') {
                if ($blogManager->toggleBlogStatus($blogId, 'Active')) {
                    $msg = "Blog \"".htmlspecialchars($blog['BlogTitle'])."\" has been activated successfully.";
                } else {
                    $error = "Failed to activate blog. Please try again.";
                }
            } elseif ($_GET['action'] === 'deactivate') {
                if ($blogManager->toggleBlogStatus($blogId, 'Inactive')) {
                    $msg = "Blog \"".htmlspecialchars($blog['BlogTitle'])."\" has been deactivated successfully.";
                } else {
                    $error = "Failed to deactivate blog. Please try again.";
                }
            }
        } else {
            $error = "Blog not found.";
        }
    }

    // Handle messages from delete operation (blog-delete.php will set session messages)
    if (isset($_SESSION['success_msg'])) {
        $msg = $_SESSION['success_msg'];
        unset($_SESSION['success_msg']);
    }
    if (isset($_SESSION['error_msg'])) {
        $error = $_SESSION['error_msg'];
        unset($_SESSION['error_msg']);
    }

    // Get filter parameters
    $statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';
    $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

    // Initialize BlogManager and get all blogs
    $blogManager = new BlogManager($con);
    $allBlogs = $blogManager->getAllBlogs();

    // Filter blogs by status and search
    $filteredBlogs = [];
    foreach ($allBlogs as $blog) {
        if ($statusFilter != 'all' && $blog['Status'] != $statusFilter) {
            continue;
        }
        if (!empty($searchTerm)) {
            if (stripos($blog['BlogTitle'], $searchTerm) === false &&
                stripos($blog['BlogDescription'], $searchTerm) === false) {
                continue;
            }
        }
        $filteredBlogs[] = $blog;
    }

    // Pagination
    $recordsPerPage = 10;
    $totalRecords = count($filteredBlogs);
    $totalPages = $totalRecords > 0 ? ceil($totalRecords / $recordsPerPage) : 0;
    $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    if ($currentPage > $totalPages && $totalPages > 0) $currentPage = $totalPages;
    $offset = ($currentPage - 1) * $recordsPerPage;
    $paginatedBlogs = array_slice($filteredBlogs, $offset, $recordsPerPage);

    // Statistics
    $stats = $blogManager->getBlogStatistics();

    // Edge case: all inactive?
    $allInactiveWarning = ($stats['total'] > 0 && $stats['active'] == 0);
} else {
    // No table
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
    <title>Blog Management || REMS</title>
    <style>
        .thumbnail {
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
        }
        .status-badge.badge-secondary {
            background-color: #6c757d !important;
            color: white !important;
        }
        .action-buttons .btn { margin-right:5px; margin-bottom:5px; }
        .toggle-status-btn { transition: all .3s ease; }
        .toggle-status-btn:hover { transform: scale(1.05); }
        .blog-row.active { background-color: rgba(40,167,69,0.05); border-left:4px solid #28a745; }
        .blog-row.inactive { opacity:0.9; border-left:4px solid #6c757d; background-color: rgba(108,117,125,0.03); }
        .bulk-actions { background-color:#f8f9fa; border:1px solid #dee2e6; border-radius:.375rem; padding:1rem; margin-bottom:1rem; display:none; }
    </style>
</head>
<body>
    <div class="dashboard-main-wrapper">
        <?php include_once('includes/header.php'); ?>
        <?php include_once('includes/sidebar.php'); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-finance">
                <div class="container-fluid dashboard-content">
                    <!-- Page header -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-header">
                                <h3 class="mb-2">Blog Management</h3>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="dashboard.php" class="breadcrumb-link">Dashboard</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Manage Blogs</li>
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
                                <h5 class="card-header bg-info text-white">Total Blogs</h5>
                                <div class="card-body">
                                    <h1 class="mb-1 text-info"><?php echo (int)$stats['total']; ?></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card border-success">
                                <h5 class="card-header bg-success text-white">Active Blogs</h5>
                                <div class="card-body">
                                    <h1 class="mb-1 text-success"><?php echo (int)$stats['active']; ?></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card border-warning">
                                <h5 class="card-header bg-warning text-white">Inactive Blogs</h5>
                                <div class="card-body">
                                    <h1 class="mb-1 text-warning"><?php echo (int)$stats['inactive']; ?></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <a href="add-blog.php" class="btn btn-primary btn-lg">
                                        <i class="fas fa-plus"></i> Add New Blog
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edge Case Warning -->
                    <?php if ($tableExists && isset($allInactiveWarning) && $allInactiveWarning) { ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Warning:</strong> All blogs are currently inactive. Visitors may not see any blog content.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    <?php } ?>

                    <!-- Messages -->
                    <?php if (isset($msg)) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $msg; ?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    <?php } ?>
                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error; ?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    <?php } ?>

                    <!-- Search & Filter -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="GET" action="">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Search Blogs</label>
                                                <input type="text" name="search" class="form-control" placeholder="Search by title or content..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Filter by Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="all" <?php echo $statusFilter == 'all' ? 'selected' : ''; ?>>All Blogs</option>
                                                    <option value="Active" <?php echo $statusFilter == 'Active' ? 'selected' : ''; ?>>Active Only</option>
                                                    <option value="Inactive" <?php echo $statusFilter == 'Inactive' ? 'selected' : ''; ?>>Inactive Only</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-primary form-control"><i class="fas fa-search"></i> Search</button>
                                            </div>
                                            <div class="col-md-3">
                                                <label>&nbsp;</label>
                                                <a href="manage-blogs.php" class="btn btn-secondary form-control"><i class="fas fa-refresh"></i> Clear Filters</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Blog List -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <h5 class="card-header">
                                    Blog List <span class="badge badge-secondary ml-2"><?php echo (int)$totalRecords; ?> items</span>
                                </h5>
                                <div class="card-body">
                                    <?php if (empty($paginatedBlogs)) { ?>
                                        <div class="text-center py-4">
                                            <i class="fas fa-pen-nib fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No blogs found</h5>
                                            <p class="text-muted">
                                                <?php if (!empty($searchTerm) || $statusFilter != 'all') { ?>
                                                    Try adjusting your search criteria or <a href="manage-blogs.php">view all blogs</a>
                                                <?php } else { ?>
                                                    <a href="add-blog.php" class="btn btn-primary">Add your first blog</a>
                                                <?php } ?>
                                            </p>
                                        </div>
                                    <?php } else { ?>
                                        <!-- Bulk actions (hidden by default) -->
                                        <div class="bulk-actions">
                                            <div class="row align-items-center">
                                                <div class="col-md-6">
                                                    <strong><span class="bulk-count">0</span> blog(s) selected</strong>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <button type="button" class="btn btn-success btn-sm bulk-activate-btn"><i class="fas fa-eye"></i> Activate Selected</button>
                                                    <button type="button" class="btn btn-warning btn-sm bulk-deactivate-btn"><i class="fas fa-eye-slash"></i> Deactivate Selected</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="40">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="selectAllBlogs">
                                                                <label class="form-check-label" for="selectAllBlogs"></label>
                                                            </div>
                                                        </th>
                                                        <th>Image</th>
                                                        <th>Title</th>
                                                        <th>Excerpt</th>
                                                        <th>Status</th>
                                                        <th>Created</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($paginatedBlogs as $blog) { ?>
                                                        <tr data-blog-id="<?php echo (int)$blog['ID']; ?>" class="blog-row <?php echo strtolower($blog['Status']); ?>">
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input blog-checkbox" type="checkbox" id="blog_<?php echo (int)$blog['ID']; ?>" data-blog-id="<?php echo (int)$blog['ID']; ?>">
                                                                    <label class="form-check-label" for="blog_<?php echo (int)$blog['ID']; ?>"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($blog['BlogImage'])) { ?>
                                                                    <img src="../assets/images/blogs/<?php echo htmlspecialchars($blog['BlogImage']); ?>" alt="<?php echo htmlspecialchars($blog['BlogTitle']); ?>" class="thumbnail">
                                                                <?php } else { ?>
                                                                    <span class="text-muted">No image</span>
                                                                <?php } ?>
                                                            </td>
                                                            <td><strong><?php echo htmlspecialchars($blog['BlogTitle']); ?></strong></td>
                                                            <td>
                                                                <?php
                                                                $desc = strip_tags($blog['BlogDescription']);
                                                                $desc = htmlspecialchars($desc);
                                                                echo strlen($desc) > 80 ? substr($desc, 0, 80) . '...' : $desc;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($blog['Status'] == 'Active') { ?>
                                                                    <span class="badge badge-success status-badge"><span class="status-indicator active"></span>Active</span>
                                                                <?php } else { ?>
                                                                    <span class="badge badge-secondary status-badge"><span class="status-indicator inactive"></span>Inactive</span>
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <?php echo date('M d, Y', strtotime($blog['CreationDate'])); ?>
                                                                <?php if (!empty($blog['CreatedByName'])) { echo "<br><small class='text-muted'>by ".htmlspecialchars($blog['CreatedByName'])."</small>"; } ?>
                                                            </td>
                                                            <td>
                                                                <div class="action-buttons">
                                                                    <a href="edit-blog.php?id=<?php echo (int)$blog['ID']; ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i></a>

                                                                    <?php if ($blog['Status'] == 'Active') { ?>
                                                                        <button type="button" class="btn btn-sm btn-warning toggle-status-btn" title="Deactivate" data-blog-id="<?php echo (int)$blog['ID']; ?>" data-blog-name="<?php echo htmlspecialchars($blog['BlogTitle']); ?>" data-action="deactivate"><i class="fas fa-eye-slash"></i> Deactivate</button>
                                                                    <?php } else { ?>
                                                                        <button type="button" class="btn btn-sm btn-success toggle-status-btn" title="Activate" data-blog-id="<?php echo (int)$blog['ID']; ?>" data-blog-name="<?php echo htmlspecialchars($blog['BlogTitle']); ?>" data-action="activate"><i class="fas fa-eye"></i> Activate</button>
                                                                    <?php } ?>

                                                                    <button type="button" class="btn btn-sm btn-danger delete-blog-btn" title="Delete" data-blog-id="<?php echo (int)$blog['ID']; ?>" data-blog-name="<?php echo htmlspecialchars($blog['BlogTitle']); ?>"><i class="fas fa-trash"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Pagination -->
                                        <?php if ($totalPages > 1) { ?>
                                            <nav aria-label="Blog pagination">
                                                <ul class="pagination justify-content-center">
                                                    <?php if ($currentPage > 1) { ?>
                                                        <li class="page-item"><a class="page-link" href="?page=<?php echo $currentPage-1; ?>&status=<?php echo urlencode($statusFilter); ?>&search=<?php echo urlencode($searchTerm); ?>">Previous</a></li>
                                                    <?php } ?>
                                                    <?php for ($i=1;$i<=$totalPages;$i++) { ?>
                                                        <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i; ?>&status=<?php echo urlencode($statusFilter); ?>&search=<?php echo urlencode($searchTerm); ?>"><?php echo $i; ?></a></li>
                                                    <?php } ?>
                                                    <?php if ($currentPage < $totalPages) { ?>
                                                        <li class="page-item"><a class="page-link" href="?page=<?php echo $currentPage+1; ?>&status=<?php echo urlencode($statusFilter); ?>&search=<?php echo urlencode($searchTerm); ?>">Next</a></li>
                                                    <?php } ?>
                                                </ul>
                                            </nav>
                                        <?php } ?>

                                    <?php } // end else (has blogs) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php include_once('includes/footer.php'); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="assets/libs/js/main-js.js"></script>

    <!-- Custom blog JS (make sure files exist) -->
    <script>
        // Inline fallback for status toggle & delete if external JS not loaded yet.
        $(document).on('click', '.toggle-status-btn', function(){
            var id = $(this).data('blog-id');
            var action = $(this).data('action');
            if (!id || !action) return;
            // confirm
            var name = $(this).data('blog-name') || 'this blog';
            if (!confirm('Are you sure you want to ' + action + ' "' + name + '"?')) return;
            // navigate to same page with action
            var params = new URLSearchParams(window.location.search);
            params.set('action', action);
            params.set('id', id);
            window.location.search = params.toString();
        });

        $(document).on('click', '.delete-blog-btn', function(){
            var id = $(this).data('blog-id');
            var name = $(this).data('blog-name') || 'this blog';
            if (!id) return;
            if (confirm('Are you sure you want to delete "' + name + '"? This action cannot be undone.')) {
                window.location.href = 'blog-delete.php?id=' + id;
            }
        });

        // Select all checkboxes
        $('#selectAllBlogs').on('change', function(){
            var checked = $(this).is(':checked');
            $('.blog-checkbox').prop('checked', checked);
            toggleBulkActions();
        });

        $(document).on('change', '.blog-checkbox', function(){
            var total = $('.blog-checkbox').length;
            var checked = $('.blog-checkbox:checked').length;
            $('#selectAllBlogs').prop('checked', total === checked);
            toggleBulkActions();
        });

        function toggleBulkActions() {
            var checkedCount = $('.blog-checkbox:checked').length;
            if (checkedCount > 0) {
                $('.bulk-actions').show();
                $('.bulk-count').text(checkedCount);
            } else {
                $('.bulk-actions').hide();
                $('.bulk-count').text('0');
            }
        }

        // Bulk activate/deactivate (simple implementation)
        $('.bulk-activate-btn').on('click', function(){
            var ids = $('.blog-checkbox:checked').map(function(){ return $(this).data('blog-id'); }).get();
            if (ids.length === 0) return alert('Select at least one blog.');
            if (!confirm('Activate ' + ids.length + ' selected blog(s)?')) return;
            // Redirect to server-side bulk handler (implement if needed)
            // Example: bulk-blog-action.php?action=activate&ids=1,2,3
            window.location.href = 'bulk-blog-action.php?action=activate&ids=' + ids.join(',');
        });

        $('.bulk-deactivate-btn').on('click', function(){
            var ids = $('.blog-checkbox:checked').map(function(){ return $(this).data('blog-id'); }).get();
            if (ids.length === 0) return alert('Select at least one blog.');
            if (!confirm('Deactivate ' + ids.length + ' selected blog(s)?')) return;
            window.location.href = 'bulk-blog-action.php?action=deactivate&ids=' + ids.join(',');
        });
    </script>

    <!-- External custom files (optional) -->
    <script src="assets/js/blog-delete.js"></script>
    <script src="assets/js/blog-status.js"></script>
</body>
</html>
