<template>
    <span>
        <button @click="showForm = true" class="btn btn-primary">{{  button_text }}</button>
        <modal :show="showForm" @close="showForm = false">
            <form @submit.prevent="submit" class="max-w-lg w-screen p-6">
                <p class="text-lg font-bold mb-6">{{  form_heading }}</p>
                <p v-show="submitError" class="my-4 text-red">There was a problem saving your data. Please refresh and try again.</p>
                <div class="flex">
                    <div class="w-1/2 flex-1 mr-4">
                        <div class="my-4" :class="{'border-b border-red': formErrors['title.en']}">
                            <label class="font-bold text-gray-dark text-sm" for="title.en">Name (English)</label>
                            <span class="text-xs text-red" v-show="formErrors['title.en']">{{ formErrors['title.en'] }}</span>
                            <input type="text" name="title.en" v-model="formData.title.en" class="mt-1 block p-2 border w-full" id="title.en">
                        </div>
                        <div class="my-4" :class="{'border-b border-red': formErrors['intro.en']}">
                            <label class="font-bold text-gray-dark text-sm" for="intro.en">Short Introduction (English)</label>
                            <span class="text-xs text-red" v-show="formErrors['intro.en']">{{ formErrors['intro.en'] }}</span>
                            <textarea name="intro.en" v-model="formData.intro.en" class="block p-2 h-24 border w-full mt-1" id="intro.en"></textarea>
                        </div>
                        <div class="my-4" :class="{'border-b border-red': formErrors['description.en']}">
                            <label class="font-bold text-gray-dark text-sm" for="description.en">SEO Description (English)</label>
                            <span class="text-xs text-red" v-show="formErrors['description.en']">{{ formErrors['description.en'] }}</span>
                            <textarea name="description.en" v-model="formData.description.en" class="block p-2 h-32 border w-full mt-1" id="description.en"></textarea>
                        </div>
                    </div>
                    <div class="w-1/2 flex-1 ml-4">
                        <div class="my-4" :class="{'border-b border-red': formErrors['title.zh']}">
                            <label class="font-bold text-gray-dark text-sm" for="title.zh">Name (Chinese)</label>
                            <span class="text-xs text-red" v-show="formErrors['title.zh']">{{ formErrors['title.zh'] }}</span>
                            <input type="text" name="title.zh" v-model="formData.title.zh" class="mt-1 block p-2 border w-full" id="title.zh">
                        </div>
                        <div class="my-4" :class="{'border-b border-red': formErrors['intro.zh']}">
                            <label class="font-bold text-gray-dark text-sm" for="intro.zh">Short Introduction (Chinese)</label>
                            <span class="text-xs text-red" v-show="formErrors['intro.zh']">{{ formErrors['intro.zh'] }}</span>
                            <textarea name="intro.zh" v-model="formData.intro.zh" class="block p-2 h-24 border w-full mt-1" id="intro.zh"></textarea>
                        </div>
                        <div class="my-4" :class="{'border-b border-red': formErrors['description.zh']}">
                            <label class="font-bold text-gray-dark text-sm" for="description.zh">SEO Description (Chinese)</label>
                            <span class="text-xs text-red" v-show="formErrors['description.zh']">{{ formErrors['description.zh'] }}</span>
                            <textarea name="description.zh" v-model="formData.description.zh" class="block p-2 h-32 border w-full mt-1" id="description.zh"></textarea>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end mt-8">
                    <button @click="showForm = false" type="button" class="btn btn-cancel">Cancel</button>
                    <button type="submit" class="ml-4 btn btn-primary">Submit</button>
                </div>
            </form>
        </modal>
    </span>
</template>

<script type="text/babel">
export default {

    props: ['category'],

    data() {
        return {
            showForm: false,
            submitError: false,
            formData: {
                title: {en: '', zh: ''},
                description: {en: '', zh: ''},
                intro: {en: '', zh: ''},
            },
            formErrors: {
                'title.en': '',
                'title.zh': '',
                'description.en': '',
                'description.zh': '',
                'intro.en': '',
                'intro.zh': '',
            }
        };
    },

    computed: {
        is_edit() {
            return this.category && this.category.id;
        },

        form_heading() {
            return this.is_edit ? 'Update this category': 'Add a new Category';
        },

        button_text() {
            return this.is_edit ? 'Edit': 'Add Category';
        }
    },

    mounted() {
        if(this.category) {
            this.formData = {
                title: {en: this.category.title.en, zh: this.category.title.zh},
                description: {en: this.category.description.en, zh: this.category.description.zh},
                intro: {en: this.category.intro.en, zh: this.category.intro.zh},
            }
        }
    },

    methods: {
        submit() {
            const url = this.is_edit ? `/blog/categories/${this.category.id}` : '/blog/categories';
            this.clearFormErrors();
            this.submitError = false;
            axios.post(url, this.formData)
            .then(() => this.onSuccess())
            .catch(({response}) => this.onError(response));
        },

        onSuccess() {
            if(!this.is_edit) {
                this.clearForm();
            }

            this.showForm = false;
            this.$emit('updated');
        },

        onError({status, data}) {
              if(status === 422) {
                  Object.keys(data.errors).forEach(key => {
                      if(this.formErrors.hasOwnProperty(key)) {
                          this.formErrors[key] = data.errors[key][0];
                      }
                  });

                  return;
              }

              this.submitError = true;
        },

        clearFormErrors() {
            this.formErrors = {
                'title.en': '',
                    'title.zh': '',
                    'description.en': '',
                    'description.zh': '',
                    'intro.en': '',
                    'intro.zh': '',
            };
        },

        clearForm() {
            this.formData = {
                title: {en: '', zh: ''},
                description: {en: '', zh: ''},
                intro: {en: '', zh: ''},
            };
        }
    }
}
</script>
