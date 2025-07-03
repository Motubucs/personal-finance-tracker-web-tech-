<!-- Contributed by Zuhayer: Monthly Spending Trend Bar Chart -->
<template>
  <!-- Modern chart container with glassmorphism styling -->
  <div class="chart-container">
    <div class="chart-header">
      <h4>
        <span class="chart-icon">📈</span>
        Monthly Spending Trend
      </h4>
      <div class="chart-badge">Expenses</div>
    </div>
    <div class="chart-content">
      <canvas ref="barChart"></canvas>
    </div>
  </div>
</template>

<script>
import {
  Chart,
  BarController,
  BarElement,
  CategoryScale,
  LinearScale,
  Tooltip,
  Legend,
} from "chart.js";

// Register necessary Chart.js components
Chart.register(
  BarController,
  BarElement,
  CategoryScale,
  LinearScale,
  Tooltip,
  Legend
);

export default {
  name: "SpendingTrend",
  props: ["monthlyData"], // Accepts the monthlyData prop for rendering the chart
  data() {
    return {
      chartInstance: null, // Holds reference to the Chart.js instance
    };
  },
  watch: {
    // Watcher to detect changes in monthlyData and update the chart accordingly
    monthlyData: {
      immediate: true, // Run handler immediately on component mount
      handler(newData) {
        // Exit early if newData is empty or undefined
        if (!newData || Object.keys(newData).length === 0) return;

        // Destroy existing chart instance to prevent duplicates
        if (this.chartInstance) {
          this.chartInstance.destroy();
        }

        // Create a new Chart.js bar chart instance with updated data
        this.chartInstance = new Chart(this.$refs.barChart, {
          type: "bar",
          data: {
            labels: Object.keys(newData), // Set X-axis labels from data keys (e.g., months)
            datasets: [
              {
                label: "Expenses (RM)", // Dataset label
                data: Object.values(newData), // Set Y-axis values from data values
                backgroundColor: "rgba(102, 126, 234, 0.8)", // Modern gradient color
                borderColor: "rgba(102, 126, 234, 1)",
                borderWidth: 2,
                borderRadius: 12, // More rounded corners for bars
                borderSkipped: false,
              },
            ],
          },
          options: {
            responsive: true, // Make chart responsive
            maintainAspectRatio: false, // Allow flexible height/width
            plugins: {
              legend: {
                position: "bottom", // Place legend at the bottom
                labels: {
                  color: "rgba(255, 255, 255, 0.9)", // Modern white text
                  padding: 20,
                  font: {
                    size: 14,
                    weight: '600',
                    family: "'Inter', sans-serif",
                  },
                },
              },
              tooltip: {
                backgroundColor: 'rgba(255, 255, 255, 0.95)',
                titleColor: '#333',
                bodyColor: '#333',
                borderColor: 'rgba(255, 255, 255, 0.2)',
                borderWidth: 1,
                cornerRadius: 12,
                padding: 12,
                font: {
                  family: "'Inter', sans-serif",
                },
              },
            },
            scales: {
              y: {
                beginAtZero: true, // Start Y-axis from zero
                grid: {
                  color: "rgba(255, 255, 255, 0.1)",
                  borderColor: "rgba(255, 255, 255, 0.2)",
                },
                ticks: {
                  color: "rgba(255, 255, 255, 0.8)", // Modern tick color
                  font: {
                    family: "'Inter', sans-serif",
                    size: 12,
                  },
                  callback: (val) => `RM ${val}`, // Format Y-axis tick labels with currency
                },
              },
              x: {
                grid: {
                  color: "rgba(255, 255, 255, 0.1)",
                  borderColor: "rgba(255, 255, 255, 0.2)",
                },
                ticks: {
                  color: "rgba(255, 255, 255, 0.8)", // Modern tick color
                  font: {
                    family: "'Inter', sans-serif",
                    size: 12,
                  },
                },
              },
            },
          },
        });
      },
    },
  },
};
</script>

<style scoped>
.chart-container {
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  padding: 30px;
  border-radius: 20px;
  min-height: 320px;
  display: flex;
  flex-direction: column;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.chart-container::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
  background-size: 200% 200%;
  animation: gradientFlow 4s ease infinite;
}

@keyframes gradientFlow {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

.chart-container:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
  background: rgba(255, 255, 255, 0.15);
}

.chart-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
  padding-bottom: 15px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.chart-header h4 {
  display: flex;
  align-items: center;
  gap: 12px;
  margin: 0;
  font-size: 18px;
  font-weight: 700;
  color: rgba(255, 255, 255, 0.95);
  font-family: 'Inter', sans-serif;
}

.chart-icon {
  font-size: 22px;
  background: rgba(255, 255, 255, 0.15);
  padding: 8px;
  border-radius: 10px;
  backdrop-filter: blur(10px);
}

.chart-badge {
  background: rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(15px);
  color: rgba(255, 255, 255, 0.9);
  padding: 6px 14px;
  border-radius: 16px;
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.chart-content {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}

canvas {
  width: 100% !important;
  height: 220px !important;
  filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
}

/* Responsive design */
@media (max-width: 768px) {
  .chart-container {
    padding: 25px 20px;
    min-height: 280px;
  }
  
  .chart-header {
    flex-direction: column;
    gap: 12px;
    align-items: flex-start;
  }
  
  .chart-header h4 {
    font-size: 16px;
  }
  
  canvas {
    height: 180px !important;
  }
}
</style>
