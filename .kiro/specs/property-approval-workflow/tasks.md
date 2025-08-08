# Implementation Plan

- [x] 1. Set up database schema for approval workflow







  - Create database migration script to add ApprovalStatus, ApprovalDate, ApprovedBy, RejectionReason, and RejectionDate columns to tblproperty table
  - Create tblpropertyaudit table for tracking approval history and changes
  - Add necessary indexes for performance optimization on approval status queries
  - Update existing property records to have 'Approved' status by default to maintain current functionality
  - _Requirements: 1.1, 2.1, 3.1, 5.1, 6.1_



- [ ] 2. Create core approval management functions
  - Write PHP functions for approving properties including database updates and audit logging
  - Write PHP functions for rejecting properties with reason storage and audit trail
  - Implement function to retrieve pending properties with agent information for admin review
  - Create function to get approval statistics for dashboard reporting


  - Write helper functions for status validation and state transition management
  - _Requirements: 2.1, 2.2, 2.3, 6.2, 6.3_

- [ ] 3. Modify property submission to use pending status
  - Update add-property.php to set ApprovalStatus to 'Pending' instead of making properties immediately live


  - Modify the success message to inform agents that their property is submitted for approval
  - Add validation to ensure all required fields are present before setting pending status
  - Test property submission workflow to ensure properties are created with correct pending status
  - _Requirements: 1.1, 1.2_

- [x] 4. Enhance admin approval interface

  - Update admin/approve-properties.php to display properties with enhanced approval workflow UI
  - Add approve and reject action buttons with confirmation dialogs for each property
  - Implement modal or detailed view for complete property information during review
  - Add search and filtering capabilities by agent name, property type, location, and submission date
  - Create bulk approval functionality for selecting and approving multiple properties at once
  - _Requirements: 2.1, 2.2, 2.3, 3.1, 3.2, 3.3_



- [ ] 5. Implement rejection reason functionality
  - Add rejection reason input field to the admin approval interface
  - Create database operations to store and retrieve rejection reasons
  - Implement validation to ensure rejection reason is provided when rejecting properties


  - Add audit logging for rejection actions with reason and admin information
  - _Requirements: 2.3, 4.1, 4.2_

- [ ] 6. Update agent property management interface
  - Modify my-properties.php to display approval status badges for each property
  - Add rejection reason display for properties that have been rejected
  - Implement visual indicators (colors, icons) to clearly show property approval states
  - Create resubmission functionality allowing agents to edit and resubmit rejected properties
  - _Requirements: 1.3, 4.2, 4.4_

- [ ] 7. Filter public property listings to show only approved properties
  - Update properties-grid.php to only display properties with ApprovalStatus='Approved'
  - Modify property search functionality to filter by approved status
  - Update all property listing queries throughout the public interface
  - Ensure property detail pages only show approved properties and return 404 for pending/rejected
  - _Requirements: 5.1, 5.2, 5.3, 5.4_

- [x] 8. Add approval statistics to admin dashboard


  - Create functions to calculate approval metrics including pending, approved, and rejected counts
  - Implement approval rate calculations by agent and overall system statistics
  - Add approval timeline reporting showing processing times and trends
  - Create visual dashboard elements to display approval statistics on admin dashboard
  - _Requirements: 6.1, 6.2, 6.3, 6.4_



- [ ] 9. Implement notification system for status changes
  - Create notification functions to alert agents when properties are approved
  - Implement rejection notifications with reason details sent to agents
  - Add email notification capability for approval status changes
  - Create system notification display within the agent interface for status updates

  - _Requirements: 4.3_

- [ ] 10. Add comprehensive error handling and validation
  - Implement proper error handling for all database operations related to approval workflow
  - Add validation for admin permissions before allowing approval/rejection actions
  - Create user-friendly error messages for approval workflow failures

  - Add logging for all approval-related errors and system events
  - _Requirements: 2.1, 2.2, 2.3, 3.1_

- [ ] 11. Create audit trail and logging system
  - Implement comprehensive logging for all approval actions including timestamps and admin details
  - Create audit trail viewing functionality for administrators to track approval history








  - Add property status change history display showing complete approval timeline
  - Implement data retention policies for audit logs and approval history
  - _Requirements: 6.1, 6.2, 6.3_

- [ ] 12. Write comprehensive tests for approval workflow
  - Create unit tests for all approval management functions including approve, reject, and status retrieval
  - Write integration tests for the complete approval workflow from submission to public display
  - Implement tests for edge cases including concurrent approvals and invalid state transitions
  - Create performance tests for approval queries with large datasets
  - _Requirements: 1.1, 2.1, 5.1_