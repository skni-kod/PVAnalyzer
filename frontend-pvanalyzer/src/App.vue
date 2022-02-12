<template>
  <div v-if="isLoggedIn">
    <Sidebar />
    <div :style="{ 'margin-left': sidebarWidth }"></div>
  </div>
  <router-view>
  </router-view>
</template>

<script>
import Sidebar from "./components/sidebar/Sidebar.vue";
import { sidebarWidth } from "./components/sidebar/state.js";

export default {
  name: "App",
  components: { Sidebar },
  setup() {
    return { sidebarWidth };
  },
  data() {
    return {};
  },
  computed: {
    isLoggedIn() {
      return this.$store.getters.isAuthenticated;
    },
  },

  methods: {},
};
</script>

<style>
body {
  /* min-height: 100vh */
  height: 100vh;
  /* height: 100%; */
}
#app {
  /* height: 100vh; */
  height: 100%;
  font-family: 'Lato', sans-serif;
    /* font-weight: 900; */
  /* font-family: Helvetica, Arial, sans-serif; */
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
</style>
