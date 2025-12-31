# Event Portal - Sitemap & Structure

## 1. Public Zone
Accessible to all visitors.
*   **Home Page (`index.php`)**: Landing page, Hero slider, Featured events teaser, Footer.
*   **Authentication**:
    *   **Login (`app/views/auth/login.php`)**: Role selection, Email/Password entry.
    *   **Register (`app/views/auth/register.php`)**: User registration with role selection (Student/Organization).

---

## 2. Student Portal
**Folder**: `/student/`
**Access**: Role 'student' only.

*   **Dashboard (`dashboard.php`)**: Welcome overview, Stats (Events Attended).
*   **Events (`events.php`)**: List of all approved events, Filter/Search Bar.
    *   **Event Details (`event-details.php?id=X`)**: Full description, Image, "Book Ticket" button.
*   **My Registrations (`my-registrations.php`)**: List of events the student has engaged with.
    *   **Ticket View (`ticket.php?id=X`)**: Printable QR Code ticket.
*   **Profile (`profile.php`)**: Edit personal info.

---

## 3. Organization Portal
**Folder**: `/organizer/`
**Access**: Role 'organization' only.

*   **Dashboard (`dashboard.php`)**: Overview of Created Events, Earnings, Total Tickets Sold.
*   **Create Event (`create-event.php`)**: Form to publish new events.
*   **My Events (`my-events.php`)**: List of own events (Approved/Pending/Rejected).
    *   **Participants List (`participants.php?event_id=X`)**: Table of users who bought tickets.
*   **Earnings (`earnings.php`)**: Financial report and Payout request.

---

## 4. Admin Portal
**Folder**: `/admin/`
**Access**: Role 'admin' only.

*   **Dashboard (`dashboard.php`)**: System-wide statistics (Total Users, Events, Revenue).
*   **User Management**:
    *   **Users List (`users.php`)**: View all users, Block/Unblock, Approve Organization documents.
*   **Event Management**:
    *   **Events List (`events.php`)**: View all events from all orgs.
    *   **Approve/Reject (`approve_event.php`)**: Moderation actions.
*   **Categories (`categories.php`)**: Add/Edit Event Categories.
*   **System (`settings.php`)**: Global configs.
