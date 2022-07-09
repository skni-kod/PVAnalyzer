<template>
  <base-dialog :show="isError" @close="handleError" title="Error">
    {{ errorMessage }}
  </base-dialog>
  <div v-if="isLoading">
    <loading v-model:active="isLoading" :can-cancel="true" :opacity="1" />
  </div>
  <base-login-register v-else>
    <div class="box">
      <div class="content">
        <form @submit.prevent="submitForm">
          <div class="form-control">
            <label class="label-form" for="username">Nazwa użytkownika</label>
            <input class="input-form" type="text" id="username" placeholder="Email" v-model.trim="email"
              @blur="v$.email.$touch" />
            <div class="error-message" v-if="v$.email.$error">
              <span v-for="error in v$.email.$errors" :key="error.$uid">{{
                  error.$message
              }}</span>
            </div>
          </div>
          <div class="form-control">
            <label class="label-form" for="password">Hasło </label>
            <input class="input-form" type="password" id="password" placeholder="Hasło" v-model.trim="password"
              @blur="v$.password.$touch" />
            <div class="error-message" v-if="v$.password.$error">
              <span v-for="error in v$.password.$errors" :key="error.$uid">{{
                  error.$message
              }}</span>
            </div>
          </div>
          <div class="submit-button">
            <button>Zaloguj się</button>
          </div>
        </form>
      </div>
    </div>

    <div class="bottom-text">
      <span>Nie masz konta?
        <router-link to="/register">Załóż konto</router-link>
      </span>
    </div>
  </base-login-register>

</template>

<script>
import useVuelidate from "@vuelidate/core";
import { required, helpers } from "@vuelidate/validators";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {
  components: {
    Loading
  },
  data() {
    return {
      v$: useVuelidate(),
      isLoading: false,
      email: "",
      password: "",
      error: null,
      vuelidateExternalResults: {
        email: null,
        password: null,
      },
    };
  },
  validations() {
    return {
      email: {
        required: helpers.withMessage("Email musi być wypełniony.", required),
      },
      password: {
        required: helpers.withMessage("Hasło musi być wypełniony.", required),
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
          password: this.password,
        };
        this.isLoading = true;
        const response = await this.$store.dispatch("login", actionPayload);

        if (!this.isError) {
          if (response.status == "201") {
            
            const hasInstallation =  await this.$store.dispatch("pVInstallation/loadInstallation");
            
            console.log(hasInstallation == true);
            const dashboardUrl = "/" + (this.$route.query.redirect || "dashboard");
            const addReadingUrl = '/add-installation';
            (this.$store.getters["pVInstallation/hasInstallation"]) ? this.$router.replace(dashboardUrl) : this.$router.replace(addReadingUrl);
          }
          if (response.status == "401") {
            this.isLoading = false;
            const rules = response.errors;
            this.vuelidateExternalResults.password = rules;
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
  padding-top: 5px;
  background-color: #ffffff;
}

.form-control {
  margin: 15px 0 15px 0;
  padding: 0 40px 0 40px;
}

.label-form {
  display: block;
  color: #1845ba;
  font-size: 12px;
  margin: 10px 0 10px 0;
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
  color: #0044e2;
}

button:hover,
button:active {
  background-color: #0044e2;
  border-color: #0044e2;
  cursor: pointer;
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

.form-control-checkbox label {
  font-size: 16px;
  margin-left: 15px;
}

@media screen and (max-width: 650px) {
  .bottom-text {
    margin-bottom: 20px;
  }
}

.error-message {
  display: flex;
  flex-direction: column;
  color: red;
  font-size: 12px;
}

.error-message span {
  display: block;
}
</style>
