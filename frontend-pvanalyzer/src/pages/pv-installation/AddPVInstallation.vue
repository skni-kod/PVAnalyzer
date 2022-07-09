<template>
  <base-card>
  <h1>Dodaj instalacje</h1>
  <form @submit.prevent="submitForm">
      <div class="form-control">
        <label class="label-form" for="date-reading">Moc instalacji</label>
        <div class="input-field">
          <input
            class="input-form"
            type="number"
            min="0"
            name="power"
            v-model="powerInstallation"
            @blur="v$.powerInstallation.$touch"
          /><span>kWh</span>
        </div>
      </div>
      <div class="form-control">
        <label class="label-form" for="date-reading">Data podłączenia instalacji</label>
        <input
          class="input-form"
          type="date"
          name="start-date"
          v-model="startDate"
          @blur="v$.startDate.$touch"
        />
      </div>
      <div class="save-button">
        <base-blue-button>Dodaj</base-blue-button>
      </div>
  </form>
  </base-card>
</template>

<script>
import useVuelidate from "@vuelidate/core";
import { required, helpers, minValue  } from "@vuelidate/validators";

export default {
  data(){
    return {
      v$: useVuelidate(),
      powerInstallation: null,
      startDate: null,
      vuelidateExternalResults: {
        powerInstallation: null,
        startDate: null,
      },
    }
  },
  validations() {
    return {
      startDate: { required: helpers.withMessage('Data musi być wypełniona.', required) },
      powerInstallation: { 
        required: helpers.withMessage('Moc instalacji musi być wypełniona.', required),
        minValue: helpers.withMessage('Moc instalacji musi być większa od 0.', minValue(1))
        },
    };
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
        const formData = {
          startDate: this.startDate,
          power: this.powerInstallation,
        };
        console.log('form data', formData);
        const response = await this.$store.dispatch(
          "pVInstallation/addNewInstallation",
          formData
        );
        console.log('respo status', response);
        if (response.status == "201") {
          const successMessage = {
            title: "Sukces!",
            desc: "Dodano nową instalację" 
          }
          this.$store.commit('setMessage', successMessage);
          this.$router.replace("/dashboard");
        }
        if (response.status == "422") {
          for (let e in response.errors) {
            switch (e) {
              case "date": {
                const rules = response.errors[e];
                let errors = [];
                for (let rule in rules) {
                  errors.push(response.errors[e][rule]);
                }
                this.vuelidateExternalResults.startDate = errors;
                break;
              }
              case "power": {
                const rules = response.errors[e];
                let errors = [];
                for (let rule in rules) {
                  errors.push(response.errors[e][rule]);
                }
                this.vuelidateExternalResults.powerInstallation = errors;
                break;
              }
            }
          }
        }
      }
    },
  },
}
</script>

<style scoped>
.form-control {
  margin: 15px 0 15px 0;
}
.label-form {
  display: block;
  color: #1845ba;
  font-size: 16px;
  font-weight: bold;
  margin: 10px 0 10px 0;
}
.input-field {
  display: flex;
  font-weight: bold;
}
.input-form {
  font-family: "Lato", sans-serif;
  font-size: 16px;
  text-align: end;
  width: 100%;
  border: none;
  outline: none;
  font-weight: bold;
  border-bottom: 1px solid black;
}
.save-button {
  text-align: center;
}
</style>