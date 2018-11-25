import Vue from 'vue'
import App from './App.vue'
import store from './store'
import GSignInButton from 'vue-google-signin-button'
import './ml'


Vue.use(GSignInButton)
var VueTruncate = require('vue-truncate-filter')
Vue.use(VueTruncate)


Vue.config.productionTip = false

Vue.filter('no_empty', function (value, replacement) {
  if (value.length<1) return replacement;
  else return value;
})


new Vue({
  store,
  render: h => h(App),
}).$mount('#app')
