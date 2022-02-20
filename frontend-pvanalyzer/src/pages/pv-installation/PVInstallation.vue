<template>
  <base-card>
    <div class="container">
      <h1>Twoja instalacja</h1>
      <img src="./solar-energy.jpg" alt="Energia słoneczna" />
      <div class="content">
        <span>Data zainstalowania: {{ dateStart }}</span>
        <span>Moc instalacji: {{ power }} kW</span>
      </div>
    </div>
    <!-- PVInstallation page
  <i class="fa-solid fa-arrow-right-from-bracket" /> -->
  </base-card>
</template>

<script>
export default {
  data() {
    return {
      power: null,
      dateStart: "",
    };
  },
  created(){
    this.power = this.$store.getters['pVInstallation/powerInstallation'];
    this.dateStart = this.$store.getters['pVInstallation/startWorking'];
  }
};
</script>

<style scoped>
.container {
  text-align: center;
}
.content {
  display: flex;
  justify-content: center;
  flex-direction: column;
}
img {
  max-width: 50%;
  height: auto;
  border-radius: 20%;
}
</style>
