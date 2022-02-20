<template>
  <div class="container" v-if="!isLoading">
    <line-chart-card></line-chart-card>
    <bar-chart-card :balance="balance"></bar-chart-card>
    <last-readings-table :tableData="tableData" ></last-readings-table>
    
  </div>
  <div v-else>
    <loading v-model:active="isLoading"
                 :can-cancel="true"
                 :opacity=1 />
  </div>
</template>

<script>
import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';


import LastReadingsTable from '../../components/counter-readings/ReadingsListContainer.vue';
import LineChartCard from '../../components/counter-readings/charts/LineChartCard.vue'
import BarChartCard from '../../components/counter-readings/charts/BarChardCard.vue'
export default {
  components: { LineChartCard, BarChartCard, LastReadingsTable, Loading},
  data() {
    return {
      allLabels: [], //wszystkie daty z bazy
      allActive: [], //wszystkie odczyty pobrane z sieci
      allReactive: [], //wszystkie odczyty oddane do sieci
      calculatedMonthlyReadings: [],
      monthlyLabels: [],
      isLoading: true,
    };
  },
  computed: {
    allReadings() {
      return this.$store.getters["readings/counterReadings"];
    },
    powerInstallation() {
      return this.$store.getters["pVInstallation/powerInstallation"];
    },
    monthlyData() {
      return this.getLastReadingsInMounths();
    },
    balance(){
      return this.monthlyData[this.monthlyData.length - 1].balance;
    },
    tableData(){
      return this.allReadings.slice(-5);
    }
  },
  created() {
    this.loadCounterReadings();
  },
  provide() {
    return {
      allLabels: this.allLabels,
      allActive: this.allActive,
      allReactive: this.allReactive,
      getCalculatedData: () => this.calculatedMonthlyReadings,
      calculatedMonthlyActive: this.calculatedMonthlyActive,
    };
  },
  methods: {
    async loadCounterReadings() {
      try {
        await this.$store.dispatch("readings/loadCounterReadings");
        this.splitIntoParts(
          this.allReadings,
          this.allLabels,
          this.allActive,
          this.allReactive,
          "date",
          null
        );
        this.calculatedMonthlyReadings = this.calculateEveryMounth();
        this.splitIntoParts(
          this.calculatedMonthlyReadings,
          this.calculatedMonthlyLabels,
          this.calculatedMonthlyActive,
          this.calculatedMonthlyReactive,
          "mounth",
          this.calculatedMonthlyRecover
        );
      } catch (error) {
        this.error = error.message || "Something went wrong!";
      }
      this.isLoading = false;
    },
    getProperties() {
      for (const reading in this.allReadings) {
        this.allLabels.push(this.allReadings[reading].date);
        this.allActive.push(this.allReadings[reading].activeEnergyConsumed);
        this.allReactive.push(this.allReadings[reading].reactiveEnergyConsumed);
      }
    },
    splitIntoParts(
      readings,
      labels,
      active,
      reactive,
      typeLabel = "date",
      recover = null
    ) {
      if (recover) {
        if (typeLabel == "date") {
          for (let reading in readings) {
            labels.push(readings[reading].date);
            active.push(readings[reading].activeEnergyConsumed);
            reactive.push(readings[reading].reactiveEnergyConsumed);
            recover.push(readings[reading].energyToRecover);
          }
        } else {
          for (let reading in readings) {
            labels.push(readings[reading].mounth);
            active.push(readings[reading].activeEnergyConsumed);
            reactive.push(readings[reading].reactiveEnergyConsumed);
            recover.push(readings[reading].energyToRecover);
          }
        }
      } else {
        if (typeLabel === "date") {
          for (let reading in readings) {
            labels.push(readings[reading].date);
            active.push(readings[reading].activeEnergyConsumed);
            reactive.push(readings[reading].reactiveEnergyConsumed);
          }
        } else {
          for (let reading in readings) {
            labels.push(readings[reading].mounth);
            active.push(readings[reading].activeEnergyConsumed);
            reactive.push(readings[reading].reactiveEnergyConsumed);
          }
        }
      }
    },
    getLastReadingsInMounths() {
      let mData = [];

      mData = this.allReadings.reduce((result, measurement) => {
        /* Convert measurement's date from ISO string to `Date` instance. */
        const date = new Date(measurement.date);

        /* Get index of the latest stored measurement of the given month. */
        const latestMonthlyMeasurementIndex = result.findIndex(
          (latestMeasurement) =>
            date.getMonth() === new Date(latestMeasurement.date).getMonth()
        );

        /* If the are no measurements from a given month - add a current measurement to the result. */
        if (latestMonthlyMeasurementIndex === -1) {
          return [...result, measurement];
        }
        if (
          date.getTime() >
          new Date(result[latestMonthlyMeasurementIndex].date).getTime()
        ) {
          const newResult = [...result];
          newResult[latestMonthlyMeasurementIndex] = measurement;
          return newResult;
        }
        console.log("koniec get last");
        /* Otherwise don't change the result */
        return result;
      }, []);
      return mData;
    },
    //get data only from every month
    // w skrócie odejmujemy od wyniku danym miesiący wynik z poprzedniego miesiąca
    calculateEveryMounth() {
      let result = [];

      result.push({
        id: this.monthlyData[0].id,
        date: this.monthlyData[0].date,
        mounth: this.monthlyData[0].mounth,
        activeEnergyConsumed: this.monthlyData[0].activeEnergyConsumed,
        reactiveEnergyConsumed: this.monthlyData[0].reactiveEnergyConsumed,
        energyToRecover: this.monthlyData[0].energyToRecover,
      });

      const multiplier = this.powerInstallation <= 10 ? 0.8 : 0.7;
      for (let i = 1; i < this.monthlyData.length; i++) {
        let newActive = null;
        let newReactive = null;
        if (
          this.monthlyData[i].activeEnergyConsumed >=
            this.monthlyData[i - 1].activeEnergyConsumed &&
          this.monthlyData[i].reactiveEnergyConsumed >=
            this.monthlyData[i - 1].reactiveEnergyConsumed
        ) {
          newActive = Number(
            (
              this.monthlyData[i].activeEnergyConsumed -
              this.monthlyData[i - 1].activeEnergyConsumed
            ).toFixed(2)
          );
          newReactive = Number(
            (
              this.monthlyData[i].reactiveEnergyConsumed -
              this.monthlyData[i - 1].reactiveEnergyConsumed
            ).toFixed(2)
          );
        } else {
          newActive = this.monthlyData[i].activeEnergyConsumed;
          newReactive = this.monthlyData[i].reactiveEnergyConsumed;
        }

        const newRecover = Number((newReactive * multiplier).toFixed(2));
        let temp = {
          id: this.monthlyData[i].id,
          date: this.monthlyData[i].date,
          mounth: this.monthlyData[i].mounth,
          activeEnergyConsumed: newActive,
          reactiveEnergyConsumed: newReactive,
          energyToRecover: newRecover,
        };
        result.push(temp);
      }
      return result;
    },
  },
};
</script>

<style scoped>
.container{
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}
</style>
