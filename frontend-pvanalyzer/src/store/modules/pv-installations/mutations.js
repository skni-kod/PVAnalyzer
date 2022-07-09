export default{
    setPVIntallationStates(state, payload){
        console.log(payload, 'payload wynois');
        state.startWorking = payload.start;
        state.powerInstallation = payload.power;
        state.idInstallation = payload.id;
    },
    setStartWorking(state, payload){
        state.startWorking = payload.start;
    },
    setPowerInstallation(state, payload){
        state.powerInstallation = payload.power;
    }
}