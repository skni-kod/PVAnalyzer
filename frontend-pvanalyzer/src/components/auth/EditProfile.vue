<template>
<base-dialog :show="isError" @close="handleError" title="Error">
    {{ errorMessage }}
  </base-dialog>
  <form @submit.prevent="submitForm">
    <div class="form-control">
      <label class="label-form" for="email">Email</label>
      <input
        class="input-form"
        type="text"
        id="email"
        v-model.trim="email"
        @blur="v$.email.$touch"
      />
    </div>
<validate-message :value="v$.email"></validate-message>
    <div class="form-control">
      <label class="label-form" for="username">Nazwa użytkownika</label>
      <input
        class="input-form"
        type="text"
        id="username"
        v-model.trim="name"
        @blur="v$.name.$touch"
      />
    </div>
    <validate-message :value="v$.name"></validate-message>
    <div class="buttons-group">
      <base-blue-button type="button" @click="cancelClicked"
        >Cancel</base-blue-button
      >
      <base-blue-button colorButton="button-green">Save</base-blue-button>
    </div>
  </form>
</template>

<script>
import ValidateMessage from "../../components/validation/ErrorMessage.vue";
import useVuelidate from "@vuelidate/core";
import { required, helpers } from "@vuelidate/validators";

export default {
  emits: ["cancel-form", "submit-clicked"],
  props: {
    userName: String,
    userEmail: String,
  },
  components: {
    ValidateMessage
  },
  data() {
    return {
      v$: useVuelidate(),
      name: "",
      email: "",
      vuelidateExternalResults: {
        email: null,
        name: null,
      },
    };
  },
  created() {
    this.name = this.userName;
    this.email = this.userEmail;
  },
  computed:{
    isError() {
      return this.$store.getters.errors == "" ? false : true;
    },
    errorMessage() {
      return this.$store.getters.errors;
    },
  },
  validations() {
    return {
      email: {
        required: helpers.withMessage("Email musi być wypełniony.", required),
      },
      name: {
        required: helpers.withMessage(
          "Nazwa użytkownika musi być wypełniona.",
          required
        ),
      },
    };
  },
  methods: {
    cancelClicked() {
      this.$emit("cancel-form");
    },
    async validate() {
      this.v$.$clearExternalResults();
      if (!(await this.v$.$validate())) {
        return true;
      }
    },
    async submitForm() {
      this.v$.$clearExternalResults();
      await this.v$.$validate();
      if (!this.v$.$invalid) {
        const formData = {};
        if (this.email != this.userEmail) formData.email = this.email;
        if (this.name != this.userName) formData.name = this.name;
        this.isLoading = true;
        const response = await this.$store.dispatch("editProfile", formData);
        if (!this.isError) {
          if (response.status == "200") {
            const successMessage = {
              title: "Sukces!",
              desc: "Dodano nowy odczyt",
            };
            const submitData = {
              email: response.data.data.email,
              name: response.data.data.name,
            }
            this.$store.commit("setMessage", successMessage);
            this.$emit("submit-clicked", submitData);
          }
          else if(response.status == 422){
          for (let e in response.errors) {
            switch (e) {
              case "name": {
                const rules = response.errors[e];
                let errors = [];
                for (let rule in rules) {
                  errors.push(response.errors[e][rule]);
                }
                this.vuelidateExternalResults.name = errors;
                break;
              }
              case "email": {
                const rules = response.errors[e];
                let errors = [];
                for (let rule in rules) {
                  errors.push(response.errors[e][rule]);
                }
                this.vuelidateExternalResults.email = errors;
                break;
              }
            }
          }
        }
        }
      }
    },
    handleError() {
      this.$store.commit("clearErrors");
    },
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
