import mutations from './mutations.js';
import actions from './actions.js';
import getters from './getters.js';

export default {
    namespaced: true,
    state(){
        return {
            counterReadings:[],
            errors: [],
            lastFetch: null,
            labels: [],
            active: [],
            reactive: [],
            recover: [],
            // readings: [],
            balance: null
        };
    },
    mutations,
    actions,
    getters,
};