# Event Portal - Project Documentation

## 1. Project Overview
**Event Portal** is a comprehensive, web-based platform designed to facilitate the creation, management, and participation in events. It serves as a bridge between **Event Organizers** (who create and host events) and **Attendees (Students/Public)** (who discover and register for events). 

The platform features a modern **Aesthetic UI (Dark/Glassmorphism Mode)**, role-based access control, and a robust database backend to ensure smooth operations for all user types.

---

## 2. User Roles & Features

The system supports three distinct user roles, each with a specialized dashboard and feature set:

### A. Student (Attendee)
The primary end-users of the platform.
*   **Registration & Login**: Secure account creation.
*   **Dashboard**: Overview of upcoming events and recent activities.
*   **Browse Events**: Search and filter events by category (Tech, Music, Sports, etc.) using dynamic (AJAX) search.
*   **Event Registration**: Seamlessly book tickets for free or paid events.
*   **My Tickets**: View registered events and access **QR Code Tickets** for entry.
*   **Profile Management**: Update personal details.

### B. Organization (Event Host)
Entities that wish to host events.
*   **Organization Profile**: Manage brand details and description.
*   **Create Events**: Post new events with rich details, images, venue, dates, and ticket prices.
*   **Manage Events**: Edit, delete, or view the status (Approved/Pending/Rejected) of their events.
*   **Participant Management**: View list of registered attendees for each event.
*   **Earnings & Payouts**: Track revenue from ticket sales and request admin payouts.

### C. Administrator (Superuser)
The guardian of the platform.
*   **Dashboard**: High-level statistics (Total Users, Events, Revenue).
*   **User Management**: View user lists, block/unblock users, and verify organizations.
*   **Event Moderation**: Review submitted events and Approve or Reject them (ensuring quality control).
*   **Category Management**: Add or edit event categories.
*   **Financial Oversight**: Process payout requests from organizations.
*   **System Settings**: Manage global site configurations.

---

## 3. Key Technical Features
*   **Dark Aesthetic Mode**: A toggleable, system-wide dark theme featuring high-contrast typography and "Glassmorphism" (translucent black panels) for a premium look.
*   **Role-Based Access Control (RBAC)**: Middleware ensures users can only access pages authorized for their specific role.
*   **Responsive Design**: optimizied for Desktops, Tablets, and Mobile devices.
*   **Dynamic Search**: Real-time event filtering without page reloads.
*   **Secure Authentication**: Password hashing (Bcrypt) and session management.

---

## 4. Database Schema
The application uses a relational MySQL database (`event_management_db`) with the following key tables:

### Core Tables
1.  **`users`**: Stores login credentials (`email`, `password`), `role`, and account status for all stats.
2.  **`organizations`**: Links to `users`; stores specific org details (`org_name`, `approval_status`, `document_path`).

### Event Management
3.  **`categories`**: LOOKUP table for event types (e.g., Technology, Health).
4.  **`events`**: The central table storing event metadata (`title`, `dates`, `venue`, `price`, `status`). Linked to `organizations`.
5.  **`event_images`**: Stores file paths for event banners/galleries.

### Participation & Finance
6.  **`registrations`**: Junction table linking `users` (students) to `events`. Tracks booking status.
7.  **`tickets`**: specific ticket details including unique `ticket_code` and `qr_code_path`.
8.  **`payments`**: Records transaction details for paid events.
9.  **`payouts`**: Tracks funds transferred from the platform to Organizations.

### System & Feedback
10. **`reviews`**: Allows students to rate and review events.
11. **`notifications`**: System alerts for users (e.g., "Event Approved").
12. **`admin_logs`**: Audit trail of admin actions.

---

## 5. Technology Stack
*   **Backend**: PHP (Native/Vanilla with MVC Pattern)
*   **Database**: MySQL
*   **Frontend**: HTML5, CSS3 (Custom + Bootstrap), JavaScript (jQuery for AJAX/Interactions)
*   **Fonts**: Google Fonts ('Outfit' for body, 'Tenor Sans' for headers)
