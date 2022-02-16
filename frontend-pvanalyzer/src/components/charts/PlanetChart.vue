<template>
  <div style="text-allign: center">
    <canvas id="planet-chart" v-show="!loading"></canvas>
  </div>
</template>

<script>
import Chart from "chart.js";
// import planetChartData from "./planet-data.js";

export default {
  name: "PlanetChart",
  data() {
    return {
      // planetChartData: planetChartData,
      loading: true,
      allLabels: [],
      allRecover: [],
      allActive: [],
      allReactive: [],
      labels: [],
      recover: [],
      active: [],
      reactive: [],
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
          // title: {
          //   display: true,
          //   text: "Ostatnie odczyty",
          //   fontSize: 24
          // },

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
    this.loadReadings();
    this.allRecover = this.$store.getters["readings/recover"];
    this.allActive = this.$store.getters["readings/active"];
    this.allReactive = this.$store.getters["readings/reactive"];
    this.allLabels = this.$store.getters["readings/labels"];
  },
  beforeMount() {
    this.getDataToChart();
  },
  mounted() {
    const ctx = document.getElementById("planet-chart");
    new Chart(ctx, this.lineChart);
  },
  methods: {
    async loadReadings() {
      try {
        await this.$store.dispatch("readings/loadCounterReadings");
      } catch (error) {
        this.error = error.message || "Something went wrong!";
      }
      this.loading = false;
    },
    getDataToChart() {
      const length = this.allRecover.length;
      this.labels = this.allLabels.slice(length - 5);
      this.recover = this.allRecover.slice(length - 5);
      this.active = this.allActive.slice(length - 5);
      this.reactive = this.allReactive.slice(length - 5);
      this.lineChart.data.labels = this.labels;
      this.lineChart.data.datasets[0].data = this.recover;
      this.lineChart.data.datasets[1].data = this.active;
      this.lineChart.data.datasets[2].data = this.reactive;
    },
  },
};
</script>

<style scoped>
p {
  background-color: #292828;
}
</style>
