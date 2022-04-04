<template>
    <div class="container">
      <div class="header">
        <h1>Ostatnie odczyty</h1>
        <div class="right-block">
          <router-link to="/notFound">Zobacz raport</router-link>
          <!-- <a href="">Zobacz raport</a> -->
          <!-- <span v-if="isSaved" style="color: green">
          <i class="fa-solid fa-arrow-up" />
          <span class="value"> {{ actualBalance }} kWh</span>
        </span>
        <span v-else style="color: red">
          <i class="fa-solid fa-arrow-down" />
          <span class="value"> {{ actualBalance }} kWh</span>
        </span> -->
        </div>
      </div>
      <LineChart />
    </div>
</template>

<script>
import LineChart from "./PlanetChart.vue";
export default {
  components: { LineChart },
  props: {
    actualBalance: Number,
  },
  computed: {
    isSaved(){
      return this.actualBalance >= 0 ? true : false;
    }
  }
};
</script>

<style scoped>
.container{
  display: flex;
  flex-direction: column;
  min-width: 445px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.26);

}
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
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
}
.right-block span span {
  margin-left: 5px;
}
</style>
