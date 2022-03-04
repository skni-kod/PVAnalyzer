<template>
  <teleport to="body">
    <div class="container" v-if="show">
      <div class="dialog" >
        <div class="upper">
          <slot name="header">
            {{ title }}
          </slot>
        </div>
        <div class="content">
          <slot></slot>
        </div>
        <div class="actions">
          <slot name="actions">
            <base-blue-button @click="tryClose">Close</base-blue-button>
          </slot>
        </div>
      </div>
    </div>
  </teleport>
  <!-- <teleport to="body">
    <div class="container">
      <dialog open v-if="show">
        <div class="header">
          <slot name="header">
            <h2>{{ title }}</h2>
          </slot>
        </div>
        <div class="content">
          <slot></slot>
        </div>
        <div class="actions">
          <slot name="actions">
            <base-blue-button @click="tryClose">Close</base-blue-button>
          </slot>
        </div>
      </dialog>
    </div>
  </teleport> -->
</template>

<script>
export default {
  props: {
    show: {
      type: Boolean,
      required: true,
    },
    title: {
      type: String,
      required: false,
    },
  },
  emits: ["close"],
  methods: {
    tryClose() {
      if (this.fixed) {
        return;
      }
      this.$emit("close");
    },
  },
};
</script>

<style scoped>
.container {
  font-family: 'Lato', sans-serif;
  display: grid;
  place-items: center;
  position: fixed;
  inset: 0;
  width: 100%;
  height: 100%;
  backdrop-filter: blur(10px) grayscale(0.5);
  
}

.dialog {
  position: relative;
  width: 35%;
  background: rgb(245, 245, 245);
  text-align: center;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.26);
}

.upper {
  color: red;
  font-weight: bold;
  font-size: 18px;
  padding: 15px 0 10px 0;
}

.content {
  padding: 10px 20px;
}
.actions{
  margin: 15px 0 15px 0;
}
/* OLD */
/* .container {
  display: grid;
  place-items: center;
  position: fixed;
  inset: 0;
  width: 100%;
  height: 100%;
  z-index: 100;
}
.backdrop {
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  width: 100%;
  background-color: rgba(0, 0, 0, 0.75);
  z-index: 10;
}

dialog {
  position: fixed;
  width: 40%;
  text-align: center;
  border: none;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.26);
  background-color: white;
}
.header {
  background-color: #3a0061;
  color: white;
  width: 100%;
  padding: 1rem;
} */
</style>
