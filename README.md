# Client-Handle-Table

A simple PHP and MySQL-based client management system to create, edit, view, and delete client records.

## Features
- Add new clients with name, email, phone, and address
- Edit client details
- Delete client records
- View a list of all clients
- Uses MySQL for data storage
- Bootstrap for responsive UI

## Technologies Used
- PHP
- MySQL
- Bootstrap 5
- XAMPP (for local development)

## Installation

### Prerequisites
Make sure you have the following installed:
- [XAMPP](https://www.apachefriends.org/download.html) (or a similar LAMP/MAMP/WAMP stack)

### Steps
1. Clone the repository:
   ```sh
   git clone https://github.com/MohdRaza216/Client-Handle-Table.git
   ```
2. Move the project to your XAMPP `htdocs` directory:
   ```sh
   mv Client-Handle-Table /xampp/htdocs/
   ```
3. Start Apache and MySQL from the XAMPP control panel.
4. Create a database:
   - Open `phpMyAdmin` (http://localhost/phpmyadmin/)
   - Create a new database named `myclients`
   - Import the `myclients.sql` file (if provided) to set up the table structure.
5. Configure database connection:
   - Open `config.php` (or edit connection variables in relevant files)
   - Ensure database credentials match your local MySQL setup:
     ```php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $database = "myclients";
     ```
6. Run the project:
   - Open your browser and go to: `http://localhost/Client-Handle-Table/`

## Usage
- Navigate to `index.php` to see all clients.
- Use the "Add Client" form to insert a new client.
- Click "Edit" to modify existing client details.
- Click "Delete" to remove a client.

## Security Improvements
- SQL injection protection using prepared statements.
- Input validation to ensure data integrity.

## Contributing
Pull requests are welcome! Follow these steps to contribute:
1. Fork the repository.
2. Create a new branch (`git checkout -b feature-name`).
3. Commit your changes (`git commit -m "Add feature"`).
4. Push to the branch (`git push origin feature-name`).
5. Open a Pull Request.

## License
This project is open-source and available under the [MIT License](LICENSE).

## Contact
For any issues or feature requests, open an issue on GitHub or contact me at `mohdrazamoghul2024@example.com`.

---
Happy coding! 🚀

