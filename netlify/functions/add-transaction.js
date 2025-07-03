// Netlify Functions - Add Transaction
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

  // Only allow POST requests
  if (event.httpMethod !== 'POST') {
    return {
      statusCode: 405,
      headers,
      body: JSON.stringify({
        success: false,
        error: 'Method not allowed'
      })
    };
  }

  try {
    // Parse request body
    const transaction = JSON.parse(event.body);
    
    // Validate required fields
    if (!transaction.type || !transaction.amount || !transaction.category || !transaction.date) {
      return {
        statusCode: 400,
        headers,
        body: JSON.stringify({
          success: false,
          error: 'Missing required fields: type, amount, category, date'
        })
      };
    }

    // Create new transaction with ID and timestamp
    const newTransaction = {
      id: Date.now(),
      type: transaction.type,
      amount: parseFloat(transaction.amount),
      category: transaction.category,
      date: transaction.date,
      note: transaction.note || '',
      created_at: new Date().toISOString()
    };

    // In a real app, you'd save to database here
    // For now, just return success with the transaction
    return {
      statusCode: 201,
      headers,
      body: JSON.stringify({
        success: true,
        message: 'Transaction added successfully',
        data: newTransaction
      })
    };

  } catch (error) {
    return {
      statusCode: 500,
      headers,
      body: JSON.stringify({
        success: false,
        error: 'Failed to add transaction',
        details: error.message
      })
    };
  }
};
