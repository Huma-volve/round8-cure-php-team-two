Software Requirements Specification (SRS) for Doctor Appointment 
1. Introduction
1.1 Purpose
This document outlines the functional and non-functional requirements for the Doctor Appointment Mobile App, a platform connecting patients with doctors for bookings, consultations, and management. It ensures a secure, user-friendly experience with real-time interactions.
1.2 Scope
The system includes:
Mobile app for Patients (iOS/Android).
Web dashboard for Admins , helpers and Doctors.
Features: Registration/login, location-based doctor search, bookings, payments (PayPal, Stripe, Cash), reviews, real-time chat, notifications.
Integrations: OTP services, Google Auth, location APIs, WebSocket for chat.
Exclusions: Video consultations, medical records storage, insurance integrations.
Roles: Patient (self-registers), Doctor (admin-created), Admin/Helpers (manage system).
Backh,hhhh                      end: PHP with Laravel framework, MySQL/PostgreSQL database.
Scalability: Supports 10,000 initial users, cloud-hosted (e.g., AWS).
1.3 Definitions, Acronyms, and Abbreviations
OTP: One-Time Password
API: Application Programming Interface
SRS: Software Requirements Specification
UI/UX: User Interface/User Experience
RBAC: Role-Based Access Control
FCM/APNS: Firebase Cloud Messaging/Apple Push Notification Service
1.4 References
PayPal API: https://developer.paypal.com/docs/api/overview/
Stripe API: https://stripe.com/docs/api
Laravel Documentation: https://laravel.com/docs
Google Maps API: https://developers.google.com/maps
1.5 Overview
This SRS is organized by user roles (Patient, Doctor, Admin). Each role includes user stories, features, data models, flows, and acceptance criteria. The document is modular for easy updates.
2. Overall Description
2.1 Product Perspective
The app facilitates healthcare access by enabling patients to find and book doctors, with real-time chat and flexible payments. It competes with platforms like Zocdoc, emphasizing location-based services.
2.2 Product Functions
Patient: Register, search/book doctors, chat, manage profile.
Doctor: Manage availability/bookings, chat (accounts created by admin).
Admin: Create doctor accounts, manage users/bookings, oversee content.
2.3 User Classes
Patient: Tech-savvy mobile users, 18+.
Doctor: Verified professionals, manage schedules via app.
Admin/Helpers: System managers, access via web dashboard.
2.4 Operating Environment
Mobile: iOS 14+, Android 8+.
Web: Chrome, Firefox.
Backend: PHP (Laravel), MySQL/PostgreSQL.
2.5 Constraints
Security: HTTPS, JWT authentication, data encryption.
Compliance: GDPR/HIPAA for health data.
UI: Responsive, WCAG 2.1 compliant.
2.6 Assumptions
Users have reliable internet.
Third-party services (OTP, payments) are stable.
Admins manually verify doctor credentials.
3. Specific Requirements
3.1 Functional Requirements
3.1.1 Patient Role
Patients self-register via the mobile app.
User Stories
I want to register and activate my account securely to access the app.
I want multiple login options for convenience.
I want to recover my password easily if forgotten.
I want to find nearby doctors and manage favorites.
I want to search doctors by specialty/name and view search history.
I want notifications for bookings and updates.
I want to view doctor details and book with flexible payments.
I want to leave reviews/feedback post-session.
I want to manage bookings (filter, rebook).
I want to customize my profile/settings.
I want real-time chat with doctors.
Features
Registration and Activation:
Splash screen on app launch.
Sign up: mobile number, email, password, confirm password.
OTP sent to mobile for activation.
Login Options:
Mobile + OTP.
Google login.
Forgot Password:
Reset via mobile with OTP.
Home Page:
Show nearby doctors based on the patient's current location.
Add/remove doctors to favorites.
View favorites list.
Search:
Search by specialty/name.
Save search history.
Custom location search (separate API).
Notifications:
Upcoming bookings.
Cancellations. 
Doctor Details and Booking:
View: reviews, session price.
Book: select date/time, payment (PayPal, Stripe, Cash).,
Reviews and Feedback:
Write review (notifies doctor).
Submit session feedback.
Bookings Management:
View all bookings.
Filter by date.
Rebook with same doctor.
Profile and Settings:
Toggle notifications.
Manage payment methods.
View favorites, FAQs, privacy policy.
Logout.
Edit: name, mobile, birthdate, photo.
Settings: Change password, delete account.
Chat:
Real-time chat with doctors.
View conversations, unread counts.
Favorite/unfavorite chats.
Send text/image/video.
Data Models
User Account: عامة محتاجة validation message باي حاجة required
Mobile Number (string, required, unique) ال validation هنا ناقصة بالنسبة ال phone , email, password, confirm password
Email (string, required, unique)
Password (string, required, hashed)
Confirm Password (string, required during sign-up) وتكون hashed ايضا
Birthdate (date, optional)
Profile Photo (string/URL, optional)
Location (latitude/longitude, float, optional)
Booking:
Doctor ID (ID, required)
Date/Time (datetime, required)
Payment Method (enum: PayPal/Stripe/Cash, required)و كمان ف اوبشن ال credit cart
Status (enum: Pending/Confirmed/Cancelled/Rescheduled, required)
Review:
Rating (integer, 1-5, required)
Comment (string, optional)
Doctor ID (ID, required)
Chat Message:
Sender ID (ID, required)
Receiver ID (ID, required)
Content (string/URL, required)
Timestamp (datetime, auto-generated)
Read Status (boolean, default false)
Flows
Registration:
Splash screen → Sign Up (mobile, email, password, confirm).وال name
Submit → OTP to mobile.
Enter OTP → Account activated.
Login:
Enter mobile → OTP sent.ومحتاجة كمان ادخل البسورد
Enter OTP → Logged in.
Or Google login.
Booking:
Search/Select doctor → View details.
Choose date/time → Select payment.وبدخل كمان ال id بتاع الدكتور
Confirm → Notify doctor/patient.
Chat:
Select doctor → Open chat.
Send message (real-time via WebSocket).
Acceptance Criteria
Valid inputs create account; OTP sent within 10s.
Invalid email/mobile shows error.
OTP verifies only correct entry.
Google login works seamlessly.
Search returns accurate results (within 5km for location).
Notifications deliver (95% success).
Bookings prevent conflicts; payments process correctly.
3.1.2 Doctor Role
Admins create doctor accounts; credentials sent via email.
User Stories
I want to receive and activate my account securely.
I want secure login options.
I want to manage my profile/availability.
I want to view/manage bookings.
I want notifications for bookings/reviews/chats.
I want real-time chat with patients.
I want to view patient details/history.
I want to handle cancellations/reschedules.
I want earnings/reports.
I want to customize settings.
Features
Account Creation and Activation:
Admin enters mobile, email, specialty, license, temporary password.
Email sent with credentials and activation link/OTP.
First login requires password change.
Login Options:
Mobile + OTP.
Email + OTP.
Google login.
Forgot Password:
Reset via email/mobile with OTP.
Dashboard:
View upcoming bookings.
Set availability (date/time slots).
View patient queue.
Profile Management:
Edit: name, specialty, bio, photo, clinic address.
Set session price.
Bookings Management:
View bookings (incoming/past).
Accept/Decline/Cancel/Reschedule.
Filter by date/patient.
View payment status.
Notifications:
New bookings, reviews, chats, payments.
Chat:
Real-time with patients.
View conversations, unread counts.
Send text/image/video.
Archive/favorite chats.
Reviews:
View reviews.
Respond (optional).
Reports:
Earnings summary.
Booking history.
Settings:
Toggle notifications.
Change password.
Delete account.
Logout.
Data Models
Doctor Account:
Mobile Number (string, required, unique)
Email (string, required, unique)
Password (string, required, hashed)
Specialty (string, required)
License Number (string, required)
Clinic Location (latitude/longitude, float, required)
Session Price (float, required)
Availability Slots (array of datetime, required)
Temporary Password (string, auto-generated)
Booking (shared).
Chat Message (shared).
Flows
Account Creation:
Admin enters details.
System generates temporary password.
Email sent: "Account created. Email: [email], Password: [temp]. Change on login."
Doctor logs in, changes password.
Booking Management:
New booking notification.
View details → Accept/Reschedule/Cancel.
Update notifies patient.
Chat:
Similar to Patient.
Acceptance Criteria
Admin creates account; email delivers within 10s.
Doctor activates with temp password, must change on first login.
Invalid license allows admin edit/reject.
Bookings update correctly; notifications sent.
Chat maintains encryption, no message loss.
3.1.3 Admin Role (Including Helpers)
Admins manage via web dashboard.
User Stories
I want secure login to manage the platform.
I want to create/edit doctor accounts.
I want to manage users/bookings.
I want dashboards for stats/reports.
I want to handle content (FAQs, policies).
I want to monitor payments/disputes.
I want to assign helper roles.
I want notifications for critical events.
I want to manage settings/backups.
Features
Login:
Email/Password + 2FA (OTP).
User Management:
Create doctor accounts (send credentials via email).
View/search users.
Approve/edit/reject doctors.
Ban/suspend accounts.
Assign helpers with permissions.
Dashboard:
Stats: users, bookings, revenue.
Content Management:
Edit FAQs, privacy policy.
Broadcast announcements.
Bookings and Payments:
View bookings.
Handle refunds/disputes.
Payment reports.
Notifications:
System alerts.
Manual broadcasts.
Reports:
Export user/booking data.
Settings:
Change password.
Manage API keys.
Backups.
Logout.
Data Models
Admin Account:
Email (string, required)
Password (string, required)
Role (enum: Admin/Helper, required)
Permissions (array, e.g., ["create_doctor"], required)
System Logs:
Event Type (string, required)
Timestamp (datetime, auto)
User ID (ID, optional)
Flows
Doctor Creation:
Admin fills form (mobile, email, specialty, license).
Generate temp password.
Send email with credentials.
Doctor activates.
Dispute Handling:
View booking.
Resolve (refund/cancel).
Acceptance Criteria
Doctor creation sends email; credentials work.
Helper permissions restrict actions.
Reports are accurate.
RBAC prevents unauthorized access.
3.2 Non-Functional Requirements
Performance: API response < 2s, supports 100 concurrent users.
Security: Laravel Sanctum for auth, encrypted storage.
Usability: Mobile-first, intuitive UI.
Reliability: 99% uptime, daily backups.
Scalability: Laravel Vapor or AWS for scaling.
Maintainability: Modular Laravel code, documented.
4. Supporting Information
4.1 Risks and Mitigations
Risk: Payment failures – Mitigation: Laravel retry queues.
Risk: Data breach – Mitigation: HIPAA/GDPR compliance, encryption.
Risk: Scalability – Mitigation: Laravel caching, load balancing.
4.2 Appendices
API Endpoints (example):
POST /api/patient/register
POST /api/booking/create
GET /api/doctors/nearby
Tech Stack:
Backend: PHP (Laravel 12)
Database: MySQL
Real-time: Laravel Echo with WebSocket
Integrations: PayPal, Stripe, Google Maps, Twilio (OTP)

