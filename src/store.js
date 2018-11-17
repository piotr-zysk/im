import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    title: 'My title from VUEX',
    //Google applicaion Cllient ID, required for authentication (client ID created for backend api located in 'intraportal.net')
    googleSignInParams: {
        client_id: '1055476069803-mudpnjdhi6d7es9tuosavl5sn4nd08ip.apps.googleusercontent.com'
    },
    //Google user - use data fetched from Google after Google authentication
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

