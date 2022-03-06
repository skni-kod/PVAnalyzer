<template>
  <div class="error-message" v-if="value.$error">
          <span v-for="error in value.$errors" :key="error.$uid">{{
            error.$message
          }}</span>
        </div>
</template>

<script>
export default {
    props:{
    value: {
      type: Object,
      required: true,
    }
    }

}
</script>

<style scoped>
.error-message {
  display: flex;
  flex-direction: column;
  color: red;
  font-size: 12px;
}
</style>