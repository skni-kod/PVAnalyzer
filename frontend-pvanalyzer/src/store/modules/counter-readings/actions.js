import axios from "axios";

export default {
  async loadCounterReadings(context) {
    const id = 9;
    const token = localStorage.getItem("token");

    const url = `http://127.0.0.1:8000/api/pv-installations/${id}/counter-readings`;

    await axios.get(url, {
      headers: {
        Authorization: `Bearer ${token}`,
        "content-type": "application/json",
      },
    })
    .then((res)=> {
        const data = res.data.data;
        const counterReadings = [];

        for (const i in data){
          const counterReading = {
            id: i+1,
            date: data[i].date,
            activeEnergyConsumed: data[i].active_energy_consumed,
            reactiveEnergyConsumed: data[i].reactive_energy_consumed,
            energyToRecover: data[i].energy_to_recover,
            balance: data[i].balance,
            mounth: data[i].mounth,
          }
          counterReadings.push(counterReading);
        }
        
        context.commit('setReadings', counterReadings);
        console.log('pobrano Odczyty');
    })
    .catch((error) => {
        console.error(error);
    });

  },
};
