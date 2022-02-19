<template>
  <base-card>
    <div class="container">
      <div class="header">
        <h1>Bilans roczny</h1>
        <div class="right-block">
          <a href="">Zobacz raport</a>
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
  </base-card>
</template>

<script>
import BarChart from "./BarChart.vue";
export default {
  components: { BarChart },
  props: {
    balance: Number,
  },
  computed: {
    isSaved(){
      return (this.balance >=0) ? true : false
    }
  }
};
</script>

<style scoped>
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-right: 25px;
  margin-left: 40px;
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
.right-block span span{
  margin-left: 10px;
}
</style>
