<!-- Contributed by Moath Morsy – Final UI-integrated Dashboard.vue -->
<template>
  <div class="app-layout">
    <!-- Enhanced Main Dashboard Area -->
    <main class="dashboard">
      <div class="dashboard-header">
        <div class="header-content">
          <h2>
            <span class="dashboard-icon">📊</span>
            Personal Finance Dashboard
          </h2>
          <p class="dashboard-subtitle">
            Track your financial journey • 
            <span class="current-date">{{ currentDate }}</span>
          </p>
        </div>
        <div class="header-stats">
          <div class="quick-stat">
            <span class="stat-label">Total Transactions</span>
            <span class="stat-value">{{ transactions.length }}</span>
          </div>
        </div>
      </div>

      <!-- Summary Cards -->
      <div class="cards">
        <SummaryCard title="Income" :amount="totalIncome" />
        <SummaryCard title="Expenses" :amount="totalExpenses" />
        <SummaryCard title="Balance" :amount="totalIncome - totalExpenses" />
      </div>

      <!-- Charts Section -->
      <div class="charts">
        <SpendingChart :data="categoryTotals" />
        <SpendingTrend :monthlyData="monthlyExpenses" />
      </div>

      <!-- Recent Transactions -->
      <TransactionList
        :transactions="transactions"
        @refresh="fetchTransactions"
      />
    </main>
  </div>
</template>

<script>
import axios from "axios";
import SummaryCard from "@/components/SummaryCard.vue";
import SpendingChart from "@/components/SpendingChart.vue";
import SpendingTrend from "@/components/SpendingTrend.vue";
import TransactionList from "@/components/TransactionList.vue";

export default {
  name: "Dashboard",
  components: {
    SummaryCard,
    SpendingChart,
    SpendingTrend,
    TransactionList,
  },
  data() {
    return {
      transactions: [],
    };
  },
  computed: {
    currentDate() {
      return new Date().toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    },
    totalIncome() {
      return this.transactions
        .filter((t) => t.type === "income")
        .reduce((sum, t) => sum + Number(t.amount), 0);
    },
    totalExpenses() {
      return this.transactions
        .filter((t) => t.type === "expense")
        .reduce((sum, t) => sum + Number(t.amount), 0);
    },
    categoryTotals() {
      const result = {};
      this.transactions
        .filter((t) => t.type === "expense")
        .forEach((t) => {
          result[t.category] = (result[t.category] || 0) + Number(t.amount);
        });
      return result;
    },
    monthlyExpenses() {
      const result = {};
      this.transactions
        .filter((t) => t.type === "expense")
        .forEach((t) => {
          const date = new Date(t.date);
          const month = date.toLocaleString("default", {
            month: "short",
            year: "numeric",
          });
          result[month] = (result[month] || 0) + Number(t.amount);
        });
      return result;
    },
  },
  mounted() {
    this.fetchTransactions();
  },
  activated() {
    // Refresh data when navigating back to dashboard (for keep-alive)
    this.fetchTransactions();
  },
  beforeRouteEnter(to, from, next) {
    // Always refresh when entering dashboard
    next(vm => {
      vm.fetchTransactions();
    });
  },
  methods: {
    async fetchTransactions() {
      try {
        console.log('🔄 === FETCHING TRANSACTIONS ===');
        console.log('🌍 Current URL:', window.location.href);
        console.log('🌍 Current hostname:', window.location.hostname);
        
        // SHARED DATABASE MODE - Load from shared database
        console.log('🌐 === LOADING FROM SHARED DATABASE ===');
        console.log('👥 All users share the same data');
        
        const API_URL = 'https://finance-tracker-production.up.railway.app/api/transactions/get.php';
        
        try {
          console.log('📡 Fetching shared transactions...');
          
          const response = await fetch(API_URL, {
            method: 'GET',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json'
            }
          });
          
          if (response.ok) {
            const data = await response.json();
            const sharedTransactions = data.transactions || [];
            
            console.log('📊 Loaded shared transactions:', sharedTransactions.length);
            
            if (sharedTransactions.length === 0) {
              console.log('📝 No shared transactions found');
              this.transactions = [];
            } else {
              this.transactions = sharedTransactions;
              console.log('✅ Shared transactions loaded successfully');
            }
            
          } else {
            const errorText = await response.text();
            console.error('❌ Server response:', response.status, errorText);
            throw new Error(`Failed to fetch from shared database: ${response.status}`);
          }
          
        } catch (error) {
          console.error('❌ Shared database error:', error);
          console.log('� Falling back to localStorage...');
          
          // Fallback to localStorage
          try {
            const localTransactions = JSON.parse(localStorage.getItem('transactions') || '[]');
            
            if (localTransactions.length === 0) {
              // Initialize with sample data
              const sampleData = [
                { id: 1, type: 'income', amount: 3000.00, category: 'Salary', note: 'Monthly salary', date: '2025-06-01', created_at: '2025-06-01T10:00:00Z' },
                { id: 2, type: 'expense', amount: 250.00, category: 'Groceries', note: 'Weekly shopping', date: '2025-06-15', created_at: '2025-06-15T14:30:00Z' },
                { id: 3, type: 'expense', amount: 80.00, category: 'Transport', note: 'Gas for car', date: '2025-06-20', created_at: '2025-06-20T09:15:00Z' }
              ];
              localStorage.setItem('transactions', JSON.stringify(sampleData));
              this.transactions = sampleData;
              console.log('✅ Sample data initialized in localStorage');
            } else {
              this.transactions = localTransactions;
              console.log('✅ Local transactions loaded');
            }
            
          } catch (localError) {
            console.error('❌ localStorage fallback failed:', localError);
            this.transactions = [];
          }
        }
        
      } catch (err) {
        console.error("❌ === ERROR FETCHING TRANSACTIONS ===");
        console.error('Error type:', err.constructor.name);
        console.error('Error message:', err.message);
        console.error('Full error:', err);
        
        // If we're in demo mode and get an error, initialize empty array
        const hostname = window.location.hostname;
        const isDemo = hostname !== 'localhost' && hostname !== '127.0.0.1';
        
        if (isDemo) {
          console.log('🔧 Demo mode error recovery - setting empty transactions');
          this.transactions = [];
        } else {
          console.log('🔧 API error recovery - setting empty transactions');
          this.transactions = [];
        }
      }
    },
  },
};
</script>

<style scoped>
.app-layout {
  display: flex;
  min-height: 100vh;
  color: #fff;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* Modern Dashboard */
.dashboard {
  flex: 1;
  background: transparent;
  position: relative;
}

/* Enhanced Dashboard Header with Glassmorphism */
.dashboard-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 50px;
  padding: 40px 0;
  position: relative;
}

.dashboard-header::before {
  content: '';
  position: absolute;
  bottom: -10px;
  left: 0;
  right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
}

.dashboard-header::after {
  content: '';
  position: absolute;
  bottom: -15px;
  left: 20%;
  width: 60%;
  height: 3px;
  background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57);
  background-size: 200% 200%;
  animation: gradientFlow 3s ease infinite;
  border-radius: 2px;
  filter: blur(1px);
}

@keyframes gradientFlow {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

.header-content {
  position: relative;
}

.header-content h2 {
  display: flex;
  align-items: center;
  gap: 20px;
  font-size: 42px;
  font-weight: 800;
  color: #ffffff;
  margin-bottom: 12px;
  line-height: 1.2;
  text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.dashboard-icon {
  font-size: 48px;
  background: linear-gradient(135deg, #667eea, #764ba2);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  filter: drop-shadow(0 4px 8px rgba(102, 126, 234, 0.4));
  animation: iconPulse 3s ease-in-out infinite;
}

@keyframes iconPulse {
  0%, 100% { transform: scale(1) rotate(0deg); }
  25% { transform: scale(1.05) rotate(1deg); }
  75% { transform: scale(0.98) rotate(-1deg); }
}

.dashboard-subtitle {
  color: rgba(255, 255, 255, 0.85);
  font-size: 18px;
  font-weight: 500;
  margin: 0;
  letter-spacing: 0.5px;
}

.current-date {
  background: linear-gradient(135deg, #4facfe, #00f2fe);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  font-weight: 700;
  text-shadow: 0 2px 10px rgba(79, 172, 254, 0.3);
}

.header-stats {
  display: flex;
  align-items: center;
  gap: 25px;
}

.quick-stat {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 8px;
  padding: 24px 28px;
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 20px;
  position: relative;
  overflow: hidden;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

.quick-stat::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1);
  background-size: 200% 200%;
  animation: gradientFlow 4s ease infinite;
}

.quick-stat:hover {
  transform: translateY(-5px) scale(1.02);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
}

.stat-label {
  font-size: 13px;
  color: rgba(255, 255, 255, 0.8);
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.stat-value {
  font-size: 32px;
  font-weight: 800;
  background: linear-gradient(135deg, #667eea, #764ba2);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

/* Enhanced Cards Section */
.cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 35px;
  margin-bottom: 50px;
  position: relative;
}

.cards::before {
  content: '';
  position: absolute;
  top: -20px;
  left: -20px;
  right: -20px;
  bottom: -20px;
  background: linear-gradient(45deg, rgba(255, 107, 107, 0.1), rgba(78, 205, 196, 0.1), rgba(69, 183, 209, 0.1));
  border-radius: 30px;
  z-index: -1;
  filter: blur(30px);
  opacity: 0.5;
}

/* Enhanced Charts Section */
.charts {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
  gap: 35px;
  margin-bottom: 50px;
  position: relative;
}

.charts::before {
  content: '';
  position: absolute;
  top: -25px;
  left: -25px;
  right: -25px;
  bottom: -25px;
  background: linear-gradient(135deg, rgba(150, 206, 180, 0.1), rgba(254, 202, 87, 0.1), rgba(245, 87, 108, 0.1));
  border-radius: 35px;
  z-index: -1;
  filter: blur(40px);
  opacity: 0.6;
}

/* Floating particles effect */
.dashboard::before {
  content: '';
  position: absolute;
  top: 10%;
  right: 5%;
  width: 100px;
  height: 100px;
  background: radial-gradient(circle, rgba(102, 126, 234, 0.3), transparent);
  border-radius: 50%;
  animation: floatParticle 6s ease-in-out infinite;
  z-index: -1;
}

.dashboard::after {
  content: '';
  position: absolute;
  bottom: 20%;
  left: 8%;
  width: 80px;
  height: 80px;
  background: radial-gradient(circle, rgba(245, 87, 108, 0.3), transparent);
  border-radius: 50%;
  animation: floatParticle 8s ease-in-out infinite reverse;
  z-index: -1;
}

@keyframes floatParticle {
  0%, 100% { 
    transform: translateY(0px) translateX(0px) scale(1);
    opacity: 0.6;
  }
  25% { 
    transform: translateY(-20px) translateX(10px) scale(1.1);
    opacity: 0.8;
  }
  50% { 
    transform: translateY(-30px) translateX(-10px) scale(0.9);
    opacity: 0.4;
  }
  75% { 
    transform: translateY(-10px) translateX(15px) scale(1.05);
    opacity: 0.7;
  }
}

/* Responsive Design */
@media (max-width: 1400px) {
  .header-content h2 {
    font-size: 36px;
  }
  
  .dashboard-icon {
    font-size: 40px;
  }
}

@media (max-width: 1200px) {
  .dashboard-header {
    flex-direction: column;
    gap: 25px;
    align-items: flex-start;
  }
  
  .header-stats {
    align-self: stretch;
    justify-content: flex-start;
  }
  
  .quick-stat {
    align-items: flex-start;
  }
}

@media (max-width: 768px) {
  .dashboard {
    padding: 0;
  }
  
  .dashboard-header {
    padding: 25px 0;
  }
  
  .header-content h2 {
    font-size: 28px;
  }
  
  .dashboard-icon {
    font-size: 32px;
  }
  
  .dashboard-subtitle {
    font-size: 16px;
  }
  
  .cards {
    grid-template-columns: 1fr;
    gap: 25px;
  }
  
  .charts {
    grid-template-columns: 1fr;
    gap: 25px;
  }
  
  .quick-stat {
    padding: 20px 24px;
  }
  
  .stat-value {
    font-size: 24px;
  }
}

/* Smooth appearance animations */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(40px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeInScale {
  from {
    opacity: 0;
    transform: scale(0.8);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}

.dashboard-header {
  animation: fadeInUp 0.8s ease-out;
}

.cards {
  animation: fadeInScale 0.8s ease-out 0.2s both;
}

.charts {
  animation: fadeInScale 0.8s ease-out 0.4s both;
}

/* Legacy sidebar styles for compatibility */
.sidebar {
  width: 220px;
  background-color: #1f2a40;
  padding: 20px;
  display: flex;
  flex-direction: column;
  gap: 15px;
  border-right: 2px solid #42b983;
}

.sidebar .logo {
  font-size: 24px;
  font-weight: bold;
  color: #42b983;
  margin-bottom: 30px;
}

.sidebar a {
  color: #ffffff;
  text-decoration: none;
  font-weight: bold;
  transition: color 0.3s;
}

.sidebar a.router-link-exact-active {
  color: #42b983;
}

.sidebar button {
  background: transparent;
  color: #f56c6c;
  border: 1px solid #f56c6c;
  padding: 8px 12px;
  cursor: pointer;
  font-weight: bold;
  border-radius: 5px;
  transition: all 0.3s ease;
}

.sidebar button:hover {
  background-color: #f56c6c;
  color: #fff;
}
</style>
