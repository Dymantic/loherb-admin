<template>
    <span>
        <button @click="showForm = true"
                class="btn btn-primary">{{ buttonText }}</button>
        <modal :show="showForm">
            <div class="border-t-4 border-black p-8">
                <vue-form :url="url"
                          :form-attributes="formObject"
                          @submission-okay="persistedUser"
                          class="max-w-sm mx-auto"
                          button-classes="btn btn-primary ml-4">

                    <div slot="form-body"
                         slot-scope="{formData, formErrors}">
                        <h3 class="my-4">{{ formTitle }}</h3>
                        <div class="form-group my-3"
                             :class="{'has-error': formErrors.name}">
                            <label class="text-sm font-bold"
                                   for="name">Name</label>
                            <span class="text-xs text-red"
                                  v-show="formErrors.name">{{ formErrors.name }}</span>
                            <input type="text"
                                   name="name"
                                   v-model="formData.name"
                                   class="w-full h-8 pl-2 mt-1 border"
                                   id="name">
                        </div>
                        <div class="form-group my-3"
                             :class="{'has-error': formErrors.email}">
                            <label class="text-sm font-bold">Email</label>
                            <span class="text-xs text-red"
                                  v-show="formErrors.email">{{ formErrors.email }}</span>
                            <input autocomplete="off"
                                   type="email"
                                   v-model="formData.email"
                                   class="w-full h-8 pl-2 mt-1 border">
                        </div>
                        <div v-if="usePasswords"
                             class="form-group my-3"
                             :class="{'has-error': formErrors.password}">
                            <label class="text-sm font-bold"
                                   for="password">Password</label>
                            <span class="text-xs text-red"
                                  v-show="formErrors.password">{{ formErrors.password }}</span>
                            <input autocomplete="off"
                                   type="password"
                                   v-model="formData.password"
                                   class="w-full h-8 pl-2 mt-1 border"
                                   id="password">
                        </div>
                        <div v-if="usePasswords"
                             class="form-group my-3"
                             :class="{'has-error': formErrors.password}">
                            <label class="text-sm font-bold"
                                   for="password_confirmation">Confirm Password</label>
                            <span class="text-xs text-red"
                                  v-show="formErrors.password">{{ formErrors.password }}</span>
                            <input autocomplete="off"
                                   type="password"
                                   name="password_confirmation"
                                   v-model="formData.password_confirmation"
                                   class="w-full h-8 pl-2 mt-1 border"
                                   id="password_confirmation">
                        </div>
                    </div>
                    <div slot="form-button-row">
                        <button type="button"
                                @click="showForm = false"
                                class="text-grey-dark underline font-bold mr-8">Cancel</button>
                    </div>
                </vue-form>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">


    export default {
        props: ['url', 'button-text', 'form-object', 'form-title', 'use-passwords'],

        data() {
            return {
                showForm: false
            };
        },

        methods: {
            persistedUser(user) {
                this.$emit('user-persisted', user);
                this.showForm = false;
            }
        }
    }
</script>

<style scoped
       lang="css"
       type="text/css">

</style>