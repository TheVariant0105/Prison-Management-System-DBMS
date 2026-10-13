# Prison Management System

A PHP and MySQL-based web application for managing prisoner records with separate administrator and officer access.

## Features

- User login and session-based authentication
- Role-based access for administrators and officers
- Add, view, edit and delete prisoner records
- Search prisoner records
- Store prisoner details such as name, age, crime, sentence duration, cell number and status
- Upload and display prisoner photos
- Dashboard displaying prisoner and cell statistics
- MySQL database integration

## Tech Stack

- **Frontend:** HTML, CSS, Bootstrap
- **Backend:** PHP
- **Database:** MySQL
- **Client-side scripting:** JavaScript and Bootstrap components

## Setup

1. Install XAMPP and start Apache and MySQL.
2. Copy the project folder into `htdocs`.
3. Create the required database in phpMyAdmin.
4. Import the SQL setup script from the `sql` directory.
5. Configure the database connection in `includes/db_connect.php`.
6. Open `http://localhost/PrisonDBMS/` in your browser.

## Security

The project uses session-based authentication and role checks to restrict access to administrative features. Review and strengthen database query handling, password storage, file-upload validation and authorization checks before deployment.
