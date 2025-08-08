# Requirements Document

## Introduction

The Property Approval Workflow system is designed to implement a quality control mechanism for the Vasantham Real Estate Management System. Currently, agents can add properties directly to the system, but this feature will introduce a mandatory approval process where all agent-submitted properties must be reviewed and approved by administrators before becoming visible to end users. This ensures property quality, accuracy, and compliance with business standards.

## Requirements

### Requirement 1

**User Story:** As an agent, I want to submit properties for approval so that my listings can be reviewed for quality before going live.

#### Acceptance Criteria

1. WHEN an agent submits a property through add-property.php THEN the system SHALL save the property with ApprovalStatus='Pending'
2. WHEN a property is saved with Pending status THEN the system SHALL display a confirmation message indicating the property is submitted for approval
3. WHEN an agent views their properties THEN the system SHALL display the approval status (Pending, Approved, Rejected) for each property
4. IF a property has Pending or Rejected status THEN the system SHALL NOT display it on public property listings

### Requirement 2

**User Story:** As an administrator, I want to review and approve pending properties so that only quality listings appear on the website.

#### Acceptance Criteria

1. WHEN an administrator accesses the approve-properties.php page THEN the system SHALL display all properties with their current approval status
2. WHEN an administrator clicks "Approve" on a pending property THEN the system SHALL update ApprovalStatus to 'Approved' and display success message
3. WHEN an administrator clicks "Reject" on a pending property THEN the system SHALL update ApprovalStatus to 'Rejected' and display success message
4. WHEN an administrator approves a property THEN the system SHALL make it visible in public property listings
5. WHEN an administrator rejects a property THEN the system SHALL keep it hidden from public listings but visible to the agent

### Requirement 3

**User Story:** As an administrator, I want to see detailed property information during approval so that I can make informed decisions.

#### Acceptance Criteria

1. WHEN an administrator views the approval page THEN the system SHALL display agent name, property title, type, location, and price for each property
2. WHEN an administrator clicks "View Details" THEN the system SHALL show complete property information including images and features
3. WHEN viewing property details THEN the system SHALL display submission date and agent contact information
4. IF a property has been rejected THEN the system SHALL allow administrators to change the status back to approved if needed

### Requirement 4

**User Story:** As an agent, I want to see why my property was rejected so that I can improve future submissions.

#### Acceptance Criteria

1. WHEN an administrator rejects a property THEN the system SHALL allow adding rejection comments
2. WHEN an agent views their rejected properties THEN the system SHALL display the rejection reason
3. WHEN a property is rejected THEN the system SHALL send a notification to the agent (email or system notification)
4. IF an agent wants to resubmit a rejected property THEN the system SHALL allow editing and resubmission

### Requirement 5

**User Story:** As a website visitor, I want to see only approved properties so that I can trust the quality of listings.

#### Acceptance Criteria

1. WHEN a visitor browses properties on the public website THEN the system SHALL only display properties with ApprovalStatus='Approved'
2. WHEN searching for properties THEN the system SHALL filter results to include only approved properties
3. WHEN viewing property details THEN the system SHALL only allow access to approved properties
4. IF a visitor tries to access a pending or rejected property directly THEN the system SHALL display "Property not found" message

### Requirement 6

**User Story:** As an administrator, I want to track approval statistics so that I can monitor system usage and agent performance.

#### Acceptance Criteria

1. WHEN an administrator accesses the dashboard THEN the system SHALL display counts of pending, approved, and rejected properties
2. WHEN viewing approval statistics THEN the system SHALL show approval rates by agent
3. WHEN generating reports THEN the system SHALL include approval timeline and processing times
4. WHEN filtering properties THEN the system SHALL allow filtering by approval status and date ranges