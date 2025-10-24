Simple Newspaper PHP

A dynamic newspaper website built with PHP, MySQL, Tailwind CSS, and vanilla JavaScript. It features a public-facing site displaying articles by category and a secure admin panel for managing content (articles and users).

Features

Dynamic Content: Articles fetched directly from a MySQL database.

Categorization: Articles organized into multiple categories (Local News, Technology, Sports, Business, etc.).

Featured Slider: Homepage features a dynamic slider for top articles.

Single Article View: Dedicated page to read the full content of each article.

Secure Admin Panel:

Login system with hashed passwords.

Role-based access (Admin, Moderator).

Article Management: Add, Edit, and Delete articles with image uploads.

User Management (Admin only): View users, change roles (Admin/Moderator), delete users.

Profile Settings: Users can change their own passwords.

Responsive Design: Adapts to various screen sizes (desktop, tablet, mobile).

Dark Mode: User-toggleable dark mode for comfortable viewing.

Tailwind CSS: Modern styling using the Tailwind CSS utility-first framework (compiled locally).

Prerequisites

XAMPP (or similar AMP stack): Provides Apache (webserver), MySQL (database), and PHP. Download from https://www.apachefriends.org/.

Git: For cloning the repository. Download from https://git-scm.com/.

Node.js and npm: Required to install Tailwind CSS dependencies and run the build script. Download from https://nodejs.org/.

Web Browser: Chrome, Firefox, Safari, Edge, etc.

Code Editor: VS Code, Sublime Text, etc.

Installation & Setup

Clone the Repository:
Open your terminal, navigate to your XAMPP htdocs directory (e.g., C:/xampp/htdocs/), and clone the project:

git clone [https://github.com/sifatmusfique/Simple_Newspaper-php.git](https://github.com/sifatmusfique/Simple_Newspaper-php.git)
cd Simple_Newspaper-php


Database Setup:

Start Apache and MySQL in the XAMPP Control Panel.

Open your web browser and go to http://localhost/phpmyadmin/.

Create a new database. Name it rajshahi_chronicle_db (or a name of your choice, but you'll need to update the config file accordingly).

Select the newly created database.

Click the "Import" tab.

Click "Choose File" and select the database.sql file located in the project's root directory.

Click "Go" or "Import" to create the articles and users tables and populate them with sample data.

Database Configuration:

Navigate to the config/ directory within your project.

Rename the file database.php.example to database.php.

Edit config/database.php and update the database credentials ($db, $user, $pass) to match your local MySQL setup (XAMPP defaults are usually $db = 'rajshahi_chronicle_db', $user = 'root', $pass = '').

Create Uploads Directory:

In the root of your project directory (the same level as index.php), create a new folder named uploads. The web server needs write permissions for this folder.

Install Dependencies & Build CSS:

Open your terminal inside the project's root directory (Simple_Newspaper-php).

Run npm install to install Tailwind CSS and its dependencies.

Run npm run build to compile the src/input.css into dist/output.css. Keep this terminal window open while developing; it will automatically rebuild the CSS when you make changes to HTML, PHP, JS, or the input.css file.

Running the Project

Ensure Apache and MySQL are running in XAMPP.

Open your web browser and navigate to: http://localhost/Simple_Newspaper-php/ (or the name you used for the project folder inside htdocs).

Admin Credentials

URL: http://localhost/Simple_Newspaper-php/admin/

Username: admin

Password: username@4 (or password123 if you used the alternative hash during setup)

You can also log in as moderator with the same password, but moderators cannot access User Management.
