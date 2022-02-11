<template>
  <div class="card" :style="{ marginLeft: marginLeft47 }">
    <slot></slot>
  </div>
</template>

<script>
import { sidebarWidth } from "../sidebar/state.js";
export default {
  data() {
    return {
      sidebarWidth,
    };
  },

  computed: {
    marginLeft47() {
      if (sidebarWidth.value === "180px") {
        return `260px`;
      } else {
        return `110px`;
      }
    },
  },
};
</script>

<style scoped>
.card {
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.26);
  margin-right: 80px;
  margin-top: 30px;
  padding: 1rem;
}
</style>
