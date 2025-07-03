// Mock API service for demo purposes
class MockApiService {
  constructor() {
    this.transactions = JSON.parse(localStorage.getItem('mock_transactions') || '[]');
    this.initializeWithSampleData();
  }

  initializeWithSampleData() {
    if (this.transactions.length === 0) {
      this.transactions = [
        {
          id: 1,
          type: 'income',
          amount: 3000.00,
          category: 'Salary',
          note: 'Monthly salary',
          date: '2025-06-01',
          created_at: '2025-06-01T00:00:00Z'
        },
        {
          id: 2,
          type: 'expense',
          amount: 250.00,
          category: 'Groceries',
          note: 'Weekly shopping',
          date: '2025-06-15',
          created_at: '2025-06-15T00:00:00Z'
        },
        {
          id: 3,
          type: 'expense',
          amount: 50.00,
          category: 'Transport',
          note: 'Bus fare',
          date: '2025-06-20',
          created_at: '2025-06-20T00:00:00Z'
        }
      ];
      this.saveToStorage();
    }
  }

  saveToStorage() {
    localStorage.setItem('mock_transactions', JSON.stringify(this.transactions));
  }

  async addTransaction(transactionData) {
    // Simulate API delay
    await new Promise(resolve => setTimeout(resolve, 500));
    
    const newTransaction = {
      id: Date.now(),
      ...transactionData,
      created_at: new Date().toISOString()
    };
    
    this.transactions.unshift(newTransaction);
    this.saveToStorage();
    
    return { success: true, data: newTransaction };
  }

  async getTransactions() {
    // Simulate API delay
    await new Promise(resolve => setTimeout(resolve, 300));
    return { success: true, data: this.transactions };
  }
}

// Export for use in Vue components
window.MockApiService = MockApiService;
