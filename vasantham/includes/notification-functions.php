<?php
/**
 * Basic Notification System Functions
 * Simple functions for handling notifications related to property approval workflow
 */

/**
 * Send approval notification to agent (basic version)
 * @param int $propertyId - ID of the approved property
 * @param int $agentId - ID of the agent
 * @param mysqli $con - Database connection
 * @return bool - True on success, false on failure
 */
function sendApprovalNotification($propertyId, $agentId, $con) {
    // Get property and agent details
    $query = "SELECT p.PropertyTitle, u.FullName, u.Email 
             FROM tblproperty p 
             JOIN tbluser u ON u.ID = p.UserID 
             WHERE p.ID = '$propertyId' AND u.ID = '$agentId'";
    
    $result = mysqli_query($con, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Log notification for now (can be extended to send emails)
        error_log("APPROVAL NOTIFICATION: Property '{$row['PropertyTitle']}' approved for agent {$row['FullName']} ({$row['Email']})");
        
        return true;
    }
    
    return false;
}

/**
 * Send rejection notification to agent (basic version)
 * @param int $propertyId - ID of the rejected property
 * @param int $agentId - ID of the agent
 * @param string $reason - Rejection reason
 * @param mysqli $con - Database connection
 * @return bool - True on success, false on failure
 */
function sendRejectionNotification($propertyId, $agentId, $reason, $con) {
    // Get property and agent details
    $query = "SELECT p.PropertyTitle, u.FullName, u.Email 
             FROM tblproperty p 
             JOIN tbluser u ON u.ID = p.UserID 
             WHERE p.ID = '$propertyId' AND u.ID = '$agentId'";
    
    $result = mysqli_query($con, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Log notification for now (can be extended to send emails)
        error_log("REJECTION NOTIFICATION: Property '{$row['PropertyTitle']}' rejected for agent {$row['FullName']} ({$row['Email']}) - Reason: {$reason}");
        
        return true;
    }
    
    return false;
}
?>