import { createStore } from 'vuex';

import authModule from './modules/auth/index.js';
import pvInstallationModule from './modules/pv-installations/index.js';

const store = createStore({
    modules: {
      auth: authModule,
      pVInstallation: pvInstallationModule
    }
  });
  
  export default store;