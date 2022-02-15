<template>
  <PlanetChart/>
</template>

<script>
import PlanetChart from './PlanetChart.vue'

export default {
  components: {
    PlanetChart
  },
  created(){
    this.loadReadings()
  },
  methods: {
    async loadReadings(){
      try{
        // const id = this.$store.getters['pVInstallation/installationId']
        await this.$store.dispatch('readings/loadCounterReadings');
      } catch (error) {
        this.error = error.message || 'Something went wrong!';
      }
    }
  }
}
</script>