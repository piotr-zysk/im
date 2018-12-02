<template>
  <MessageList type="unread"></MessageList>

</template>

<script>
import MessageList from "../components/MessageList.vue";

export default {
  name: "UnreadList",
  components: {
    MessageList
  }
};
</script>

