import axios from "axios";

export default {
  async loadCounterReadings(context) {

    const id = 9;
    const token = localStorage.getItem("token");

    const url = `http://127.0.0.1:8000/api/pv-installations/${id}/counter-readings`;

    axios.get(url, {
      headers: {
        Authorization: `Bearer ${token}`,
        "content-type": "application/json",
      },
    })
    .then((res)=> {
        const data = res.data.data;
        const labels = [];
        const active = [];
        const reactive = [];
        const recover = [];
        const balance = res.data.total;

        for (const i in data){
            labels.push(data[i].date);
            active.push(data[i].active_energy_consumed);
            reactive.push(data[i].reactive_energy_consumed);
            recover.push(data[i].energy_to_recover);
        }
        
        context.commit('setLabels', labels);
        context.commit('setActive', active);
        context.commit('setReactive', reactive);
        context.commit('setRecover', recover);
        context.commit('setBalance', balance);
        console.log('pobrano Odczyty');
    })
    .catch((error) => {
        console.error(error);
    });

  },
};
