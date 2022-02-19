import axios from "axios";

export default {
  async loadInstallation(context) {
    const token = localStorage.getItem("token");

    let url = `http://127.0.0.1:8000/api/pv-installations`;

    axios
      .get(url, {
        headers: {
          Authorization: `Bearer ${token}`,
          "content-type": "application/json",
        },
      })
      .then((res) => {
        context.commit('setPVIntallationStates', {
            start: res.data.data[0].start,
            power: res.data.data[0].power,
            id: res.data.data[0].id,
          });
          // context.commit('setTest', res.data.data[0].id, {root: true})
      })
      .catch((error) => {
        console.error(error);
      });
  },
};
