<template>
  <div class="form-container">
    <div class="form-header">
      <h2>
        <span class="form-icon">➕</span>
        Add New Transaction
      </h2>
      <p class="form-subtitle">Track your income and expenses</p>
    </div>

    <form @submit.prevent="handleSubmit" class="transaction-form">
      <div class="form-row">
        <div class="form-group">
          <label for="type">
            <span class="label-icon">📝</span>
            Transaction Type
          </label>
          <select id="type" v-model="form.type" required class="form-select">
            <option disabled value="">Select type</option>
            <option value="income">💰 Income</option>
            <option value="expense">💸 Expense</option>
          </select>
        </div>

        <div class="form-group">
          <label for="amount">
            <span class="label-icon">💲</span>
            Amount (RM)
          </label>
          <input
            id="amount"
            type="number"
            v-model.number="form.amount"
            min="0.01"
            step="0.01"
            required
            class="form-input"
            placeholder="0.00"
          />
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="category">
            <span class="label-icon">🏷️</span>
            Category
          </label>
          <input 
            id="category" 
            type="text" 
            v-model="form.category" 
            required 
            class="form-input"
            placeholder="e.g., Groceries, Salary, Entertainment"
          />
        </div>

        <div class="form-group">
          <label for="date">
            <span class="label-icon">📅</span>
            Date
          </label>
          <input 
            id="date" 
            type="date" 
            v-model="form.date" 
            required 
            class="form-input"
          />
        </div>
      </div>

      <div class="form-group full-width">
        <label for="note">
          <span class="label-icon">📄</span>
          Note (optional)
        </label>
        <textarea
          id="note"
          v-model="form.note"
          placeholder="Add a description or note about this transaction..."
          class="form-textarea"
        ></textarea>
      </div>

      <div class="form-actions">
        <button type="submit" class="submit-btn">
          <span class="btn-icon">✅</span>
          Add Transaction
        </button>
        <router-link to="/" class="cancel-btn">
          <span class="btn-icon">❌</span>
          Cancel
        </router-link>
      </div>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "AddForm",
  data() {
    return {
      form: {
        type: "",
        amount: 0,
        category: "",
        date: "",
        note: "",
      },
    };
  },
  methods: {
    async handleSubmit() {
      try {
        console.log('=== FORM SUBMISSION STARTED ===');
        console.log('Form data:', JSON.stringify(this.form));
        console.log('Current URL:', window.location.href);
        console.log('User Agent:', navigator.userAgent);
        
        // Enhanced form validation with detailed logging
        const validationErrors = [];
        if (!this.form.type) validationErrors.push('Transaction type is required');
        if (!this.form.amount || this.form.amount <= 0) validationErrors.push('Valid amount is required');
        if (!this.form.category) validationErrors.push('Category is required');
        if (!this.form.date) validationErrors.push('Date is required');
        
        if (validationErrors.length > 0) {
          console.error('Validation errors:', validationErrors);
          alert("❌ Please fix the following:\n" + validationErrors.join('\n'));
          return;
        }

        console.log('✅ Form validation passed');

        // SHARED DATABASE MODE - Always use API for everyone
        console.log('� === SHARED DATABASE MODE ===');
        console.log('💾 All users will share the same database');
        
        // Use our PHP backend API with CORS headers
        const API_URL = 'https://finance-tracker-production.up.railway.app/api/transactions/post.php';
        
        try {
          // Create new transaction
          const newTransaction = {
            type: this.form.type,
            amount: parseFloat(this.form.amount),
            category: this.form.category,
            date: this.form.date,
            note: this.form.note || '',
            created_at: new Date().toISOString()
          };
          
          console.log('➕ Adding new transaction:', newTransaction);
          
          // Save transaction to PHP backend
          const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json'
            },
            body: JSON.stringify(newTransaction)
          });
          
          if (response.ok) {
            const result = await response.json();
            console.log('✅ Transaction saved to shared database:', result);
            alert("✅ Transaction Added Successfully!\n\n🌐 Shared Database: Everyone with the link can see this transaction!");
            
            // Reset form
            this.form = {
              type: "",
              amount: 0,
              category: "",
              date: "",
              note: "",
            };
            
            // Navigate to dashboard
            this.$router.push("/");
          } else {
            const errorText = await response.text();
            console.error('❌ Server response:', response.status, errorText);
            throw new Error(`Failed to save transaction: ${response.status} ${errorText}`);
          }
          
        } catch (error) {
          console.error('❌ Shared database error:', error);
          
          // Fallback to localStorage with clear message
          console.log('🔄 Falling back to localStorage...');
          
          try {
            const existingTransactions = JSON.parse(localStorage.getItem('transactions') || '[]');
            const newTransaction = {
              id: Date.now(),
              type: this.form.type,
              amount: parseFloat(this.form.amount),
              category: this.form.category,
              date: this.form.date,
              note: this.form.note || '',
              created_at: new Date().toISOString()
            };
            
            existingTransactions.unshift(newTransaction);
            localStorage.setItem('transactions', JSON.stringify(existingTransactions));
            
            alert("⚠️ Transaction saved locally only!\n\n� Network error: Could not save to shared database.\nThis transaction is only visible on your device.");
            
            // Reset form
            this.form = {
              type: "",
              amount: 0,
              category: "",
              date: "",
              note: "",
            };
            
            this.$router.push("/");
            
          } catch (localError) {
            console.error('❌ localStorage fallback failed:', localError);
            alert("❌ Failed to save transaction!\n\nPlease check your internet connection and try again.");
          }
        }
        
      } catch (error) {
        console.error('=== SUBMISSION ERROR ===');
        console.error('Error type:', error.constructor.name);
        console.error('Error message:', error.message);
        console.error('Error stack:', error.stack);
        console.error('Full error object:', error);
        
        // More detailed error message for user
        let errorMessage = "❌ Failed to add transaction\n\n";
        
        if (error.message) {
          errorMessage += `Error: ${error.message}\n\n`;
        }
        
        if (error.response) {
          errorMessage += `Server Error: ${error.response.status} ${error.response.statusText}\n\n`;
        }
        
        errorMessage += "📱 If you're on mobile, please try:\n";
        errorMessage += "• Refresh the page and try again\n";
        errorMessage += "• Check your internet connection\n";
        errorMessage += "• Try using a different browser\n\n";
        errorMessage += "🔍 Check browser console for technical details";
        
        alert(errorMessage);
      }
    },
  },
};
</script>

<style scoped>
.form-container {
  max-width: 900px;
  margin: 0 auto;
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(25px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 30px;
  padding: 50px;
  box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
  position: relative;
  overflow: hidden;
}

.form-container::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 5px;
  background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #f5576c, #4facfe, #00f2fe);
  background-size: 300% 300%;
  animation: gradientShift 4s ease infinite;
}

.form-container::after {
  content: '';
  position: absolute;
  top: -50%;
  right: -50%;
  width: 100%;
  height: 100%;
  background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
  animation: rotate 20s linear infinite;
  z-index: -1;
}

@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

@keyframes rotate {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

.form-header {
  text-align: center;
  margin-bottom: 50px;
  padding-bottom: 30px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.2);
  position: relative;
}

.form-header::after {
  content: '';
  position: absolute;
  bottom: -5px;
  left: 50%;
  transform: translateX(-50%);
  width: 100px;
  height: 3px;
  background: linear-gradient(90deg, #4facfe, #00f2fe);
  border-radius: 2px;
  box-shadow: 0 0 20px rgba(79, 172, 254, 0.5);
}

.form-header h2 {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 20px;
  font-size: 36px;
  font-weight: 800;
  color: #ffffff;
  margin-bottom: 12px;
  text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.form-icon {
  font-size: 42px;
  background: linear-gradient(135deg, #f093fb, #f5576c);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  filter: drop-shadow(0 4px 8px rgba(240, 147, 251, 0.4));
  animation: iconBounce 2s ease-in-out infinite;
}

@keyframes iconBounce {
  0%, 100% { transform: translateY(0px) scale(1); }
  50% { transform: translateY(-5px) scale(1.05); }
}

.form-subtitle {
  color: rgba(255, 255, 255, 0.85);
  font-size: 18px;
  font-weight: 500;
  letter-spacing: 0.5px;
}

.transaction-form {
  display: flex;
  flex-direction: column;
  gap: 30px;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 30px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 12px;
  position: relative;
}

.form-group.full-width {
  grid-column: 1 / -1;
}

label {
  display: flex;
  align-items: center;
  gap: 12px;
  font-weight: 700;
  font-size: 16px;
  color: rgba(255, 255, 255, 0.9);
  margin-bottom: 8px;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.label-icon {
  font-size: 20px;
  background: linear-gradient(135deg, #4facfe, #00f2fe);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  filter: drop-shadow(0 2px 4px rgba(79, 172, 254, 0.3));
}

.form-input,
.form-select,
.form-textarea {
  padding: 20px 24px;
  border-radius: 18px;
  border: 2px solid rgba(255, 255, 255, 0.2);
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(15px);
  color: #ffffff;
  font-size: 16px;
  font-family: inherit;
  font-weight: 500;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
  outline: none;
  border-color: #4facfe;
  background: rgba(79, 172, 254, 0.15);
  box-shadow: 0 0 0 6px rgba(79, 172, 254, 0.2);
  transform: translateY(-3px) scale(1.02);
  color: #ffffff;
}

.form-input::placeholder,
.form-textarea::placeholder {
  color: rgba(255, 255, 255, 0.6);
  font-weight: 400;
}

.form-select {
  cursor: pointer;
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
  background-position: right 20px center;
  background-repeat: no-repeat;
  background-size: 16px;
  padding-right: 50px;
  appearance: none;
}

.form-select option {
  background: rgba(102, 126, 234, 0.9);
  color: #ffffff;
  padding: 15px;
  font-weight: 600;
}

.form-textarea {
  min-height: 140px;
  resize: vertical;
  font-family: inherit;
  line-height: 1.6;
}

.form-actions {
  display: flex;
  gap: 25px;
  margin-top: 30px;
  justify-content: center;
}

.submit-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 15px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 20px 40px;
  border: none;
  border-radius: 18px;
  cursor: pointer;
  font-weight: 700;
  font-size: 16px;
  transition: all 0.4s ease;
  box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
  min-width: 200px;
  text-transform: uppercase;
  letter-spacing: 1px;
  position: relative;
  overflow: hidden;
}

.submit-btn::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
  transition: left 0.6s;
}

.submit-btn:hover::before {
  left: 100%;
}

.submit-btn:hover {
  background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
  transform: translateY(-4px) scale(1.02);
  box-shadow: 0 12px 35px rgba(102, 126, 234, 0.5);
}

.submit-btn:active {
  transform: translateY(-2px) scale(1.01);
}

.cancel-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 15px;
  background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
  color: white;
  padding: 20px 40px;
  border-radius: 18px;
  text-decoration: none;
  font-weight: 700;
  font-size: 16px;
  transition: all 0.4s ease;
  box-shadow: 0 8px 25px rgba(245, 87, 108, 0.4);
  min-width: 180px;
  text-transform: uppercase;
  letter-spacing: 1px;
  position: relative;
  overflow: hidden;
}

.cancel-btn::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
  transition: left 0.6s;
}

.cancel-btn:hover::before {
  left: 100%;
}

.cancel-btn:hover {
  background: linear-gradient(135deg, #e287f0 0%, #e74c3c 100%);
  transform: translateY(-4px) scale(1.02);
  box-shadow: 0 12px 35px rgba(245, 87, 108, 0.5);
  color: white;
}

.btn-icon {
  font-size: 20px;
  filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
}

/* Floating decorative elements */
.form-container .floating-element {
  position: absolute;
  pointer-events: none;
  z-index: -1;
}

.form-container .floating-element:nth-child(1) {
  top: 10%;
  right: 5%;
  width: 60px;
  height: 60px;
  background: radial-gradient(circle, rgba(79, 172, 254, 0.3), transparent);
  border-radius: 50%;
  animation: float 4s ease-in-out infinite;
}

.form-container .floating-element:nth-child(2) {
  bottom: 15%;
  left: 8%;
  width: 40px;
  height: 40px;
  background: radial-gradient(circle, rgba(240, 147, 251, 0.3), transparent);
  border-radius: 50%;
  animation: float 6s ease-in-out infinite reverse;
}

@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-15px) rotate(180deg); }
}

/* Responsive Design */
@media (max-width: 1024px) {
  .form-container {
    max-width: 700px;
    padding: 40px 35px;
  }
  
  .form-header h2 {
    font-size: 32px;
  }
  
  .form-icon {
    font-size: 36px;
  }
}

@media (max-width: 768px) {
  .form-container {
    margin: 20px;
    padding: 35px 25px;
  }
  
  .form-row {
    grid-template-columns: 1fr;
    gap: 25px;
  }
  
  .form-actions {
    flex-direction: column;
    align-items: stretch;
  }
  
  .submit-btn,
  .cancel-btn {
    min-width: auto;
    padding: 18px 32px;
  }
  
  .form-header h2 {
    font-size: 28px;
  }
  
  .form-icon {
    font-size: 32px;
  }
  
  .form-subtitle {
    font-size: 16px;
  }
}

/* Enhanced animation for form appearance */
@keyframes slideInUp {
  from {
    opacity: 0;
    transform: translateY(50px) scale(0.9);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

@keyframes slideInLeft {
  from {
    opacity: 0;
    transform: translateX(-30px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

@keyframes slideInRight {
  from {
    opacity: 0;
    transform: translateX(30px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

.form-container {
  animation: slideInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.form-group:nth-child(odd) {
  animation: slideInLeft 0.6s ease-out;
  animation-delay: 0.2s;
  animation-fill-mode: both;
}

.form-group:nth-child(even) {
  animation: slideInRight 0.6s ease-out;
  animation-delay: 0.3s;
  animation-fill-mode: both;
}

.form-actions {
  animation: slideInUp 0.6s ease-out;
  animation-delay: 0.5s;
  animation-fill-mode: both;
}
</style>
