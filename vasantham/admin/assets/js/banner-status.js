/**
 * Banner Status Management JavaScript
 * Handles banner activation/deactivation with AJAX and confirmation dialogs
 */

$(document).ready(function() {
    // Handle individual banner status toggle
    $('.toggle-status-btn').on('click', function() {
        const $btn = $(this);
        const bannerId = $btn.data('banner-id');
        const bannerName = $btn.data('banner-name');
        const currentStatus = $btn.data('current-status');
        const newStatus = $btn.data('new-status');
        const action = $btn.data('action');
        
        // Show confirmation dialog
        const actionText = action === 'activate' ? 'activate' : 'deactivate';
        const confirmMessage = `Are you sure you want to ${actionText} the banner "${bannerName}"?`;
        
        if (!confirm(confirmMessage)) {
            return;
        }
        
        // Disable button during request
        $btn.prop('disabled', true);
        const originalHtml = $btn.html();
        $btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        
        // Make AJAX request
        $.ajax({
            url: 'banner-status-handler.php',
            type: 'POST',
            data: {
                action: 'toggle_status',
                banner_id: bannerId,
                new_status: newStatus
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Show success message
                    showStatusMessage(response.message, 'success');
                    
                    // Update button and status badge
                    updateBannerStatusUI(bannerId, newStatus, bannerName);
                    
                    // Update statistics
                    updateStatistics(response.stats);
                    
                    // Check for edge case warning
                    if (response.warning) {
                        showStatusMessage(response.warning, 'warning');
                    }
                } else {
                    showStatusMessage(response.message || 'Error updating banner status', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                showStatusMessage('Network error occurred. Please try again.', 'error');
            },
            complete: function() {
                // Re-enable button
                $btn.prop('disabled', false);
                $btn.html(originalHtml);
            }
        });
    });
    
    // Handle bulk status operations
    $('.bulk-activate-btn, .bulk-deactivate-btn').on('click', function() {
        const isActivate = $(this).hasClass('bulk-activate-btn');
        const action = isActivate ? 'activate' : 'deactivate';
        const newStatus = isActivate ? 'Active' : 'Inactive';
        
        const selectedBanners = getSelectedBanners();
        if (selectedBanners.length === 0) {
            alert('Please select at least one banner.');
            return;
        }
        
        const confirmMessage = `Are you sure you want to ${action} ${selectedBanners.length} selected banner(s)?`;
        if (!confirm(confirmMessage)) {
            return;
        }
        
        // Process bulk operation
        processBulkStatusChange(selectedBanners, newStatus, action);
    });
    
    // Handle select all checkbox
    $('#selectAllBanners').on('change', function() {
        const isChecked = $(this).is(':checked');
        $('.banner-checkbox').prop('checked', isChecked);
        updateBulkActionsVisibility();
    });
    
    // Handle individual banner checkboxes
    $(document).on('change', '.banner-checkbox', function() {
        updateBulkActionsVisibility();
        
        // Update select all checkbox state
        const totalCheckboxes = $('.banner-checkbox').length;
        const checkedCheckboxes = $('.banner-checkbox:checked').length;
        
        $('#selectAllBanners').prop('indeterminate', checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes);
        $('#selectAllBanners').prop('checked', checkedCheckboxes === totalCheckboxes);
    });
});

/**
 * Update banner status UI elements
 */
function updateBannerStatusUI(bannerId, newStatus, bannerName) {
    const $row = $(`tr[data-banner-id="${bannerId}"]`);
    const $statusBadge = $row.find('.status-badge');
    const $toggleBtn = $row.find('.toggle-status-btn');
    
    // Update status badge
    if (newStatus === 'Active') {
        $statusBadge.removeClass('badge-secondary').addClass('badge-success');
        $statusBadge.html('<span class="status-indicator active"></span>Active');
        
        // Update toggle button
        $toggleBtn.removeClass('btn-success').addClass('btn-warning');
        $toggleBtn.attr('title', 'Deactivate Banner');
        $toggleBtn.data('current-status', 'Active');
        $toggleBtn.data('new-status', 'Inactive');
        $toggleBtn.data('action', 'deactivate');
        $toggleBtn.html('<i class="fas fa-eye-slash"></i> Deactivate');
        
        // Update row styling
        $row.removeClass('inactive').addClass('active');
    } else {
        $statusBadge.removeClass('badge-success').addClass('badge-secondary');
        $statusBadge.html('<span class="status-indicator inactive"></span>Inactive');
        
        // Update toggle button
        $toggleBtn.removeClass('btn-warning').addClass('btn-success');
        $toggleBtn.attr('title', 'Activate Banner');
        $toggleBtn.data('current-status', 'Inactive');
        $toggleBtn.data('new-status', 'Active');
        $toggleBtn.data('action', 'activate');
        $toggleBtn.html('<i class="fas fa-eye"></i> Activate');
        
        // Update row styling
        $row.removeClass('active').addClass('inactive');
    }
}

/**
 * Update statistics cards
 */
function updateStatistics(stats) {
    if (stats) {
        $('.card-header.bg-info').next('.card-body').find('h1').text(stats.total);
        $('.card-header.bg-success').next('.card-body').find('h1').text(stats.active);
        $('.card-header.bg-warning').next('.card-body').find('h1').text(stats.inactive);
    }
}

/**
 * Show status message
 */
function showStatusMessage(message, type) {
    // Remove existing alerts
    $('.alert').remove();
    
    let alertClass = 'alert-info';
    switch (type) {
        case 'success':
            alertClass = 'alert-success';
            break;
        case 'error':
            alertClass = 'alert-danger';
            break;
        case 'warning':
            alertClass = 'alert-warning';
            break;
    }
    
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `;
    
    // Insert after page header
    $('.page-header').after(alertHtml);
    
    // Auto-dismiss after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}

/**
 * Get selected banner IDs
 */
function getSelectedBanners() {
    const selected = [];
    $('.banner-checkbox:checked').each(function() {
        selected.push($(this).data('banner-id'));
    });
    return selected;
}

/**
 * Process bulk status change
 */
function processBulkStatusChange(bannerIds, newStatus, action) {
    const $bulkBtn = action === 'activate' ? $('.bulk-activate-btn') : $('.bulk-deactivate-btn');
    
    // Disable bulk action buttons
    $('.bulk-activate-btn, .bulk-deactivate-btn').prop('disabled', true);
    $bulkBtn.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
    
    $.ajax({
        url: 'banner-status-handler.php',
        type: 'POST',
        data: {
            action: 'bulk_toggle_status',
            banner_ids: bannerIds,
            new_status: newStatus
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                showStatusMessage(response.message, 'success');
                
                // Update UI for each banner
                bannerIds.forEach(function(bannerId) {
                    const bannerName = $(`tr[data-banner-id="${bannerId}"]`).find('td:nth-child(3) strong').text();
                    updateBannerStatusUI(bannerId, newStatus, bannerName);
                });
                
                // Update statistics
                updateStatistics(response.stats);
                
                // Clear selections
                $('.banner-checkbox, #selectAllBanners').prop('checked', false);
                updateBulkActionsVisibility();
                
                // Check for edge case warning
                if (response.warning) {
                    showStatusMessage(response.warning, 'warning');
                }
            } else {
                showStatusMessage(response.message || 'Error updating banner statuses', 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('Bulk AJAX Error:', error);
            showStatusMessage('Network error occurred. Please try again.', 'error');
        },
        complete: function() {
            // Re-enable bulk action buttons
            $('.bulk-activate-btn, .bulk-deactivate-btn').prop('disabled', false);
            $('.bulk-activate-btn').html('<i class="fas fa-eye"></i> Activate Selected');
            $('.bulk-deactivate-btn').html('<i class="fas fa-eye-slash"></i> Deactivate Selected');
        }
    });
}

/**
 * Update bulk actions visibility
 */
function updateBulkActionsVisibility() {
    const selectedCount = $('.banner-checkbox:checked').length;
    $('.bulk-count').text(selectedCount);
    
    if (selectedCount > 0) {
        $('.bulk-actions').slideDown();
    } else {
        $('.bulk-actions').slideUp();
    }
}

/**
 * Activate first banner (for edge case handling)
 */
function activateFirstBanner() {
    const $firstInactiveBtn = $('.toggle-status-btn[data-action="activate"]').first();
    
    if ($firstInactiveBtn.length > 0) {
        $firstInactiveBtn.click();
    } else {
        alert('No inactive banners found to activate.');
    }
}