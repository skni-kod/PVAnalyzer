<template>
  <base-login-register>
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
            />
            <p class="error-message" v-if="errors['emailE']">
              Login jest wymagany
            </p>
          </div>
          <div class="form-control">
            <label class="label-form" for="username">Nazwa użytkownika</label>
            <input
              class="input-form"
              type="text"
              id="username"
              placeholder="Nazwa użytkownika"
              v-model.trim="userName"
            />
            <p class="error-message" v-if="errors['userNameE']">
              Nazwa użytkownika jest wymagana
            </p>
          </div>
          <div class="form-control">
            <label class="label-form" for="password">Hasło </label>
            <input
              class="input-form"
              type="password"
              id="password"
              placeholder="Hasło"
              v-model.trim="password"
            />
            <p class="error-message" v-if="errors['passwordE']">
              Hasło jest wymagane
            </p>
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
            />
            <p class="error-message" v-if="errors['repeatPasswordE']">
              Hasło jest wymagane
            </p>
          </div>
          <div class="form-control-checkbox">
            <input type="checkbox" id="statute" v-model="statute" />
            <label for="statute">Akceptuję <a href="">regulamin</a> </label>
            <p class="error-message" v-if="errors['statuteE']">
              Musisz zaakceptować regulamin
            </p>
          </div>
        </div>
        <div class="submit-button">
          <button>Utwórz konto</button>
        </div>
      </form>
    </div>

    <div class="bottom-text">
      <span
        >Masz już konto?
        <router-link to="/login">Zaloguj się</router-link></span
      >
    </div>
  </base-login-register>
</template>

<script>
export default {
  setup() {},
  data() {
    return {
      errors: {
        emailE: "",
        userNameE: "",
        passwordE: "",
        repeatPasswordE: "",
        statuteE: "",
      },
      formIsOk: true,
      email: "",
      userName: "",
      password: "",
      repeatPassword: "",
      statute: null,
    };
  },
  computed: {},
  methods: {
    valitation() {
      if (this.email == "") {
        this.errors["emailE"] = "Email jest wymagany.";
        this.formIsOk = false;
      }
      if (this.userName == "") {
        this.errors["userNameE"] = "Nazwa użytkownika jest wymagana.";
        this.formIsOk = false;
      }
      if (this.password == "") {
        this.errors["passwordE"] = "Hasło jest wymagane.";
        this.formIsOk = false;
      }
      if (this.repeatPassword == "") {
        this.errors["repeatPasswordE"] = "Hasło jest wymagane.";
        this.formIsOk = false;
      }
      if (this.statute === null) {
        this.errors["statuteE"] = "Musisz akceptować regulamin";
        this.formIsOk = false;
      }
    },
    async submitForm() {
      this.initErrors();
      console.log("form rejestracji wysłany");
      console.log(this.errors);
      this.valitation();

      if (this.formIsOk) {
        console.log('walidacja przebiegła poprawnie');
        const actionPayload = {
          email: this.email,
          name: this.userName,
          password: this.password,
          password_confirmation: this.repeatPassword,
        };

        try {
         await this.$store.dispatch("register", actionPayload);
         const redirectUrl = "/login";
         this.$router.replace(redirectUrl); 
        }catch (err){
          this.errors = err.message;
        }
      }
    },
    initErrors() {
      this.errors = {
        emailE: "",
        userNameE: "",
        passwordE: "",
        repeatPasswordE: "",
        statuteE: "",
      };
      this.formIsOk = true;
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
  color: #0044e2;
}
button:hover,
button:active {
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
