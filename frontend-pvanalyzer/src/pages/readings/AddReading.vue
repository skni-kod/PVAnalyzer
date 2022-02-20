<template>
  <base-card>
    <h1>Dodaj odczyt</h1>
    <form @submit.prevent="submitForm">
      <div class="form-control">
        <label class="label-form" for="date-reading">Data oczytu</label>
        <input class="input-form" type="date" name="date-reading" v-model="date" />
      </div>
      <div class="form-control">
        <label class="label-form" for="date-reading">Energia pobrana</label>
        <div class="input-field">
          <input class="input-form" type="number" name="activeEnergy" v-model="activeEnergyConsumed" /><span>kWh</span>
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
          />
          kWh
        </div>
      </div>
      <div class="save-button">
        <base-blue-button>Dodaj</base-blue-button>
      </div>
    </form>
  </base-card>
</template>

<script>
export default {
  data(){
    return{
      date: '',
      activeEnergyConsumed: null,
      reactiveEnergyConsumed: null,
      errors: []
    }
  },
  methods:{
    submitForm(){
      const formData = {
        date: this.date,
        activeEnergyConsumed: this.activeEnergyConsumed,
        reactiveEnergyConsumed: this.reactiveEnergyConsumed,
      };
      console.log('data:', formData);
    }
  }
};
</script>

<style scoped>
h1{
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
.save-button{
  text-align: center;
}
</style>
