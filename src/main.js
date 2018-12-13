import Vue from 'vue'
import App from './App.vue'
import store from './store'
import GSignInButton from 'vue-google-signin-button'
import './ml'
import VueProgressBar from 'vue-progressbar'

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(ElementUI);

Vue.use(GSignInButton)
var VueTruncate = require('vue-truncate-filter')
Vue.use(VueTruncate)

Vue.use(VueProgressBar, {
  color: 'rgb(64, 115, 158)',
  failedColor: 'red',
  height: '2px'
})

Vue.config.productionTip = false

Vue.filter('no_empty', function (value, replacement) {
  if ((value!=undefined) && (value.length<1)) return replacement;
  else return value;
})
Vue.filter('uppercase', function (value) {
  if (!value) return '';
  value = value.toString();
  return value.toUpperCase();
})

new Vue({
  store,
  render: h => h(App),
}).$mount('#app')
