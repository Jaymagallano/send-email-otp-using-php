# PHP Login and Registration System with Email OTP

This is a simple web-based login and registration system built with PHP, using Email OTP (One-Time Password) for verification.

## Features

*   User Registration with Email Verification
*   User Login with OTP Verification
*   Secure Password Hashing
*   OTP Generation and Expiration (5 minutes)
*   Simple Dashboard for Authenticated Users

## Prerequisites

Before running this project, make sure you have the following installed:

*   **XAMPP** (or any other web server with PHP and MySQL) - [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html)
*   **Composer** (for managing PHP dependencies) - [https://getcomposer.org/download/](https://getcomposer.org/download/)

## Setup

1.  **Clone or Download the Project:**
    ```bash
    git clone <repository_url>
    ```
    Or download the zip file and extract it.

2.  **Place Project in XAMPP htdocs:**
    Move the extracted project folder (e.g., `finalexam`) into your XAMPP's `htdocs` directory. The path should look something like `C:\xampp\htdocs\finalexam\`.

3.  **Start Apache and MySQL:**
    Open the XAMPP Control Panel and start the Apache and MySQL modules.

4.  **Database Setup:**
    *   Open your web browser and go to `http://localhost/phpmyadmin`.
    *   Go to the **SQL** tab.
    *   Copy the contents of the `database.sql` file from the project and paste it into the SQL editor.
    *   Click **Go** to create the database and tables.

5.  **Install Composer Dependencies:**
    *   Open your terminal or command prompt.
    *   Navigate to your project's root directory:
        ```bash
        cd C:\xampp\htdocs\finalexam
        ```
    *   Run the Composer install command:
        ```bash
        composer install
        ```
    This will install PHPMailer into the `vendor` directory.

6.  **Configure Email Settings:**
    *   Open the `utils/email.php` file in your project.
    *   Replace `'your.email@gmail.com'` with your actual Gmail address.
    *   Replace `'your-app-password'` with your Gmail App Password.
        *   *Note:* You need to enable 2-Step Verification and generate an App Password for your Google Account to use Gmail for sending emails. See [https://support.google.com/accounts/answer/185833](https://support.google.com/accounts/answer/185833) for instructions.

## Usage

1.  Open your web browser and go to `http://localhost/finalexam/register.php` to register a new account.
2.  After registration, you will be redirected to `verify_otp.php` to enter the OTP sent to your email.
3.  Once verified, you can go to `http://localhost/finalexam/login.php` to log in.
4.  Upon successful login, you will receive a new OTP via email and be directed to `verify_otp.php` again for login verification.
5.  After verifying the login OTP, you will be redirected to the dashboard (`dashboard.php`).

## File Structure

```
finalexam/
├── config/
│   └── database.php        # Database connection and configuration
├── utils/
│   └── email.php           # Email sending utility (using PHPMailer)
├── vendor/                 # Composer dependencies (PHPMailer, etc.)
├── composer.json           # Composer file
├── composer.lock
├── database.sql            # SQL file for database structure
├── register.php            # User registration page
├── verify_otp.php          # OTP verification page
├── login.php               # User login page
└── dashboard.php           # User dashboard (after login)
```

## Contributing

Feel free to fork this repository and contribute! 
