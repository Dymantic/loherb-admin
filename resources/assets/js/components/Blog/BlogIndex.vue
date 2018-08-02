<template>
    <div>
        <div class="flex justify-between items-center mt-4 mb-12">
            <h1 class="text-4xl font-sans text-grey-darkest normal">Blog Posts</h1>
            <div class="flex justify-end items-center">
                <new-post-form></new-post-form>
            </div>
        </div>
        <div class="flex justify-between my-8 max-w-lg mx-auto">
            <button @click="getPrevPage" class="btn btn-primary" :disabled="current_page === 1">Prev page</button>
            <p>Page {{ current_page }} of {{ totalPages }}</p>
            <button @click="getNextPage" class="btn btn-primary" :disabled="current_page >= totalPages">Next page</button>
        </div>
        <div class="bg-grey-lightest max-w-lg mx-auto shadow rounded mb-8">
            <div class="p-4 border-b border-grey-light" v-for="post in posts" :key="post.id">
                <a :href="`/blog/posts/${post.id}/edit`"
                   class="no-underline hover:underline text-black">
                    <p class="my-4 font-bold">{{ showTitle(post) }}</p>
                </a>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['post-list', 'page', 'total-pages'],

        data() {
            return {
                lang: 'en',
                posts: [],
                current_page: 1
            };
        },

        mounted() {
          this.posts = this.postList;
          this.current_page = this.page
        },

        methods: {
            showTitle(post) {
                if(post.title[this.lang]) {
                    return post.title[this.lang];
                }

                const lang = Object.keys(post.title).find(lang => post[lang] !== "");
                return post.title[lang];
            },

            getNextPage() {
                if(this.current_page === this.totalPages) {
                    return;
                }
                this.getPage(this.current_page + 1);
            },

            getPrevPage() {
                if(this.current_page === 1) {
                    return;
                }
                this.getPage(this.current_page - 1);
            },

            getPage(page) {
                axios.get(`/api/blog/posts?page=${page}`)
                     .then(({data}) => {
                         this.posts = data.posts;
                         this.current_page = data.page;
                     });
            }
        }
    }
</script>

<style scoped lang="scss" type="text/scss">

</style>