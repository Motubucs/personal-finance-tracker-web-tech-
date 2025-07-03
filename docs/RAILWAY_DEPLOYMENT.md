# 🛠️ BACKEND DEPLOYMENT GUIDE (RAILWAY)

## Prerequisites
- GitHub account  
- Railway account (free tier available)
- Docker basics understanding

## Step-by-Step Instructions

### 1. Prepare Backend Structure
```
finance-backend/
├── api/transactions/    # All PHP endpoints
├── config/             # Database configurations  
├── Dockerfile          # Container configuration
├── railway.toml        # Railway settings
└── personal_finance_tracker.sql
```

### 2. Deploy to Railway
1. **Visit**: https://railway.app
2. **Sign up** with GitHub
3. **New Project**:
   - "Deploy from GitHub repo"
   - Select your repository
   - Choose "Dockerfile" deployment

### 3. Add MySQL Database
1. **Railway Dashboard** → Add Database
2. **Select MySQL**
3. **Note connection details**:
   ```
   DATABASE_URL=mysql://user:pass@host:port/dbname
   ```

### 4. Environment Variables
Railway Dashboard → Variables:
```
APP_ENV = production
APP_DEBUG = false
DATABASE_URL = mysql://user:pass@host:port/dbname
```

### 5. Import Database Schema
```bash
# Use Railway MySQL connection string
mysql -h your-host -P port -u username -p dbname < personal_finance_tracker.sql
```

### 6. Test API Endpoints
```bash
# Test GET endpoint
curl https://your-backend.railway.app/api/transactions/get.php

# Test POST endpoint  
curl -X POST https://your-backend.railway.app/api/transactions/post.php \
  -H "Content-Type: application/json" \
  -d '{"type":"expense","amount":25.50,"category":"Test","date":"2025-06-26"}'
```

## Alternative: Render Deployment
If Railway doesn't work, use Render:
1. **Visit**: https://render.com
2. **Web Service** → Connect GitHub
3. **Build Command**: `docker build -t backend .`
4. **Start Command**: `apache2-foreground`

## ✅ Expected Result
- Backend API accessible at: `https://finance-tracker-backend.railway.app`
- All CRUD endpoints working
- CORS configured for frontend
- Database connected and responsive
