# DriveMarket


DriveMarket is a PHP-based car sales web application that allows users to browse car listings, search for cars, rate and comment on cars, make offers, book test drive appointments, and manage activity based on their role.

The system includes three user roles:

- Viewer
- Creator
- Admin

This README explains how to run the project using **Apache NetBeans IDE 29** and how to import the database using **phpMyAdmin** with the provided SQL file.

---

## Programs Used

Install these on your machine:

- **Apache NetBeans IDE 29**
- **XAMPP** or any local PHP/MySQL environment
- **phpMyAdmin**
- A web browser such as **Chrome**, **Edge**, or **Brave**

---

## Setup and Run Guide

### 1. Get the Project

- Download the repository as a ZIP from GitHub and extract it, **or**
- Clone it:

```bash
git clone <REPO_URL>
```

After downloading or cloning, make sure the project folder is available on your machine.

---

### 2. Open the Project in Apache NetBeans IDE 29

1. Open **Apache NetBeans IDE 29**.
2. Go to **File → Open Project** or **Open File/Folder** depending on your setup.
3. Select the **DriveMarket** project folder.
4. Make sure NetBeans recognizes it as a **PHP application**.
5. Wait for the project files to load completely.

---

### 3. Import the Database in phpMyAdmin

1. Open **phpMyAdmin** in your browser.
2. Create a new database or use you own database but make sure that there is no tables that names conflict.
   - You may name it according to your project setup, for example mine is:
   ```text
   db202301830
   ```
3. Open the new database.
4. Click the **Import** tab.
5. Choose the SQL file provided with the project:
   ```text
   Script.sql
   ```
   If your submission file is named differently, use that SQL file instead.
6. Click **Go** to import the database.

This will import:
- tables
- all sample data
- stored procedure
- triggers
- indexes

---

### 4. Check the Database Import

After importing, confirm that the database contains the all six project tables , which name as:

- `dbProj_users`
- `dbProj_cars`
- `dbProj_comments`
- `dbProj_ratings`
- `dbProj_offers`
- `dbProj_appointments`

Also confirm that the database includes:

- stored procedure:
  - `sp_GetCarsByCreator`
- triggers:
  - `trg_prevent_duplicate_rating`
  - `trg_prevent_duplicate_offer`

---

### 5. Configure the Database Connection

Open the project files in NetBeans and check the database connection file:

```text
config/db.php
```

Make sure the database configuration matches your local setup, especially:

- host
- username
- password
- database name


Example values may look like:

```php
localhost
root
''
db202301830
```

Adjust them if your local MySQL setup is different.

---

### 6. Place the Project in the Correct Web Directory

Move or keep the project folder inside your web server directory if required by your setup.

For example, if you use XAMPP, place it inside:

```text
htdocs
```

the path is:

```text
C:\xampp\htdocs
```


If your environment uses a university server (PHPAdmin) path or another local server path, keep it in the correct location for that setup.

---

### 7. Run the Project from NetBeans

Make sure the Run Configuration is set to run as **Local Web Site**,
 and the **Project URL** is set to:
 
```text
http://localhost/IT8415_DriveMarket-main/
```

Index File should be :

```text
index.php
```

1. In **Apache NetBeans IDE 29**, right-click the project.
2. Choose **Run**.
3. NetBeans will open the project in your browser.

You can then access the website pages such as:

- Home page
- Cars page
- Search page
- Offers page
- Appointments page
- Login / Register pages

---

## Demo User Accounts

Use the provided credentials file:

```text
Users_Credentials.txt
```

It contains demo login accounts for:

- Admins
- Creators
- Viewers

Each account can log in using either:
- username
- email

---

## Main Features

The project includes:

- User registration and login
- Session management
- Edit profile
- Car listing and browsing
- Search by title, creator, date/date range, and rating
- Full-text or indexed search support
- Comments and ratings
- Offers
- Test drive appointments
- My Activity page
- Creator dashboard
- Admin dashboard
- Reports
- Pagination
- Responsive and styled UI

---

## Validation and Security

The project includes:

- JavaScript-based validation
- Server-side validation
- Encrypted passwords
- Prepared statements
- Trigger-based duplicate prevention for:
  - ratings
  - offers

---

## Notes

- Import the SQL file before running the project.
- Make sure the database name in `config/db.php` matches the imported database.
- Some features require logging in with the correct role.
- Image upload depends on server folder permissions.
- Image URL input is also supported as an alternative.


---

## How to Use the Website

### Viewer
A viewer can:
- browse cars
- search cars
- rate cars
- comment on cars
- make offers
- book test drive appointments
- manage activity
- edit profile

### Creator
A creator can:
- add new cars
- edit their cars
- publish or keep cars as draft
- view their own listings
- access the creator dashboard

### Admin
An admin can:
- manage users
- manage all cars
- remove and restore cars
- manage comments
- generate reports
- access the admin dashboard

---

## Final Step

After importing the database and opening the project in NetBeans, run the project and test the features using the demo accounts from `Users_Credentials.txt`.
