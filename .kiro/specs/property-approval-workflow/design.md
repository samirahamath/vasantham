# Design Document

## Overview

The Property Approval Workflow system enhances the existing Vasantham Real Estate Management System by implementing a quality control mechanism. The system introduces an approval process where agent-submitted properties must be reviewed and approved by administrators before becoming visible to public users. This design leverages the existing PHP/MySQL architecture and integrates seamlessly with the current codebase.

## Architecture

### Current System Architecture
- **Frontend**: PHP-based web application with HTML/CSS/JavaScript
- **Backend**: PHP with procedural programming approach
- **Database**: MySQL (MariaDB) with database name `remsdb`
- **Session Management**: PHP sessions for user authentication
- **File Structure**: Modular approach with separate admin and public sections

### Enhanced Architecture Components
- **Approval Engine**: Core logic for managing property approval states
- **Notification System**: Alert mechanisms for status changes
- **Admin Dashboard**: Enhanced interface for property review and approval
- **Agent Interface**: Updated property management with approval status visibility
- **Public Filter**: Automatic filtering to show only approved properties

## Components and Interfaces

### 1. Database Schema Enhancement

#### Modified `tblproperty` Table
```sql
ALTER TABLE `tblproperty` ADD COLUMN `ApprovalStatus` VARCHAR(20) DEFAULT 'Pending' AFTER `ListingDate`;
ALTER TABLE `tblproperty` ADD COLUMN `ApprovalDate` TIMESTAMP NULL AFTER `ApprovalStatus`;
ALTER TABLE `tblproperty` ADD COLUMN `ApprovedBy` INT(10) NULL AFTER `ApprovalDate`;
ALTER TABLE `tblproperty` ADD COLUMN `RejectionReason` TEXT NULL AFTER `ApprovedBy`;
ALTER TABLE `tblproperty` ADD COLUMN `RejectionDate` TIMESTAMP NULL AFTER `RejectionReason`;

-- Add foreign key constraint
ALTER TABLE `tblproperty` ADD CONSTRAINT `fk_approved_by` 
FOREIGN KEY (`ApprovedBy`) REFERENCES `tbladmin`(`ID`);

-- Add index for performance
CREATE INDEX `idx_approval_status` ON `tblproperty`(`ApprovalStatus`);
CREATE INDEX `idx_approval_date` ON `tblproperty`(`ApprovalDate`);
```

#### New `tblpropertyaudit` Table
```sql
CREATE TABLE `tblpropertyaudit` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `PropertyID` int(10) NOT NULL,
  `Action` varchar(50) NOT NULL,
  `OldStatus` varchar(20) NULL,
  `NewStatus` varchar(20) NOT NULL,
  `AdminID` int(10) NULL,
  `Comments` text NULL,
  `ActionDate` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`PropertyID`) REFERENCES `tblproperty`(`ID`),
  FOREIGN KEY (`AdminID`) REFERENCES `tbladmin`(`ID`)
);
```

### 2. Core PHP Components

#### ApprovalManager Class
```php
class ApprovalManager {
    private $connection;
    
    public function __construct($dbConnection) {
        $this->connection = $dbConnection;
    }
    
    public function approveProperty($propertyId, $adminId) {
        // Update property status to approved
        // Log audit trail
        // Send notification to agent
    }
    
    public function rejectProperty($propertyId, $adminId, $reason) {
        // Update property status to rejected
        // Store rejection reason
        // Log audit trail
        // Send notification to agent
    }
    
    public function getPendingProperties() {
        // Return properties with status 'Pending'
    }
    
    public function getApprovalStatistics() {
        // Return approval metrics for dashboard
    }
}
```

#### NotificationManager Class
```php
class NotificationManager {
    public function sendApprovalNotification($propertyId, $agentId) {
        // Send email/system notification for approval
    }
    
    public function sendRejectionNotification($propertyId, $agentId, $reason) {
        // Send email/system notification for rejection
    }
}
```

### 3. Enhanced User Interfaces

#### Admin Approval Interface (`admin/approve-properties.php`)
- **Property List View**: Tabular display with filtering options
- **Quick Actions**: Approve/Reject buttons with confirmation dialogs
- **Detailed View**: Modal or separate page for complete property information
- **Bulk Operations**: Select multiple properties for batch approval/rejection
- **Search and Filter**: By agent, date range, property type, location

#### Agent Property Management (`my-properties.php`)
- **Status Indicators**: Visual badges showing approval status
- **Rejection Details**: Display rejection reasons when applicable
- **Resubmission**: Option to edit and resubmit rejected properties
- **Status History**: Timeline of approval process

#### Public Property Listings
- **Automatic Filtering**: Only show approved properties
- **No Status Display**: Hide approval status from public users

### 4. File Structure Enhancements

```
vasantham/
├── includes/
│   ├── approval-functions.php (New)
│   ├── notification-functions.php (New)
│   └── dbconnection.php (Existing)
├── admin/
│   ├── approve-properties.php (Enhanced)
│   ├── approval-statistics.php (New)
│   └── bulk-approve.php (New)
├── add-property.php (Modified)
├── my-properties.php (Modified)
├── properties-grid.php (Modified)
└── property-search.php (Modified)
```

## Data Models

### Property Approval States
```
Pending -> Initial state when agent submits property
Approved -> Admin approves property (visible to public)
Rejected -> Admin rejects property (not visible to public)
```

### State Transitions
```
Pending -> Approved (Admin action)
Pending -> Rejected (Admin action)
Rejected -> Pending (Agent resubmission)
Approved -> Rejected (Admin action - rare case)
```

### Data Flow
1. **Agent Submission**: Property saved with status 'Pending'
2. **Admin Review**: Admin views pending properties
3. **Approval Decision**: Admin approves or rejects with reason
4. **Status Update**: Database updated with new status and timestamp
5. **Notification**: Agent notified of decision
6. **Public Visibility**: Only approved properties shown to public

## Error Handling

### Database Error Handling
- **Connection Failures**: Graceful degradation with user-friendly messages
- **Query Failures**: Proper error logging and rollback mechanisms
- **Constraint Violations**: Validation before database operations

### User Input Validation
- **Property Data**: Validate all required fields before submission
- **Admin Actions**: Confirm approval/rejection actions
- **File Uploads**: Validate image formats and sizes

### Session Management
- **Authentication Checks**: Verify user permissions for all actions
- **Session Timeouts**: Handle expired sessions gracefully
- **Role-based Access**: Ensure only admins can approve/reject

## Testing Strategy

### Unit Testing
- **Approval Functions**: Test approve/reject logic
- **Database Operations**: Test CRUD operations for approval status
- **Validation Functions**: Test input validation and sanitization

### Integration Testing
- **Workflow Testing**: End-to-end approval process
- **Database Integration**: Test with actual database operations
- **File Upload Testing**: Test property image handling

### User Acceptance Testing
- **Admin Workflow**: Test admin approval interface
- **Agent Workflow**: Test agent property submission and status viewing
- **Public Interface**: Verify only approved properties are visible

### Performance Testing
- **Database Queries**: Optimize queries for large property datasets
- **Page Load Times**: Ensure approval interface loads quickly
- **Concurrent Users**: Test multiple admins approving simultaneously

## Security Considerations

### Access Control
- **Admin Authentication**: Verify admin session for approval actions
- **Agent Permissions**: Agents can only view/edit their own properties
- **Public Access**: No approval status information exposed to public

### Data Protection
- **SQL Injection**: Use prepared statements for all database queries
- **XSS Prevention**: Sanitize all user inputs and outputs
- **CSRF Protection**: Implement tokens for state-changing operations

### Audit Trail
- **Action Logging**: Log all approval/rejection actions
- **User Tracking**: Track which admin performed which actions
- **Timestamp Recording**: Record exact times of all status changes

## Implementation Phases

### Phase 1: Database Schema
- Add approval status fields to tblproperty
- Create audit table for tracking changes
- Update existing data with default 'Approved' status

### Phase 2: Core Functionality
- Implement approval manager class
- Update add-property.php to set 'Pending' status
- Enhance approve-properties.php with new functionality

### Phase 3: User Interface Enhancements
- Update admin interface with improved approval workflow
- Enhance agent interface to show approval status
- Add rejection reason display and resubmission capability

### Phase 4: Public Interface Updates
- Update all public property listing pages to filter approved only
- Ensure search and filter functions respect approval status
- Test public interface thoroughly

### Phase 5: Notifications and Reporting
- Implement notification system for status changes
- Add approval statistics to admin dashboard
- Create reporting functionality for approval metrics