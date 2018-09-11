<template>
    <span>
        <button @click="showForm = true" class="btn btn-primary">Add Post</button>
        <modal :show="showForm" @close="showForm = false">
            <div class="border-t-4 border-black max-w-md mx-auto px-4 pb-4">
                <h3 class="my-4">Create a new blog post</h3>
                <p>To get started you need to give your post a title. This can be changed later.</p>
                <vue-form url="/multilingual-posts/posts" :form-attributes="post" @submission-okay="postCreated" button-classes="btn btn-primary">
                    <div slot="form-body" slot-scope="{formData, formErrors}">
                        <div class="form-group my-3" :class="{'has-error': formErrors.title}"  v-if="lang === 'en'">
                            <label class="text-xs uppercase text-black font-bold" for="title_en">Title</label>
                            <span class="text-xs text-red" v-show="formErrors.title">{{ formErrors.title }}</span>
                            <input type="text" name="title" v-model="formData.title.en" class="w-full h-8 pl-2 mt-2 border" id="title_en">
                        </div>
                        <div class="form-group my-3" :class="{'has-error': formErrors.title}" v-if="lang === 'zh'">
                            <label class="text-xs uppercase text-black font-bold" for="title_zh">標題</label>
                            <span class="text-xs text-red" v-show="formErrors.title">{{ formErrors.title }}</span>
                            <input type="text" name="title" v-model="formData.title.zh" class="w-full h-8 pl-2 mt-2 border" id="title_zh">
                        </div>
                        <div class="mt-8">
                            <p class="text-xs text-grey mb-3">Which language are you using?</p>
                            <span class="cursor-pointer" :class="lang === 'en' ? 'text-black font-bold' : 'text-grey'" @click="lang = 'en'">English</span>
                            <span class="cursor-pointer ml-6" :class="lang === 'zh' ? 'text-black font-bold' : 'text-grey'" @click="lang = 'zh'">中文</span>
                        </div>
                    </div>
                    <div slot="form-button-row">
                        <button type="button" @click="showForm = false" class="btn btn-cancel mr-4">Cancel</button>
                    </div>
                </vue-form>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
import { Form } from "@dymantic/vue-forms";
export default {
  data() {
    return {
      post: new Form({ title: { en: "", zh: "" } }),
      showForm: false,
      lang: "en"
    };
  },

  methods: {
    postCreated({ id }) {
      window.location = `/blog/posts/${id}/edit`;
    }
  }
};
</script>

<style scoped lang="less" type="text/scss">
</style>