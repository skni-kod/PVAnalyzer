export default {
    userId(state) {
      return state.userId;
    },
    userName(state){
      return state.userName;
    },
    userEmail(state){
      return state.userEmail;
    },
    token(state) {
      return state.token;
    },
    isAuthenticated(state) {
      return !!state.token;
    },
    didAutoLogout(state) {
      return state.didAutoLogout;
    }
  };