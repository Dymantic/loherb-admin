<template>
    <div>
        <div class="flex justify-between items-center mt-4 mb-12">
            <h1 class="text-4xl font-sans text-grey-darkest normal">Categories</h1>
            <div class="flex justify-end items-center">
                <category-form @updated="fetchCategories"></category-form>
            </div>
        </div>
        <div>
            <div v-for="category in categories" :key="category.id" class="p-6 border max-w-xl my-12">
                <div class="max-w-lg flex justify-between">
                    <div class="mr-6 w-1/2 flex-1">
                        <p class="font-bold text-lg">{{ category.title.en }}</p>
                        <p class="my-4">{{ category.description.en }}</p>
                    </div>
                    <div class="ml-6 w-1/2 flex-1">
                        <p class="font-bold text-lg">{{ category.title.zh }}</p>
                        <p class="my-4">{{ category.description.zh }}</p>
                    </div>
                </div>
                <div class="flex justify-end">
                    <delete-category class="mr-4" :category="category" @deleted="fetchCategories"></delete-category>
                    <category-form :category="category" @updated="fetchCategories"></category-form>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import CategoryForm from "./CategoryForm";
import DeleteCategory from "./DeleteCategory";
    export default {
        components: {
            CategoryForm,
            DeleteCategory,
        },

        data() {
            return {
                categories: [],
            };
        },

        mounted() {
          this.fetchCategories();
        },

        methods: {
            fetchCategories() {
                axios.get("/blog/categories")
                .then(({data}) => this.categories = data);
            }
        }
    }
</script>
