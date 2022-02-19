<template>
  <div style="text-allign: center">
    <canvas id="planet-chart" v-show="!loading"></canvas>
  </div>
</template>

<script>
import Chart from "chart.js";

export default {
  name: "PlanetChart",
  inject: ['allLabels','allActive','allReactive'],
  data() {
    return {
      loading: true,
      labels: this.allLabels,
      recover: [],
      active: this.allActive,
      reactive: this.allReactive,
      lineChart: {
        type: "line",
        data: {
          labels: [],
          datasets: [
            {
              label: "Do odzyskania",
              fill: false,
              data: [],
              // backgroundColor: "rgba(81, 52,132,.5)",
              borderColor: "#21b784",
              borderWidth: 1.5,
              lineTension: 0.15,
            },
            {
              label: "Pobrana",
              fill: false,
              data: [],
              // backgroundColor: "rgba(211, 38, 38,.5)",
              borderColor: "#c90000",
              borderWidth: 1.5,
              lineTension: 0.15,
            },
            {
              label: "Oddana",
              fill: false,
              data: [],
              // backgroundColor: "rgba(82, 69, 69,.5)",
              borderColor: "#292828",
              borderWidth: 1.5,
              lineTension: 0.15,
            },
          ],
        },
        options: {
          responsive: true,
          legend: {
            labels: {
              fontSize: 16,
            },
          },
          lineTension: 1,
          scales: {
            xAxes: [
              {
                scaleLabel: {
                  display: true,
                  labelString: "Data odczytu",
                  fontSize: 20,
                },
              },
            ],
            yAxes: [
              {
                scaleLabel: {
                  display: true,
                  labelString: "Energia [kWh]",
                  fontSize: 20,
                },
                ticks: {
                  beginAtZero: true,
                  padding: 15,
                },
              },
            ],
          },
        },
      },
    };
  },
  created() {
    
  },
  beforeMount() {
    this.getDataToChart();
  },
  mounted() {
    const ctx = document.getElementById("planet-chart");
    new Chart(ctx, this.lineChart);
  },
  methods: {
    getDataToChart() {
      // const length = this.allRecover.length;
      // this.labels = this.allLabels.slice(length - 5);
      // this.recover = this.allRecover.slice(length - 5);
      // this.active = this.allActive.slice(length - 5);
      // this.reactive = this.allReactive.slice(length - 5);
      this.lineChart.data.labels = this.labels;
      this.lineChart.data.datasets[0].data = this.recover;
      this.lineChart.data.datasets[1].data = this.active;
      this.lineChart.data.datasets[2].data = this.reactive;
      this.loading = false;
    },
  },
};
</script>

<style scoped>
p {
  background-color: #292828;
}
</style>
