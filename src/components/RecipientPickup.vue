<template>
<div>
<p>wybór adresatów</p>
<!-- https://www.youtube.com/watch?v=BTwfyfv1v84 -->

<select class="listbox" id="list1" multiple>
    <option v-for="item1 in list1" :key="item1">{{item1}}</option>
</select>
</div>
</template>

<script>
export default {
  name: "NewMessage",
  data() { return {
      list1: ['adedede','b','c','d']
  }}
}

</script>

<style>
.listbox {
    width: 250px;
    height: 200px;
    display: block;
}

</style>