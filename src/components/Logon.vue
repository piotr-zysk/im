<template>
  <div class="logon">
  <g-signin-button v-show="!this.guser.Name"
    :params="googleSignInParams"
    @success="onSignInSuccess"
    @error="onSignInError" @click="myClickEvent" ref="myBtn">
    Sign in with Google
  </g-signin-button>
  {{guser.Name}} {{guser.Email}} {{gToken}}
  {{title}}
  </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
  name: 'Logon',
  computed: mapState([
    'title'
  ]),
  mounted() {
    //this.methods.myClickEvent(null);
  },
  data () {
    return {
      /**
       * The Auth2 parameters, as seen on
       * https://developers.google.com/identity/sign-in/web/reference#gapiauth2initparams.
       * As the very least, a valid client_id must present.
       * @type {Object}
       */
      googleSignInParams: {
        client_id: '1055476069803-mudpnjdhi6d7es9tuosavl5sn4nd08ip.apps.googleusercontent.com'
      },
      guser: {
        Name: '',
        Email: ''
      },
      gToken: ''

    }
  },
  methods: {
    onSignInSuccess (googleUser) {
      // `googleUser` is the GoogleUser object that represents the just-signed-in user.
      // See https://developers.google.com/identity/sign-in/web/reference#users
      const profile = googleUser.getBasicProfile() // etc etc
      this.guser.Name=profile.getName();
      this.guser.Email=profile.getEmail();
      this.gToken=googleUser.getAuthResponse().id_token;
    },
    onSignInError (error) {
      // `error` contains any error occurred.
      console.log('OH NOES', error)
    },
    myClickEvent($event) {
            const elem = this.$refs.myBtn
            elem.click()
        }
  }
}
</script>

<style>
.g-signin-button {
  /* This is where you control how the button looks. Be creative! */
  display: inline-block;
  padding: 4px 8px;
  border-radius: 3px;
  background-color: #3c82f7;
  color: #fff;
  box-shadow: 0 3px 0 #0f69ff;
}
.logon {
  color: #fff;
}
</style>
