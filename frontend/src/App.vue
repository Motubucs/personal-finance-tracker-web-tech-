<template>
  <div id="app">
    <h1>📊 Transactions</h1>

    <!-- ✅ Add Transaction Form -->
    <form @submit.prevent="addTransaction">
      <select v-model="form.type">
        <option value="income">Income</option>
        <option value="expense">Expense</option>
      </select>

      <input v-model="form.amount" type="number" placeholder="Amount" required />
      <input v-model="form.category" type="text" placeholder="Category" required />
      <input v-model="form.note" type="text" placeholder="Note (optional)" />
      <input v-model="form.date" type="date" required />
      <button type="submit">➕ Add Transaction</button>
    </form>

    <hr />

    <!-- ✅ Transaction List -->
    <ul v-if="transactions.length > 0">
      <li v-for="tx in transactions" :key="tx.id">
        <strong>{{ tx.type }}</strong> - {{ tx.category }} - RM{{ tx.amount }} on {{ tx.date }}<br />
        <em>{{ tx.note }}</em>
      </li>
    </ul>

    <p v-else>Loading transactions...</p>
  </div>
</template>

<script>
import axios from 'axios';
import { API_BASE_URL } from '../config/api';

export default {
  name: 'App',
  data() {
    return {
      transactions: [],
      form: {
        type: 'income',
        amount: '',
        category: '',
        note: '',
        date: ''
      }
    }
  },
  mounted() {
    this.loadTransactions();
  },
  methods: {
    loadTransactions() {
      axios.get(`${API_BASE_URL}/api/transactions/get.php`)
        .then(response => {
          this.transactions = response.data;
        })
        .catch(error => {
          console.error("Error fetching transactions:", error);
        });
    },
    addTransaction() {
      console.log("🚀 Sending form:", this.form);
      axios.post(`${API_BASE_URL}/api/transactions/post.php`, this.form, {
        headers: {
          'Content-Type': 'application/json'
        }
      })
      .then(() => {
        alert("✅ Transaction added!");
        this.loadTransactions(); // refresh the list
        this.form = { type: 'income', amount: '', category: '', note: '', date: '' }; // reset form
      })
      .catch(error => {
        console.error("❌ Error adding transaction:", error.response?.data || error.message);
        alert("❌ Error: Could not add transaction.");
      });
    }
  }
}
</script>

<style>
body {
  font-family: 'Segoe UI', sans-serif;
  padding: 20px;
}
form {
  margin-bottom: 20px;
}
input, select, button {
  margin: 5px;
  padding: 6px;
}
</style>
