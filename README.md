# PHP Full Stack Library Management System

## Project Overview
The AAU Library Management System is a robust, full-stack web-based digital platform designed to streamline library operations, enhance user experience, and provide efficient resource management for academic institutions. This comprehensive solution empowers students and librarians with intuitive tools for book tracking, borrowing, and administrative management, ultimately supporting the academic community's research and learning objectives.

## Features
- Student Login and Authentication
- Librarian Login and Authentication
- Book Management System
- Book Borrowing System
- Charge Tracking

## Technology Stack
- PHP
- MySQL
- HTML
- CSS

## Database Structure

### Tables
1. **books**
   - Tracks library book inventory
   - Columns: id, title, version, publisher, publication_year, field, status

2. **student**
   - Stores student information
   - Columns: name, major, student_id, password

3. **borrowed**
   - Tracks book borrowing information
   - Columns: borrowID, password, bookID, borrowDate

4. **charges**
   - Manages late return charges
   - Columns: charge_id, student_password, book_id, return_date, charge_amount

5. **studentpass**
   - Stores student passwords
   - Columns: id, Password

## Setup Instructions
1. Install XAMPP or similar PHP development environment
2. Create a MySQL database named `library`
3. Import the `library.sql` file to set up database tables
4. Place project files in the `htdocs` directory
5. Start Apache and MySQL services
6. Access the application via `localhost/project_dir/index.php`

## Default Credentials
### Students
- Username: 1234567, Password: 12345
- Username: 233, Password: 55555

### Librarian
- Credentials to be set up during first login

## File Structure
- `index.php`: Landing page with login options
- `Login.php`: Student login page
- `LibrarianPage.php`: Librarian login page
- `AddBook.php`: Interface for adding new books
- `AddStudent.php`: Interface for adding new students
- `create_profile.php`: Student profile creation
- `db.php`: Database connection configuration
- `style.css`: Styling for web pages

## Security Notes
- Implement additional security measures for production
- Use prepared statements to prevent SQL injection
- Consider implementing password hashing

## Limitations
- Basic authentication system
- Minimal error handling
- No advanced user role management

## Future Improvements
- Implement secure password hashing
- Add more robust error handling
- Create a more comprehensive user management system
- Implement book search and filtering
- Add user profile management

## License
MIT License
