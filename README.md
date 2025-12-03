

# **Digital Library System – Setup Guide**

This project is a secure PHP + MySQL web application for user registration, login, book browsing, searching/filtering, borrowing books, returning borrowed items, and viewing personal borrowing history.

It follows secure development practices using prepared statements, password hashing, session handling, and server-side validation.

---

# **1. Requirements**

Before running the project, ensure:

* **XAMPP** is installed
* **Apache** is ON
* **MySQL** is ON
* phpMyAdmin is accessible at:

```
http://localhost/phpmyadmin
```

---

# **2. Project Installation**

1. Place the project folder inside:

```
C:\xampp\htdocs\web-project
```

2. Confirm your folder structure matches:

```
web-project/
│
├── index.php
├── books.php
├── book_details.php
├── login.php
├── register.php
├── my_borrowings.php
│
├── action/
│   ├── borrow_book.php
│   ├── logout.php
│   ├── process_register.php
│   ├── process-login.php
│   └── return_book.php
│
├── config/
│   └── database.php
│
├── database/
│   ├── database.php
│   ├── userDAO.php
│   ├── bookDAO.php
│   └── borrowingDAO.php
│
├── partials/
│   └── navbar.php
│
├── css/
│   └── style.css
│
├── js/
│   ├── login.js
│   └── signup.js
│
└── webProject_schema.sql
```

3. Start XAMPP:

* **Apache** → ON
* **MySQL** → ON

---

# **3. Import the Database**

1. Open phpMyAdmin
2. Click **New** → create database:

```
digital_library_db
```

3. Open **Import** tab
4. Upload and import:

```
webProject_schema.sql
```

5. Click **Go**

This loads the following tables:

* `users`
* `books`
* `borrowings`

---

# **4. Project Folder Structure Explanation**

```
web-project/
│
├── index.php               → Home page (hero section)
├── books.php               → Book catalog + search/filter
├── book_details.php        → Single book view + Borrow button
├── login.php               → User login page
├── register.php            → New user registration
├── my_borrowings.php       → View & return borrowed books
│
├── partials/
│   └── navbar.php          → Shared navigation bar (dynamic)
│
├── action/                 → Server-side handlers (POST actions)
│   ├── process_register.php → Handles user signup
│   ├── process-login.php    → Handles user authentication
│   ├── borrow_book.php      → Creates new borrowing
│   ├── return_book.php      → Marks borrowing as returned
│   └── logout.php           → Ends session
│
├── config/
│   └── database.php        → DB credentials + PDO config
│
├── database/               → PDO + Data Access Objects
│   ├── database.php        → Singleton PDO wrapper
│   ├── userDAO.php         → Users table logic
│   ├── bookDAO.php         → Books table logic
│   └── borrowingDAO.php    → Borrowings table logic
│
├── css/
│   └── style.css           → Global styles, cards, grids, navbar
│
├── js/
│   ├── login.js            → (Optional) client-side validation
│   └── signup.js           → (Optional) client-side validation
│
└── webProject_schema.sql   → Database schema
```

---

# **5. How to Run the System**

After Apache and MySQL are running, open your browser:

```
http://localhost/web-project/
```

or go directly to:

```
http://localhost/web-project/books.php
```

---

# **6. Step-by-Step Usage**

### **1. Register a New User**

Open:

```
http://localhost/web-project/register.php
```

Fill out:

* Full name
* Email
* Password

System checks:

* Required fields
* Email format
* Password hashing
* Duplicate email prevention

---

### **2. Login**

Visit:

```
http://localhost/web-project/login.php
```

Enter your registered email and password.
System validates credentials using:

* `userDAO->getUserByEmail()`
* `password_verify()` against stored hash

---

### **3. Browse Books**

Go to:

```
http://localhost/web-project/books.php
```

Features include:

* Search by **title, author, ISBN**
* Filter by **category**
* View full book details

---

### **4. View Book Details & Borrow**

Open any title:

```
book_details.php?id=BOOK_ID
```

If logged in and the book is marked **available**:

* A *Borrow This Book* button appears
* Request is processed via `borrow_book.php`

The system prevents:

* Borrowing same book twice (active loan rule)
* Borrowing unavailable books

---

### **5. View Your Borrowed Books**

```
http://localhost/web-project/my_borrowings.php
```

You can:

* See all your borrowings
* See borrow + return timestamps
* Return an active borrowing

Returns are processed through:

```
action/return_book.php
```

---

### **6. Logout**

```
action/logout.php
```

Destroys session and returns to home.

---

# **7. Security Practices Implemented**

Consistent with CYB325 secure development requirements :

### **Client-Side**

* Clean UI with semantic HTML5
* JavaScript validation (required fields, formats)

### **Server-Side**

* Strict server-side validation for all inputs
* PDO with prepared statements → prevents SQL injection
* Password hashing using `password_hash()`
* Safe session usage
* Output escaping using `htmlspecialchars()`

---