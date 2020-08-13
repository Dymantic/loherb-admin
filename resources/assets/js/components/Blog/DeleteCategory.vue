<template>
    <span>
        <button class="btn btn-danger" @click="showModal = true">Delete</button>
        <modal :show="showModal" @close="showModal = false">
            <div class="max-w-md w-screen p-6">
                <p class="font-bold text-red text-lg mb-6">Are you sure?</p>
                <p v-show="submitError" class="my-4 text-red">There was a error trying to delete the category. Please refresh and try again.</p>
                <p class="mt-6">You are about to delete the "{{ category.title.en }}" category. You cannot undo this. Posts saved to this category will NOT be deleted.</p>
                <div class="flex justify-end mt-8">
                    <button @click="showModal = false" class="btn btn-cancel mr-4">Cancel</button>
                    <button @click="deleteCategory" class="btn btn-danger">Yes, delete it!</button>
                </div>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
    export default {
        props: ['category'],

        data() {
            return {
                submitError: false,
                showModal: false,
            };
        },

        methods: {
            deleteCategory() {
                this.submitError = false;
                axios.delete(`/blog/categories/${this.category.id}`)
                .then(this.onSuccess)
                .catch(this.onError);
            },

            onSuccess() {
                this.showModal = false;
                this.$emit('deleted');
            },

            onError() {
                this.submitError = true;
            }
        }
    }
</script>
