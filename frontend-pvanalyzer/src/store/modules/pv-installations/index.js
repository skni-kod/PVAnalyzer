import mutations from './mutations.js';
import actions from './actions.js';
import getters from './getters.js';

export default {
    namespaced: true,
    state(){
        return{
            startWorking: null,
            powerInstallation: null,
            idInstallation: null
        };
    },
    mutations,
    actions,
    getters
};