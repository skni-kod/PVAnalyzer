import axios from "axios";

export default {
  async loadCounterReadings(context) {
      console.log('Context: ', context);
    //   console.log('46: ', context.getters.myInstallation);
      console.log('47: ', context.rootGetters['pVInstallation/installationId']);
    //   console.log(context.rootGetters['pVInstallation/installationId']);
    const id = 9;
    console.log('Wbiło?', id);
    const token = localStorage.getItem("token");

    const url = `http://127.0.0.1:8000/api/pv-installations/${id}/counter-readings`;

    axios.get(url, {
      headers: {
        Authorization: `Bearer ${token}`,
        "content-type": "application/json",
      },
    })
    .then((res)=> {
        console.log(res.data.data[1]);
        const data = res.data.data[1];
        const labels = [];
        // const readings = [];
        for (const i in data){
            labels.push(data[i].date);
        }
    })
    .catch((error) => {
        console.error(error);
    });
  },
};
