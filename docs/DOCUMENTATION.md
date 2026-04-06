# Hall Management System — Technical Documentation

## Table of Contents

1. [System Overview](#1-system-overview)
2. [Architecture](#2-architecture)
3. [Module Descriptions](#3-module-descriptions)
   - [Authentication & Session Management](#31-authentication--session-management)
   - [Student Module](#32-student-module)
   - [DSW Module](#33-dsw-module)
   - [Provost Module](#34-provost-module)
4. [Class Reference](#4-class-reference)
   - [Database](#41-database)
   - [Session](#42-session)
   - [User](#43-user)
   - [Student](#44-student)
   - [Provost](#45-provost)
   - [Dsw](#46-dsw)
5. [Page Reference](#5-page-reference)
6. [Database Tables](#6-database-tables)
7. [Request & Admission Workflow](#7-request--admission-workflow)
8. [Security Notes](#8-security-notes)

---

## 1. System Overview

The **Hall Management System** is a multi-role PHP web application designed to digitise the process of dormitory (hall) admission and room allocation for university students. It targets institutions where students must formally apply for on-campus accommodation through an administrative hierarchy.

**Three roles interact with the system:**

| Role    | ID | Responsibilities                                                        |
|---------|----|-------------------------------------------------------------------------|
| DSW     | 1  | Approve student registrations, manage halls and provost accounts, process hall admission requests |
| Provost | 2  | Manage rooms within their hall, process room seat requests from students |
| Student | 3  | Register, request a hall placement, request a room seat                 |

---

## 2. Architecture

The application follows a **procedural MVC-inspired structure** with PHP classes in `/lib` acting as the model/service layer, and PHP view files in the root and role-specific folders acting as controllers and views combined.

```
Browser
  │
  ▼
index.php / regi.php          ← Public pages (login, registration)
  │
  ▼
admin.php                     ← Post-login redirect dispatcher
  │
  ├──▶ student/               ← Student portal
  ├──▶ provost/               ← Provost portal
  └──▶ DSW/                   ← DSW portal

Each portal page:
  ├── includes inc/header.php   (initialises session, outputs HTML head)
  ├── includes inc/admin_nav.php (role-aware navigation)
  ├── uses lib/*.php classes     (data access)
  └── includes inc/footer.php   (closes HTML body)
```

**Database access** is exclusively through PDO prepared statements in the `/lib` classes, keeping SQL out of view files.

---

## 3. Module Descriptions

### 3.1 Authentication & Session Management

**Files involved:** `index.php`, `lib/User.php`, `lib/Session.php`, `inc/login_header.php`, `inc/header.php`

- `index.php` presents the login form. On POST, it calls `User::userAuthentication()`.
- `userAuthentication()` queries the `users` table, and on success writes the following session keys:

  | Key           | Value                                 |
  |---------------|---------------------------------------|
  | `login`       | `true`                                |
  | `id`          | User ID                               |
  | `email`       | User email                            |
  | `user_role`   | 1 (DSW), 2 (Provost), or 3 (Student) |
  | `login_status`| Account status from `users.status`   |

- If `users.status == 1` the account is still pending approval; a warning message is shown and the user is not redirected.
- If `users.status == 2`, the user is redirected to `admin.php`, which reads `user_role` from the session and issues a further redirect to the appropriate portal entry point.
- `inc/header.php` calls `Session::checkSession()` on every authenticated page to enforce access control.

**Registration (`regi.php`):** Students register themselves. A record is inserted into both the `student` table and the `users` table with `status = 1` (pending). DSW must approve the account before the student can log in fully.

---

### 3.2 Student Module

**Entry point:** `student/hallRequest.php` (after DSW approval)

**Hall Request Flow:**
1. Student opens the modal on `hallRequest.php` and selects up to 4 hall choices.
2. `Student::hallReques()` inserts a row into `hallRequest` with `status = 'pending'` and sets `student.hallStatus = 'pending'`.
3. The page displays the student's current choices and their status.
4. Once DSW accepts the request, `student.hallStatus` and `hallRequest.status` become `'Accepted'`, and a new entry appears in `uniqueHall`.
5. The navbar now shows a **Req. for Seat** link.

**Seat Request Flow (`student/seatRequest.php`):**
1. Student selects up to 3 room preferences within their assigned hall.
2. `Student::setRoomChoice()` inserts a row into `roomChoice` with `status = 'pending'`.
3. Provost reviews the request and assigns a room (see Provost module).
4. On acceptance, `selectRoom` is populated and `uniqueHall.status` / `roomChoice.status` become `'Accepted'`.

---

### 3.3 DSW Module

**Entry point:** `student/ReqStudent.php`

**Manage Halls (`DSW/room.php`):**
- Lists all halls from the `hall` table.
- DSW can create a new hall (modal form → `Dsw::create()`).
- Edit hall name (`Dsw::updateHall()`).
- Delete a hall (`Dsw::deleteHall()`).

**Manage Provosts (`DSW/provost.php`):**
- Lists all provosts from the `provost` table.
- DSW can add a new provost: inserts into `provost` and `users` (with `user_role = 2`, `status = 2`).
- Edit provost details (`Dsw::updateProvost()`).
- Delete a provost (`Dsw::deleteProvost()`).

**Hall Admission Requests (`DSW/request.php`):**
- Calls `Dsw::getStudentSort()` to retrieve students with `hallStatus = 'pending'` **sorted by `total_credit DESC, CGPA DESC`**, prioritising academically stronger students.
- DSW reviews each student and assigns them to a hall.
- On assignment, `User::setStudentHallStatus()` is called, which:
  - Inserts a row into `uniqueHall`
  - Updates `hallRequest.status` → `'Accepted'`
  - Updates `student.hallStatus` → `'Accepted'`
  - Increments `hall.currentSeat`

**Approve Student Registrations (`student/ReqStudent.php`):**
- Lists students with `status = 1` (pending).
- DSW can approve a student, calling `User::setStudentStatus()` which updates both `student.status` and `users.status` to `2`.

---

### 3.4 Provost Module

**Entry point:** `provost/addmisson.php`

Each provost is linked to exactly one hall (stored in `provost.hallName`). All provost actions are scoped to that hall.

**Admission (`provost/addmisson.php`):**
- Calls `Provost::getStudentByHall()` to list students in `uniqueHall` where `hallName` matches the logged-in provost's hall and `status = 'pending'`.
- The provost can search by student ID (AJAX via `provost/getStudent.php`).
- Clicking **view** opens `provost/student.php` with the student's full details and room assignment action.

**Room Management (`provost/showRoom.php`, `provost/seat.php`):**
- `Provost::getAllRoom()` lists rooms for the provost's hall.
- `Provost::addNewRoom()` inserts a new room into the `room` table.
- `Provost::updateRoom()` / `Provost::deleteRoom()` edit or remove rooms.

**Assign a Room Seat:**
- The provost views a student's room choices and confirms an assignment.
- `Student::setStudentSeatStatus()` is called with the chosen room, which:
  - Inserts into `selectRoom`
  - Updates `uniqueHall.status` → `'Accepted'`
  - Updates `roomChoice.status` → `'Accepted'`
  - Increments `room.currentSeat`

---

## 4. Class Reference

### 4.1 Database

**File:** `lib/Database.php`

Wraps a PDO connection. Constructed once per request by each service class.

| Property  | Default value            |
|-----------|--------------------------|
| `$hostdb` | `"localhost"`            |
| `$userdb` | `"root"`                 |
| `$passdb` | `""`                     |
| `$namedb` | `"HALL_MANAGEMENT_SYSTEM"` |
| `$pdo`    | PDO instance (public)    |

The connection uses `PDO::ERRMODE_EXCEPTION` and `utf8` character set.

---

### 4.2 Session

**File:** `lib/Session.php`

Static helper class for session operations.

| Method                    | Description                                                   |
|---------------------------|---------------------------------------------------------------|
| `Session::init()`         | Starts the PHP session                                        |
| `Session::set($key, $val)`| Sets `$_SESSION[$key]`                                        |
| `Session::get($key)`      | Returns `$_SESSION[$key]` or `null`                           |
| `Session::destroy()`      | Destroys the session                                          |
| `Session::checkSession()` | Redirects to `index.php` if the user is not logged in         |

---

### 4.3 User

**File:** `lib/User.php`

Handles authentication, registration, and hall status updates shared across roles.

| Method                        | Description                                                                 |
|-------------------------------|-----------------------------------------------------------------------------|
| `userRegistration($data)`     | Validates and inserts into `student` + `users`. Returns HTML alert string.  |
| `getLoginUser($email, $pass)` | Fetches user from `users` by email and password. Returns object or `false`. |
| `userAuthentication($data)`   | Validates credentials, sets session, redirects or returns alert string.     |
| `getAllStudent()`             | Returns all rows from `student`.                                            |
| `getStudentById($id)`        | Returns a single student row by `student_id`.                               |
| `setStudentStatus($data)`    | Sets `student.status` and `users.status` to `2` (approved).                |
| `getHallRequestById($data)`  | Returns a `hallRequest` row by `studentID`.                                 |
| `getSeat($data)`             | Returns a `hall` row by `hallName`; stores `currentSeat` in session.        |
| `setStudentHallStatus($data)`| Assigns student to a hall; updates `uniqueHall`, `hallRequest`, `student`, `hall`. |
| `getRoomById($data)`         | Returns a `selectRoom` row by `student_id`.                                 |

---

### 4.4 Student

**File:** `lib/Student.php`

Handles student-side hall and room request operations.

| Method                       | Description                                                                    |
|------------------------------|--------------------------------------------------------------------------------|
| `getRegularStudent()`        | Returns students with `status = 2`.                                            |
| `getReqStudent()`            | Returns students with `status = 1` (pending).                                  |
| `isFound($data)`             | Checks if a hall request exists for a student ID.                              |
| `hallReques($data)`          | Inserts hall preferences into `hallRequest`; sets `student.hallStatus = 'pending'`. |
| `getChoice()`                | Returns hall choices for the current session user.                             |
| `getAllHall()`                | Returns all halls.                                                             |
| `getHallById($data)`        | Returns `uniqueHall` row for a student ID.                                     |
| `setRoomChoice($data, $hall, $id)` | Inserts room preferences into `roomChoice`.                             |
| `getAllRoomByHall($data)`    | Returns all rooms for a given hall name.                                       |
| `getSeatChoiceById($data)`   | Returns `roomChoice` row for a student ID.                                     |
| `getStudentById($data)`      | Returns `student` row by ID.                                                   |
| `getSeat($data)`             | Returns `room` row by room number; stores `currentSeat` in session.            |
| `setStudentSeatStatus($data)`| Assigns room to student; updates `selectRoom`, `uniqueHall`, `roomChoice`, `room`. |
| `getRoomSeat($data)`         | Returns `selectRoom` row for a student ID.                                     |

---

### 4.5 Provost

**File:** `lib/Provost.php`

Handles room management within a provost's hall.

| Method                    | Description                                              |
|---------------------------|----------------------------------------------------------|
| `getStudentByHall($data)` | Returns `uniqueHall` rows for a given hall name.         |
| `getProvostById($data)`   | Returns `provost` row by provost ID.                     |
| `addNewRoom($data, $hall)`| Inserts a new room into the `room` table.                |
| `getAllRoom($data)`        | Returns all rooms for a given hall.                      |
| `updateRoom($data)`       | Updates room seat counts.                                |
| `deleteRoom($data)`       | Deletes a room from the `room` table.                    |
| `getRoomNumber($data)`    | Returns all rooms for a hall (used to populate dropdowns). |

---

### 4.6 Dsw

**File:** `lib/Dsw.php`

Handles hall and provost management for the DSW role.

| Method                  | Description                                                          |
|-------------------------|----------------------------------------------------------------------|
| `create($data)`         | Inserts a new hall into `hall`.                                      |
| `getAllHall()`           | Returns all halls.                                                   |
| `updateHall($data)`     | Updates a hall's name.                                               |
| `deleteHall($data)`     | Deletes a hall by ID.                                                |
| `addNewProvost($data)`  | Inserts into `provost` + `users` (role 2, status 2).                 |
| `getAllProvost()`        | Returns all provost records.                                         |
| `updateProvost($data)`  | Updates provost details.                                             |
| `deleteProvost($data)`  | Deletes a provost by ID.                                             |
| `getRequest()`          | Returns all rows from `hallRequest`.                                 |
| `getStudentSort()`      | Returns students with `hallStatus = 'pending'` sorted by total credit and CGPA (descending). |

---

## 5. Page Reference

### Public Pages

| Page        | Description                                  |
|-------------|----------------------------------------------|
| `index.php` | Login form for all users                     |
| `regi.php`  | Student self-registration form               |

### Student Pages (`student/`)

| Page               | Description                                        |
|--------------------|----------------------------------------------------|
| `hallRequest.php`  | Submit hall preferences; view current request status |
| `seatRequest.php`  | Submit room preferences after hall acceptance      |
| `Dashboard.php`    | Student dashboard                                  |
| `RegularStudent.php` | List of approved students (used by DSW via nav)  |
| `ReqStudent.php`   | List of pending student registrations (DSW entry point) |
| `edit.php`         | Edit student record                               |

### Provost Pages (`provost/`)

| Page                 | Description                                        |
|----------------------|----------------------------------------------------|
| `addmisson.php`      | List pending students for the provost's hall       |
| `showStudent.php`    | List all students in the hall                      |
| `showRoom.php`       | List all rooms; manage rooms                       |
| `seat.php`           | Add a new room/seat                                |
| `student.php`        | View individual student profile and assign room    |
| `getStudent.php`     | AJAX endpoint for student search by ID             |
| `getAllowStudent.php` | Retrieve allowed (accepted) students              |
| `getRoomDetails.php` | Retrieve room details                             |
| `showAllowDetails.php` | Show room allocation details                    |

### DSW Pages (`DSW/`)

| Page               | Description                                      |
|--------------------|--------------------------------------------------|
| `room.php`         | Hall CRUD (create, edit, delete)                 |
| `provost.php`      | Provost CRUD                                     |
| `request.php`      | View hall admission requests; assign halls       |
| `requestDetails.php`| Detailed view of a specific hall request        |
| `getUser.php`      | AJAX endpoint for user lookup                    |

---

## 6. Database Tables

Refer to the [Database Schema section in README.md](../README.md#database-schema) for full column-level documentation of all tables:

- `users`
- `student`
- `hall`
- `hallRequest`
- `uniqueHall`
- `provost`
- `room`
- `roomChoice`
- `selectRoom`

---

## 7. Request & Admission Workflow

```
Student registers (regi.php)
        │
        ▼
DSW approves registration
(student/ReqStudent.php → User::setStudentStatus)
        │
        ▼
Student logs in and submits hall preferences
(student/hallRequest.php → Student::hallReques)
        │
        ▼
DSW reviews requests sorted by CGPA / total credits
(DSW/request.php → Dsw::getStudentSort)
        │
        ▼
DSW assigns student to a hall
(User::setStudentHallStatus)
 → inserts into uniqueHall (status=pending)
 → sets hallRequest.status = 'Accepted'
 → sets student.hallStatus = 'Accepted'
 → increments hall.currentSeat
        │
        ▼
Student submits room seat preferences
(student/seatRequest.php → Student::setRoomChoice)
        │
        ▼
Provost reviews seat requests
(provost/student.php → Student::setStudentSeatStatus)
 → inserts into selectRoom
 → sets uniqueHall.status = 'Accepted'
 → sets roomChoice.status = 'Accepted'
 → increments room.currentSeat
        │
        ▼
Student has an assigned hall and room
```

---

## 8. Security Notes

> The following issues are present in the current codebase and should be addressed before deploying in a production environment.

1. **Plain-text passwords** — Passwords are stored and compared as plain text in the `users`, `student`, and `provost` tables. Use `password_hash()` / `password_verify()` (bcrypt) instead.

2. **No CSRF protection** — Forms do not use CSRF tokens. Add a hidden token field and validate on the server side.

3. **Session fixation** — Call `session_regenerate_id(true)` immediately after a successful login to prevent session fixation attacks.

4. **Input validation** — Several numeric fields (e.g., `student_id`, `NID`) are cast to `int`, but string fields are not sanitised beyond being bound via PDO. Consider adding stricter server-side validation.

5. **Error messages** — PDO errors bubble up directly to the browser (`die("Failed to connect with Database".$e->getMessage())`). In production, log errors server-side and show a generic message to the user.

6. **Database credentials** — Credentials are hard-coded in `lib/Database.php`. Use environment variables or a configuration file excluded from version control.
