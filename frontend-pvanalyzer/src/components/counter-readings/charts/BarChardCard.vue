<template>
  <div class="container">
    <div class="header">
      <h1>Bilans roczny</h1>
      <div class="right-block">
        <router-link to="/notFound">Zobacz raport</router-link>
        <span v-if="isSaved" style="color: green">
          <i class="fa-solid fa-arrow-up" />
          <span class="value"> {{ balance }} kWh</span>
        </span>
        <span v-else style="color: red">
          <i class="fa-solid fa-arrow-down" />
          <span class="value"> {{ balance }} kWh</span>
        </span>
      </div>
    </div>
    <bar-chart></bar-chart>
  </div>
</template>

<script>
import BarChart from "./BarChart.vue";
export default {
  components: { BarChart },
  props: {
    balance: Number,
  },
  computed: {
    isSaved() {
      return this.balance >= 0 ? true : false;
    },
  },
};
</script>

<style scoped>
.container {
  display: flex;
  flex-direction: column;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.26);
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.right-block {
  padding-bottom: 10px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
}
.right-block span {
  font-size: 30px;
  font-weight: bold;
  /* color: green; */
}
.right-block span span {
  margin-left: 5px;
}
</style>
