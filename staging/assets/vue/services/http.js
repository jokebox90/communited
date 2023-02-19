// assets/vue/services/http.js

import axios from "axios";

const http = axios.create({
  validateStatus: (s) => s < 500,
});

export default http;
