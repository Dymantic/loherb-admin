<template>
    <div>
        <div class="flex justify-between items-center mt-4 mb-12">
            <h1 class="text-4xl font-sans text-grey-darkest normal">{{ name }}</h1>
            <div class="flex justify-end items-center">
                <delete-modal :resource-name="name"
                              :delete-url="`/users/${userAttributes.id}`"
                              @item-deleted="userDeleted"
                              button-classes="btn btn-danger mr-4"
                              delete-button-classes="btn btn-danger"
                              cancel-button-classes="btn-cancel mr-4"></delete-modal>
                <user-form :form-object="user_form"
                           :use-passwords="false"
                           :url="`/users/${userAttributes.id}`"
                           button-text="edit"
                           form-title="Edit this users details"
                           @user-persisted="updateUser"></user-form>
            </div>
        </div>
        <div>
            <div class="flex items-center text-grey-dark">
                <svg height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M18 2a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4c0-1.1.9-2 2-2h16zm-4.37 9.1L20 16v-2l-5.12-3.9L20 6V4l-10 8L0 4v2l5.12 4.1L0 14v2l6.37-4.9L10 14l3.63-2.9z"/></svg>
                <a :href="`mailto:${email}`" class="text-xl no-underline text-grey-dark ml-6">{{ email }}</a>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import {Form} from "@dymantic/vue-forms";

    export default {
        props: ['user-attributes'],

        data() {
            return {
                user_form: new Form({
                    name: this.userAttributes.name,
                    email: this.userAttributes.email
                }),
                name: '',
                email: ''
            };
        },

        created() {
            this.name = this.userAttributes.name;
            this.email = this.userAttributes.email;
        },

        methods: {
            updateUser({name, email}) {
                this.user_form.resetFields({name, email});
                this.name = name;
                this.email = email;
            },

            userDeleted() {
                window.location = '/users';
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>