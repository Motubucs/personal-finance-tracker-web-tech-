# 💰 Personal Finance Tracker – Backend API

PHP + MySQL backend for managing income and expenses. Developed for Assignment 2 (Web Technology).

## 📂 Folder Structure

- `api/transactions/*.php` — API endpoints (CRUD + search)
- `config/database.php` — PDO connection class
- `personal_finance_tracker.sql` — Exported database

## 🔗 API Endpoints

| Method | Endpoint                      | Description              |
|--------|-------------------------------|--------------------------|
| GET    | `/get.php`                    | Fetch all transactions   |
| GET    | `/get_single.php?id=1`        | Get transaction by ID    |
| POST   | `/post.php`                   | Add new transaction      |
| PUT    | `/put.php`                    | Update transaction       |
| DELETE | `/delete.php`                 | Delete transaction by ID |
| DELETE | `/delete_all.php`             | Delete all transactions  |
| GET    | `/search.php?search=keyword`  | Search by keyword        |

## 🧪 How to Test

1. Start Apache + MySQL in XAMPP
2. Visit `http://localhost/backend/api/transactions/get.php`
3. Use Postman for POST, PUT, DELETE testing
4. Import `personal_finance_tracker.sql` into phpMyAdmin

## 👨‍💻 Developer

**Mohammed Salghi**  
Bachelor of Computer Science (Software Engineering)  
Universiti Teknologi Malaysia
