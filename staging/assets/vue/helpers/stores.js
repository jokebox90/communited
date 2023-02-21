import _ from "lodash";
import { defineStore } from "pinia";
import { ref } from "vue";
import http from "./http";
import { getAuth, setAuth } from "./auth";
import { success, warning } from "./toasts";

export const useUserStore = defineStore("user", () => {
  const auth = getAuth();
  const username = ref(_.get(auth, "username", ""));
  const isAuthenticated = ref(_.get(auth, "isAuthenticated", false));

  async function doSignIn(credentials) {
    const { data, status } = await http.post("/api/sign-in", {
      username: credentials.username,
      password: credentials.password,
    });

    if (status === 200) {
      setAuth({
        isAuthenticated: true,
        username: data.username,
        roles: data.roles,
      });

      username.value = data.username;
      isAuthenticated.value = true;
      await success("Vous êtes bien connecté !");
    } else if (status === 401) {
      _.map(data.messages, async (m) => await warning(m));
    }

    return { status };
  }

  function doSignOut() {
    setAuth(null);
    isAuthenticated.value = false;
  }

  return { username, isAuthenticated, doSignIn, doSignOut };
});
