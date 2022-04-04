import { createStore } from "vuex";

import authModule from "./modules/auth/index.js";
import pvInstallationModule from "./modules/pv-installations/index.js";
import counterReadingsModule from "./modules/counter-readings/index.js";

const store = createStore({
  state() {
    return {
      errors: '',
      successMessage: {
        desc: '',
        title: '',
      },
    };
  },
  mutations: {
    setErrors(state, payload) {
      state.errors = payload.errors;
    },
    clearErrors(state){
      state.errors = '';
    },
    setMessage(state, payload){
      state.successMessage.desc = payload.desc;
      state.successMessage.title = payload.title;
    },
    clearSuccessMessage(state){
      state.successMessage = [];
    }
  },
  getters: {
    errors(state){
      return state.errors;
    },
    successMessage(state){
      return state.successMessage;
    }
  },
  modules: {
    auth: authModule,
    pVInstallation: pvInstallationModule,
    readings: counterReadingsModule,
  },
});

export default store;
