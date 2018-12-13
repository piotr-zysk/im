<template>
  <div class="newmessage_component">
    <recipient-pickup></recipient-pickup>
    <input
      class="newmessage_title"
      type="text"
      :placeholder="$ml.get('message_title')"
      v-model="title"
    >
    <Editor class="newmessage_editor" ></Editor>

    <div>
      <img
        class="newmessage_picture"
        id="newmessage_picture"
        v-show="showPreview"
        :src="imagePreview"
      >
    </div>

    <div class="newmessage_footer">
      <input
        type="file"
        name="file"
        id="file"
        accept="image/jpeg"
        ref="file"
        @change="handleFileUpload"
      >
      <!-- image/x-png,image/gif, -->
      <label for="file" class="button_small_shadow">
        <i class="fas fa-upload"></i>
        {{$ml.get('attach_image')}}
      </label>

      <A href="#" :class="{button_small:form_ready, button_small_disable:!form_ready}">
        <i class="fas fa-shipping-fast"></i>
        {{$ml.get('send')}}
      </A>
      <A href="#" class="button_small_shadow" @click="resetForm();">
        <i class="fas fa-toilet-paper"></i>
        {{$ml.get('reset_form')}}
      </A>
      <p>test:</p>
    </div>
    <!-- <A href=# @click="test">test</A> -->
  </div>
</template>

<script>
import Editor from "./Editor.vue";
import RecipientPickup from "./RecipientPickup.vue";
import ImgHelper from "@/../services/ImgHelper";
import { mapState, mapMutations } from "vuex";

export default {
  name: "NewMessage",  
  components: {
    Editor, RecipientPickup
  },
  data() {
    return {
      title: "",
      imageFile: "",
      content: "aaa",
      file: "",
      showPreview: false,
      imagePreview: ""
    };
  },
  computed: {
    ...mapState(["message"]),
    form_ready: function() {
      if (this.title != "") return true;
      else return false;      
    }
  },
  methods: {
    ...mapMutations(["setMessageContent"]),
    /*
    test() {
        
          console.log(this.imagePreview);
    },
    */
    getImage(imgbody) {
      const imgt = new Image();
      imgt.src = imgbody;
      this.imagePreview = imgt.src;

      this.imagePreview = imgbody;
    },
    resetForm() {
      this.title = "";
      this.file = "";
      this.showPreview = false;
      this.imagePreview = "";

      this.$children[1].content='';
      this.setMessageContent('');
    },
    handleFileUpload() {
      this.$Progress.start();
      /*
      Set the local file variable to what the user has selected.
    */
      this.file = this.$refs.file.files[0];
      //console.log(this.file);

      if (this.file.type != "image/jpeg") {
        this.$Progress.fail();
        this.$message.error({ message: this.$ml.get("wrong_file_type") });
        return;
      }
      /*
      else if (this.file.size > 5242880) {
        this.$message.error({ message: this.$ml.get("file_too_big") });
        return;
      }
      */
      /*
      Initialize a File Reader object
    */
      let reader = new FileReader();

      /*
      Add an event listener to the reader that when the file
      has been loaded, we flag the show preview as true and set the
      image to be what was read from the reader.
    */
      reader.addEventListener(
        "load",
        function() {
          this.imagePreview = reader.result;
          this.showPreview = true;
          this.limitImageSize();
          this.$Progress.finish();
        }.bind(this),
        false
      );
      //      Check to see if the file is not empty.
      if (this.file) {
        //    Ensure the file is an image file.
        if (/\.(jpe?g|png|gif)$/i.test(this.file.name)) {
          /*
          Fire the readAsDataURL method which will read the file in and
          upon completion fire a 'load' event which we will listen to and
          display the image in the preview.
        */
          reader.readAsDataURL(this.file);
          reader.abort;
        }
      }
    },
    async limitImageSize() {
      var newDataURI = await ImgHelper.limitImageSize(this.imagePreview, 1800);
      this.imagePreview = newDataURI;
    }
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
  margin-top: 10px;
  outline: none;
  font-size: 130%;
}
.newmessage_editor {
  width: 100%;
  border: none;
  background-color: #fff;
  box-shadow: 0 3px 3px #ccc;
  padding: 4px 0;
  margin-top: 10px;
  outline: none;
}
.newmessage_picture {
  border: none;
  background-color: #fff;
  box-shadow: 0 3px 3px #ccc;
  margin-top: 10px;
  outline: none;
  width: 100%;
}
.newmessage_footer {
  border: none;
  background-color: #fff;
  box-shadow: 0 3px 3px #ccc;
  margin-top: 10px;
  padding: 4px 4px;
  outline: none;
}
.newmessage_footer input {
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