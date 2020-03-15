<template>
    <span>
        <button @click="showDeleteForm = true" class="text-red"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="fill-current" d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8H3a1 1 0 1 1 0-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1z"/></svg></button>
        <modal :show="showDeleteForm" @close="showDeleteForm = false">
            <div class="w-full max-w-sm mx-auto px-8 pt-4 pb-8 border-t-4 border-red">
                <p class="text-2xl font-bold text-red mb-6">Please confirm</p>
                <p class="text-lg">Are you sure you want to delete this post? You will not be able to recover it.</p>
                <div class="mt-4 flex justify-end items-center">
                    <button @click="showDeleteForm = false" class="font-bold mr-4 text-grey-dark">No, cancel.</button>
                    <button @click="deletePost" class="btn btn-danger" :class="{'opacity-50': waiting}">Yes, Delete it.</button>
                </div>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
    export default {
        props: ['post-id'],
        data() {
            return {
                waiting: false,
                showDeleteForm: false
            };
        },

        methods: {
            deletePost() {
                this.waiting = true;
                axios.delete(`/multilingual-posts/posts/${this.postId}`)
                    .then(() => this.onPostDeleted())
                    .catch(() => this.failedToDelete())
                    .then(() => this.waiting = false)
            },
            onPostDeleted() {
               window.location = '/blog';
            },
            failedToDelete() {
                console.log('failed to delete post');
            }
        }
    }
</script>
