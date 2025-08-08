// Banner deletion functionality with enhanced confirmation
function deleteBanner(bannerId, bannerName, isActive) {
    // Create confirmation modal HTML
    const modalHtml = `
        <div class="modal fade" id="deleteBannerModal" tabindex="-1" role="dialog" aria-labelledby="deleteBannerModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteBannerModalLabel">
                            <i class="fas fa-exclamation-triangle"></i> Confirm Banner Deletion
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning" role="alert">
                            <strong>Warning:</strong> This action cannot be undone!
                        </div>
                        
                        ${isActive ? `
                            <div class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation-circle"></i>
                                <strong>Active Banner Warning:</strong> This banner is currently active and displayed on the homepage. 
                                Deleting it will remove it from the website immediately.
                            </div>
                        ` : ''}
                        
                        <p>Are you sure you want to delete the banner <strong>"${bannerName}"</strong>?</p>
                        
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="confirmDeleteCheckbox">
                            <label class="form-check-label" for="confirmDeleteCheckbox">
                                I understand that this action cannot be undone
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn" disabled>
                            <i class="fas fa-trash"></i> Delete Banner
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    $('#deleteBannerModal').remove();
    
    // Add modal to body
    $('body').append(modalHtml);
    
    // Show modal
    $('#deleteBannerModal').modal('show');
    
    // Enable/disable delete button based on checkbox
    $('#confirmDeleteCheckbox').change(function() {
        $('#confirmDeleteBtn').prop('disabled', !this.checked);
    });
    
    // Handle delete confirmation
    $('#confirmDeleteBtn').click(function() {
        const btn = $(this);
        const originalText = btn.html();
        
        // Show loading state
        btn.html('<i class="fas fa-spinner fa-spin"></i> Deleting...').prop('disabled', true);
        
        // Send AJAX request
        $.ajax({
            url: 'delete-banner.php',
            type: 'POST',
            data: {
                banner_id: bannerId,
                confirm_delete: 1,
                ajax: 1
            },
            dataType: 'json',
            success: function(response) {
                $('#deleteBannerModal').modal('hide');
                
                if (response.success) {
                    // Show success message (with different styling for partial success)
                    const alertType = response.partial ? 'warning' : 'success';
                    showAlert(alertType, response.message);
                    
                    // Remove the banner row from table
                    $(`tr[data-banner-id="${bannerId}"]`).fadeOut(500, function() {
                        $(this).remove();
                        
                        // Update statistics
                        updateBannerStatistics();
                        
                        // Check if table is empty
                        if ($('tbody tr').length === 0) {
                            location.reload();
                        }
                    });
                } else if (response.needs_confirmation) {
                    // Show warning and ask for confirmation again
                    showAlert('warning', response.message);
                } else {
                    showAlert('danger', response.message);
                }
            },
            error: function(xhr, status, error) {
                $('#deleteBannerModal').modal('hide');
                showAlert('danger', 'An error occurred while deleting the banner. Please try again.');
                console.error('Delete error:', error);
            },
            complete: function() {
                btn.html(originalText).prop('disabled', false);
            }
        });
    });
    
    // Clean up modal when hidden
    $('#deleteBannerModal').on('hidden.bs.modal', function() {
        $(this).remove();
    });
}

// Show alert messages
function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `;
    
    // Remove existing alerts
    $('.alert').remove();
    
    // Add new alert at the top of the content
    $('.dashboard-content .row:first').after(alertHtml);
    
    // Auto-hide success alerts after 5 seconds
    if (type === 'success') {
        setTimeout(function() {
            $('.alert-success').fadeOut();
        }, 5000);
    }
}

// Update banner statistics after deletion
function updateBannerStatistics() {
    $.ajax({
        url: 'get-banner-stats.php',
        type: 'GET',
        dataType: 'json',
        success: function(stats) {
            $('.card-header:contains("Total Banners")').next('.card-body').find('h1').text(stats.total);
            $('.card-header:contains("Active Banners")').next('.card-body').find('h1').text(stats.active);
            $('.card-header:contains("Inactive Banners")').next('.card-body').find('h1').text(stats.inactive);
        },
        error: function() {
            console.log('Could not update statistics');
        }
    });
}

// Initialize delete functionality when document is ready
$(document).ready(function() {
    // Handle delete button clicks
    $(document).on('click', '.delete-banner-btn', function(e) {
        e.preventDefault();
        
        const bannerId = $(this).data('banner-id');
        const bannerName = $(this).data('banner-name');
        const isActive = $(this).data('is-active') === 'true';
        
        deleteBanner(bannerId, bannerName, isActive);
    });
});