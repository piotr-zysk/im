<template>
  <div class="newmessage_component">
    <input
      class="newmessage_title"
      type="text"
      :placeholder="$ml.get('message_title')"
      v-model="title"
    >
    <Editor class="newmessage_editor"></Editor>
    <div class="newmessage_attachment">
      <input type="file" name="file" id="file" accept="image/jpeg" ref="myFiles" @change="loadImage"> <!-- image/x-png,image/gif, -->
      <label for="file" class="button_small_shadow"><i class="fas fa-upload"></i> {{$ml.get('attach_image')}}</label>
      <A href="#" :class="{button_small:form_ready, button_small_disable:!form_ready}"><i class="fas fa-shipping-fast"></i> {{$ml.get('send')}}</A>
      <A href="#" class="button_small_shadow" @click="resetForm();"><i class="fas fa-toilet-paper"></i> {{$ml.get('reset_form')}}</A>
    </div>
  </div>
</template>

<script>
import Editor from "../components/Editor.vue";

export default {
  name: "NewMessage",
  data: function() {
    return {
      title: "",
      imageFile: ""
    };
  },
  computed: {
    form_ready: function() {
      if (this.title!='') return true;
      else return false;
    }
  },
  methods: {
    resetForm() {
      this.title = "";
    },
    loadImage() {
      this.imageFile = this.$refs.myFiles.files[0];
      if (this.imageFile!='image/jpeg') console.log(this.imageFile);
    }
  },
  components: {
    Editor
  }
};
</script>

<style>
.newmessage_component {
  width: 90%;
  margin: 20px auto;
  box-shadow: 0 1px 1px #ccc;
  outline: none;
  text-align: left;
}
.newmessage_title {
  width: 100%;
  border: none;
  background-color: #fff;
  box-shadow: 0 3px 3px #ccc;
  padding: 4px 0;
  margin: 10px 0;
  outline: none;
  font-size: 130%;
}
.newmessage_editor {
  width: 100%;
  border: none;
  background-color: #fff;
  box-shadow: 0 3px 3px #ccc;
  padding: 4px 0;
  outline: none;
}
.newmessage_attachment {
  border: none;
  background-color: #fff;
  box-shadow: 0 3px 3px #ccc;
  padding: 4px 4px;
  margin: 10px 0;
  outline: none;
}
.newmessage_attachment input {
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}
::placeholder {
  color: #bbb;
}
i {
  background-color: inherit;
}
</style>