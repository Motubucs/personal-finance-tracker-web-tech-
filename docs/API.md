# API Documentation

## Overview
Personal Finance Tracker REST API for managing financial transactions.

**Base URL**: `http://localhost/personal-finance-tracker-web-tech-group-1/finance-backend/api`

## Authentication
Currently no authentication required (development mode).

## Endpoints

### Health Check
Check if the API is running.

**GET** `/health.php`

**Response:**
```json
{
  "status": "healthy",
  "timestamp": "2025-06-26 23:52:00",
  "message": "API is working"
}
```

### Transactions

#### Create Transaction
Add a new financial transaction.

**POST** `/transactions/post.php`

**Request Body:**
```json
{
  "type": "expense",
  "amount": 250.00,
  "category": "Groceries",
  "date": "2025-06-26",
  "note": "Weekly shopping"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Transaction created successfully",
  "data": {
    "id": 123,
    "type": "expense",
    "amount": 250.00,
    "category": "Groceries",
    "date": "2025-06-26",
    "note": "Weekly shopping",
    "created_at": "2025-06-26T23:52:00Z"
  }
}
```

#### Get Transactions
Retrieve all transactions.

**GET** `/transactions/get.php`

**Query Parameters:**
- `limit` (optional): Number of transactions to return
- `offset` (optional): Number of transactions to skip
- `type` (optional): Filter by transaction type (income/expense)

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 123,
      "type": "expense",
      "amount": 250.00,
      "category": "Groceries",
      "date": "2025-06-26",
      "note": "Weekly shopping",
      "created_at": "2025-06-26T23:52:00Z"
    }
  ],
  "total": 1
}
```

## Error Responses

### 400 Bad Request
```json
{
  "error": true,
  "message": "Missing required fields: type, amount, category, date"
}
```

### 500 Internal Server Error
```json
{
  "error": true,
  "message": "Database connection failed"
}
```

## Data Types

### Transaction
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| id | integer | No | Auto-generated unique identifier |
| type | string | Yes | Either "income" or "expense" |
| amount | decimal | Yes | Transaction amount (positive number) |
| category | string | Yes | Category name (max 100 chars) |
| date | date | Yes | Transaction date (YYYY-MM-DD) |
| note | string | No | Optional description (max 500 chars) |
| created_at | timestamp | No | Auto-generated creation time |
| updated_at | timestamp | No | Auto-generated update time |

## Database Schema

### transactions table
```sql
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('income','expense') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `category` varchar(100) NOT NULL,
  `note` text DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

## CORS Headers
The API includes CORS headers for cross-origin requests:
- `Access-Control-Allow-Origin: *`
- `Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS`
- `Access-Control-Allow-Headers: Content-Type`
