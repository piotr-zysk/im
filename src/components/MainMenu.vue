<template>
  <div class="mainmenu">
    <a class="menu_item" :class="is_active_tab('UnreadList')" @click="selectTab('UnreadList')" href=#><i class="icon ion-md-mail"></i> {{$ml.get('menu_unread')}}</a>
    <a class="menu_item" :class="is_active_tab('ReadList')" @click="selectTab('ReadList')" href=#><i class="icon ion-md-mail-open"></i> {{$ml.get('menu_read')}}</a>
    <a class="menu_item" :class="is_active_tab('SentList')" @click="selectTab('SentList')" href=#><i class="icon ion-md-paper-plane"></i> {{$ml.get('menu_sent')}}</a>
    <a class="menu_item" :class="is_active_tab('NewMessage')" @click="selectTab('NewMessage')" href=#><i class="icon ion-md-create"></i> {{$ml.get('menu_create')}}</a>




  </div>
</template>

<script>
import { mapState, mapMutations } from "vuex";

export default {
  name: "MainMenu",
  computed: mapState(["navigation","tab_locked"]),
  props: {
    msg: String
  },
  methods: {
    ...mapMutations(["changeTab"]),
    is_active_tab(tab) {
      if (this.navigation.tab == tab) return { menu_item_active: true };
      else if (this.tab_locked) return { menu_item_locked: true };
      else return { menu_item_inactive: true };
    },
    selectTab(tab){
      if (tab!=this.navigation.tab) 
      {
        this.changeTab(tab);
        // TO DO: emit an event to load tab content
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<!-- https://flatuicolors.com/palette/gb -->
<style scoped>
.mainmenu {
  float: left;
  text-align: left;
  transition: 0.2s;
  margin-bottom: 40px;
}
.menu_item {
  color: #40739e;
  display: inline-block;
  border-bottom: 3px solid transparent;
  border-left: 3px solid transparent;
  /* background-color: #7f8fa6; */
  font-weight: 600;
  text-transform: uppercase;
  padding: 2px 0 8px 8px;
  margin: 3px 8px 0 0;
  text-decoration: none;
  border-radius: 3px
}
.menu_item_inactive:hover {
  border-bottom: 3px solid #40739e;
  border-left: 3px solid #40739e;
  transition: 0.5s;
}
.menu_item_locked {
  color: #7f8fa6;
}
.menu_item_locked:hover {
  border-bottom: 3px solid transparent;
  border-left: 3px solid transparent;
  transition: 0.5s;
}
.menu_item_active {
  color: #c23616;
}
</style>
