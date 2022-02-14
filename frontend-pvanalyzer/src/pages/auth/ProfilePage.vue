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
      <show-profile
        :user-email="userEmail"
        :user-name="userName"
        v-if="!isEdit"
      />
      <!-- edit -->
      <edit-profile
        :user-email="userEmail"
        :user-name="userName"
        v-else
        @cancel-form="showUser"
        @save-data="saveData"
      />
      <div class="with-buttons">
        <div class="one-line" v-if="!isChange">
          <label for="">Hasło</label>
          <base-blue-button @click="toggleChangePassword"
            >Zmień hasło</base-blue-button
          >
        </div>
        <change-password
          v-else
          @cancel-form="showPassword"
          @save-data="changePassword"
        />
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
      v-if="changedName"
      type="success"
      title="Sukces!"
      :desc="descMessage"
    />
  </Transition>
</template>

<script>
import ShowProfile from "../../components/auth/ShowProfile.vue";
import EditProfile from "../../components/auth/EditProfile.vue";
import ChangePassword from "../../components/auth/ChangePassword.vue";
export default {
  components: {
    ShowProfile,
    EditProfile,
    ChangePassword,
  },
  data() {
    return {
      userName: null,
      userEmail: null,
      error: null,
      isEdit: false,
      isChange: false,
      changedName: false,
      descMessage: "",
    };
  },
  created() {
    this.userName = this.$store.getters.userName;
    this.userEmail = this.$store.getters.userEmail;
  },
  methods: {
    showUser() {
      this.isEdit = false;
    },
    showPassword() {
      this.isChange = false;
    },
    toggleEdit() {
      this.isEdit = !this.isEdit;
    },
    toggleChangePassword() {
      this.isChange = !this.isChange;
    },
    async saveData(data) {
      console.log("data", data);
      try {
        await this.$store.dispatch("editProfile", data);
      } catch (err) {
        this.error = err.message;
      }
      if (!this.error) {
        this.userName = data.name;
        this.userEmail = data.email;
        this.isEdit = false;
        this.descMessage = "Dane zostały zmienione.";
        this.changedName = true;
        setTimeout(() => {
          this.changedName = false;
        }, 3000);
      }
    },
    async changePassword(data) {
      console.log("Data w rodzicu: ", data);
      try {
        await this.$store.dispatch("changePassword", data);
      } catch (err) {
        this.error = err.message;
      }
      if (!this.error) {
        this.userName = data.name;
        this.userEmail = data.email;
        this.isChange = false;
        this.descMessage = "Hasło zostały zmienione.";
        this.changedName = true;
        setTimeout(() => {
          this.changedName = false;
        }, 3000);
      }
    },
  },
};
</script>

<style scoped>
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
}
</style>
