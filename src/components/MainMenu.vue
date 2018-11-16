<template>
  <div class="mainmenu">
    <div>Unread</div>
    <div>Read</div>
    <div>Create</div>

  </div>
</template>

<script>
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
  color: #ecf0f1;
}

</style>
