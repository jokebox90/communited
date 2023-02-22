// assets/vue/services/http.js

import axios from "axios";

const http = axios.create({
  validateStatus: (s) => s < 400 || s === 400 || s === 404,
});

export default http;
