import axios from "axios";

export default {
  async addNewReading(context, payload) {
    const id = context.rootGetters['pVInstallation/installationId'];
    const token = localStorage.getItem("token");

    const data = {
      date: payload.date,
      active_energy_consumed: payload.active,
      // active_energy_consumed: "siema",
      reactive_energy_consumed: payload.reactive,
    };

    const url = `http://127.0.0.1:8000/api/pv-installations/${id}/counter-readings`;

    const response = await axios
      .post(url, data, {
        headers: {
          Authorization: `Bearer ${token}`,
          "content-type": "application/json",
        },
      })
      .then((response) => {
        const data = response.data.data;
        const counterReading = {
          id: data.id,
          date: data.date,
          activeEnergyConsumed: data.active_energy_consumed,
          reactiveEnergyConsumed: data.reactive_energy_consumed,
          energyToRecover: data.energy_to_recover,
          balance: data.balance,
          mounth: data.mounth,
        };
        context.commit("addReading", counterReading);
        return response;
      })
      .catch((error) => {
        if (error.response.status == "422") {
          const errors = {
            status: error.response.status,
            errors: error.response.data.errors,
            statusText: error.response.statusText,
          };
          return errors;
        }
      });

    return response;
  },
  async loadCounterReadings({ commit, getters,  rootGetters }) {
    
    // if (!context.getters.shouldUpdate){
    if (!getters.shouldUpdate){
      return;
    }
    const id = rootGetters['pVInstallation/installationId'];
    // console.log(context.rootGetters['pVInstallation/installationId']);
    // console.log('root getters:', rootGetters['pVInstallation/installationId']);
    const token = localStorage.getItem("token");

    const url = `http://127.0.0.1:8000/api/pv-installations/${id}/counter-readings`;

    await axios
      .get(url, {
        headers: {
          Authorization: `Bearer ${token}`,
          "content-type": "application/json",
        },
      })
      .then((res) => {
        const data = res.data.data;
        const counterReadings = [];

        for (const i in data) {
          const counterReading = {
            id: i + 1,
            date: data[i].date,
            activeEnergyConsumed: data[i].active_energy_consumed,
            reactiveEnergyConsumed: data[i].reactive_energy_consumed,
            energyToRecover: data[i].energy_to_recover,
            balance: data[i].balance,
            mounth: data[i].mounth,
          };
          counterReadings.push(counterReading);
        }

        commit("setReadings", counterReadings);
        // context.commit("setReadings", counterReadings);
        // context.commit('setFetchTimestamp');
        commit('setFetchTimestamp');
      })
      .catch((error) => {
        console.error(error);
      });
  },
};
