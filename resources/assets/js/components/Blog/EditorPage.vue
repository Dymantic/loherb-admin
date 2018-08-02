<template>
    <div class="flex">
        <div class="flex-1 px-4">
            <h1 v-if="!post.title[lang]"
                class="my-6 text-grey-light">This is the post title</h1>
            <h1 v-else
                class="my-6">{{ post.title[lang] }}</h1>
            <div v-if="post.id">
                <wysiwyg v-for="l in Object.keys(post.body)"
                         :key="`wysiwyg_${l}`"
                         :taller="true"
                         v-model="post.body[l]"
                         v-if="l === lang"></wysiwyg>
            </div>

        </div>
        <div class="w-100 bg-grey-lightest sidebar relative">
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
                                  :upload-url="`/blog/posts/${postId}/title-image`"></image-upload>
                </div>
            </div>
            <div class="w-full h-16 border absolute pin-b flex justify-between px-4 items-center bg-white shadow">
                <p class="text-xs w-1/2">You have unsaved changes, don't forget to save.</p>
                <button @click="savePost"
                        class="px-3 py-2 uppercase tracking-wide font-bold bg-black text-white rounded shadow">Save
                </button>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import {Wysiwyg} from "@dymantic/trix-vue-wysiwyg";
    import {ImageUpload} from "@dymantic/imagineer";
    import {postRepo} from "../../Blog/PostRepo";
    import {Post} from "../../Blog/Post";

    export default {
        props: ['post-id'],
        components: {
            Wysiwyg,
            ImageUpload
        },

        data() {
            return {
                post: new Post({}),
                lang: 'en',
            };
        },

        mounted() {
            if(this.postId) {
                postRepo.fetch(this.postId)
                        .then(post => this.post = post)
                        .catch(err => console.log(err));
            }
        },

        methods: {
            setLang(lang) {
                this.lang = lang;
            },

            savePost() {
                this.post.id
                    ? postRepo.update(this.post).catch(err => console.log(err))
                    : postRepo.create(this.post).then(postId => this.post.id = postId).catch(err => console.log(err));

            }
        }
    }
</script>

<style scoped
       lang="less"
       type="text/scss">
    .current-lang:after {
        content: '';
        margin-left: 10px;
        width: .5rem;
        height: .5rem;
        vertical-align: middle;
        border-radius: 50%;
        background: black;
        display: inline-block;
    }

    .sidebar {
        height: calc(100vh - 3rem);
    }
</style>