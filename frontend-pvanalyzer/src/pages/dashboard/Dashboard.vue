<template>
  <div
    class="container"
    v-if="!isLoading"
    :style="{ marginLeft: marginLeftComputed }"
  >
    <div v-if="hasReadings">
    <line-chart-card :actualBalance="actualBalance"></line-chart-card>
    <bar-chart-card :balance="balance"></bar-chart-card>
    </div>
    <last-readings-table
      :tableData="tableData"
    ></last-readings-table>
  </div>
  <div v-else>
    <loading v-model:active="isLoading" :can-cancel="true" :opacity="1" />
  </div>
  <Transition name="slide-fade">
    <flash-message
      v-if="message.desc"
      type="success"
      :title="message.title"
      :desc="message.desc"
    />
  </Transition>
</template>

<script>
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

import LastReadingsTable from "../../components/counter-readings/ReadingsListContainer.vue";
import LineChartCard from "../../components/counter-readings/charts/LineChartCard.vue";
import BarChartCard from "../../components/counter-readings/charts/BarChardCard.vue";
import { sidebarWidth } from "../../components/sidebar/state.js";
export default {
  components: { LineChartCard, BarChartCard, LastReadingsTable, Loading },
  data() {
    return {
      allLabels: [], //wszystkie daty z bazy
      allActive: [], //wszystkie odczyty pobrane z sieci
      allReactive: [], //wszystkie odczyty oddane do sieci
      allRecover: [],
      calculatedMonthlyReadings: [],
      monthlyLabels: [],
      isLoading: true,
      changesIsSuccess: false,
      descMessage: null,
      message: {
        title: '',
        desc: ''
      }
    };
  },
  computed: {
    marginLeftComputed() {
      if (sidebarWidth.value === "180px") {
        return `200px`;
      } else {
        return `110px`;
      }
    },
    allReadings() {
      return this.$store.getters["readings/counterReadings"];
    },
    hasReadings(){
      return (this.$store.getters["readings/counterReadings"].length)?true:false;
    },
    powerInstallation() {
      return this.$store.getters["pVInstallation/powerInstallation"];
    },
    monthlyData() {
      return this.getLastReadingsInMonths();
    },
    balance() {
      return 0;
      // return this.monthlyData[this.monthlyData.length - 1].balance;
    },
    actualBalance() {
      // return this.allReadings[this.allReadings.length - 1].balance;
      return 0;
    },
    tableData() {
      return this.allReadings.slice(-5);
    }
  },
  async created() {
    await this.addNewReading();
    await this.loadCounterReadings();
  },
  provide() {
    return {
      allLabels: this.allLabels,
      allActive: this.allActive,
      allReactive: this.allReactive,
      allRecover: this.allRecover,
      getCalculatedData: () => this.calculatedMonthlyReadings,
      calculatedMonthlyActive: this.calculatedMonthlyActive,
    };
  },
  methods: {
    addNewReading() {
      this.message = this.$store.getters.successMessage;
      if(this.message.desc === 'Dodano nowy odczyt'){
        this.$store.commit('readings/clearLastFetch');
      }
      if(this.message){
        
        setTimeout(() => {
        this.$store.commit('clearSuccessMessage');
        this.message = this.$store.getters.successMessage;
      }, 3000);
      }
      
    },
    async loadCounterReadings() {
      try {
        await this.$store.dispatch("readings/loadCounterReadings");
        this.splitIntoParts(
          this.allReadings,
          this.allLabels,
          this.allActive,
          this.allReactive,
          "date",
          this.allRecover
        );
        this.calculatedMonthlyReadings = this.calculateEverymonth();
        this.splitIntoParts(
          this.calculatedMonthlyReadings,
          this.calculatedMonthlyLabels,
          this.calculatedMonthlyActive,
          this.calculatedMonthlyReactive,
          "month",
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
            labels.push(readings[reading].month);
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
            labels.push(readings[reading].month);
            active.push(readings[reading].activeEnergyConsumed);
            reactive.push(readings[reading].reactiveEnergyConsumed);
          }
        }
      }
    },
    getLastReadingsInMonths() {
      const allData = this.allReadings;
      const length = allData.length;
      let results = [];
      for (let i = 1; i < length; i++) {
        let previousData = new Date(allData[i - 1].date);
        let nextData = new Date(allData[i].date);
        let previousMonth = previousData.getMonth();
        let nextMonth = nextData.getMonth();
        if (nextMonth !== previousMonth) {
          results.push(allData[i - 1]);
        }
      }
      const lastDay = new Date(allData[length - 1]);
      const dayBeforeLast = new Date(allData[length - 2]);
      const lastDayMonth = lastDay.getMonth();
      const dayBeforeLastMonth = dayBeforeLast.getMonth();
      if (lastDayMonth !== dayBeforeLastMonth) {
        results.push(allData[allData.length - 1]);
      }
      return results;
    },
    //get data only from every month
    // w skrócie odejmujemy od wyniku danym miesiący wynik z poprzedniego miesiąca
    calculateEverymonth() {
      let result = [];

      result.push({
        id: this.monthlyData[0].id,
        date: this.monthlyData[0].date,
        month: this.monthlyData[0].month,
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
          month: this.monthlyData[i].month,
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
.slide-fade-enter-active {
  transition: all 0.7s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.4s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(90px);
  opacity: 0;
}
.container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 30px;
  /* box-shadow: 0 2px 8px rgba(0, 0, 0, 0.26); */
  padding: 1rem 18px;
}
</style>
