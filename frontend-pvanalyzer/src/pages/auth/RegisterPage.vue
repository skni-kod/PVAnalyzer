<template>
  <base-dialog :show="isError" @close="handleError" title="Error">
    {{ errorMessage }}
  </base-dialog>
  <div v-if="isLoading">
    <loading v-model:active="isLoading" :can-cancel="true" :opacity="1" />
  </div>
  <base-login-register v-else>
    <div class="box">
      <form @submit.prevent="submitForm">
        <div class="content">
          <div class="form-control">
            <label class="label-form" for="email">Email</label>
            <input
              class="input-form"
              type="text"
              id="email"
              placeholder="Email"
              v-model.trim="email"
              @blur="v$.email.$touch"
            />
            <validate-message :value="v$.email"></validate-message>
          </div>
          <div class="form-control">
            <label class="label-form" for="username">Nazwa użytkownika</label>
            <input
              class="input-form"
              type="text"
              id="username"
              placeholder="Nazwa użytkownika"
              v-model.trim="userName"
              @blur="v$.userName.$touch"
            />
            <validate-message :value="v$.userName"></validate-message>
          </div>
          <div class="form-control">
            <label class="label-form" for="password">Hasło </label>
            <input
              class="input-form"
              type="password"
              id="password"
              placeholder="Hasło"
              v-model.trim="password"
              @blur="v$.password.$touch"
            />
            <validate-message :value="v$.password"></validate-message>
          </div>
          <div class="form-control">
            <label class="label-form" for="repeat-password"
              >Powtórz hasło</label
            >
            <input
              class="input-form"
              type="password"
              id="repeat-password"
              placeholder="Powtórz hasło"
              v-model.trim="repeatPassword"
              @blur="v$.repeatPassword.$touch"
            />
            <validate-message :value="v$.repeatPassword"></validate-message>
          </div>
          <div class="form-control-checkbox">
            <input type="checkbox" id="statute" v-model="statute" />
            <label for="statute">Akceptuję <a href="">regulamin</a> </label>
          </div>
          <validate-message :value="v$.statute"></validate-message>
        </div>
        <div class="submit-button">
          <button>Utwórz konto</button>
        </div>
      </form>
    </div>
    <div class="bottom-text">
      <span
        >Masz już konto?
        <router-link to="/login">Zaloguj się</router-link>
      </span>
    </div>
  </base-login-register>
</template>

<script>
import ValidateMessage from "../../components/validation/ErrorMessage.vue";
import useVuelidate from "@vuelidate/core";
import {
  email,
  minLength,
  required,
  helpers,
  sameAs,
} from "@vuelidate/validators";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {
  components: {
    ValidateMessage,
    Loading,
  },
  setup() {},
  data() {
    return {
      v$: useVuelidate(),
      vuelidateExternalResults: {
        email: "",
        userName: "",
        password: "",
        repeatPassword: "",
        statute: null,
      },
      isLoading: false,
      email: "",
      userName: "",
      password: "",
      repeatPassword: "",
      statute: null,
    };
  },
  validations() {
    return {
      email: {
        email: helpers.withMessage("Email jest niepoprawny", email),
        required: helpers.withMessage("Email musi być podany.", required),
      },
      userName: {
        minLength: helpers.withMessage(
          "Nazwa użytkownia musi mieć min 4 znaki.",
          minLength(4)
        ),
        required: helpers.withMessage(
          "Nazwa użytkownika musi być podana.",
          required
        ),
      },
      password: {
        minLength: helpers.withMessage(
          "Hasło musi mieć min 8 znaków.",
          minLength(8)
        ),
        required: helpers.withMessage("Hasło musi być podane.", required),
      },
      repeatPassword: {
        sameAs: helpers.withMessage(
          "Hasła muszą być identyczne",
          sameAs(this.password)
        ),
        minLength: helpers.withMessage(
          "Hasło musi mieć min 8 znaków.",
          minLength(8)
        ),
        required: helpers.withMessage("Hasło musi być podane.", required),
      },
      statute: {
        required: helpers.withMessage(
          "Musisz zaakceptować regulamin.",
          required
        ),
      },
    };
  },
  computed: {
    isError() {
      return this.$store.getters.errors == "" ? false : true;
    },
    errorMessage() {
      return this.$store.getters.errors;
    },
  },
  methods: {
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
        const actionPayload = {
          email: this.email,
          name: this.userName,
          password: this.password,
          password_confirmation: this.repeatPassword,
        };
        this.isLoading = true;
        const response = await this.$store.dispatch("register", actionPayload);
        this.isLoading = false;
        if (!this.isError) {
          if (response.status == "201") {
            this.$router.replace("/login");
          }
          if (response.status == "422") {
            for (let e in response.errors) {
              switch (e) {
                case "name": {
                  const rules = response.errors[e];
                  let errors = [];
                  for (let rule in rules) {
                    errors.push(response.errors[e][rule]);
                  }
                  this.vuelidateExternalResults.userName = errors;
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
                case "password": {
                  const rules = response.errors[e];
                  let errors = [];
                  for (let rule in rules) {
                    errors.push(response.errors[e][rule]);
                  }
                  this.vuelidateExternalResults.password = errors;
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
.box {
  box-shadow: 0 5px 8px rgba(0, 0, 0, 0.26);
  margin: 5% 15% 0 15%;
}

.content {
  padding: 10px 40px 10px 40px;
  background-color: #ffffff;
}
.form-control {
  margin: 10px 0 10px 0;
}
.label-form {
  display: block;
  color: #1845ba;
  font-size: 12px;
  margin: 5px 0 5px 0;
}
.input-form {
  font-size: 12px;
  width: 100%;
  border: none;
  outline: none;
  border-bottom: 1px solid black;
}

.submit-button button {
  width: 100%;
  text-align: center;
  padding: 20px 0 20px 0;
  background-color: #0934a5;
  color: #ffffff;
  font-size: 18px;
  font-weight: bold;
  border: none;
}
a:hover,
a:active {
  cursor: pointer;
  color: #0044e2;
}
button:hover,
button:active {
  cursor: pointer;
  background-color: #0044e2;
  border-color: #0044e2;
}
.error-message {
  color: red;
  font-size: 10px;
  font-weight: 600;
  margin-top: 5px;
}

.bottom-text {
  padding-top: 11px;
  margin-left: 15%;
  margin-right: 15%;
  text-align: center;
}
.bottom-text span {
  color: #0934a5;
  font-size: 12px;
}
.form-control-checkbox {
  display: flex;
  align-items: center;
}
.form-control-checkbox label {
  font-size: 12px;
  font-weight: 600;
  margin-left: 15px;
}
@media screen and (max-width: 650px) {
  .bottom-text {
    margin-bottom: 20px;
  }
}
</style>
