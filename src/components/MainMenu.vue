<template>
  <div class="mainmenu">
    <div>{{$ml.get('menu_unread')}}</div>
    <div>{{$ml.get('menu_read')}}</div>
    <div>{{$ml.get('menu_sent')}}</div>
    <div>{{$ml.get('menu_create')}}</div>


<!--
  Wybór języka przenieś do dedykowanego komponentu.
obrazki z flagami wyświetlają się prawidłowo jedynie z poziomu IIS, po recznym skopiowaniu folderu assets.
Obczaj jak to poprowic / webpack?
Ewentualnie dodaj batcha, ktory bedzie automatycznie robil build i kopiowal pliki do IISa
https://cli.vuejs.org/guide/html-and-static-assets.html#url-transform-rules
-->

<!-- <img src="flags/flag-english.png"> -->
<div class="lang" v-for="lang in $ml.list" :key="lang">
<img :src="flag_file(lang)" @click="$ml.change(lang)" :alt="lang">

<!-- <button
	@click="$ml.change(lang)"
	v-text="lang"
/> -->
</div>


  </div>
</template>

<script>
import { MLBuilder } from 'vue-multilanguage'

export default {
  name: 'MainMenu',
  data () {
  return {
    baseUrl: process.env.BASE_URL
  }
  },
  props: {
    msg: String
  },
  methods: {
    flag_file(lang) {
      return "img/flags/flag-"+lang+".png";
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

.mainmenu{
  color: #182124;
}
img{
  height: 25px;
  width: 40px;
}

</style>
