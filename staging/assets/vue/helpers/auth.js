// assets/vue/helpers/auth.js

import _ from "lodash";

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
