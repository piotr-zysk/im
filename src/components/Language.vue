<template>
  <div>
    <!-- <img src="flags/flag-english.png"> -->
    <div v-for="lang in $ml.list" :key="lang">
      <img
        class="language"
        :class="chosen_language(lang)"
        :src="flag_file(lang)"
        @click="$ml.change(lang); language=lang;"
        :alt="lang"
      >
    </div>
  </div>
</template>

<script>
// all translations in ml.js
//import { MLBuilder } from "vue-multilanguage";

export default {
  name: "Language",
  data() {
    return {
      baseUrl: process.env.BASE_URL,
      language: this.$ml.current
    };
  },
  methods: {
    flag_file(lang) {
      return "img/flags/flag-" + lang + ".png";
    },
    chosen_language(lang) {
      if (this.language == lang) return { lang_active: true };
      else return { lang_other: true };
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
img {
  margin: 0px;
  border: 1px solid #000;
  transition: 0.3s;
}
.language {
  padding: 0px;
  display: block;
  float: right;
  margin: 0px 5px;
}
.lang_active {
  height: 27px;
  width: 37px;
  box-shadow: 0 3px 3px #aaa;
}
.lang_other {
  height: 17px;
  width: 22px;
  opacity: 0.7;
}
.lang_other:hover {
  height: 21px;
  width: 26px;
  margin: 0px 3px;
  box-shadow: 0 3px 3px #aaa;
  opacity: 1;
}
</style>
