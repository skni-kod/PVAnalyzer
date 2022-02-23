<template>
  <base-card>
    <h1>Dodaj odczyt</h1>
    <form @submit.prevent="submitForm">
      <div class="form-control">
        <label class="label-form" for="date-reading">Data oczytu</label>
        <input
          class="input-form"
          type="date"
          name="date-reading"
          v-model="date"
          @blur="v$.date.$touch"
        />
        <div class="error-message" v-if="v$.date.$error">
          <span v-for="error in v$.date.$errors" :key="error.$uid">{{
            error.$message
          }}</span>
        </div>
      </div>
      <div class="form-control">
        <label class="label-form" for="date-reading">Energia pobrana</label>
        <div class="input-field">
          <input
            class="input-form"
            type="number"
            name="activeEnergy"
            v-model="activeEnergyConsumed"
            @blur="v$.activeEnergyConsumed.$touch"
          /><span>kWh</span>
        </div>
        <div class="error-message" v-if="v$.activeEnergyConsumed.$error">
          <span
            v-for="error in v$.activeEnergyConsumed.$errors"
            :key="error.$uid"
            >{{ error.$message }}</span
          >
        </div>
      </div>
      <div class="form-control">
        <label class="label-form" for="date-reading">Energia oddana</label>
        <div class="input-field">
          <input
            class="input-form"
            type="number"
            min="0"
            step="0.1"
            name="activeEnergy"
            v-model="reactiveEnergyConsumed"
            @blur="v$.reactiveEnergyConsumed.$touch"
          />
          kWh
        </div>
        <div class="error-message" v-if="v$.reactiveEnergyConsumed.$error">
          <span
            v-for="error in v$.reactiveEnergyConsumed.$errors"
            :key="error.$uid"
            >{{ error.$message }}</span
          >
        </div>
      </div>
      <div class="save-button">
        <base-blue-button>Dodaj</base-blue-button>
      </div>
    </form>
  </base-card>
</template>

<script>
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";

export default {
  data() {
    return {
      v$: useVuelidate(),
      date: null,
      activeEnergyConsumed: "",
      reactiveEnergyConsumed: null,
      vuelidateExternalResults: {
        date: null,
        activeEnergyConsumed: null,
        reactiveEnergyConsumed: null,
      },
    };
  },
  validations() {
    return {
      date: { required },
      activeEnergyConsumed: { required },
      reactiveEnergyConsumed: { required },
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
          date: this.date,
          active: this.activeEnergyConsumed,
          reactive: this.reactiveEnergyConsumed,
        };
        const response = await this.$store.dispatch(
          "readings/addNewReading",
          formData
        );
        console.log(response);
        if (response.status == "201") {
          console.log('Dodano nowy odczyt');
          this.$router.replace("/dashboard");
        }
        if (response.status == "422") {
          for (let e in response.errors) {
            console.log("e wynosi:", e);
            switch (e) {
              case "active_energy_consumed": {
                const rules = response.errors[e];
                let errors = [];
                for (let rule in rules) {
                  errors.push(response.errors[e][rule]);
                }
                this.vuelidateExternalResults.activeEnergyConsumed = errors;
                break;
              }
              case "date": {
                const rules = response.errors[e];
                let errors = [];
                for (let rule in rules) {
                  errors.push(response.errors[e][rule]);
                }
                this.vuelidateExternalResults.date = errors;
                break;
              }
              case "reactive_energy_consumed": {
                const rules = response.errors[e];
                let errors = [];
                for (let rule in rules) {
                  errors.push(response.errors[e][rule]);
                }
                this.vuelidateExternalResults.reactiveEnergyConsumed = errors;
                break;
              }
            }
          }
        }
      }
    },
  },
};
</script>

<style scoped>
h1 {
  text-align: center;
}
.form-control {
  margin: 15px 0 15px 0;
}
.input-field {
  display: flex;
  font-weight: bold;
}
.label-form {
  display: block;
  color: #1845ba;
  font-size: 16px;
  font-weight: bold;
  margin: 10px 0 10px 0;
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
.error-message {
  display: flex;
  flex-direction: column;
  color: red;
  font-size: 12px;
}
</style>
