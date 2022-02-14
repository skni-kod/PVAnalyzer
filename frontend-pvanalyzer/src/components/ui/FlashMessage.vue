<template>

  <div class="container">
    <div class="strip" :style="{ backgroundColor: isSuccess }"></div>
    <div class="content">
      <div class="title">
        <i :class="icon" :style="{ color: isSuccess }" />
        <h1>{{ title }}</h1>
      </div>
      <p>{{ desc }}</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      color: "green",
    };
  },
  computed: {
    isSuccess() {
      if (this.type === "success") {
        return "green";
      } else return "red";
    },
    icon() {
      if (this.type === "success") {
        return "fa-solid fa-circle-check";
      } else {
        return "fa-solid fa-circle-exclamation";
      }
    },
  },
  props: {
    type: {
      type: String,
      required: true,
      default: "success",
    },
    title: {
      type: String,
      required: true,
    },
    desc: {
      type: String,
      required: true,
    },
  },
};
</script>

<style scoped>

.container {
  width: fit-content;
  position: fixed;
  right: 1rem;
  bottom: 1rem;
  margin: 5px;
  height: 60px;
  display: flex;
  align-items: center;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.26);
}
.title {
  display: flex;
  align-items: center;
}
.title svg {
  margin-right: 3px;
}
h1 {
  font-size: 14px;
}
p {
  font-size: 12px;
  margin: 0;
}
h1 svg {
  color: green;
  margin-right: 3px;
}
.strip {
  width: 5px;
  height: 100%;
}
.content {
  background-color: white;
  height: 100%;
  padding-left: 10px;
  padding-right: 10px;
}
</style>
