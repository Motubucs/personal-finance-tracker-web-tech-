<!-- SummaryCard.vue - Contributed by Mohammed Salghi -->
<template>
  <div class="summary-card" :class="cardClass">
    <div class="card-header">
      <div class="card-icon">{{ cardIcon }}</div>
      <div class="card-badge">{{ title }}</div>
    </div>
    <div class="card-content">
      <p class="amount">{{ formattedAmount }}</p>
      <div class="amount-trend">
        <span class="trend-indicator" :class="trendClass">{{ trendIcon }}</span>
        <span class="trend-text">{{ trendText }}</span>
      </div>
    </div>
    <div class="card-decoration"></div>
  </div>
</template>

<script>
export default {
  name: "SummaryCard",
  props: {
    title: String,
    amount: Number,
    type: {
      type: String, // "income", "expense", "balance"
      default: "balance",
    },
  },
  computed: {
    formattedAmount() {
      return "RM " + Number(this.amount).toFixed(2);
    },
    cardClass() {
      const titleLower = this.title.toLowerCase();
      if (titleLower.includes('income')) return 'income';
      if (titleLower.includes('expense')) return 'expense';
      if (titleLower.includes('balance')) return 'balance';
      return this.type;
    },
    cardIcon() {
      const titleLower = this.title.toLowerCase();
      if (titleLower.includes('income')) return '💰';
      if (titleLower.includes('expense')) return '💸';
      if (titleLower.includes('balance')) return '⚖️';
      return '📊';
    },
    trendIcon() {
      const amount = Number(this.amount);
      if (this.title.toLowerCase().includes('balance')) {
        return amount >= 0 ? '📈' : '📉';
      }
      return amount > 0 ? '📊' : '📋';
    },
    trendClass() {
      const amount = Number(this.amount);
      if (this.title.toLowerCase().includes('balance')) {
        return amount >= 0 ? 'positive' : 'negative';
      }
      return 'neutral';
    },
    trendText() {
      const titleLower = this.title.toLowerCase();
      if (titleLower.includes('income')) return 'Total Earned';
      if (titleLower.includes('expense')) return 'Total Spent';
      if (titleLower.includes('balance')) {
        return Number(this.amount) >= 0 ? 'Positive Balance' : 'Negative Balance';
      }
      return 'Current Status';
    }
  },
};
</script>

<style scoped>
.summary-card {
  padding: 30px;
  border-radius: 25px;
  color: #ffffff;
  min-width: 280px;
  min-height: 180px;
  text-align: left;
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
  cursor: pointer;
}

.summary-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, var(--gradient-start), var(--gradient-end));
  background-size: 200% 200%;
  animation: gradientFlow 3s ease infinite;
}

@keyframes gradientFlow {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

.summary-card:hover {
  transform: translateY(-8px) scale(1.02);
  box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
  background: rgba(255, 255, 255, 0.2);
}

/* Card type specific gradients */
.summary-card.income {
  --gradient-start: #4facfe;
  --gradient-end: #00f2fe;
}

.summary-card.income::after {
  content: '';
  position: absolute;
  top: -50%;
  right: -50%;
  width: 100%;
  height: 100%;
  background: radial-gradient(circle, rgba(79, 172, 254, 0.15) 0%, transparent 70%);
  animation: rotate 20s linear infinite;
  z-index: -1;
}

.summary-card.expense {
  --gradient-start: #f093fb;
  --gradient-end: #f5576c;
}

.summary-card.expense::after {
  content: '';
  position: absolute;
  top: -50%;
  right: -50%;
  width: 100%;
  height: 100%;
  background: radial-gradient(circle, rgba(240, 147, 251, 0.15) 0%, transparent 70%);
  animation: rotate 25s linear infinite reverse;
  z-index: -1;
}

.summary-card.balance {
  --gradient-start: #667eea;
  --gradient-end: #764ba2;
}

.summary-card.balance::after {
  content: '';
  position: absolute;
  top: -50%;
  right: -50%;
  width: 100%;
  height: 100%;
  background: radial-gradient(circle, rgba(102, 126, 234, 0.15) 0%, transparent 70%);
  animation: rotate 30s linear infinite;
  z-index: -1;
}

@keyframes rotate {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 20px;
}

.card-icon {
  font-size: 32px;
  background: rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(10px);
  padding: 12px;
  border-radius: 16px;
  border: 1px solid rgba(255, 255, 255, 0.3);
  filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
  animation: iconFloat 3s ease-in-out infinite;
}

@keyframes iconFloat {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-5px); }
}

.card-badge {
  background: rgba(255, 255, 255, 0.25);
  backdrop-filter: blur(15px);
  color: rgba(255, 255, 255, 0.95);
  padding: 8px 16px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  border: 1px solid rgba(255, 255, 255, 0.3);
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.card-content {
  position: relative;
  z-index: 2;
}

.amount {
  font-size: 36px;
  font-weight: 800;
  margin-bottom: 12px;
  background: linear-gradient(135deg, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0.8));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
  line-height: 1.2;
}

.amount-trend {
  display: flex;
  align-items: center;
  gap: 8px;
  opacity: 0.9;
}

.trend-indicator {
  font-size: 16px;
  padding: 6px 10px;
  border-radius: 12px;
  background: rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.05); }
}

.trend-indicator.positive {
  background: rgba(76, 175, 80, 0.3);
  border-color: rgba(76, 175, 80, 0.5);
}

.trend-indicator.negative {
  background: rgba(244, 67, 54, 0.3);
  border-color: rgba(244, 67, 54, 0.5);
}

.trend-text {
  font-size: 14px;
  font-weight: 600;
  color: rgba(255, 255, 255, 0.85);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.card-decoration {
  position: absolute;
  bottom: -20px;
  right: -20px;
  width: 80px;
  height: 80px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 50%;
  filter: blur(20px);
  opacity: 0.6;
  animation: decorationFloat 4s ease-in-out infinite;
}

@keyframes decorationFloat {
  0%, 100% { transform: translate(0px, 0px) scale(1); }
  50% { transform: translate(-10px, -10px) scale(1.1); }
}

/* Responsive design */
@media (max-width: 768px) {
  .summary-card {
    padding: 25px;
    min-width: 250px;
    min-height: 160px;
  }
  
  .card-icon {
    font-size: 28px;
    padding: 10px;
  }
  
  .amount {
    font-size: 28px;
  }
  
  .card-badge {
    font-size: 11px;
    padding: 6px 12px;
  }
}

@media (max-width: 480px) {
  .summary-card {
    padding: 20px;
    min-width: 220px;
    min-height: 140px;
  }
  
  .amount {
    font-size: 24px;
  }
  
  .trend-text {
    font-size: 12px;
  }
}

/* Enhanced hover effects */
.summary-card.income:hover {
  box-shadow: 0 25px 50px rgba(79, 172, 254, 0.4);
}

.summary-card.expense:hover {
  box-shadow: 0 25px 50px rgba(240, 147, 251, 0.4);
}

.summary-card.balance:hover {
  box-shadow: 0 25px 50px rgba(102, 126, 234, 0.4);
}

/* Card entrance animation */
@keyframes cardSlideIn {
  from {
    opacity: 0;
    transform: translateY(30px) scale(0.9);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

.summary-card {
  animation: cardSlideIn 0.6s ease-out;
}
</style>
