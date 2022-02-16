<template>
  <div style="width: 80%; text-allign: center; height: 500px">
    <canvas id="planet-chart"></canvas>
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
              data: [],
              // backgroundColor: "rgba(81, 52,132,.5)",
              borderColor: "#21b784",
              borderWidth: 3,
            },
            {
              label: "Pobrana",
              data: [],
              // backgroundColor: "rgba(211, 38, 38,.5)",
              borderColor: "#c90000",
              borderWidth: 3,
            },
            {
              label: "Oddana",
              data: [],
              // backgroundColor: "rgba(82, 69, 69,.5)",
              borderColor: "#292828",
              borderWidth: 3,
            },
          ],
        },
        options: {
            title: {
            display: true,
            text: 'Custom Chart Title'
        }
  
        //   responsive: true,
        //   title: {
        //     display: true,
        //     text: "Kurwy Kurwy",
        //   },

        //   lineTension: 1,
        //   scales: {
        //     y:{
        //       display: true,
        // title: {
        //   display: true,
        //   text: 'Value',
        //   color: '#191',
        //     }},
        //     yAxes: [
        //       {
        //         ticks: {
        //           beginAtZero: true,
        //           padding: 25,
        //         },
        //       },
        //     ],
          // },
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
