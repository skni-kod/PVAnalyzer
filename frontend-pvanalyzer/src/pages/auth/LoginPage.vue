<template>
  <base-login-register>
    <div class="box">
      <div class="content">
        <form @submit.prevent="siema">
          <div class="form-control">
            <label class="label-form" for="username">Nazwa użytkownika</label>
            <input
              class="input-form"
              type="text"
              id="username"
              placeholder="Email"
              v-model.trim="email"
              required
            />
          </div>
          <div class="form-control">
            <label class="label-form" for="password">Hasło </label>
            <input
              class="input-form"
              type="password"
              id="password"
              placeholder="Hasło"
              v-model.trim="password"
              required
            />
          </div>
        </form>
      </div>
      <div class="submit-button">
        <button type="submit" @click="submitForm">Zaloguj się</button>
      </div>
    </div>

    <div class="bottom-text">
      <span>Nie masz konta? <router-link to="/register">Załóż konto</router-link></span>
    </div>
  </base-login-register>
</template>

<script>
export default {
  data() {
    return {
      email: "",
      password: "",
      error: null,
    };
  },

  methods: {
    async submitForm() {
      const actionPayload = {
        email: this.email,
        password: this.password,
      };

      try {
        await this.$store.dispatch("login", actionPayload);
        await this.$store.dispatch("pVInstallation/loadInstallation");
        const redirectUrl = "/" + (this.$route.query.redirect || "dashboard");
        console.log("Logowanie zakończone powodzeniem");
        this.$router.replace(redirectUrl);
      } catch (err) {
        this.error = err.message;
      }
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
  margin: 15px 0 15px 0;
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
</style>
