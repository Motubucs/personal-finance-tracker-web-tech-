// API Configuration - Use environment variables
const API_CONFIG = {
  baseURL: process.env.VUE_APP_API_BASE_URL || 'http://localhost/finance-tracker/finance-backend/api/transactions',
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
};

export const API_BASE_URL = import.meta.env.VITE_API_URL || "http://localhost:8000";
