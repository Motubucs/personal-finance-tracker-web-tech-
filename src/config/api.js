// API Configuration - Use environment variables
const API_CONFIG = {
  baseURL: process.env.VUE_APP_API_BASE_URL || 'https://personal-finance-tracker-web-tech.onrender.com',
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
};

// For Vue 3 (Vite)
export const API_BASE_URL = import.meta.env.VITE_API_URL || "https://personal-finance-tracker-web-tech.onrender.com";

// For Vue 2 (Vue CLI)
export const API_BASE_RL = process.env.VUE_APP_API_URL || "https://personal-finance-tracker-web-tech.onrender.com";
