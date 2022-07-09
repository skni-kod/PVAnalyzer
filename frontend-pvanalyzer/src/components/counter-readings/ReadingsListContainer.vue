<template>
  <div class="container">
    <div class="header">
      <h1>Lista odczytów</h1>
      <span>Zobacz listę</span>
    </div>
    <table v-if="hasData">
      <tr>
        <th>Data</th>
        <th>Pobrana</th>
        <th>Oddana</th>
        <th>Do odzyskania</th>
        <th>Bilans</th>
      </tr>
      <tr v-for="data in tableData" :key="data.id">
        <td>{{ data.date }}</td>
        <td>{{ data.activeEnergyConsumed }} kWh</td>
        <td>{{ data.reactiveEnergyConsumed }} kWh</td>
        <td>{{ data.energyToRecover }} kWh</td>
        <td>{{ data.balance }} kWh</td>
      </tr>
    </table>
    <span v-else>Nie posiadasz żadnych odczytów.</span>
    <base-blue-button link to="/add-reading" colorButton="button-green"
      >Dodaj nowy odczyt</base-blue-button
    >
  </div>
</template>

<script>
export default {
  props: {
    tableData: Array,
  },
  computed:{
    hasData(){
      return (this.tableData.length)?true:false;
    }
  }
};
</script>

<style scoped>
.container {
  display: flex;
  flex-direction: column;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.26);
}
.header {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.header span {
  color: green;
}
table {
  border-collapse: collapse;
  width: 100%;
}
th,
td {
  padding: 10px;
  text-align: center;
}
th {
  font-weight: bold;
}
tr:nth-child(even) {
  background-color: #f2f2f2;
}
</style>
