# Digital Recipe Book (RecipeRealm)
**Course:** ICT 1209 - Web Technologies  
**Department:** Department of ICT, Faculty of Technology, Rajarata University of Sri Lanka  
**Project Title:** Interactive Digital Recipe Book Web Application

---

## 1. Project Overview & Features
RecipeRealm is an interactive, fully responsive web application built with HTML5, CSS3, Bootstrap 5, JavaScript, PHP, and MySQL. It enables food enthusiasts to discover, categorize, and submit homemade culinary recipes.

### Frontend Features:
- **Responsive Layout:** Built with Bootstrap 5 grid, responsive navbar, and cards.
- **Interactive Carousel / Image Slider:** Hero banner showcasing featured dishes.
- **Dynamic Content Updates & Search:** Real-time recipe title search and category filtering with JavaScript DOM manipulation.
- **Smooth Scrolling:** Smooth anchor transitions to recipe catalogs.
- **Client-Side Validation:** HTML5 and JavaScript form validation on all inputs.

### Backend Features:
- **Relational Database Design:** MySQL database with `users`, `recipes`, and `messages` tables.
- **Secure Authentication:** User registration and login using `password_hash()` (Bcrypt) and PHP session management (`$_SESSION`).
- **CRUD Functionality:** Logged-in users can publish and delete their recipes.
- **Contact Message Processing:** Functional contact form storing customer feedback with prepared statements to prevent SQL Injection.

---

## 2. Directory Structure
```text
recipe_book/
│
├── css/
│   └── style.css            # Custom CSS styles
├── js/
│   └── main.js              # JavaScript for dynamic search, filter, and smooth scroll
├── images/                  # Local assets or icons
├── includes/
│   ├── db.php               # PDO MySQL database connection
│   └── functions.php        # Input sanitization and authentication helpers
├── auth/
│   ├── register.php         # User registration form & logic
│   ├── login.php            # User authentication & session startup
│   └── logout.php           # Session destruction & redirect
├── contact.php              # Contact form & database message logging
├── index.php                # Homepage with carousel and dynamic recipe filter
├── dashboard.php            # Protected chef dashboard for recipe creation
├── database.sql             # Complete database schema and seed data
└── README.md                # Project documentation and setup guide
```

---

## 3. Installation & Setup Instructions

### Prerequisites:
- **XAMPP** or **WAMP** server with Apache and MySQL services running.
- Web browser (Chrome / Edge / Firefox).

### Step-by-Step Setup:
1. **Download / Clone Project:**
   Place the `recipe_book` folder into your local server root:
   - For XAMPP: `C:\xampp\htdocs\recipe_book\`
   - For WAMP: `C:\wamp64\www\recipe_book\`

2. **Import Database:**
   - Open **phpMyAdmin** in your browser (`http://localhost/phpmyadmin/`).
   - Create a new database named `recipe_book` (utf8mb4).
   - Click on the **Import** tab.
   - Choose the file `database.sql` located inside the project root folder.
   - Click **Go** / **Import** to create all tables and sample records.

3. **Database Configuration (If Necessary):**
   - Verify connection settings in `includes/db.php`:
     ```php
     $host     = 'localhost';
     $dbname   = 'recipe_book';
     $user     = 'root';
     $password = ''; 
     ```

4. **Run the Web Application:**
   - Open your browser and navigate to:
     `http://localhost/recipe_book/index.php`

5. **Default Demo Account:**
   - **Username:** `demo_chef`
   - **Password:** `password123`
   - (Or create a new account via the Register page).
