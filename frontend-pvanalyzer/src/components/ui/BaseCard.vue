<template>
  <div class="card">
      <slot></slot>
  </div>
</template>

<script>
export default {

}
</script>

<style scoped>
.card{
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.26);
}
</style>