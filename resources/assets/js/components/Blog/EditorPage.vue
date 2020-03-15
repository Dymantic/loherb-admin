<template>
    <div>
        <div v-if="!post.id">loading</div>
        <div v-if="post.id" class="flex relative editor-container">
            <div class="flex-1 px-4 overflow-auto pb-20">
                <h1 v-if="!post.title[lang]"
                    class="my-6 text-grey-light">This is the post title</h1>
                <h1 v-else
                    class="my-6">{{ post.title[lang] }}</h1>
                <wysiwyg v-for="l in Object.keys(post.body)"
                         :key="`wysiwyg_${l}`"
                         v-model="post.body[l]"
                         class="max-w-lg mx-auto"
                         :image-upload-path="`/multilingual-posts/posts/${post.id}/images`"
                         :max-image-file-size="20"
                         v-slot="{document}"
                         v-if="l === lang">
                    <embed-video-button :trix="document"></embed-video-button>
                </wysiwyg>
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
                    <div class="my-6"
                         v-if="post.category_id">
                        <p class="font-bold text-xs uppercase tracking-wide">Category</p>
                        <div class="flex flex-wrap justify-around">
                            <label v-for="category in categories"
                                   :for="category.slug"
                                   class="w-2/5 my-2">
                                <input :value="category.id"
                                       v-model="post.category_id"
                                       :id="category.slug"
                                       type="checkbox"
                                       class="hidden">
                                <span class="psuedo-check-label">{{ category.title }}</span>
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
                                      :initial-src="post.title_image_web"
                                      :upload-url="`/multilingual-posts/posts/${postId}/title-image`"></image-upload>
                    </div>
                </div>

            </div>
            <div class="w-full h-16 border absolute pin-b flex justify-between px-4 items-center bg-white shadow">
                <div class="flex justify-between items-center">
                    <delete-post-button :post-id="post.id"></delete-post-button>
                    <publish-button :init-draft="post.is_draft"
                                    :post-id="postId"
                                    :init-publish-date="post.publish_date"
                                    @published-status-changed="updatePublishInfo"
                    ></publish-button>
                    <p class="text-xs">{{ publish_status }}</p>
                </div>
                <div class="flex justify-between items-center w-64" :class="{'opacity-75': !should_save}">
                    <p class="text-xs w-1/2">{{ saved_status }}</p>
                    <busy-button @clicked="savePost"
                                 :busy="waiting"
                                 button-text="Save"
                                 class="px-3 py-2 uppercase tracking-wide font-bold text-xs bg-black text-white rounded shadow"
                    ></busy-button>
                </div>
            </div>
        </div>
    </div>

</template>

<script type="text/babel">
    import Wysiwyg from "@dymantic/vue-trix-editor";
    import {ImageUpload} from "@dymantic/imagineer";
    import {postRepo} from "../../Blog/PostRepo";
    import {Post} from "../../Blog/Post";
    import PublishButton from "./PostPublishButton";
    import BusyButton from "../BusyButton";
    import EmbedVideoButton from "./VideoPlugin";
    import DeletePostButton from "./DeletePostButton";

    export default {
        props: ["post-id", 'categories'],
        components: {
            Wysiwyg,
            ImageUpload,
            PublishButton,
            BusyButton,
            EmbedVideoButton,
            DeletePostButton
        },

        data() {
            return {
                post: new Post({}),
                lang: "en",
                category_id: [1],
                waiting: false,
                last_saved_at: null,
            };
        },

        computed: {
            publish_status() {
                if (this.post.is_draft === undefined) {
                    return "";
                }

                if (this.post.is_draft === true) {
                    return "This post is currently a draft.";
                }

                const publish = new Date(this.post.publish_date_year, this.post.publish_date_month, this.post.publish_date_day);
                const now = new Date();

                const future = publish.getTime() > now.getTime();

                return future ? "This post will be published on " + this.post.publish_date_string :
                    "This post was published on " + this.post.publish_date_string;
            },

            saved_status() {
                if(! this.last_saved_at) {
                    return "";
                }

                return `Saved at ${this.last_saved_at.toLocaleTimeString('en-US')}`;
            },

            should_save() {
                return this.post.is_dirty;
            }
        },

        mounted() {
            if (this.postId) {
                postRepo
                    .fetch(this.postId)
                    .then(post => (this.post = post))
                    .catch(err => console.log("fuck", err));
            }

            window.setInterval(() => {
                if(this.should_save) {
                    this.savePost()
                }
            }, 10000);
        },

        methods: {
            setLang(lang) {
                this.lang = lang;
            },

            savePost() {
                this.waiting = true;
                postRepo.save(this.post)
                        .then(() => {
                            this.last_saved_at = new Date();
                            this.post.is_dirty = false;
                        })
                        .catch(err => console.log(err))
                        .then(() => this.waiting = false);
            },

            updatePublishInfo({is_draft, is_live, first_published_on, publish_date_string, publish_date_year, publish_date_month, publish_date_day}) {
                this.post.is_draft = is_draft;
                this.post.is_live = is_live;
                this.post.first_published_on = first_published_on;
                this.post.publish_date_string = publish_date_string;
                this.post.publish_date_year = publish_date_year;
                this.post.publish_date_month = publish_date_month;
                this.post.publish_date_day = publish_date_day;
            }
        }
    };
</script>

<style scoped
       lang="less">
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
