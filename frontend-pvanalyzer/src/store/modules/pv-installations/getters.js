export default{
    startWorking(state){
        return state.startWorking;
    },
    powerInstallation(state){
        return state.powerInstallation;
    },
    installationId(state){
        return state.idInstallation;
    },
    hasInstallation(state){
        return !!state.idInstallation;
    }
};