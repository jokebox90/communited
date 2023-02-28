import _ from "lodash";
import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import { getAuth, setAuth } from "@/helpers/auth";

export const useUserStore = defineStore("user", () => {
  const auth = getAuth();
  const userState = reactive({
    username: _.get(auth, "username", ""),
    roles: _.get(auth, "roles", ["ANONYMOUS"]),
    isAuthenticated: _.get(auth, "isAuthenticated", false),
    isAdmin: _.get(auth, "isAdmin", false),
  });

  function doSignIn({ username, roles }) {
    setAuth(
      _.assign(userState, {
        isAuthenticated: true,
        isAdmin: _.includes(roles, "ROLE_ADMIN"),
        username,
        roles,
      }),
    );
  }

  function doSignOut() {
    setAuth(
      _.assign(userState, {
        isAuthenticated: false,
        isAdmin: false,
        username: "anonymous",
        roles: ["ANONYMOUS"],
      }),
    );
  }

  return { userState, doSignIn, doSignOut };
});

export const useBrowserStore = defineStore("browser", () => {
  const browserState = reactive({
    height: 0,
    width: 0,
    isMobile: true,
  });

  function doWindowResize() {
    browserState.height = window.innerHeight;
    browserState.width = window.innerWidth;
    browserState.isMobile = window.innerWidth < 420;
  }

  return { browserState, doWindowResize };
});
