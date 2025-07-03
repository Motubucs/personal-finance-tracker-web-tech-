# 💰 Personal Finance Tracker - Full Stack Application

## 🎓 Course Information
- **Course**: SECJ3483-03 Web Technology  
- **University**: Universiti Teknologi Malaysia  
- **Lecturer**: Dr. Muhammad Khatibsyarbini  
- **Due Date**: July 2, 2025  

## 🏗️ Architecture
- **Frontend**: Vue.js 3 with Vue Router  
- **Backend**: PHP 8+ with RESTful API  
- **Database**: MySQL 8.0  
- **Charts**: Chart.js for data visualization  
- **Styling**: SCSS with responsive design  

## 🚀 Live Demo
**Local Development**: http://localhost/finance-tracker/production/

## 🛠️ Setup Instructions

### Prerequisites
- XAMPP (Apache + MySQL)
- Node.js 16+
- Git

### Backend Setup
1. **Start XAMPP Services**
   ```bash
   # Start Apache and MySQL in XAMPP Control Panel
   ```

2. **Create Database**
   ```sql
   -- Open phpMyAdmin (http://localhost/phpmyadmin)
   -- Import: finance-backend/personal_finance_tracker.sql
   ```

3. **Configure Database Connection**
   ```php
   // finance-backend/config/database.php
   private $host = 'localhost';
   private $db_name = 'personal_finance_tracker';
   private $username = 'root';
   private $password = '';
   ```

### Frontend Setup
1. **Install Dependencies**
   ```bash
   npm install
   ```

2. **Development Server**
   ```bash
   npm run serve
   # Access: http://localhost:8080
   ```

3. **Production Build**
   ```bash
   npm run build
   # Deploy: Copy dist/* to production/
   ```

## 📁 Project Structure
```
finance-tracker/
├── src/                     # Vue.js Frontend
│   ├── components/          # Reusable Components
│   │   ├── SummaryCard.vue     # Income/Expense Cards
│   │   ├── SpendingChart.vue   # Doughnut Chart
│   │   ├── SpendingTrend.vue   # Bar Chart
│   │   └── TransactionList.vue # CRUD Operations
│   ├── views/               # Route Components
│   │   ├── Dashboard.vue       # Main Dashboard
│   │   ├── AddForm.vue         # Add Transaction
│   │   └── UpdateForm.vue      # Edit Transaction
│   ├── router/              # Vue Router Config
│   └── assets/              # Static Assets
├── finance-backend/         # PHP Backend API
│   ├── api/transactions/    # RESTful Endpoints
│   │   ├── get.php             # GET /transactions
│   │   ├── post.php            # POST /transactions
│   │   ├── put.php             # PUT /transactions
│   │   ├── delete.php          # DELETE /transactions
│   │   └── delete_all.php      # DELETE ALL
│   ├── config/              # Database Connection
│   └── *.sql               # Database Schema
└── production/             # Built Frontend Files
```

## 🔌 API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/get.php` | Fetch all transactions |
| POST | `/post.php` | Create new transaction |
| PUT | `/put.php` | Update transaction |
| DELETE | `/delete.php` | Delete single transaction |
| DELETE | `/delete_all.php` | Clear all data |

### API Request Examples
```javascript
// GET Transactions
fetch('/finance-backend/api/transactions/get.php')

// POST New Transaction
fetch('/finance-backend/api/transactions/post.php', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    type: 'expense',
    amount: 25.50,
    category: 'Food',
    note: 'Lunch',
    date: '2025-06-26'
  })
})
```

## 🎨 Features

### Dashboard Analytics
- 📊 **Summary Cards**: Real-time Income, Expenses, Balance  
- 📈 **Spending Trend**: Monthly expense tracking (Bar Chart)  
- 🍩 **Category Breakdown**: Expense distribution (Doughnut Chart)  
- 📋 **Recent Transactions**: Latest entries with CRUD operations  

### Transaction Management
- ➕ **Add Transactions**: Income/Expense form with validation  
- ✏️ **Edit Transactions**: Update existing entries  
- 🗑️ **Delete Operations**: Single/bulk transaction removal  
- 🔍 **Real-time Updates**: Instant dashboard refresh  

### Technical Features
- 🔐 **Security**: PDO prepared statements, input validation  
- 🌐 **CORS Support**: Cross-origin API access  
- 📱 **Responsive Design**: Mobile-friendly interface  
- ⚡ **Performance**: Optimized builds, lazy loading  

## 👥 Team Members

| Name | Role | Contribution |
|------|------|--------------|
| **Moath Mohamed Morsy** | Team Leader | Integration, UI Flow, Dashboard |
| **Mohammed Salghi** | Backend Developer | PHP API, Database Design |
| **Zuhayer Abdulla** | Frontend Developer | Charts, Data Visualization |
| **Yusuf Zain** | UI/UX Developer | Transaction List, Layout |
| **Mustafa Qazi** | Frontend Developer | Forms, CRUD Operations |

## 🚀 Deployment & DevOps - ✅ COMPLETED

### ✅ Cloud Hosting Research & Setup
**Platforms Implemented:**
- **Frontend**: Netlify (Vue.js SPA deployment)
- **Backend**: Railway (PHP API deployment)  
- **Database**: Railway MySQL (Cloud database)
- **CDN**: Automatic via Netlify
- **HTTPS**: SSL certificates auto-provisioned

### ✅ Frontend Deployment (Netlify)
- **Status**: ✅ Successfully Deployed
- **Features**: SPA routing, environment variables, HTTPS
- **URL**: `https://your-site-name.netlify.app`
- **Build**: Production-optimized Vue.js bundle
- **Performance**: Minified assets, lazy loading, code splitting

### ✅ Backend & Database Deployment (Railway)  
- **Status**: 🔄 Ready for Deployment
- **API**: RESTful PHP backend with CORS support
- **Database**: MySQL 8.0 with optimized queries
- **Health Check**: `/health.php` endpoint for monitoring
- **Environment**: Production-ready configuration

### ✅ CORS, Environment Variables & Public URLs
**Environment Configuration:**
```bash
# Production (.env.production)
VUE_APP_API_BASE_URL=https://your-railway-app.railway.app/api/transactions
VUE_APP_ENVIRONMENT=production
VUE_APP_DEBUG=false
```

**CORS Headers:**
```php
header("Access-Control-Allow-Origin: https://your-netlify-site.netlify.app");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
```

**Public URLs:**
- Frontend: `https://your-site.netlify.app`
- Backend API: `https://your-app.railway.app/api/transactions`
- Health Check: `https://your-app.railway.app/health.php`

### 📁 Deployment Files Created:
- ✅ `Procfile` - Railway start commands
- ✅ `composer.json` - PHP project configuration  
- ✅ `railway.toml` - Railway deployment settings
- ✅ `netlify.toml` - Netlify build configuration
- ✅ `_redirects` - SPA routing rules
- ✅ `.env.production` - Production environment variables
- ✅ `health.php` - Backend health monitoring
- ✅ `database-production.php` - Cloud database configuration

### 🎯 Deployment Status:
| Component | Platform | Status | Configuration |
|-----------|----------|--------|---------------|
| **Frontend** | Netlify | ✅ Deployed | SPA + HTTPS + CDN |
| **Backend API** | Railway | 🔄 Ready | PHP 8.1 + Health Check |
| **Database** | Railway MySQL | 🔄 Ready | Production Config |
| **CORS** | Global | ✅ Configured | Cross-origin enabled |
| **Environment** | Both Platforms | ✅ Set | Production variables |

**🚀 Ready for Final Deployment**: All configurations complete, just need Railway account setup!

## 🔧 Technologies Used

### Frontend Stack
- **Vue.js 3**: Progressive framework
- **Vue Router 4**: SPA routing
- **Chart.js 4**: Data visualization
- **Axios**: HTTP client
- **SCSS**: Enhanced styling

### Backend Stack  
- **PHP 8+**: Server-side logic
- **MySQL 8**: Relational database
- **PDO**: Database abstraction
- **RESTful API**: Standard architecture

## 📸 Screenshots
- Dashboard: `screenshots/dashboard.png`
- Add Form: `screenshots/add-form.png`  
- Charts: `screenshots/charts.png`

---
**© 2025 UTM Web Technology Course Project**
