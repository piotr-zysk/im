<template>
  <div>
    

    <vue-ckeditor v-model="content" :config="config" @blur="onBlur"/>

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
import { mapState, mapMutations } from "vuex";

export default {
  name: "Editor",
  components: { VueCkeditor },
  mounted() {
    if ((this.message_store.content != '') && (this.message_store.content != undefined)) this.content=this.message_store.content;
    //console.log(this.content+'/'+this.message_store.content);
  },
  computed: mapState(["message_store"]),
  data() {
    return {
      //...mapState(["message_store"]),
      content: '',
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
    ...mapMutations(["setMessageContent"]),
    onBlur() {
      this.setMessageContent(this.content);
    },
    /*
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



