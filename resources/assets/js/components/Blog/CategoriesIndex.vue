<template>
    <div>
        <div class="flex justify-between items-center my-12">
            <h1 class="text-4xl font-sans text-grey-darkest normal">Journal Categories</h1>
            <div class="flex justify-end items-center">
                <category-form @updated="fetchCategories"></category-form>
            </div>
        </div>

        <div class="my-12">
            <language-selector v-model="lang"></language-selector>
        </div>

        <div>
            <div v-for="category in categories" :key="category.id" class="p-6 border max-w-lg mx-auto my-12">
                <div class="max-w-lg">
                    <div class="mr-6">
                        <p class="font-bold text-lg">{{ category.title[lang] }}</p>
                        <p class="my-4">{{ category.intro[lang] }}</p>
                        <p class="my-4 text-sm text-gray-light">{{ category.description[lang] }}</p>
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
                lang: 'zh',
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
