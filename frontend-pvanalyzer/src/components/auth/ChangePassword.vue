<template>
  <Form @submit="submitForm">
    <div class="form-control">
      <label class="label-form" for="email">Hasło</label>
      <Field
        class="input-form"
        type="password"
        :class="{errorLabel: errorPass}"
        id="password"
        name="password"
        rules="required|min:6"
      />
      <ErrorMessage name="password" />
    </div>
    <div class="form-control">
      <label class="label-form" for="email">Powtórz hasło</label>
      <Field
        class="input-form"
        type="password"
        id="confirmation"
        name="confirmation"
        rules="required|confirmed:@password|min:6|"
      />
      <ErrorMessage name="confirmation" />
    </div>
    <div class="buttons-group">
      <base-blue-button type="button" @click="cancelClicked"
        >Cancel</base-blue-button
      >
      <base-blue-button color="green">Save</base-blue-button>
    </div>
  </Form>
</template>

<script>
import { Form, Field, ErrorMessage, defineRule } from "vee-validate";
// import { max } from "@vee-validate/rules";
defineRule("required", (value) => {
  if (!value || !value.length) {
    return "To pole jest wymagane";
  }
  return true;
});
defineRule('min', (value, [limit]) => {
  // The field is empty so it should pass
  if (!value || !value.length) {
    return true;
  }
  if (value.length < limit) {
    return `To pole musi mieć conajmniej ${limit} znaków`;
  }
  return true;
});
defineRule("confirmed", (value, [target]) => {
  if (value === target) {
    return true;
  }
  return "Hasła muszą być takie same";
});

export default {
  components: {
    Form,
    Field,
    ErrorMessage,
  },
  emits: ["cancel-form", "save-data"],
  data() {
    return {
      enteredPassword: "",
      enteredRepeatPass: "",
      errorPass: null,
    };
  },
  computed:{
    
  },
  methods: {
    cancelClicked() {
      this.$emit("cancel-form");
    },
    submitForm(values) {
      console.log('values to:', values);
      console.log(JSON.stringify(values, null, 2));

      this.$emit('save-data', values);
    },
  },
};
</script>

<style scoped>
form {
  margin-bottom: 10px;
}
.error-label{
  background-color: rgb(238, 123, 123);
}
.form-control span {
  color: red;
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
