// Netlify Functions - Get Transactions
exports.handler = async (event, context) => {
  // Enable CORS
  const headers = {
    'Access-Control-Allow-Origin': '*',
    'Access-Control-Allow-Headers': 'Content-Type',
    'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, OPTIONS',
    'Content-Type': 'application/json'
  };

  // Handle preflight OPTIONS request
  if (event.httpMethod === 'OPTIONS') {
    return {
      statusCode: 204,
      headers
    };
  }

  // Simple in-memory storage (for demo)
  // In production, you'd use a database
  const sampleTransactions = [
    {
      id: 1,
      type: 'income',
      amount: 3000.00,
      category: 'Salary',
      note: 'Monthly salary',
      date: '2025-06-01',
      created_at: '2025-06-01T10:00:00Z'
    },
    {
      id: 2,
      type: 'expense',
      amount: 250.00,
      category: 'Groceries',
      note: 'Weekly shopping',
      date: '2025-06-15',
      created_at: '2025-06-15T14:30:00Z'
    },
    {
      id: 3,
      type: 'expense',
      amount: 80.00,
      category: 'Transport',
      note: 'Gas for car',
      date: '2025-06-20',
      created_at: '2025-06-20T09:15:00Z'
    },
    {
      id: 4,
      type: 'income',
      amount: 500.00,
      category: 'Freelance',
      note: 'Web design project',
      date: '2025-06-22',
      created_at: '2025-06-22T16:45:00Z'
    }
  ];

  try {
    return {
      statusCode: 200,
      headers,
      body: JSON.stringify({
        success: true,
        data: sampleTransactions,
        count: sampleTransactions.length
      })
    };
  } catch (error) {
    return {
      statusCode: 500,
      headers,
      body: JSON.stringify({
        success: false,
        error: 'Failed to fetch transactions'
      })
    };
  }
};
