// assets/vue/helpers/sleep.js

function sleep(ms) {
  return new Promise((resolve) => setTimeout(resolve, ms));
}

export default sleep;
