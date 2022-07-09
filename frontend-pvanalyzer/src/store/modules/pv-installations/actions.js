import axios from "axios";

export default {
  async addNewInstallation(context, payload){
    const token = localStorage.getItem("token");

    const data = {
      start: payload.startDate,
      power: payload.power,
    };

    const url = `http://127.0.0.1:8000/api/pv-installations`;

    const response = await axios.post(url, data,{
      headers: {
        Authorization: `Bearer ${token}`,
        "content-type": "application/json",
      },
    }).then((response)=>{
      console.log('resoibse w actions', response);
      const data = response.data.data;
      const pVInstallation = {
        id:data.id,
        start: data.start,
        power: data.power,
      };
      context.commit("setPVIntallationStates", pVInstallation);
      return response;
    }).catch((error) => {
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
  async loadInstallation(context) {
    const token = localStorage.getItem("token");
    let url = `http://127.0.0.1:8000/api/pv-installations`;

    await axios
      .get(url, {
        headers: {
          Authorization: `Bearer ${token}`,
          "content-type": "application/json",
        },
      })
      .then((res) => {
        console.log('res', res);
        const data = res.data.data;
        console.log(res.data, 'res z act');
        const pvInstallation = {
          id: data.id,
          start: data.start,
          power: data.power,
        };

        context.commit('setPVIntallationStates', pvInstallation);
          return pvInstallation;
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
