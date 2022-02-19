export default {
    setUser(state, payload) {
      state.token = payload.token;
      state.userId = payload.userId;
      state.userName = payload.userName;
      state.userEmail = payload.userEmail;
      state.didAutoLogout = false;
    },
    setName(state, payload){
      state.userName = payload.userName;
    },
    setEmail(state, payload){
      state.userEmail = payload.userEmail;
    },
    setAutoLogout(state) {
      state.didAutoLogout = true;
    },
  };