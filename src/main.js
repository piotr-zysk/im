import Vue from 'vue'
import App from './App.vue'
import store from './store'
import GSignInButton from 'vue-google-signin-button'

Vue.use(GSignInButton)


Vue.config.productionTip = false



new Vue({
  store,
  render: h => h(App),
}).$mount('#app')
