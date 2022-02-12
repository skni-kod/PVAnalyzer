<template>
  <base-card>
    <div class="containter">
      <div class="header">
        <img
          src="./oki.png"
          height="115"
          width="90"
          alt="profile foto"
        />
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
            />
          </div>
          <div class="form-control">
            <label class="label-form" for="username">Nazwa użytkownika</label>
            <input
              class="input-form"
              type="text"
              id="username"
              v-model.trim="enteredName"
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
</template>

<script>
export default {
  data() {
    return {
      userName: '',
      userEmail: '',
      enteredName: '',
      enteredEmail: '',
      error: '',
      isEdit: false,
    };
  },
  created(){
    this.userName = this.$store.getters.userName;
    this.userEmail = this.$store.getters.userEmail;
  },
  methods: {
    toggleEdit() {
      this.isEdit = !this.isEdit;
      this.enteredName = this.userName;
      this.enteredEmail = this.userEmail;
    },
    async submitForm(){
      const actionPayload = {
        email: this.enteredEmail,
        name: this.enteredName
      };

      try{
        await this.$store.dispatch('editProfile', actionPayload);
        const redirectUrl = "/profile";
        this.$router.push(redirectUrl);
      }catch(err){
        this.error = err.message;
      }
    }
  },
};
</script>

<style scoped>
img{
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
.buttons-group{
  display: flex;
  justify-content: space-around;
  /* margin-bottom: 5px; */
}
</style>
