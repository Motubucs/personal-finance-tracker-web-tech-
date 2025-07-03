# 💰 Personal Finance Tracker

A full-stack web application for tracking personal income and expenses with Malaysian Ringgit (RM) currency support.

## 🌟 Features

- **Dashboard Overview**: Total income, expenses, and current balance
- **Transaction Management**: Add, view, and delete transactions
- **Visual Analytics**: Interactive charts (category breakdown & monthly trends)
- **Malaysian Ringgit (RM)**: Localized currency display
- **Responsive Design**: Works on desktop and mobile
- **Database Integration**: MySQL with localStorage fallback

## 🛠️ Tech Stack

- **Frontend**: Vue.js 3, Chart.js, CSS3
- **Backend**: PHP 8+, MySQL
- **Deployment**: Netlify (Frontend), Railway (Backend)

## 🚀 Quick Start

1. **Clone & Setup**
   ```bash
   git clone https://github.com/yourusername/finance-tracker.git
   cd finance-tracker
   ```

2. **Local Development** (XAMPP)
   - Start Apache + MySQL
   - Import: `finance-backend/personal_finance_tracker.sql`
   - Open: `http://localhost/finance-tracker/dist/modern-finance-app-fixed.html`

## 📁 Project Structure

```
📦 finance-tracker/
├── 📁 dist/                    # 🎯 Production Files
│   └── modern-finance-app-fixed.html  # Main App (RM)
├── 📁 finance-backend/         # 🔧 PHP API
│   ├── api/transactions/       # REST endpoints
│   ├── config/database.php     # DB config
│   └── personal_finance_tracker.sql
├── 📁 screenshots/             # 📸 App previews
└── 📄 README.md
```

## 🔗 API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `api/transactions/get.php` | Fetch all transactions |
| POST | `api/transactions/post.php` | Create transaction |
| DELETE | `api/transactions/delete.php` | Delete transaction |

## 📊 Database Schema

```sql
CREATE TABLE transactions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  type ENUM('income', 'expense'),
  amount DECIMAL(10,2),
  category VARCHAR(100),
  note TEXT,
  date DATE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## 🎯 Assignment Requirements

✅ **Frontend**: Vue.js SPA with responsive design  
✅ **Backend**: PHP REST API with MySQL  
✅ **Database**: Transaction CRUD operations  
✅ **Deployment**: Cloud hosting (Netlify + Railway)  
✅ **Currency**: Malaysian Ringgit (RM) localization  

---

**⭐ Star this repo if it helped you!**
