<template>
    <div>
        <div class="flex justify-between items-center mt-4 mb-12">
            <h1 class="text-4xl font-sans text-grey-darkest normal">Admin Users</h1>
            <div class="flex justify-end items-center">
                <user-form url="/users" button-text="Add User" :form-object="blank_user" @user-persisted="addNewUser" form-title="Add a new admin user" :use-passwords="true"></user-form>
            </div>
        </div>
        <p class="mt-12 mb-4">These are the admin users for the site. All users have equal abilities, meaning they can all create new users, log in, and such.</p>
        <p class="mb-12">When adding a new user, choose them a password to start with, and inform them of their login details. A user may change their password once they have logged in.</p>
        <div>
            <div v-for="user in users" :key="user.id" class="my-12 pl-4 border-l-4 border-black">
                <div class="flex items-center text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" height="20px"><path d="M5 5a5 5 0 0 1 10 0v2A5 5 0 0 1 5 7V5zM0 16.68A19.9 19.9 0 0 1 10 14c3.64 0 7.06.97 10 2.68V20H0v-3.32z"/></svg>
                    <p class="text-xl font-black ml-4"><a :href="`users/${user.id}`" class="text-black">{{ user.name }}</a></p>
                </div>
                <div class="flex items-center text-grey-dark mt-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" height="20px"><path d="M18 2a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4c0-1.1.9-2 2-2h16zm-4.37 9.1L20 16v-2l-5.12-3.9L20 6V4l-10 8L0 4v2l5.12 4.1L0 14v2l6.37-4.9L10 14l3.63-2.9z"/></svg>
                    <p class="text-lg ml-4"><a :href="`mailto:${user.email}`" class="no-underline text-grey-dark">{{ user.email }}</a></p>
                </div>

            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import {Form} from "@dymantic/vue-forms";
    export default {
        props: ['users-list'],

        data() {
            return {
                users: [],
                blank_user: new Form({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                })
            };
        },

        created() {
          this.users = this.usersList || [];
        },

        methods: {
            addNewUser(user) {
                this.users.push(user);
                this.blank_user.resetFields();
            }
        }
    }
</script>

<style scoped lang="scss" type="text/scss">

</style>