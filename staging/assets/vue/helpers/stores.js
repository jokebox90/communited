import _ from "lodash";
import http from "./http";
import { success, warning } from "./toasts";
import { defineStore } from "pinia";
import { computed, ref } from "vue";

export function getAuth() {
  const raw = localStorage.getItem("app:auth");
  if (_.isNull(raw)) return null;
  const auth = JSON.parse(raw);
  return auth;
}

export function setAuth(options) {
  if (_.isNull(options)) {
    localStorage.removeItem("app:auth");
    return;
  }

  const current = _.defaultTo(getAuth(), {});
  const raw = JSON.stringify(_.assign(current, options));
  localStorage.setItem("app:auth", raw);
}

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
