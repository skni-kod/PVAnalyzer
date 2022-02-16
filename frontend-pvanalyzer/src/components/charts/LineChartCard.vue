<template>
  <base-card>
    <div class="container">
      <div class="header">
        <h1>Ostatnie odczyty</h1>
        <div class="right-block">
          <a href="">Zobacz raport</a>
          <span
            ><i class="fa-solid fa-arrow-up" />
            <span class="value"> 50 kWh</span></span
          >
        </div>
      </div>
      <LineChartCard />
    </div>
  </base-card>
</template>

<script>
import LineChartCard from "./PlanetChart.vue";
export default {
  components: { LineChartCard },
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
  padding: 10px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  gap: 20px;
}
.right-block span {
  font-size: 30px;
  font-weight: bold;
  color: green;
}
</style>
