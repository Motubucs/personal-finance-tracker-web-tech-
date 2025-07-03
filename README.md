# 💰 Personal Finance Tracker

> A modern, responsive web application for tracking personal finances with beautiful UI and real-time data visualization.

![Personal Finance Tracker Dashboard](./screenshots/Screenshot%202025-06-26%20235443.png)

![Vue.js](https://img.shields.io/badge/Vue.js-3.x-green) ![PHP](https://img.shields.io/badge/PHP-8.x-blue) ![MySQL](https://img.shields.io/badge/MySQL-8.x-orange) ![Netlify](https://img.shields.io/badge/Deployed-Netlify-success)

## ✨ Features

- 💳 **Transaction Management** - Add, view, and manage income/expense transactions
- 📊 **Data Visualization** - Interactive charts and spending breakdowns
- 📱 **Responsive Design** - Works perfectly on desktop and mobile
- 🎨 **Modern UI** - Beautiful glassmorphism design with smooth animations
- 💾 **Dual Mode** - Local database for development, localStorage for demo
- 🚀 **Fast & Lightweight** - Optimized for performance

## 🚀 Live Demo

- **Frontend**: [Live Demo on Netlify](https://ornate-nasturtium-e736ab.netlify.app)
- **Features**: Add transactions, view charts, responsive design

## 🛠️ Tech Stack

**Frontend:**
- Vue.js 3.x
- Chart.js for data visualization
- CSS3 with modern effects
- Responsive design

**Backend:**
- PHP 8.x
- MySQL database
- RESTful API

**Deployment:**
- Netlify (Frontend)
- XAMPP (Local development)

## 📦 Quick Start

1. **Clone the repository**
   ```bash
   git clone https://github.com/MohammedSalghi/personal-finance-tracker-web-tech-group.git
   cd personal-finance-tracker-web-tech-group
   ```

2. **Install dependencies**
   ```bash
   npm install
   ```

3. **Set up database** (for local development)
   - Import `finance-backend/personal_finance_tracker.sql` to MySQL
   - Update database config in `finance-backend/config/database.php`

4. **Run development server**
   ```bash
   npm run serve
   ```

5. **Access the app**
   - Frontend: `http://localhost:8080`
   - Backend API: `http://localhost/personal-finance-tracker-web-tech-group-1/finance-backend`

## 📸 Screenshots

### 🏠 Main Dashboard
![Main Dashboard](./screenshots/Screenshot%202025-06-26%20235443.png)
*Modern glassmorphism design with transaction overview and financial summary*

### 📊 Data Visualization & Charts
![Charts and Analytics](./screenshots/Screenshot%202025-06-26%20235518.png)
*Interactive spending breakdown with beautiful donut charts and category analysis*

### � Transaction Management
![Transaction Form](./screenshots/Screenshot%202025-06-26%20235536.png)
*Easy-to-use form for adding income and expense transactions*

### 📈 Financial Analytics
![Financial Trends](./screenshots/Screenshot%202025-06-26%20235554.png)
*Comprehensive financial analytics with spending trends and insights*

### ✨ Key Visual Features
- **Glassmorphism UI**: Modern transparent design with backdrop blur effects
- **Gradient Animations**: Smooth flowing gradients and hover animations  
- **Responsive Charts**: Interactive Chart.js visualizations
- **Real-time Updates**: Live data synchronization between frontend and database
- **Modern Color Scheme**: Professional purple/blue gradient theme

## 🎯 Project Structure

```
personal-finance-tracker/
├── src/                    # Vue.js frontend source
│   ├── components/         # Reusable Vue components
│   ├── views/             # Page components
│   └── assets/            # Static assets
├── finance-backend/       # PHP backend API
│   ├── api/               # API endpoints
│   ├── config/            # Database configuration
│   └── models/            # Data models
├── public/                # Static files
└── docs/                  # Documentation
```

## 🌟 Key Features

- **Smart Dual Mode**: Automatically switches between MySQL (local) and localStorage (demo)
- **Modern UI**: Glassmorphism effects, smooth animations, gradient backgrounds
- **Responsive Charts**: Interactive spending breakdowns and trend analysis
- **Professional Design**: Clean, modern interface suitable for portfolio
- **Easy Deployment**: Ready for Netlify, Railway, or any hosting platform

## 📄 License

MIT License - see [LICENSE](LICENSE) file for details

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## � Team Members

This project was developed as a collaborative effort by our web technology team:

### **Moath Mohamed Morsy (A21EC4036)** - *Team Leader & Frontend Developer*
- 🎯 **Role**: Team Lead, Dashboard Development, Data Visualization
- 💻 **Contributions**: 
  - Implemented the dashboard layout structure using Vue components
  - Configured Chart.js for expense breakdown and monthly trend visualizations
  - Ensured proper chart responsiveness and interactivity
  - Created summary cards with reactive data binding

### **Mohammed Salghi** - *Backend API Developer*
- 🎯 **Role**: Backend Development, Database Architecture
- 💻 **Contributions**:
  - Built all 6 PHP API endpoints (based on Assignment 2)
  - Created database connection classes
  - Implemented full CRUD operations with proper validation
  - Added error handling and JSON response formatting

### **Zuhayer Adnan Siddique** - *Documentation & Testing Specialist*
- 🎯 **Role**: Quality Assurance, Documentation, Testing
- 💻 **Contributions**:
  - Created final project documentation (PDF)
  - Captured screenshots of live system
  - Wrote deployment guide and README documentation
  - Tested complete application and coordinated bug fixes

### **Mustafa Tarig Abdelwahid** - *DevOps & Deployment Engineer*
- 🎯 **Role**: Cloud Deployment, Platform Configuration
- 💻 **Contributions**:
  - Researched and set up cloud hosting platforms
  - Deployed frontend (Netlify) and backend + database (Railway)
  - Configured CORS, environment variables, and public URLs
  - Managed production environment optimization

### **Yousof** - *Frontend-Backend Integration & Database Setup*
- 🎯 **Role**: Database Management, API Integration
- 💻 **Contributions**:
  - Set up MySQL database using the documented schema
  - Added sample data for testing and development
  - Connected Vue.js frontend with PHP API
  - Replaced dummy data with real API calls
  - Added loading states and error handling

## 🏆 Team Achievements

- ✅ **Successful Cloud Deployment**: App hosted on Netlify with 100% uptime
- ✅ **Cross-Platform Compatibility**: Works seamlessly on desktop and mobile
- ✅ **Shared Database Integration**: Real-time data sharing across all users
- ✅ **Modern Tech Stack**: Latest Vue.js 3.x with PHP 8.x backend
- ✅ **Professional UI**: Glassmorphism design with smooth animations
- ✅ **Zero CORS Issues**: Properly configured API with cross-origin support



Project Link: [https://github.com/MohammedSalghi/personal-finance-tracker-web-tech-group](https://github.com/MohammedSalghi/personal-finance-tracker-web-tech-group)

---

⭐ Star this repo if you found it helpful!
