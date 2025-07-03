# Railway Backend Deployment Configuration

# Start Command
web: cd finance-backend && php -S 0.0.0.0:$PORT -t .

# Health Check
healthcheck: curl -f http://localhost:$PORT/api/transactions/get.php || exit 1
