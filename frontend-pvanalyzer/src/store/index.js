import { createStore } from 'vuex';

import authModule from './modules/auth/index.js';
import pvInstallationModule from './modules/pv-installations/index.js';
import counterReadingsModule from './modules/counter-readings/index.js'

const store = createStore({
    modules: {
      auth: authModule,
      pVInstallation: pvInstallationModule,
      readings: counterReadingsModule
    },
  });
  
  export default store;