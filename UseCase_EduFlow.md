# EduFlow - Use Case Diagram

## System Overview
EduFlow is a comprehensive Learning Management System (LMS) that supports three main user roles: Students, Instructors, and Administrators. The system facilitates online education through course creation, content management, enrollment, and progress tracking.

## Use Case Diagram

```mermaid
graph TB
    %% Actors
    Student[👤 Student]
    Instructor[👨‍🏫 Instructor]
    Admin[🔧 Administrator]
    System[🖥️ System]
    
    %% Use Case Packages
    subgraph "Authentication & User Management"
        UC1[Register Account]
        UC2[Login/Logout]
        UC3[Email Verification]
        UC4[Password Reset]
        UC5[Manage Profile]
        UC6[OTP Verification]
    end
    
    subgraph "Course Management"
        UC7[Create Course]
        UC8[Edit Course]
        UC9[Delete Course]
        UC10[View Course Details]
        UC11[Browse Courses]
        UC12[Publish/Unpublish Course]
    end
    
    subgraph "Content Management"
        UC13[Create Module]
        UC14[Edit Module]
        UC15[Delete Module]
        UC16[Upload Video]
        UC17[Upload Document]
        UC18[Manage Content Order]
        UC19[Publish/Unpublish Content]
    end
    
    subgraph "Enrollment & Learning"
        UC20[Enroll in Course]
        UC21[Unenroll from Course]
        UC22[View Enrolled Courses]
        UC23[Access Course Content]
        UC24[Track Learning Progress]
        UC25[View Course Modules]
        UC26[Watch Videos]
        UC27[Download Documents]
    end
    
    subgraph "Communication & Interaction"
        UC28[Add Comments]
        UC29[Reply to Comments]
        UC30[Delete Comments]
        UC31[Create Announcements]
        UC32[View Announcements]
        UC33[Send Notifications]
    end
    
    subgraph "Administration"
        UC34[Manage Users]
        UC35[View Analytics]
        UC36[Monitor System]
        UC37[Manage Course Approvals]
        UC38[Generate Reports]
        UC39[System Configuration]
    end
    
    subgraph "Progress & Assessment"
        UC40[Track Course Progress]
        UC41[View Certificates]
        UC42[Monitor Student Progress]
        UC43[Generate Progress Reports]
    end
    
    %% Student Relationships
    Student --> UC1
    Student --> UC2
    Student --> UC3
    Student --> UC4
    Student --> UC5
    Student --> UC6
    Student --> UC11
    Student --> UC10
    Student --> UC20
    Student --> UC21
    Student --> UC22
    Student --> UC23
    Student --> UC24
    Student --> UC25
    Student --> UC26
    Student --> UC27
    Student --> UC28
    Student --> UC29
    Student --> UC32
    Student --> UC40
    Student --> UC41
    
    %% Instructor Relationships
    Instructor --> UC1
    Instructor --> UC2
    Instructor --> UC3
    Instructor --> UC4
    Instructor --> UC5
    Instructor --> UC6
    Instructor --> UC7
    Instructor --> UC8
    Instructor --> UC9
    Instructor --> UC10
    Instructor --> UC11
    Instructor --> UC12
    Instructor --> UC13
    Instructor --> UC14
    Instructor --> UC15
    Instructor --> UC16
    Instructor --> UC17
    Instructor --> UC18
    Instructor --> UC19
    Instructor --> UC22
    Instructor --> UC23
    Instructor --> UC25
    Instructor --> UC26
    Instructor --> UC27
    Instructor --> UC28
    Instructor --> UC29
    Instructor --> UC30
    Instructor --> UC31
    Instructor --> UC32
    Instructor --> UC33
    Instructor --> UC42
    Instructor --> UC43
    
    %% Admin Relationships
    Admin --> UC1
    Admin --> UC2
    Admin --> UC3
    Admin --> UC4
    Admin --> UC5
    Admin --> UC6
    Admin --> UC34
    Admin --> UC35
    Admin --> UC36
    Admin --> UC37
    Admin --> UC38
    Admin --> UC39
    Admin --> UC7
    Admin --> UC8
    Admin --> UC9
    Admin --> UC10
    Admin --> UC11
    Admin --> UC12
    Admin --> UC13
    Admin --> UC14
    Admin --> UC15
    Admin --> UC16
    Admin --> UC17
    Admin --> UC18
    Admin --> UC19
    Admin --> UC20
    Admin --> UC21
    Admin --> UC22
    Admin --> UC23
    Admin --> UC24
    Admin --> UC25
    Admin --> UC26
    Admin --> UC27
    Admin --> UC28
    Admin --> UC29
    Admin --> UC30
    Admin --> UC31
    Admin --> UC32
    Admin --> UC33
    Admin --> UC40
    Admin --> UC41
    Admin --> UC42
    Admin --> UC43
    
    %% System Relationships
    System --> UC3
    System --> UC4
    System --> UC6
    System --> UC33
    System --> UC39
    
    %% Include/Extend Relationships
    UC2 -.->|<<include>> UC6
    UC7 -.->|<<include>> UC12
    UC13 -.->|<<include>> UC19
    UC16 -.->|<<include>> UC19
    UC17 -.->|<<include>> UC19
    UC20 -.->|<<include>> UC24
    UC23 -.->|<<include>> UC24
    UC28 -.->|<<include>> UC33
    UC31 -.->|<<include>> UC33
```

## Detailed Use Case Descriptions

### Authentication & User Management

#### UC1: Register Account
- **Actor**: Student, Instructor
- **Description**: New users can create an account by providing personal information and selecting their role
- **Preconditions**: User is not logged in
- **Main Flow**: 
  1. User fills registration form with name, email, password, and role
  2. System validates input and creates account
  3. System sends email verification
  4. User receives confirmation

#### UC2: Login/Logout
- **Actor**: Student, Instructor, Admin
- **Description**: Users authenticate to access the system
- **Preconditions**: User has a valid account
- **Main Flow**:
  1. User enters email and password
  2. System validates credentials
  3. For non-admin users, system sends OTP
  4. User completes OTP verification
  5. System grants access to appropriate dashboard

#### UC3: Email Verification
- **Actor**: Student, Instructor
- **Description**: Users verify their email address to activate their account
- **Preconditions**: User has registered but email is unverified
- **Main Flow**:
  1. System sends verification code via email
  2. User enters verification code
  3. System marks email as verified

#### UC4: Password Reset
- **Actor**: Student, Instructor, Admin
- **Description**: Users can reset their password if forgotten
- **Preconditions**: User has a valid email address
- **Main Flow**:
  1. User requests password reset
  2. System sends reset link via email
  3. User clicks link and sets new password

#### UC5: Manage Profile
- **Actor**: Student, Instructor, Admin
- **Description**: Users can update their personal information
- **Preconditions**: User is logged in
- **Main Flow**:
  1. User accesses profile settings
  2. User updates information
  3. System saves changes

### Course Management

#### UC7: Create Course
- **Actor**: Instructor, Admin
- **Description**: Instructors can create new courses with detailed information
- **Preconditions**: User is logged in as instructor or admin
- **Main Flow**:
  1. Instructor fills course creation form
  2. System validates input
  3. System creates course and assigns instructor
  4. Course is set to draft status

#### UC8: Edit Course
- **Actor**: Instructor, Admin
- **Description**: Course creators can modify course information
- **Preconditions**: User is the course instructor or admin
- **Main Flow**:
  1. Instructor accesses course edit page
  2. Instructor modifies course details
  3. System saves changes

#### UC9: Delete Course
- **Actor**: Instructor, Admin
- **Description**: Course creators can remove courses from the system
- **Preconditions**: User is the course instructor or admin
- **Main Flow**:
  1. Instructor confirms deletion
  2. System removes course and all associated content
  3. System notifies enrolled students

#### UC10: View Course Details
- **Actor**: Student, Instructor, Admin
- **Description**: Users can view comprehensive course information
- **Preconditions**: Course exists and user has access
- **Main Flow**:
  1. User navigates to course page
  2. System displays course information, modules, and enrollment status
  3. User can see instructor details and course statistics

### Content Management

#### UC13: Create Module
- **Actor**: Instructor, Admin
- **Description**: Instructors can create learning modules within their courses
- **Preconditions**: User is course instructor or admin
- **Main Flow**:
  1. Instructor accesses module creation form
  2. Instructor provides module details and uploads content
  3. System creates module and organizes content
  4. Module is set to draft status

#### UC16: Upload Video
- **Actor**: Instructor, Admin
- **Description**: Instructors can upload video content to modules
- **Preconditions**: Module exists and user is instructor
- **Main Flow**:
  1. Instructor selects video file or provides URL
  2. System validates file format and size
  3. System processes and stores video
  4. Video is associated with module

#### UC17: Upload Document
- **Actor**: Instructor, Admin
- **Description**: Instructors can upload supporting documents
- **Preconditions**: Module exists and user is instructor
- **Main Flow**:
  1. Instructor selects document file
  2. System validates file type and size
  3. System stores document and metadata
  4. Document is associated with module

### Enrollment & Learning

#### UC20: Enroll in Course
- **Actor**: Student
- **Description**: Students can enroll in available courses
- **Preconditions**: Student is logged in and course is published
- **Main Flow**:
  1. Student views course details
  2. Student clicks enroll button
  3. System creates enrollment record
  4. Student gains access to course content

#### UC23: Access Course Content
- **Actor**: Student, Instructor, Admin
- **Description**: Enrolled users can access course materials
- **Preconditions**: User is enrolled or is course instructor
- **Main Flow**:
  1. User navigates to course modules
  2. System displays available content
  3. User can view videos, download documents, and track progress

#### UC24: Track Learning Progress
- **Actor**: Student, Instructor, Admin
- **Description**: System tracks and displays learning progress
- **Preconditions**: User is enrolled in courses
- **Main Flow**:
  1. System monitors content consumption
  2. System calculates completion percentages
  3. System displays progress metrics
  4. Users can view detailed progress reports

### Communication & Interaction

#### UC28: Add Comments
- **Actor**: Student, Instructor, Admin
- **Description**: Users can add comments to course modules
- **Preconditions**: User has access to module
- **Main Flow**:
  1. User navigates to module discussion
  2. User writes and submits comment
  3. System stores comment and notifies relevant users

#### UC31: Create Announcements
- **Actor**: Instructor, Admin
- **Description**: Instructors can create announcements for their courses
- **Preconditions**: User is course instructor or admin
- **Main Flow**:
  1. Instructor creates announcement
  2. System publishes announcement
  3. System notifies enrolled students

### Administration

#### UC34: Manage Users
- **Actor**: Admin
- **Description**: Administrators can manage all user accounts
- **Preconditions**: User is logged in as admin
- **Main Flow**:
  1. Admin views user list with filters
  2. Admin can edit user details, roles, and status
  3. Admin can delete users if necessary
  4. System applies changes and notifies affected users

#### UC35: View Analytics
- **Actor**: Admin
- **Description**: Administrators can view system-wide analytics
- **Preconditions**: User is logged in as admin
- **Main Flow**:
  1. Admin accesses analytics dashboard
  2. System displays user growth, course statistics, and enrollment data
  3. Admin can view detailed reports and charts

#### UC36: Monitor System
- **Actor**: Admin
- **Description**: Administrators can monitor system health and performance
- **Preconditions**: User is logged in as admin
- **Main Flow**:
  1. Admin accesses system monitoring tools
  2. System displays performance metrics and alerts
  3. Admin can take corrective actions if needed

### Progress & Assessment

#### UC40: Track Course Progress
- **Actor**: Student, Instructor, Admin
- **Description**: System tracks individual course completion
- **Preconditions**: User is enrolled in course
- **Main Flow**:
  1. System monitors module completion
  2. System calculates overall course progress
  3. System updates progress indicators
  4. Users can view detailed progress breakdown

#### UC41: View Certificates
- **Actor**: Student
- **Description**: Students can view earned certificates
- **Preconditions**: Student has completed courses
- **Main Flow**:
  1. Student accesses certificate section
  2. System displays earned certificates
  3. Student can download or share certificates

## System Boundaries

### Included Use Cases
- Email verification is included in registration
- OTP verification is included in login for non-admin users
- Content publishing is included in content creation
- Progress tracking is included in enrollment
- Notifications are included in comments and announcements

### Extended Use Cases
- System monitoring extends user management
- Analytics extend course management
- Progress tracking extends content access

## Key Features by Role

### Student Features
- Course enrollment and browsing
- Content consumption and progress tracking
- Communication through comments
- Certificate viewing
- Profile management

### Instructor Features
- Course creation and management
- Content upload and organization
- Student progress monitoring
- Announcement creation
- Communication management

### Administrator Features
- User management and role assignment
- System-wide analytics and monitoring
- Course oversight and approval
- System configuration
- Comprehensive reporting

This use case diagram provides a comprehensive view of the EduFlow system's functionality and user interactions, showing how different user roles interact with various system components to create a complete learning management experience. 