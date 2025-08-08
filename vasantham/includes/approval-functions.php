<?php
/**
 * Property Approval Management Functions
 * Core functions for handling property approval workflow
 */

/**
 * Approve a property
 * @param int $propertyId - ID of the property to approve
 * @param int $adminId - ID of the admin approving the property
 * @param mysqli $con - Database connection
 * @return bool - True on success, false on failure
 */
function approveProperty($propertyId, $adminId, $con) {
    try {
        // Start transaction
        mysqli_autocommit($con, false);
        
        // Get current property status for audit trail
        $currentStatusQuery = mysqli_query($con, "SELECT ApprovalStatus FROM tblproperty WHERE ID = '$propertyId'");
        $currentStatus = mysqli_fetch_array($currentStatusQuery);
        $oldStatus = $currentStatus ? $currentStatus['ApprovalStatus'] : null;
        
        // Update property status to approved
        $approveQuery = "UPDATE tblproperty SET 
                        ApprovalStatus = 'Approved', 
                        ApprovalDate = NOW(), 
                        ApprovedBy = '$adminId',
                        RejectionReason = NULL,
                        RejectionDate = NULL
                        WHERE ID = '$propertyId'";
        
        $result = mysqli_query($con, $approveQuery);
        
        if (!$result) {
            throw new Exception("Failed to update property status");
        }
        
        // Log audit trail
        $auditQuery = "INSERT INTO tblpropertyaudit (PropertyID, Action, OldStatus, NewStatus, AdminID, Comments, ActionDate) 
                      VALUES ('$propertyId', 'APPROVED', '$oldStatus', 'Approved', '$adminId', 'Property approved by admin', NOW())";
        
        $auditResult = mysqli_query($con, $auditQuery);
        
        if (!$auditResult) {
            throw new Exception("Failed to log audit trail");
        }
        
        // Commit transaction
        mysqli_commit($con);
        mysqli_autocommit($con, true);
        
        // Send notification to agent
        include_once('notification-functions.php');
        sendApprovalNotification($propertyId, $adminId, $con);
        
        return true;
        
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($con);
        mysqli_autocommit($con, true);
        error_log("Error approving property: " . $e->getMessage());
        return false;
    }
}

/**
 * Reject a property with reason
 * @param int $propertyId - ID of the property to reject
 * @param int $adminId - ID of the admin rejecting the property
 * @param string $reason - Reason for rejection
 * @param mysqli $con - Database connection
 * @return bool - True on success, false on failure
 */
function rejectProperty($propertyId, $adminId, $reason, $con) {
    try {
        // Start transaction
        mysqli_autocommit($con, false);
        
        // Get current property status for audit trail
        $currentStatusQuery = mysqli_query($con, "SELECT ApprovalStatus FROM tblproperty WHERE ID = '$propertyId'");
        $currentStatus = mysqli_fetch_array($currentStatusQuery);
        $oldStatus = $currentStatus ? $currentStatus['ApprovalStatus'] : null;
        
        // Sanitize rejection reason
        $reason = mysqli_real_escape_string($con, $reason);
        
        // Update property status to rejected
        $rejectQuery = "UPDATE tblproperty SET 
                       ApprovalStatus = 'Rejected', 
                       RejectionReason = '$reason',
                       RejectionDate = NOW(),
                       ApprovalDate = NULL,
                       ApprovedBy = NULL
                       WHERE ID = '$propertyId'";
        
        $result = mysqli_query($con, $rejectQuery);
        
        if (!$result) {
            throw new Exception("Failed to update property status");
        }
        
        // Log audit trail
        $auditQuery = "INSERT INTO tblpropertyaudit (PropertyID, Action, OldStatus, NewStatus, AdminID, Comments, ActionDate) 
                      VALUES ('$propertyId', 'REJECTED', '$oldStatus', 'Rejected', '$adminId', '$reason', NOW())";
        
        $auditResult = mysqli_query($con, $auditQuery);
        
        if (!$auditResult) {
            throw new Exception("Failed to log audit trail");
        }
        
        // Commit transaction
        mysqli_commit($con);
        mysqli_autocommit($con, true);
        
        // Send notification to agent
        include_once('notification-functions.php');
        sendRejectionNotification($propertyId, $adminId, $reason, $con);
        
        return true;
        
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($con);
        mysqli_autocommit($con, true);
        error_log("Error rejecting property: " . $e->getMessage());
        return false;
    }
}

/**
 * Get pending properties for admin review
 * @param mysqli $con - Database connection
 * @param string $filter - Optional filter (agent, type, location)
 * @param string $search - Optional search term
 * @return array - Array of pending properties with agent information
 */
function getPendingProperties($con, $filter = '', $search = '') {
    $whereClause = "WHERE p.ApprovalStatus = 'Pending'";
    
    // Add search filter if provided
    if (!empty($search)) {
        $search = mysqli_real_escape_string($con, $search);
        $whereClause .= " AND (p.PropertyTitle LIKE '%$search%' 
                         OR p.Location LIKE '%$search%' 
                         OR u.FullName LIKE '%$search%')";
    }
    
    // Add additional filters if provided
    if (!empty($filter)) {
        $filter = mysqli_real_escape_string($con, $filter);
        $whereClause .= " AND p.Type = '$filter'";
    }
    
    $query = "SELECT p.*, u.FullName as AgentName, u.Email as AgentEmail, u.MobileNumber as AgentPhone,
                     pt.PropertType as PropertyTypeName
              FROM tblproperty p 
              LEFT JOIN tbluser u ON u.ID = p.UserID 
              LEFT JOIN tblpropertytype pt ON pt.ID = p.Type
              $whereClause
              ORDER BY p.ListingDate ASC";
    
    $result = mysqli_query($con, $query);
    $properties = array();
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $properties[] = $row;
        }
    }
    
    return $properties;
}

/**
 * Get all properties with their approval status
 * @param mysqli $con - Database connection
 * @param string $status - Filter by status (optional)
 * @return array - Array of properties with approval information
 */
function getAllPropertiesWithStatus($con, $status = '') {
    $whereClause = "";
    
    if (!empty($status)) {
        $status = mysqli_real_escape_string($con, $status);
        $whereClause = "WHERE p.ApprovalStatus = '$status'";
    }
    
    $query = "SELECT p.*, u.FullName as AgentName, u.Email as AgentEmail,
                     pt.PropertType as PropertyTypeName,
                     a.AdminName as ApprovedByName
              FROM tblproperty p 
              LEFT JOIN tbluser u ON u.ID = p.UserID 
              LEFT JOIN tblpropertytype pt ON pt.ID = p.Type
              LEFT JOIN tbladmin a ON a.ID = p.ApprovedBy
              $whereClause
              ORDER BY p.ListingDate DESC";
    
    $result = mysqli_query($con, $query);
    $properties = array();
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $properties[] = $row;
        }
    }
    
    return $properties;
}

/**
 * Get approval statistics for dashboard
 * @param mysqli $con - Database connection
 * @return array - Array containing approval statistics
 */
function getApprovalStatistics($con) {
    $stats = array();
    
    // Get total counts by status
    $statusQuery = "SELECT ApprovalStatus, COUNT(*) as count 
                   FROM tblproperty 
                   GROUP BY ApprovalStatus";
    $statusResult = mysqli_query($con, $statusQuery);
    
    while ($row = mysqli_fetch_assoc($statusResult)) {
        $stats['by_status'][$row['ApprovalStatus']] = $row['count'];
    }
    
    // Get approval rates by agent
    $agentQuery = "SELECT u.FullName as AgentName, u.ID as AgentID,
                          COUNT(*) as total_properties,
                          SUM(CASE WHEN p.ApprovalStatus = 'Approved' THEN 1 ELSE 0 END) as approved_count,
                          SUM(CASE WHEN p.ApprovalStatus = 'Rejected' THEN 1 ELSE 0 END) as rejected_count,
                          SUM(CASE WHEN p.ApprovalStatus = 'Pending' THEN 1 ELSE 0 END) as pending_count
                   FROM tblproperty p
                   LEFT JOIN tbluser u ON u.ID = p.UserID
                   WHERE u.UserType = '1'
                   GROUP BY u.ID, u.FullName
                   ORDER BY total_properties DESC";
    
    $agentResult = mysqli_query($con, $agentQuery);
    $stats['by_agent'] = array();
    
    while ($row = mysqli_fetch_assoc($agentResult)) {
        $row['approval_rate'] = $row['total_properties'] > 0 ? 
            round(($row['approved_count'] / $row['total_properties']) * 100, 2) : 0;
        $stats['by_agent'][] = $row;
    }
    
    // Get recent activity
    $recentQuery = "SELECT pa.*, p.PropertyTitle, u.FullName as AgentName, a.AdminName
                   FROM tblpropertyaudit pa
                   LEFT JOIN tblproperty p ON p.ID = pa.PropertyID
                   LEFT JOIN tbluser u ON u.ID = p.UserID
                   LEFT JOIN tbladmin a ON a.ID = pa.AdminID
                   ORDER BY pa.ActionDate DESC
                   LIMIT 10";
    
    $recentResult = mysqli_query($con, $recentQuery);
    $stats['recent_activity'] = array();
    
    while ($row = mysqli_fetch_assoc($recentResult)) {
        $stats['recent_activity'][] = $row;
    }
    
    return $stats;
}

/**
 * Validate approval status transition
 * @param string $currentStatus - Current approval status
 * @param string $newStatus - New approval status
 * @return bool - True if transition is valid, false otherwise
 */
function validateStatusTransition($currentStatus, $newStatus) {
    $validTransitions = array(
        'Pending' => array('Approved', 'Rejected'),
        'Approved' => array('Rejected'), // Rare case, admin can reject approved property
        'Rejected' => array('Pending', 'Approved') // Agent can resubmit or admin can directly approve
    );
    
    if (!isset($validTransitions[$currentStatus])) {
        return false;
    }
    
    return in_array($newStatus, $validTransitions[$currentStatus]);
}

/**
 * Get property approval history
 * @param int $propertyId - ID of the property
 * @param mysqli $con - Database connection
 * @return array - Array of audit records for the property
 */
function getPropertyApprovalHistory($propertyId, $con) {
    $query = "SELECT pa.*, a.AdminName, a.Email as AdminEmail
              FROM tblpropertyaudit pa
              LEFT JOIN tbladmin a ON a.ID = pa.AdminID
              WHERE pa.PropertyID = '$propertyId'
              ORDER BY pa.ActionDate DESC";
    
    $result = mysqli_query($con, $query);
    $history = array();
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $history[] = $row;
        }
    }
    
    return $history;
}

/**
 * Check if user has permission to approve properties
 * @param array $session - User session data
 * @return bool - True if user is admin, false otherwise
 */
function canApproveProperties($session) {
    return isset($session['remsaid']) && !empty($session['remsaid']);
}

/**
 * Get property details for approval review
 * @param int $propertyId - ID of the property
 * @param mysqli $con - Database connection
 * @return array|null - Property details or null if not found
 */
function getPropertyForApproval($propertyId, $con) {
    $query = "SELECT p.*, u.FullName as AgentName, u.Email as AgentEmail, u.MobileNumber as AgentPhone,
                     pt.PropertType as PropertyTypeName, c.CountryName, s.StateName,
                     a.AdminName as ApprovedByName
              FROM tblproperty p 
              LEFT JOIN tbluser u ON u.ID = p.UserID 
              LEFT JOIN tblpropertytype pt ON pt.ID = p.Type
              LEFT JOIN tblcountry c ON c.ID = p.Country
              LEFT JOIN tblstate s ON s.ID = p.State
              LEFT JOIN tbladmin a ON a.ID = p.ApprovedBy
              WHERE p.ID = '$propertyId'";
    
    $result = mysqli_query($con, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    
    return null;
}
?>