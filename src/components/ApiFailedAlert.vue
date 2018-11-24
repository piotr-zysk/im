<template>
  <div class="alert">
<h2 class="alert_content">{{$ml.get('api_failed_alert_title')}}</h2>
<h3 class="alert_content"><em>{{$ml.get('api_failed_alert_subtitle')}}</em></h3>
<ol class="alert_content">
  <li>{{$ml.get('api_failed_alert_description1')}}</li>
  <li>{{$ml.get('api_failed_alert_description2')}}</li>
  <li>{{$ml.get('api_failed_alert_description3')}}</li>
</ol>

<button class="alert_content">{{$ml.get('api_failed_alert_button')}}</button>
  </div>
</template>

<script>
/*
oprogramuj przycisk retry, aby brał z vuexa nazwę funkcji, parametry i wywolywal

https://ctrlq.org/code/20181-call-javascript-function-by-name


*/



import { mapState, mapMutations } from "vuex";

export default {
  name: "ApiFailedAlert",
  methods: mapMutations(["changeTab"]),
  computed: mapState(["lastApiCall"]),
  data: function() {
    return {
      test: "null"
    };
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.alert {
  position: absolute;
  left: 50%;
  top: 100px;
}
.alert_content {
  position: relative;
  left: -50%;
}
</style>
