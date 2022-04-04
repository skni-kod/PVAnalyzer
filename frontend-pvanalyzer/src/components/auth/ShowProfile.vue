<template>
  <div class="content">
    <div class="form-control">
      <label class="label-form" for="email">Email</label>
      <span>{{ userEmail }}</span>
    </div>
    <div class="form-control">
      <label class="label-form" for="username">Nazwa użytkownika</label>
      <span>{{ userName }}</span>
    </div>
  </div>
</template>

<script>
export default {
props: {
    userName: String,
    userEmail: String
}

};
</script>

<style scoped>
.form-control {
  margin: 15px 0 15px 0;
}
.form-control span {
  font-weight: 900;
  font-size: 12px;
}
.label-form {
  display: block;
  color: #1845ba;
  font-size: 12px;
  font-weight: bold;
  margin: 10px 0 10px 0;
}
</style>
