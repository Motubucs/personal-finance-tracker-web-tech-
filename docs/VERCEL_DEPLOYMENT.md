# 🚀 FRONTEND DEPLOYMENT GUIDE (VERCEL)

## Prerequisites
- GitHub account
- Vercel account (free)
- Project pushed to GitHub

## Step-by-Step Instructions

### 1. Push to GitHub
```bash
# Initialize git repository (if not done)
git init
git add .
git commit -m "Initial commit - Finance Tracker"

# Add GitHub remote
git remote add origin https://github.com/yourusername/finance-tracker.git
git push -u origin main
```

### 2. Deploy to Vercel
1. **Visit**: https://vercel.com
2. **Sign up** with GitHub account
3. **Import Project**:
   - Click "New Project"
   - Select your GitHub repository
   - Configure build settings:
     ```
     Framework Preset: Vue.js
     Build Command: npm run build:prod
     Output Directory: dist
     Install Command: npm install
     ```

### 3. Environment Variables
In Vercel Dashboard → Settings → Environment Variables:
```
VUE_APP_API_BASE_URL = https://your-backend-url.railway.app/api/transactions
VUE_APP_ENVIRONMENT = production
VUE_APP_DEBUG = false
```

### 4. Custom Domain (Optional)
- Vercel Dashboard → Domains
- Add your custom domain
- Configure DNS records

## ✅ Expected Result
- Frontend accessible at: `https://finance-tracker-yourname.vercel.app`
- Automatic deployments on git push
- Global CDN distribution
- HTTPS enabled by default
