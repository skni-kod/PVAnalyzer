export default{
    counterReadings(state){
        return state.counterReadings;
    },
    labels(state){
        return state.labels;
    },
    active(state){
        return state.active;
    },
    reactive(state){
        return state.reactive;
    },
    recover(state){
        return state.recover;
    },
    shouldUpdate(state){
        const lastFetch = state.lastFetch;
        if(!lastFetch){
            return true;
        }
        const currentTimeStamp = new Date().getTime();
        return (currentTimeStamp - lastFetch) / 1000 > 60;
    },

}