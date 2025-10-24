Simple Newspaper PHP

A dynamic, responsive newspaper website built with PHP, MySQL, Tailwind CSS, and vanilla JavaScript. Features include categorized articles, a featured slider, a secure admin panel with CRUD operations for articles, user management (Admin/Moderator roles), image uploads, and a dark mode toggle.

✨ Live Demo

Check out the live version: https://sifatmusfique.unaux.com/news

🚀 Features

Dynamic Content: Articles fetched directly from a MySQL database.

Categorization: Articles organized into multiple categories (Local News, Technology, Sports, Business, etc.).

Featured Slider: Homepage features an automated SwiperJS slider for top articles.

Single Article View: Dedicated page to read the full content of each article.

Secure Admin Panel:

Login system with securely hashed passwords (password_verify).

Role-based access control (Admin, Moderator).

Article Management: Add, Edit, and Delete articles via a modal interface.

Image Uploads: Direct image file uploads handled by the backend.

User Management (Admin only): View users, change roles (Admin/Moderator), delete users (excluding the primary admin).

Profile Settings: Logged-in users can securely change their own passwords.

Responsive Design: Adapts seamlessly to desktops, tablets, and mobile devices using Tailwind CSS.

Dark Mode: User-toggleable dark/light theme preference saved in local storage.

Modern Frontend: Built with Tailwind CSS (utility-first) and vanilla JavaScript for interactivity.

🛠️ Tech Stack

Backend: PHP

Database: MySQL / MariaDB

Frontend: HTML, Tailwind CSS, Vanilla JavaScript

Development Tools: Node.js, npm (for Tailwind CSS build process), Git

Server Environment (Typical): Apache (or Nginx), MySQL, PHP (e.g., XAMPP, WAMP, MAMP, LAMP)

⚙️ Local Setup and Installation

Follow these steps to run the project on your local machine:

Prerequisites:

Install XAMPP (or another AMP stack).

Install Git.

Install Node.js and npm.

Clone the Repository:
Open your terminal, navigate to your XAMPP htdocs directory (e.g., C:/xampp/htdocs/), and run:

git clone [https://github.com/sifatmusfique/Simple_Newspaper-php.git](https://github.com/sifatmusfique/Simple_Newspaper-php.git)
cd Simple_Newspaper-php


Database Setup:

Start Apache and MySQL from the XAMPP Control Panel.

Go to http://localhost/phpmyadmin/.

Create a new database (e.g., rajshahi_chronicle_db).

Select the database, go to the Import tab.

Upload and execute the database.sql file (located in the project root) to create tables and add sample data.

Configure Database Connection:

Go to the config/ directory.

Rename database.php.example to database.php.

Edit database.php and enter your local database name, username (usually root), and password (usually empty for XAMPP).

Create Uploads Folder:

In the project's root directory, create a folder named uploads. Ensure your web server has permission to write files into this folder.

Install Frontend Dependencies & Build CSS:

In your terminal (inside the project root Simple_Newspaper-php), run:

npm install
npm run build 


Keep the npm run build process running during development to automatically recompile CSS changes.

▶️ Running the Project Locally

Ensure Apache and MySQL are running in XAMPP.

Open your browser and navigate to: http://localhost/Simple_Newspaper-php/ (adjust the folder name if you changed it).

🔑 Admin Access

Admin URL: http://localhost/Simple_Newspaper-php/admin/

Default Credentials:

Username: admin

Password: admin@1234

Username: moderator

Password: mod@1234

📄 License

This project is licensed under the MIT License - see the LICENSE file for details (if one exists).


**Next Steps:**

1.  **Save this content** into a file named `README.md` in the root directory of your `Simple_Newspaper-php` project.
2.  **Stage and commit** the new `README.md` file using Git:
    ```bash
    git add README.md
    git commit -m "Update README with professional details and live demo link"
    ```
3.  **Push the changes** to your GitHub repository:
    ```bash
    git push origin main
