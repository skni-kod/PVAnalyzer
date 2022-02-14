<template>
  <div class="sidebar" :style="{ width: sidebarWidth }">
    <router-link to="/dashboard">
      <h1>
        <i class="fa-solid fa-bolt" />
        <span v-if="collapsed"> </span>
        <span v-else style="margin-left: 10px">PVAnalyzer</span>
      </h1></router-link
    >
    <SidebarLink to="/dashboard" icon="fas fa-home-alt">Home</SidebarLink>
    <SidebarLink to="/pv-installation" icon="fa-solid fa-solar-panel"
      >Moja instalacja</SidebarLink
    >
    <SidebarLink to="/profile" icon="fas fa-user">{{ userName }}</SidebarLink>
    <SidebarLink @click="logout" icon="fa-solid fa-arrow-right-from-bracket"
      >Wyloguj</SidebarLink
    >
    <span
      class="collapse-icon"
      :class="{ 'rotate-180': collapsed }"
      @click="toggleSidebar"
    >
      <i class="fa-solid fa-angle-double-left" />
    </span>
  </div>
</template>

<script>
import SidebarLink from "./SidebarLink.vue";
import { collapsed, toggleSidebar, sidebarWidth } from "./state.js";
import logo from "../../assets/logo.png";
export default {
  props: {},
  components: { SidebarLink },
  setup() {
    return { collapsed, toggleSidebar, sidebarWidth, logo };
  },
  data() {
    return {
    };
  },
  computed:{
    userName(){
      return this.$store.getters.userName;
    }
  },
  methods: {
    logout() {
      this.$store.dispatch("logout");
      this.$router.replace("/login");
    },
  },
};
</script>

<style>
:root {
  --sidebar-bg-color: #0934a5;
  --sidebar-item-hover: #083bbd;
  --sidebar-item-active: #041c58;
}
</style>

<style scoped>
h1 {
  font-size: 24px;
  color: white;
}
a{
  text-decoration: none;
}

.sidebar {
  color: white;
  background-color: var(--sidebar-bg-color);
  float: left;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  bottom: 0;
  padding: 0.5em;

  transition: 0.3s ease;

  display: flex;
  flex-direction: column;
}

.collapse-icon {
  position: absolute;
  bottom: 0;
  padding: 0.75em;

  color: rgba(255, 255, 255, 0.7);

  transition: 0.2s linear;
}

.rotate-180 {
  transform: rotate(180deg);
  transition: 0.2s linear;
}
</style>
