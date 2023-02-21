// assets/vue/services/http.js

import axios from "axios";
import { setAuth } from "./auth";

const http = axios.create({
  validateStatus: (s) => s < 400 || s === 400 || s === 404,
});

http.interceptors.response.use(
  (response) => {
    return response;
  },
  async function (error) {
    const req = error.config;
    if (error.response.status === 403 && !req._retry) {
      setAuth(null);
    }
    return Promise.reject(error);
  }
);

export default http;
