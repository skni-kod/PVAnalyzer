export default{
    addReading(state, payload){
        state.counterReadings.push(payload);
    },
    setReadings(state, payload){
        state.counterReadings = payload;
    },
    setCounterReadingStates(state, payload){
        state.labels = payload.labels;
        state.readings = payload.readings;
        state.balance = payload.balance;
    },
    setLabels(state, payload){
        state.labels = payload;
    },
    setBalance(state, payload){
        state.balance = payload;
    },
    setActive(state, payload){
        state.active = payload;
    },
    setReactive(state, payload){
        state.reactive = payload;
    },
    setRecover(state, payload){
        state.recover = payload;
    },
    setFetchTimestamp(state){
        state.lastFetch = new Date().getTime();
    },
    clearLastFetch(state){
        state.lastFetch = null;
    }
}