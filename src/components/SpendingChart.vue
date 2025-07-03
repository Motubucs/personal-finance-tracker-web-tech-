<!-- Contributed by Zuhayer: Spending Breakdown (Doughnut) -->
<template>
  <!-- Modern chart container with glassmorphism styling -->
  <div class="chart-container">
    <div class="chart-header">
      <h4>
        <span class="chart-icon">📊</span>
        Spending Breakdown
      </h4>
      <div class="chart-badge">Categories</div>
    </div>
    <div class="chart-content">
      <canvas ref="chart"></canvas>
    </div>
  </div>
</template>

<script>
// Import required components from Chart.js
import {
  Chart,
  DoughnutController,
  ArcElement,
  Tooltip,
  Legend,
} from "chart.js";

// Register Chart.js components
Chart.register(DoughnutController, ArcElement, Tooltip, Legend);

export default {
  name: "SpendingChart",
  props: ["data"], // Receives spending data as a prop
  data() {
    return {
      chartInstance: null, // Holds the Chart.js instance
    };
  },
  watch: {
    // Watcher for changes in the data prop
    data: {
      immediate: true, // Trigger handler immediately upon component load
      handler(newData) {
        // Exit early if data is empty or not provided
        if (!newData || Object.keys(newData).length === 0) return;

        // Destroy previous chart instance to prevent duplication
        if (this.chartInstance) {
          this.chartInstance.destroy();
        }

        // Create a new doughnut chart instance with the updated data
        this.chartInstance = new Chart(this.$refs.chart, {
          type: "doughnut",
          data: {
            labels: Object.keys(newData), // Set segment labels from data keys
            datasets: [
              {
                data: Object.values(newData), // Set segment values from data values
                backgroundColor: [
                  "#667eea",
                  "#764ba2", 
                  "#f093fb",
                  "#f5576c",
                  "#4facfe",
                  "#00f2fe",
                  "#96ceb4",
                  "#feca57",
                ], // Modern gradient-inspired colors
                borderWidth: 3, // Slightly thicker border
                borderColor: "rgba(255, 255, 255, 0.2)", // Subtle white border
                hoverBorderWidth: 4,
                hoverBorderColor: "rgba(255, 255, 255, 0.8)",
              },
            ],
          },
          options: {
            responsive: true, // Make chart responsive
            maintainAspectRatio: false, // Allow flexible aspect ratio
            plugins: {
              legend: {
                position: "bottom", // Place legend below the chart
                labels: {
                  color: "rgba(255, 255, 255, 0.9)", // Modern white text
                  padding: 20, // More padding between labels
                  boxWidth: 16, // Slightly smaller color box
                  boxHeight: 16,
                  font: {
                    size: 14,
                    weight: '600',
                    family: "'Inter', sans-serif",
                  },
                  usePointStyle: true, // Use circle instead of square
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
