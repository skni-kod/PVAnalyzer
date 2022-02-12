<template>
  <base-card>
    <div class="containter">
      <div class="header">
        <img src="./oki.png" height="115" width="90" alt="profile foto" />
        <base-blue-button
          icon="fa-solid fa-pencil"
          style="margin-bottom: auto"
          v-if="!isEdit"
          @click="toggleEdit"
          >Edytuj profil</base-blue-button
        >
      </div>
      <!-- show -->
      <div class="content" v-if="!isEdit">
        <div class="form-control">
          <label class="label-form" for="email">Email</label>
          <span>{{ userEmail }}</span>
        </div>
        <div class="form-control">
          <label class="label-form" for="username">Nazwa użytkownika</label>
          <span>{{ userName }}</span>
        </div>
      </div>
      <!-- edit -->
      <div v-else>
        <form @submit.prevent="submitForm">
          <div class="form-control">
            <label class="label-form" for="email">Email</label>
            <input
              class="input-form"
              type="text"
              id="email"
              v-model.trim="enteredEmail"
              required
            />
          </div>
          <div class="form-control">
            <label class="label-form" for="username">Nazwa użytkownika</label>
            <input
              class="input-form"
              type="text"
              id="username"
              v-model.trim="enteredName"
              required
            />
          </div>
          <div class="buttons-group">
            <base-blue-button @click="toggleEdit">Cancel</base-blue-button>
            <base-blue-button color="green">Save</base-blue-button>
          </div>
        </form>
      </div>
      <div class="with-buttons" v-if="!isEdit">
        <div class="one-line">
          <label for="">Hasło</label>
          <base-blue-button>Zmień hasło</base-blue-button>
        </div>
        <div class="one-line">
          <label for="">Instrukcje</label>
          <base-blue-button link to="/pv-installation"
            >Moje instrukcje</base-blue-button
          >
        </div>
      </div>
    </div>
  </base-card>
  <Transition name="slide-fade">
    <flash-message
      v-if="showMessage"
      type="success"
      title="Success!"
      desc="Edycja danych zakończona sukcesem."
    />
  </Transition>
</template>

<script>
export default {
  data() {
    return {
      userName: null,
      userEmail: null,
      enteredName: "",
      enteredEmail: "",
      error: null,
      isEdit: false,
      showMessage: false,
    };
  },
  created() {
    this.userName = this.$store.getters.userName;
    this.userEmail = this.$store.getters.userEmail;
  },
  methods: {
    toggleEdit() {
      this.isEdit = !this.isEdit;
      this.enteredName = this.userName;
      this.enteredEmail = this.userEmail;
    },
    async submitForm() {
      const actionPayload = {
        email: this.enteredEmail,
        name: this.enteredName,
      };
      try {
        await this.$store.dispatch("editProfile", actionPayload);
      } catch (err) {
        this.error = err.message;
      }
      if (!this.error) {
        this.userName = this.enteredName;
        this.userEmail = this.enteredEmail;
        this.isEdit = false;
        this.showMessage = true;
        setTimeout(() => {
          this.showMessage = false;
        }, 3000);
      }
    },
  },
};
</script>

<style scoped>
/*
  Enter and leave animations can use different
  durations and timing functions.
*/
.slide-fade-enter-active {
  transition: all 0.7s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.4s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(90px);
  opacity: 0;
}
.alert {
  width: 40%;
}
img {
  border-radius: 20%;
}
.header {
  display: flex;
  justify-content: space-between;
}

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
.one-line {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}
.with-buttons label {
  display: block;
  color: #1845ba;
  font-size: 12px;
  font-weight: bold;
  margin: 10px 0 10px 0;
}
.buttons-group {
  display: flex;
  justify-content: space-around;
  /* margin-bottom: 5px; */
}
</style>
