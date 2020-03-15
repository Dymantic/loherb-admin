<template>
    <div class="bg-grey-lightest p-8 shadow max-w-md mx-auto mt-16">

        <p v-if="waiting">Checking feed, please wait...</p>
        <div v-else>
            <div v-if="all_good">
                <p class="text-lg text-blue font-bold mb-8">All good!</p>
                <p>Your Instagram feed is connected. Here are your latest posts. The sites will only update daily.</p>
                <div class="flex flex-wrap mt-12">
                    <img v-for="image in media" :src="image.url" class="h-32 w-32 object-cover block m-2"
                         alt="">
                </div>
            </div>
            <div v-if="!checked">
                <p class="text-lg text-red font-bold mb-8">Oh Dear!</p>
                <p>There was a problem checking your Instagram feed. This might be a temporary problem, or a problem with Instagram. You can try re-authorise, and if there are still problems, just try again later.</p>
                <div class="p-8 mb-12">
                    <p class="text-sm uppercase font-bold tracking-wide mb-4">Note:</p>
                    <p>If the problem does not go away, please contact Dymantic Design.</p>
                </div>

                <a class="btn btn-primary font-bold no-underline mt-8" :href="auth_url">Re-authorise</a>
            </div>
            <div v-if="bad_token">
                <p class="text-lg text-red font-bold mb-8">Oh Dear!</p>
                <p>Your instagram token is now invalid. Please use the button below to re-authorise your account.</p>
                <div class="p-8 mb-12">
                    <p class="text-sm uppercase font-bold tracking-wide mb-4">Note:</p>
                    <p>Make sure you are logged in to the correct instagram account.</p>
                </div>

                <a class="btn btn-primary font-bold no-underline mt-8" :href="auth_url">Re-authorise</a>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        data() {
            return {
                checked: false,
                has_access: false,
                auth_url: '',
                media: [],
                waiting: true,
            };
        },

        computed: {
            all_good() {
                return this.checked && this.has_access;
            },

            bad_token() {
                return this.checked && !this.has_access;
            }
        },


        mounted() {
            axios.get('/instagram-feed-status')
                .then(({data}) => this.setData(data))
                .catch(() => console.log('oh hell'))
        },
        methods: {
            setData({checked, has_access, media, auth_url}) {
                this.waiting = false;
                this.checked = checked;
                this.has_access = has_access;
                this.media = media;
                this.auth_url = auth_url;
            }
        }
    }
</script>
