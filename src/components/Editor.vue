<template>
  <div>
    

    <vue-ckeditor v-model="content" :config="config"/>

    <!--
      @blur="onBlur($event)" 
      @focus="onFocus($event)"
      @contentDom="onContentDom($event)"
      @dialogDefinition="onDialogDefinition($event)"
      @fileUploadRequest="onFileUploadRequest($event)"
      @fileUploadResponse="onFileUploadResponse($event)" />
    -->
  </div>
</template>

<script>
import VueCkeditor from "vue-ckeditor2";

export default {
  name: "Editor",
  components: { VueCkeditor },
  mounted() {},

  data() {
    return {
      content: "",
      config: {
        toolbarGroups: [
          { groups: ["undo"] },
          { name: "editing", groups: ["find", "selection"] },
          

          {
            name: "basicstyles",
            groups: ["basicstyles", "underline", "cleanup"]
          },
          {
            name: "paragraph",
            groups: ["list", "indent", "blocks", "align","links"]
          },
          { name: "styles" },
          { name: "colors" }
        ],
        height: 200,
        autoresize: true,
        language: "en"
      }
    };
  },
  methods: {
    /*
    onBlur(evt) {
      console.log(evt);
    },
    onFocus(evt) {
      console.log(evt);
    },
    onContentDom(evt) {
      console.log(evt);
    },
    onDialogDefinition(evt) {
      console.log(evt);
    },
    onFileUploadRequest(evt) {
      console.log(evt);
    },
    onFileUploadResponse(evt) {
      console.log(evt);
    }
    */
  }
};
</script>



