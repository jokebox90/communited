// assets/vue/helpers/auth.js

import _ from "lodash";

export function getAuth() {
  const raw = sessionStorage.getItem("app:auth");
  if (_.isNull(raw)) return null;
  const auth = JSON.parse(raw);
  return auth;
}

export function setAuth(options) {
  if (_.isNull(options)) {
    sessionStorage.removeItem("app:auth");
    return;
  } else {
    const current = _.defaultTo(getAuth(), {});
    const raw = JSON.stringify(_.assign(current, options));
    sessionStorage.setItem("app:auth", raw);
  }
}
