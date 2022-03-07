import { createStore } from "vuex";

import authModule from "./modules/auth/index.js";
import pvInstallationModule from "./modules/pv-installations/index.js";
import counterReadingsModule from "./modules/counter-readings/index.js";

const store = createStore({
  state() {
    return {
      errors: '',
    };
  },
  mutations: {
    setErrors(state, payload) {
      state.errors = payload.errors;
    },
    clearErrors(state){
      state.errors = '';
    }
  },
  getters: {
    errors(state){
      return state.errors;
    }
  },
  modules: {
    auth: authModule,
    pVInstallation: pvInstallationModule,
    readings: counterReadingsModule,
  },
});

export default store;
