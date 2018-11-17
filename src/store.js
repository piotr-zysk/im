import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    title: 'My title from VUEX',
    googleSignInParams: {
        client_id: '1055476069803-mudpnjdhi6d7es9tuosavl5sn4nd08ip.apps.googleusercontent.com'
    },
    guser: {
      email: '',
      token: ''
    }
  },
  mutations: {
    setGuser (state, guser) {
      state.guser=guser;
    }
  },
  actions: {

  }
})

// https://coursetro.com/posts/code/144/A-Vuex-Tutorial-by-Example---Learn-Vue-State-Management