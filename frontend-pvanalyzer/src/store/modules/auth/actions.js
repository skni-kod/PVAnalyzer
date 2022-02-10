export default {
  async regiser(context, payload) {
    let url = "http://127.0.0.1:8000/api/register";
    const response = await fetch(url, {
      method: "POST",
      body: JSON.stringify({
        email: payload.email,
        password: payload.password,
      }),
    });
    const responseData = await response.json();
    console.log(responseData);
  },

  async login(context, payload) {
    let url = "http://127.0.0.1:8000/api/login";

    const response = await fetch(url, {
      method: "POST",
      body: JSON.stringify({
        email: payload.email,
        password: payload.password,
      }),
      headers: {
        "Content-Type": "application/json",
      },
    });

    const responseData = await response.json();

    if (!response.ok) {
      const error = new Error(
        responseData.message || "Failed to authenticate. Check your login data."
      );
      throw error;
    }

    localStorage.setItem("token", responseData.token);
    localStorage.setItem("userId", responseData.user.id);

    context.commit("setUser", {
      token: responseData.token,
      userId: responseData.user.id,
      userName: responseData.user.name,
    });

    console.log(responseData);
  },
  logout(context) {
    localStorage.removeItem("token");
    localStorage.removeItem("userId");

    context.commit("setUser", {
      token: null,
      userId: null,
    });
  },
};
