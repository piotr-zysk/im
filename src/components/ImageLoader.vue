<template>
<div>
<input
        type="file"
        name="file"
        id="file"
        accept="image/jpeg"
        ref="myFiles"
        @change="loadImage"
      >
      <!-- image/x-png,image/gif, -->
      <label for="file" class="button_small_shadow">
        <i class="fas fa-upload"></i>
        {{$ml.get('attach_image')}}
      </label>
</div>
      <!--
  <label class="text-reader">
    <input type="file" @change="loadTextFromFile">
  </label>-->
</template>

<script>
export default {
  methods: {
    getIMG(body) {

          const img=new Image();
          img.src=body;
          return img.src;
    },
    loadImage(ev) {
      const file = ev.target.files[0];
    if (file.type != "image/jpeg_")
      {

      const reader = new FileReader();

    reader.onload = e => this.$emit("load", decodeURI(this.getIMG(e.target.result.toString('base64'))));
      //reader.onload = e => this.$emit("load", 'data:image/jpeg;base64,' + this.getIMG(e.target.result).toString('base64'));
      //reader.onload = e => this.$emit("load", e.target.result.toString('base64'));
/*
        reader.onload =function() {

          const img=new Image();
          img.src=reader.result;
          return this.$emit("load", img.src);
        }

*/
      reader.readAsText(file);
      }
      else
      {
      this.$message.error({
          message: this.$ml.get("wrong_file_type")
        });
      }
    }
  }
};
</script>