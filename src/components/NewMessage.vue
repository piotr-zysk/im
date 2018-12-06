<template>
  <div class="newmessage_component">
    <input
      class="newmessage_title"
      type="text"
      :placeholder="$ml.get('message_title')"
      v-model="title"
    >
    <Editor class="newmessage_editor"></Editor>

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
    </div>
    <!-- <A href=# @click="test">test</A> -->
  </div>
</template>

<script>
import Editor from "./Editor.vue";

export default {
  name: "NewMessage",
  data() {
    return {
      title: "",
      imageFile: "",

      file: "",
      showPreview: false,
      imagePreview: ""
    };
  },
  computed: {
    form_ready: function() {
      if (this.title != "") return true;
      else return false;
    }
  },
  methods: {
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
    },
    handleFileUpload() {
      /*
      Set the local file variable to what the user has selected.
    */
      this.file = this.$refs.file.files[0];
      //console.log(this.file);

      if (this.file.type != "image/jpeg") {
        this.$message.error({ message: this.$ml.get("wrong_file_type") });
        return;
      }
      else if (this.file.size > 5242880) {
        this.$message.error({ message: this.$ml.get("file_too_big") });
        return;
      }
      
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
            //console.log(document);
          // change/adjust image resolution
          /*
            const p_img = new Image();
            p_img.src=reader.result;
            const canvas = document.createElement('canvas');
            //var canvas = $("<canvas>", {"id":"testing"})[0];
            let ctx = canvas.getContext("2d");
            //ctx.drawImage(p_img, 0, 0);

            let MAX_WIDTH = 1700;
            let MAX_HEIGHT = 2000;
            let width = p_img.width;
            let height = p_img.height;
            if (width > height) {
                if (width > MAX_WIDTH) {
                    height *= MAX_WIDTH / width;
                    width = MAX_WIDTH;
                }
            } else {
                if (height > MAX_HEIGHT) {
                    width *= MAX_HEIGHT / height;
                    height = MAX_HEIGHT;
                }
            }
            canvas.width = width;
            canvas.height = height;
            //ctx = canvas.getContext("2d");
            ctx.drawImage(p_img, 0, 0, width, height);


                ctx.canvas.toBlob((blob) => {
                    const efile = new File([blob], fileName, {
                        type: 'image/jpeg',lastModified: Date.now()
                    });
                }, 'image/jpeg', 1);

            //let dataurl = ctx.canvas.toDataURL("image/jpg");

            //document.getElementById('output').src = dataurl;


          //this.imagePreview = dataurl;
          */


          this.imagePreview = reader.result;
          this.showPreview = true;

        }.bind(this),
        false
      );

      /*
      Check to see if the file is not empty.
    */
      if (this.file) {
        /*
        Ensure the file is an image file.
      */
        if (/\.(jpe?g|png|gif)$/i.test(this.file.name)) {
          /*
          Fire the readAsDataURL method which will read the file in and
          upon completion fire a 'load' event which we will listen to and
          display the image in the preview.
        */
          reader.readAsDataURL(this.file);
        }
      }
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