import Vue from 'vue'
import App from './App.vue'
import store from './store'
import GSignInButton from 'vue-google-signin-button'
import './ml'


Vue.use(GSignInButton)
var VueTruncate = require('vue-truncate-filter')
Vue.use(VueTruncate)


Vue.config.productionTip = false



new Vue({
  store,
  render: h => h(App),
}).$mount('#app')
