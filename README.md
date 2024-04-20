# Secure PHP CRUD Application with Login and Register

This is a simple CRUD (Create, Read, Update, Delete) application built with PHP and MySQL. It also includes secure login and registration functionality, protected against common vulnerabilities such as SQL injection and cross-site scripting (XSS).

## Features

- Secure user authentication system with hashed passwords.
- Registration form with validation to prevent SQL injection and XSS attacks.
- Input validation and sanitization to protect against malicious inputs.
- CRUD operations for managing data in a MySQL database.

## Usage
- Login: Access the login page (login.php) and enter your credentials.
- Register: If you're a new user, click on the "Register" link to create a new account.
- CRUD Operations: Once logged in, you can perform CRUD operations on the data.
- Profile Page: You can view your profile with user information.

## Security
- SQL Injection: Prepared statements are used to prevent SQL injection attacks.
- Cross-Site Scripting (XSS): User inputs are sanitized using htmlspecialchars() to prevent XSS attacks.
- Password Hashing: Passwords are hashed using PHP's password_hash() function.
- Input Validation: Form inputs are validated to ensure data integrity and security.
- Session Management: Sessions are securely managed to prevent session hijacking.

## Contributing
Contributions are welcome! Feel free to submit bug reports, feature requests, or pull requests.
