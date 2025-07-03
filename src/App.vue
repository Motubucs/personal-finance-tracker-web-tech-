<template>
  <div id="app-layout">
    <!-- Enhanced Sidebar Navigation -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="logo">
          <span class="logo-icon">💰</span>
          <h2>Finance Tracker</h2>
        </div>
        <div class="app-version">v1.0</div>
      </div>

      <nav class="navigation">
        <router-link to="/" class="nav-btn">
          <span class="nav-icon">📊</span>
          <span class="nav-text">Dashboard</span>
        </router-link>

        <router-link to="/add" class="nav-btn add-btn">
          <span class="nav-icon">➕</span>
          <span class="nav-text">Add Transaction</span>
        </router-link>
      </nav>

      <div class="sidebar-footer">
        <button class="clear-btn" @click="clearTransactions">
          <span class="clear-icon">🗑️</span>
          <span class="clear-text">Clear All Data</span>
        </button>
      </div>
    </aside>

    <!-- Enhanced Main Content -->
    <main class="main-content">
      <div class="content-wrapper">
        <router-view />
      </div>
    </main>
  </div>
</template>

<script>
import axios from "axios";

export default {
  methods: {
    async clearTransactions() {
      if (confirm("Are you sure you want to clear all transactions?")) {
        try {
          await axios.delete(
            `${process.env.VUE_APP_API_BASE_URL}/delete_all.php`
          );
          alert("✅ All transactions cleared!");
          location.reload(); // Or emit an event to refresh only
        } catch (error) {
          console.error("Clear All Error:", error);
          alert("❌ Failed to clear transactions.");
        }
      }
    },
  },
};
</script>

<style lang="scss">
/* Global Reset & Base Styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

#app-layout {
  display: flex;
  min-height: 100vh;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #f5576c 75%, #4facfe 100%);
  background-size: 400% 400%;
  animation: gradientShift 15s ease infinite;
  color: #ffffff;
  overflow-x: hidden;
  position: relative;
}

/* Animated background */
@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

/* Background overlay for better readability */
#app-layout::before {
  content: '';
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.1);
  backdrop-filter: blur(1px);
  z-index: 1;
}

/* Enhanced Sidebar Styles */
.sidebar {
  width: 300px;
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  display: flex;
  flex-direction: column;
  box-shadow: 0 25px 45px rgba(0, 0, 0, 0.1);
  position: relative;
  z-index: 10;
  border-radius: 0 25px 25px 0;
}

/* Sidebar Header */
.sidebar-header {
  padding: 40px 30px 30px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.2);
  background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.05) 100%);
  position: relative;
}

.sidebar-header::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57);
  background-size: 200% 200%;
  animation: gradientFlow 3s ease infinite;
}

@keyframes gradientFlow {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

.logo {
  display: flex;
  align-items: center;
  gap: 15px;
  margin-bottom: 10px;
}

.logo-icon {
  font-size: 32px;
  background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  filter: drop-shadow(0 3px 6px rgba(255, 107, 107, 0.3));
  animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.05); }
}

.logo h2 {
  font-size: 24px;
  font-weight: 800;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);
}

.app-version {
  font-size: 12px;
  color: rgba(255, 255, 255, 0.8);
  font-weight: 600;
  letter-spacing: 1px;
  text-transform: uppercase;
  background: rgba(255, 255, 255, 0.1);
  padding: 4px 12px;
  border-radius: 20px;
  backdrop-filter: blur(10px);
}

/* Enhanced Navigation */
.navigation {
  flex: 1;
  padding: 30px 25px;
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.nav-btn {
  display: flex;
  align-items: center;
  gap: 18px;
  padding: 20px 24px;
  background: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 18px;
  color: rgba(255, 255, 255, 0.9);
  text-decoration: none;
  font-weight: 600;
  font-size: 15px;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
  backdrop-filter: blur(10px);
}

.nav-btn::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
  transition: left 0.6s;
}

.nav-btn:hover::before {
  left: 100%;
}

.nav-btn:hover {
  background: rgba(255, 255, 255, 0.25);
  border-color: rgba(255, 255, 255, 0.4);
  color: #ffffff;
  transform: translateX(8px) scale(1.02);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.nav-btn.router-link-exact-active {
  background: linear-gradient(135deg, rgba(102, 126, 234, 0.8) 0%, rgba(118, 75, 162, 0.8) 100%);
  border-color: rgba(255, 255, 255, 0.5);
  color: #ffffff;
  box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
  transform: translateX(4px);
}

.nav-icon {
  font-size: 22px;
  width: 24px;
  text-align: center;
  filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
}

.nav-text {
  font-weight: 700;
  letter-spacing: 0.5px;
}

/* Special styling for Add Transaction button */
.add-btn {
  background: linear-gradient(135deg, rgba(245, 87, 108, 0.3) 0%, rgba(240, 147, 251, 0.3) 100%);
  border-color: rgba(245, 87, 108, 0.5);
}

.add-btn:hover {
  background: linear-gradient(135deg, rgba(245, 87, 108, 0.5) 0%, rgba(240, 147, 251, 0.5) 100%);
  border-color: rgba(245, 87, 108, 0.7);
  box-shadow: 0 15px 35px rgba(245, 87, 108, 0.4);
}

/* Sidebar Footer */
.sidebar-footer {
  padding: 25px;
  border-top: 1px solid rgba(255, 255, 255, 0.2);
  background: rgba(255, 255, 255, 0.05);
}

.clear-btn {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  padding: 18px 24px;
  background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
  color: white;
  border: none;
  border-radius: 16px;
  cursor: pointer;
  font-weight: 700;
  font-size: 15px;
  transition: all 0.3s ease;
  box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.clear-btn:hover {
  background: linear-gradient(135deg, #ff5252 0%, #e74c3c 100%);
  transform: translateY(-3px) scale(1.02);
  box-shadow: 0 12px 35px rgba(255, 107, 107, 0.5);
}

.clear-btn:active {
  transform: translateY(-1px) scale(1.01);
}

.clear-icon {
  font-size: 18px;
  filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
}

/* Enhanced Main Content */
.main-content {
  flex: 1;
  position: relative;
  overflow-y: auto;
  z-index: 5;
}

.content-wrapper {
  padding: 50px;
  max-width: 1500px;
  margin: 0 auto;
  position: relative;
}

/* Modern scrollbar */
.main-content::-webkit-scrollbar {
  width: 12px;
}

.main-content::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.1);
  border-radius: 10px;
}

.main-content::-webkit-scrollbar-thumb {
  background: linear-gradient(135deg, #667eea, #764ba2);
  border-radius: 10px;
  border: 2px solid rgba(255, 255, 255, 0.1);
}

.main-content::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(135deg, #5a6fd8, #6a4190);
}

/* Responsive Design */
@media (max-width: 1024px) {
  #app-layout {
    flex-direction: column;
  }
  
  .sidebar {
    width: 100%;
    border-radius: 0 0 25px 25px;
    flex-direction: row;
    padding: 0;
    height: auto;
  }
  
  .sidebar-header {
    flex: 1;
    padding: 20px;
    border-bottom: none;
    border-right: 1px solid rgba(255, 255, 255, 0.2);
  }
  
  .navigation {
    flex: 2;
    flex-direction: row;
    padding: 20px;
    gap: 12px;
  }
  
  .sidebar-footer {
    padding: 20px;
    border-top: none;
    border-left: 1px solid rgba(255, 255, 255, 0.2);
  }
  
  .content-wrapper {
    padding: 30px 20px;
  }
}

@media (max-width: 768px) {
  .sidebar {
    flex-direction: column;
  }
  
  .sidebar-header {
    border-right: none;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
  }
  
  .navigation {
    flex-direction: column;
    padding: 20px;
  }
  
  .sidebar-footer {
    border-left: none;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
  }
  
  .nav-btn {
    padding: 16px 20px;
    font-size: 14px;
  }
  
  .content-wrapper {
    padding: 20px 15px;
  }
}

/* Floating elements effect */
.sidebar::after {
  content: '';
  position: absolute;
  top: 20%;
  right: -10px;
  width: 20px;
  height: 20px;
  background: linear-gradient(135deg, #4facfe, #00f2fe);
  border-radius: 50%;
  opacity: 0.6;
  animation: float 3s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-10px) rotate(180deg); }
}

.sidebar::before {
  content: '';
  position: absolute;
  bottom: 30%;
  right: -5px;
  width: 15px;
  height: 15px;
  background: linear-gradient(135deg, #f093fb, #f5576c);
  border-radius: 50%;
  opacity: 0.5;
  animation: float 4s ease-in-out infinite reverse;
}
</style>
