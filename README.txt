SEN305 STUDENT BIODATA - PHP + XAMPP

REQUIREMENTS
- XAMPP with Apache and MySQL
- A web browser

INSTALLATION
1. Extract the sen305_student_biodata folder into:
   C:\xampp\htdocs\

2. Open XAMPP Control Panel.
3. Start Apache and MySQL.
4. Open phpMyAdmin:
   http://localhost/phpmyadmin
5. Select the Import tab.
6. Choose the database.sql file from this project and click Import.
   This creates the student_registration database and its two tables.

7. Open the application:
   http://localhost/sen305_student_biodata/signup.php

HOW TO USE
1. Create an account on the signup page.
2. Log in using that account.
3. Complete and save the student biodata form.
4. Log out when finished.
5. Log in again to see the saved biodata.

DATABASE
Database: student_registration
Tables:
- users: account name, email and hashed password
- student_biodata: student biodata linked to a user

DEFAULT XAMPP DATABASE SETTINGS
Host: localhost
Database: student_registration
Username: root
Password: (blank)

If your MySQL root account has a password, update config.php.

NOTES
- Passwords are stored using PHP password_hash() and checked using password_verify().
- Database operations use PDO prepared statements.
- Each account can save one biodata record. Saving again updates that record.
- This is a local learning project. Configure HTTPS and additional protections before deploying it publicly.
