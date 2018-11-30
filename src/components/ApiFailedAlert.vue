<template>
  <div class="alert">
<h2 class="alert_content alert_title">{{$ml.get('api_failed_alert_title')}}</h2>
<h3 class="alert_content">{{$ml.get('api_failed_alert_subtitle')}}</h3>
<ol class="alert_content alert_description">
  <li>{{$ml.get('api_failed_alert_description1')}}</li>
  <li>{{$ml.get('api_failed_alert_description2')}}</li>
  <li>{{$ml.get('api_failed_alert_description3')}}</li>

</ol>

<a href=# class="button alert_content" @click="Retry">{{$ml.get('api_failed_alert_button')}}</a>
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
  methods: {
    ...mapMutations(["changeTab"]),
    Retry()
    {
      this.changeTab(this.navigation.tab);
    }
  },
  computed: mapState(["lastApiCall","navigation"]),
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
.alert_title {
   color: #c23616;
}
.alert_content li {
  text-align: left;
  text-transform: capitalize;
  font-style: italic;
}
.alert h3 {
  font-style: italic;
  font-weight: 100;
}

</style>
