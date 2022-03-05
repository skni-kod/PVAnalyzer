import axios from "axios";

export default {
  async editProfile(context, payload) {
    const token = localStorage.getItem("token");
    const userId = localStorage.getItem("userId");

    let url = `http://127.0.0.1:8000/api/users/${userId}`;

    let data = {
      name: payload.name,
      email: payload.email,
    };
    axios
      .put(url, data, {
        headers: {
          Authorization: `Bearer ${token}`,
          "content-type": "application/json",
        },
      })
      .then((res) => {
        context.commit("setName", {
          userName: res.data.data.name,
        });
        context.commit("setEmail", {
          userEmail: res.data.data.email,
        });
      })
      .catch((error) => {
        console.error(error);
      });
  },

  async changePassword(context, payload) {
    const token = localStorage.getItem("token");
    const userId = localStorage.getItem("userId");

    let url = `http://127.0.0.1:8000/api/users/${userId}/change-password`;

    let data = {
      password: payload.password,
      password_confirmation: payload.confirmation,
    };
    axios
      .put(url, data, {
        headers: {
          Authorization: `Bearer ${token}`,
          "content-type": "application/json",
        },
      })
      .then((res) => {
        //komunikat o poprawności wykonania
        console.log(res);
      })
      .catch((error) => {
        const errors = error.response;
        console.error(errors);
      });
  },
  async register(context, payload) {
    const url = "http://127.0.0.1:8000/api/register";

    const response = await fetch(url, {
      method: "POST",
      body: JSON.stringify({
        name: payload.name,
        email: payload.email,
        password: payload.password,
        password_confirmation: payload.password_confirmation,
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
      userId: responseData.user.id,
      userName: responseData.user.name,
    });
  },
  async login(context, payload) {
    const url = "http://127.0.0.1:8000/api/login";

    const data = {
      email: payload.email,
      password: payload.password,
    };

    const response = await axios
      .post(url, data, {
        headers: {
          "content-type": "application/json",
        },
      })
      .then((res) => {
        const responseData = res.data;
        localStorage.setItem("token", responseData.token);
        localStorage.setItem("userId", responseData.user.id);

        context.commit("setUser", {
          token: responseData.token,
          userId: responseData.user.id,
          userName: responseData.user.name,
          userEmail: responseData.user.email,
        });
        return res;
      })
      .catch((error) => {
        const responseError = error.response;
        if (responseError.status == 401) {
          const errors = {
            status: responseError.status,
            errors:  responseError.data.message,
            statusText: responseError.statusText,
          };
          return errors;
        } else {
          context.commit("setErrors", {
            errors: responseError.statusText,
          });
        }
      });
    return response;
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
