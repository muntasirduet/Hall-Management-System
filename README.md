# Hall Management System

A web-based Hall (Dormitory) Management System for university students built with PHP and MySQL. It supports three roles — **DSW (Director of Student Welfare)**, **Provost**, and **Student** — each with their own dedicated portal for managing hall admissions, room assignments, and student records.

---

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [User Roles](#user-roles)
- [Project Structure](#project-structure)
- [Database Schema](#database-schema)
- [Installation & Setup](#installation--setup)
- [Usage](#usage)
- [Screenshots](#screenshots)

---

## Features

- Student self-registration with academic details
- Role-based login and dashboard redirect
- Students can submit hall preferences (up to 4 choices)
- DSW reviews and approves student hall requests, sorted by CGPA and total credits
- DSW manages halls and provost accounts
- Provost manages room assignments for their assigned hall
- Students can request specific room seats after being accepted into a hall
- Provost approves seat requests and assigns rooms

---

## Tech Stack

| Layer      | Technology                      |
|------------|---------------------------------|
| Backend    | PHP 7+ (OOP, PDO)               |
| Database   | MySQL                           |
| Frontend   | Bootstrap 4.6, jQuery 3.6       |
| Server     | Apache / XAMPP / WAMP           |

---

## User Roles

| Role    | Role ID | Description                                                                 |
|---------|---------|-----------------------------------------------------------------------------|
| DSW     | 1       | Manages halls, provosts, and approves student hall admission requests       |
| Provost | 2       | Manages rooms and seat assignments within their assigned hall               |
| Student | 3       | Registers, requests a hall, and requests a room seat after hall acceptance  |

---

## Project Structure

```
Hall-Management-System/
├── index.php             # Login page
├── admin.php             # Post-login role-based redirect
├── regi.php              # Student registration form
│
├── inc/                  # Shared includes
│   ├── header.php        # Authenticated page header (Bootstrap, session check)
│   ├── login_header.php  # Unauthenticated page header
│   ├── admin_nav.php     # Role-aware navigation bar
│   └── footer.php        # Page footer
│
├── lib/                  # PHP class library
│   ├── Database.php      # PDO database connection
│   ├── Session.php       # Session helpers (init, get, set, destroy, checkSession)
│   ├── User.php          # User authentication, registration, hall status logic
│   ├── Student.php       # Student hall/room request logic
│   ├── Provost.php       # Room management logic for provosts
│   └── Dsw.php           # Hall and provost management logic for DSW
│
├── student/              # Student portal
│   ├── hallRequest.php   # Submit/view hall preferences
│   ├── seatRequest.php   # Submit/view room seat preferences
│   ├── Dashboard.php     # Student dashboard
│   ├── RegularStudent.php
│   ├── ReqStudent.php
│   └── edit.php
│
├── provost/              # Provost portal
│   ├── addmisson.php     # View pending student admissions
│   ├── showStudent.php   # List students in hall
│   ├── showRoom.php      # List rooms
│   ├── seat.php          # Add new seats/rooms
│   ├── student.php       # View individual student details
│   ├── getStudent.php    # AJAX student search
│   ├── getAllowStudent.php
│   ├── getRoomDetails.php
│   └── showAllowDetails.php
│
├── DSW/                  # DSW portal
│   ├── room.php          # Hall management (create, edit, delete)
│   ├── provost.php       # Provost management (create, edit, delete)
│   ├── request.php       # View and process hall admission requests
│   ├── requestDetails.php# View individual request details
│   └── getUser.php       # AJAX user lookup
│
└── img/                  # Static images (e.g., background)
```

---

## Database Schema

The application uses a MySQL database named `HALL_MANAGEMENT_SYSTEM`. Below are the key tables:

### `users`
| Column    | Type    | Description                          |
|-----------|---------|--------------------------------------|
| id        | INT     | User ID (matches student/provost ID) |
| email     | VARCHAR | Login email                          |
| password  | VARCHAR | Plain-text password                  |
| user_role | INT     | 1 = DSW, 2 = Provost, 3 = Student    |
| status    | INT     | 1 = pending, 2 = active              |

### `student`
| Column       | Type    | Description                        |
|--------------|---------|------------------------------------|
| student_id   | INT     | Primary key                        |
| firstname    | VARCHAR |                                    |
| lastname     | VARCHAR |                                    |
| email        | VARCHAR |                                    |
| phone_number | VARCHAR |                                    |
| father_name  | VARCHAR |                                    |
| mother_name  | VARCHAR |                                    |
| running_year | VARCHAR | Current academic year              |
| semister     | VARCHAR | Current semester                   |
| department   | VARCHAR |                                    |
| NID          | INT     | National ID number                 |
| blood_group  | VARCHAR |                                    |
| CGPA         | DECIMAL |                                    |
| total_credit | INT     |                                    |
| address      | TEXT    |                                    |
| status       | INT     | 1 = pending approval, 2 = approved |
| user_role    | INT     | Always 3 for students              |
| reg_date     | DATE    |                                    |
| password     | VARCHAR |                                    |
| hallStatus   | VARCHAR | pending / Accepted                 |

### `hall`
| Column      | Type    | Description          |
|-------------|---------|----------------------|
| hallID      | INT     | Primary key          |
| hallName    | VARCHAR | Name of the hall     |
| currentSeat | INT     | Number of seats used |

### `hallRequest`
| Column       | Type    | Description              |
|--------------|---------|--------------------------|
| studentID    | INT     | Foreign key → student    |
| firstChoice  | VARCHAR | 1st hall preference      |
| secondChoice | VARCHAR | 2nd hall preference      |
| thirdChoice  | VARCHAR | 3rd hall preference      |
| fourtChoice  | VARCHAR | 4th hall preference      |
| status       | VARCHAR | pending / Accepted       |

### `uniqueHall`
| Column     | Type    | Description            |
|------------|---------|------------------------|
| student_id | INT     | Foreign key → student  |
| hallName   | VARCHAR | Assigned hall          |
| status     | VARCHAR | pending / Accepted     |

### `provost`
| Column       | Type    | Description            |
|--------------|---------|------------------------|
| provostId    | INT     | Primary key            |
| provostName  | VARCHAR |                        |
| hallName     | VARCHAR | Assigned hall          |
| Department   | VARCHAR |                        |
| Designation  | VARCHAR |                        |
| mobileNumber | VARCHAR |                        |
| email        | VARCHAR |                        |
| PASS         | VARCHAR | Password               |

### `room`
| Column      | Type    | Description                  |
|-------------|---------|------------------------------|
| roomNumber  | VARCHAR | Primary key                  |
| totalSeat   | INT     | Capacity of the room         |
| currentSeat | INT     | Number of occupied seats     |
| hallName    | VARCHAR | Foreign key → hall           |

### `roomChoice`
| Column       | Type    | Description            |
|--------------|---------|------------------------|
| student_id   | INT     | Foreign key → student  |
| firstChoice  | VARCHAR | 1st room preference    |
| secondChoice | VARCHAR | 2nd room preference    |
| thirdChoice  | VARCHAR | 3rd room preference    |
| hallName     | VARCHAR | Hall the student is in |
| status       | VARCHAR | pending / Accepted     |

### `selectRoom`
| Column     | Type    | Description                   |
|------------|---------|-------------------------------|
| student_id | INT     | Foreign key → student         |
| roomNumber | VARCHAR | Assigned room                 |
| hallName   | VARCHAR | Hall                          |

---

## Installation & Setup

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- A local server environment such as [XAMPP](https://www.apachefriends.org/) or [WAMP](https://www.wampserver.com/)

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/muntasirduet/Hall-Management-System.git
   ```

2. **Place the project in your server's web root**
   - For XAMPP: `C:/xampp/htdocs/Hall-Management-System/`
   - For WAMP: `C:/wamp/www/Hall-Management-System/`

3. **Create the database**
   - Open [phpMyAdmin](http://localhost/phpmyadmin) or your MySQL client
   - Create a new database named `HALL_MANAGEMENT_SYSTEM`
   - Import the SQL schema (create the tables listed in [Database Schema](#database-schema))

4. **Configure the database connection**

   Open `lib/Database.php` and update the credentials if needed:
   ```php
   private $hostdb = "localhost";
   private $userdb  = "root";
   private $passdb  = "";
   private $namedb  = "HALL_MANAGEMENT_SYSTEM";
   ```

5. **Seed the DSW account**

   Insert a default DSW user directly into the `users` table:
   ```sql
   INSERT INTO users (id, email, password, user_role, status)
   VALUES (1, 'dsw@example.com', 'password123', 1, 2);
   ```

6. **Open the application**

   Navigate to `http://localhost/Hall-Management-System/` in your browser.

---

## Usage

### Student Workflow

1. Go to `regi.php` and fill in the registration form.
2. Log in at `index.php` — the account will initially be **pending** until approved by DSW.
3. Once approved, log in and submit hall preferences via **Req. for Hall**.
4. After DSW accepts the hall request, request a specific room via **Req. for Seat**.
5. The Provost will assign a room; the student can then view their assigned hall and room.

### DSW Workflow

1. Log in — redirected to `student/ReqStudent.php`.
2. Review pending student registrations and approve them.
3. Manage halls via **HALL** menu (create, edit, delete).
4. Manage provost accounts via **Provost** menu.
5. Review hall admission requests via **Hall Request** and assign students to halls.

### Provost Workflow

1. Log in — redirected to `provost/addmisson.php`.
2. View students assigned to your hall who are awaiting room assignment.
3. Manage rooms via **Show Room** and **Add New Seat** menus.
4. View and process student seat requests.

---

## Screenshots

> _Screenshots can be added here to illustrate the login page, student dashboard, DSW hall management, and provost room assignment views._
