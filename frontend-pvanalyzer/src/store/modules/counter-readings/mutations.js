export default{
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
    }
}