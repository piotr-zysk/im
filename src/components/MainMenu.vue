<template>
  <div class="mainmenu">
    <div>{{$ml.get('menu_unread')}}</div>
    <div>Read</div>
    <div>Create</div>


<button
	v-for="lang in $ml.list"
	:key="lang"
	@click="$ml.change(lang)"
	v-text="lang"
/>


  </div>
</template>

<script>
import { MLBuilder } from 'vue-multilanguage'

export default {
  name: 'MainMenu',
  props: {
    msg: String
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

.mainmenu{
  color: #182124;
}

</style>
