<template>
  <button v-if="!link" :style="{backgroundColor: color}">
    <i :class="icon" />
    <slot></slot>
  </button>
  <router-link v-else :to="to" :style="{backgroundColor: color}">
    <i  :class="icon" />
    <slot></slot>
  </router-link>
</template>

<script>
export default {
  props:{
    link: {
      type: Boolean,
      required: false,
      default: false
    },
    icon:{
      type: String,
      required: false,
    },
    to: {
      type: String,
      required: false,
      default: '/'
    },
    color:{
      type: String,
      required: false,
      default: '#0934a5'
    }
  }
};
</script>

<style scoped>
button,
a {
  text-decoration: none;
  font-family: "Lato", sans-serif;
  background-color: #0934a5;
  color: white;
  border: none;
  cursor: pointer;
  font-size: 12px;
  padding: 10px 15px;
}
button svg,
a svg{
  margin-right: 10px;
}
a:hover,
a:active,
button:hover,
button:active {
  background-color: #0b44d4;
}
</style>
