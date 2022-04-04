<template>
  <button v-if="!link" :class="colorButton">
    <i :class="icon" />
    <slot></slot>
  </button>
  <router-link v-else :to="to" :class="colorButton">
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
    },
    colorButton:{
      type: String,
      required: false,
      default: 'button-blue'
    }
  }
};
</script>

<style scoped>
.button-blue{
  background-color: #0934a5;
}
.button-blue:hover,
.button-blue:active{
  background-color: #0044e2;
  cursor: pointer;
}
.button-green{
  background-color: green;
}
.button-green:hover,
.button-green:active{
  background-color: #42ac00;
  cursor: pointer;
}
button,
a {
  text-decoration: none;
  font-family: "Lato", sans-serif;
  text-align: center;
  color: white;
  border: none;
  font-size: 16px;
  padding: 10px 15px;
}
button svg,
a svg{
  margin-right: 10px;
}
/* a:hover,
a:active,
button:hover,
button:active {
   !important;
  
} */
</style>
