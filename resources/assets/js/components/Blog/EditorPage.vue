<template>
    <div class="flex relative editor-container">
        <div class="flex-1 px-4 overflow-auto pb-20">
            <h1 v-if="!post.title[lang]"
                class="my-6 text-grey-light">This is the post title</h1>
            <h1 v-else
                class="my-6">{{ post.title[lang] }}</h1>
            <div v-if="post.id">
                <wysiwyg v-for="l in Object.keys(post.body)"
                         :key="`wysiwyg_${l}`"
                         v-model="post.body[l]"
                         class="max-w-lg mx-auto"
                         :image-upload-path="`/multilingual-posts/posts/${post.id}/images`"
                         v-if="l === lang">
                </wysiwyg>
            </div>

        </div>
        <div class="w-100 bg-grey-lightest h-full relative">
            <div class="px-4 h-full overflow-auto pb-20">
                <div class="my-6">
                    <span class="font-bold text-xs uppercase tracking-wide">Language</span>
                    <div class="py-3"
                         @click="setLang('en')"
                         :class="{'current-lang': lang === 'en'}">English
                    </div>
                    <div class="py-3"
                         @click="setLang('zh')"
                         :class="{'current-lang': lang === 'zh'}">Chinese
                    </div>
                </div>
                <div class="my-6">
                    <label for="title-field"
                           class="font-bold text-xs uppercase tracking-wide">Title</label>
                    <input type="text"
                           id="title-field"
                           placeholder="A clear and helpful title"
                           class="w-full h-8 rounded bg-white pl-2 mt-2"
                           v-model="post.title[lang]">
                </div>
                <div class="my-6" v-if="post.category_id">
                    <p class="font-bold text-xs uppercase tracking-wide">Category</p>
                    <div class="flex flex-wrap justify-around">
                        <label for="cuisine" class="w-2/5 my-2">
                            <input :value="1" v-model="post.category_id" id="cuisine" type="checkbox" class="hidden">
                            <span class="psuedo-check-label">Cuisine</span>
                        </label>
                        <label for="estate" class="w-2/5 my-2">
                            <input :value="4" v-model="post.category_id" id="estate" type="checkbox" class="hidden">
                            <span class="psuedo-check-label">Estate</span>
                        </label>
                        <label for="biotech" class="w-2/5 my-2">
                            <input :value="2" v-model="post.category_id" id="biotech" type="checkbox" class="hidden">
                            <span class="psuedo-check-label">Biotech</span>
                        </label>
                        <label for="villa" class="w-2/5 my-2">
                            <input :value="3" v-model="post.category_id" id="villa" type="checkbox" class="hidden">
                            <span class="psuedo-check-label">Villa</span>
                        </label>
                    </div>
                </div>
                <div class="my-6">
                    <label for="description-field"
                           class="font-bold text-xs uppercase tracking-wide">SEO Description</label>
                    <textarea id="description-field"
                              v-model="post.description[lang]"
                              placeholder="This is important for SEO. A brief description of what the post is about."
                              class="w-full h-24 rounded bg-white p-2 mt-2"></textarea>
                </div>
                <div class="my-6">
                    <label for="intro-field"
                           class="font-bold text-xs uppercase tracking-wide">Introduction</label>
                    <textarea id="intro-field"
                              v-model="post.intro[lang]"
                              placeholder="A short paragraph to introduce your post. Will be shown on blog pages."
                              class="w-full h-32 rounded bg-white p-2 mt-2"></textarea>
                </div>
                <div class="my-6">
                    <span class="font-bold text-xs uppercase tracking-wide mb-2">Title Image</span>
                    <image-upload class="mt-2"
                                  v-if="post.id"
                                  :initial-src="post.title_image_web"  
                                  :upload-url="`/multilingual-posts/posts/${postId}/title-image`"></image-upload>
                </div>
            </div>
            
        </div>
        <div class="w-full h-16 border absolute pin-b flex justify-between px-4 items-center bg-white shadow">
            <div class="flex justify-between items-center">
                <p>{{ publish_status }}</p>
                <button type="button" class="ml-4 px-3 py-2 uppercase tracking-wide font-bold bg-black text-white rounded shadow">Publish</button>
            </div>
            <div class="flex justify-between items-center w-64">
                <p class="text-xs w-1/2">Remember to save your changes.</p>
                <button @click="savePost"
                        class="px-3 py-2 uppercase tracking-wide font-bold bg-black text-white rounded shadow">Save
                </button>
            </div>
            
        </div>
    </div>
</template>

<script type="text/babel">
import Wysiwyg from "@dymantic/trix-vue";
import { ImageUpload } from "@dymantic/imagineer";
import { postRepo } from "../../Blog/PostRepo";
import { Post } from "../../Blog/Post";

export default {
  props: ["post-id"],
  components: {
    Wysiwyg,
    ImageUpload
  },

  data() {
    return {
      post: new Post({}),
      lang: "en",
      category_id: [1]
    };
  },

  computed: {
    publish_status() {
      if (this.post.is_draft === undefined) {
        return "";
      }

      if (this.post.is_draft === true) {
        return "This is a draft, the post is not public";
      }

      return "This post has been published: " + this.post.publish_date;
    }
  },

  mounted() {
    if (this.postId) {
      postRepo
        .fetch(this.postId)
        .then(post => (this.post = post))
        .catch(err => console.log("fuck", err));
    }
  },

  methods: {
    setLang(lang) {
      this.lang = lang;
    },

    savePost() {
      postRepo.save(this.post).catch(err => console.log(err));
    }
  }
};
</script>

<style scoped
       lang="less"
       type="text/scss">
.current-lang:after {
  content: "";
  margin-left: 10px;
  width: 0.5rem;
  height: 0.5rem;
  vertical-align: middle;
  border-radius: 50%;
  background: black;
  display: inline-block;
}

.editor-container {
  height: calc(100vh - 3rem);
}

.psuedo-check-label::after {
  content: "";
  margin-left: 8px;
  display: inline-block;
  width: 1rem;
  height: 1rem;
  border: 1px solid #333;
  vertical-align: text-bottom;
}

input[type="checkbox"]:checked + .psuedo-check-label::after {
  background: #333;
}
</style>