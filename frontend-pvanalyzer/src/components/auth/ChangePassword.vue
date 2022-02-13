<template>
  <form @submit.prevent="submitForm">
    <div class="form-control">
      <label class="label-form" for="email">Hasło</label>
      <input
        class="input-form"
        type="password"
        id="password"
        v-model.trim="enteredPassword"
        required
      />
    </div>
    <div class="form-control">
      <label class="label-form" for="email">Powtórz hasło</label>
      <input
        class="input-form"
        type="password"
        id="repeatpassword"
        v-model.trim="enteredRepeatPass"
        required
      />
    </div>
    <div class="buttons-group">
      <base-blue-button type="button" @click="cancelClicked"
        >Cancel</base-blue-button
      >
      <base-blue-button color="green">Save</base-blue-button>
    </div>
  </form>
</template>

<script>
export default {
  emits: ["cancel-form", "save-data"],
  data() {
    return {
      enteredPassword: "",
      enteredRepeatPass: "",
    };
  },
  methods: {
    cancelClicked() {
      this.$emit("cancel-form");
    },
  },
};
</script>

<style scoped>
form{
  margin-bottom: 10px;
}
.container {
  margin-left: 20px;
  margin-right: 20px;
}
.container h1 {
  text-align: center;
}
.form-control {
  margin: 15px 0 15px 0;
  /* width: fit-content; */
}
.label-form {
  display: block;
  color: #1845ba;
  font-size: 12px;
  font-weight: bold;
  margin: 10px 0 10px 0;
}
.input-form {
  font-family: "Lato", sans-serif;
  font-size: 12px;
  width: 100%;
  border: none;
  outline: none;
  font-weight: bold;
  border-bottom: 1px solid black;
}
.buttons-group {
  display: flex;
  justify-content: space-around;
}
</style>
