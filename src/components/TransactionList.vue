<!-- Contributed by Yusuf Zain: Developed the transaction list layout with dynamic rendering -->
<template>
  <div class="transaction-list">
    <h4>🧾 Recent Transactions</h4>
    <ul v-if="transactions.length">
      <li v-for="t in transactions" :key="t.id">
        <span class="date">{{ t.date }}</span>
        <span class="category">{{ t.category }}</span>
        <span :class="t.type">
          {{ t.type === "income" ? "+" : "-" }}RM
          {{ parseFloat(t.amount).toFixed(2) }}
        </span>
        <div class="actions">
          <router-link :to="`/update/${t.id}`">✏️ Edit</router-link>
          <button @click="deleteTransaction(t.id)" class="delete-btn">
            🗑️
          </button>
        </div>
      </li>
    </ul>
    <p v-else>No transactions available.</p>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "TransactionList",
  props: ["transactions"],
  emits: ["refresh"],
  methods: {
    async deleteTransaction(id) {
      if (confirm("Are you sure you want to delete this transaction?")) {
        try {
          await axios.delete(
            "http://localhost/finance-tracker/finance-backend/api/transactions/delete.php",
            { data: { id } }
          );
          this.$emit("refresh"); // Ask parent to reload
        } catch (err) {
          console.error("Delete failed:", err);
        }
      }
    },
  },
};
</script>

<style scoped>
.transaction-list {
  background: #1f2a40;
  color: #fff;
  padding: 20px;
  border-radius: 10px;
  margin-bottom: 30px;
}
.transaction-list h4 {
  margin-bottom: 12px;
  font-weight: bold;
  border-bottom: 1px solid #444;
  padding-bottom: 8px;
}
.transaction-list ul {
  list-style: none;
  padding: 0;
  margin: 0;
}
.transaction-list li {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px 0;
  border-bottom: 1px solid #333;
  font-size: 14px;
}
.transaction-list .income {
  color: #4caf50;
  font-weight: bold;
}
.transaction-list .expense {
  color: #f44336;
  font-weight: bold;
}
.transaction-list .date {
  flex: 1;
  opacity: 0.8;
}
.transaction-list .category {
  flex: 1;
  font-weight: 500;
  text-align: center;
}
.actions {
  display: flex;
  gap: 10px;
}
.delete-btn {
  background-color: transparent;
  border: none;
  color: #f56c6c;
  cursor: pointer;
  font-size: 16px;
  transition: color 0.3s;
}
.delete-btn:hover {
  color: #ff3b3b;
}
</style>
