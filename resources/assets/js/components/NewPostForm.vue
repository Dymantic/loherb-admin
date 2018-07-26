<template>
    <span>
        <button @click="showForm = true" class="btn btn-primary">New Post</button>
        <modal :show="showForm">
            <div class="max-w-sm mx-auto border-t-4 border-black" slot="body">
                <h3 class="my-4">Create a new blog post</h3>
                <p class="my-4">Start with a title a language. You can change the title later, this is just to get started.</p>
                <p v-if="main_error.length > 0" class="text-danger text-xl">{{ main_error }}</p>
                <form>
                    <div class="form-group mt-3 mb-6" :class="{'has-error': form.errors.title}">
                        <label class="text-sm text-black font-bold" for="title">Post Title:</label>
                        <span class="text-xs text-red" v-show="form.errors.title">{{ form.errors.title }}</span>
                        <input type="text" name="title" v-model="form.data.title" class="w-full h-8 pl-2 mt-1 border" id="title">
                    </div>
                    <div class="lang-selector">
                        <p class="mb-3">Which language is the title in?</p>
                        <div>
                            <label class="mr-8" for="en_title">
                                <input class="lang-checkbox" id="en_title" type="radio" name="title_lang" value="en" v-model="form.data.lang">
                                <span class="lang-name font-bold">English</span>
                            </label>
                            <label for="zh_title">
                                <input class="lang-checkbox" type="radio" id="zh_title" name="title_lang" value="zh" v-model="form.data.lang">
                                <span class="lang-name font-bold">Chinese</span>
                            </label>
                        </div>
                    </div>
                    <div class="my-8 flex justify-end">
                        <button type="button" @click="showForm = false" class="btn btn-grey mr-8">Cancel</button>
                        <button type="submit" class="btn btn-primary" @click.prevent="postTitle">
                            Get started
                        </button>
                    </div>
                </form>
            </div>

        </modal>
    </span>
</template>

<script type="text/babel">


    export default {
        props: [],

        data() {
            return {
                main_error: '',
                showForm: false,
                form: {
                    data: {
                        title: '',
                        lang: 'en'
                    },
                    errors: {
                        title: '',
                    }
                }
            };
        },

        methods: {
            postTitle() {
                this.clearErrors();
                const title = {};
                title[this.form.data.lang] = this.form.data.title;

                axios.post("/blog/posts", {title})
                    .then(({data}) => this.handlePostSuccess(data))
                    .catch(({response}) => this.handleError(response))
            },

            handlePostSuccess(data) {
                console.log(data);
                this.showForm = false;

            },

            handleError(response) {
                if(response.status === 422) {
                    return this.form.errors.title = 'Your input was invalid. Make sure you have a title and a language.'
                }

                this.main_error = 'Failed to create post. Please refresh and try again later.'
            },

            clearErrors() {
                this.form.errors.title = '';
                this.form.errors.lang = '';
                this.main_error = '';
            }
        }
    }
</script>

<style scoped lang="less" type="text/css">
    .lang-checkbox {
        display: none;
    }

    .lang-name:after {
        content: '';
        display: inline-block;
        width: 1rem;
        height: 1rem;
        border: 1px solid black;
        margin-left: 10px;
    }
    .lang-checkbox:checked + .lang-name:after {
        background: black;
    }
</style>