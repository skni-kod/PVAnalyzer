<template>
  <form @submit.prevent="submitForm">
    <div class="form-control">
      <label class="label-form" for="email">Email</label>
      <input
        class="input-form"
        type="text"
        id="email"
        v-model.trim="email.val"
        required
      />
    </div>
    <div class="form-control">
      <label class="label-form" for="username">Nazwa użytkownika</label>
      <input
        class="input-form"
        type="text"
        id="username"
        v-model.trim="name.val"
        required
      />
    </div>
    <div class="buttons-group">
      <base-blue-button type="button" @click="cancelClicked">Cancel</base-blue-button>
      <base-blue-button colorButton="button-green">Save</base-blue-button>
    </div>
  </form>
</template>

<script>
export default {
  emits: ["cancel-form", "save-data"],
  props: {
    userName: String,
    userEmail: String,
  },
  data() {
    return {
      name: {
        val: "",
        isValid: true,
      },
      email: {
        val: "",
        isValid: true,
      },
      formIsValid: true,
    };
  },
  created() {
    this.name.val = this.userName;
    this.email.val = this.userEmail;
  },
  methods: {
    cancelClicked() {
      this.$emit("cancel-form");
    },
    validateForm(){
        this.formIsValid = true;
        if(this.name.val === ''){
            this.name.isValid = false;
            this.formIsValid = false;
        }
        if(this.email.val === ''){
            this.email.isValid = false;
            this.formIsValid = false;
        }
    },
    submitForm(){
        this.validateForm();

        if(!this.formIsValid){
            return;
        }

        const formData = {
            name: this.name.val,
            email: this.email.val
        }

        this.$emit('save-data', formData);
    }
  },
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
