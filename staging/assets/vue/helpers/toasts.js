// assets/vue/helpers/toasts.js

import { toast } from 'vue3-toastify';
import "vue3-toastify/dist/index.css";

export async function notify(message) {
  toast(message);
}

export async function success(message) {
  toast.success(message);
}

export async function warning(message) {
  toast.warning(message);
}
