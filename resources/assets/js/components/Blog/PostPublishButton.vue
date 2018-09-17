<template>
    <span>
        <busy-button :button-text="button_text"
                     :busy="waiting"
                     class="p-2 rounded text-xs font-bold bg-black text-white uppercase tracking-wide mx-4"
                     @clicked="doPublishAction"></busy-button>
        <modal :show="showPublishPanel">
            <div class="">
                <div class="h-12 flex justify-between items-center border-b border-grey px-4">
                    <p class="text-lg text-bold">Publish this post</p>
                    <button type="button"
                            @click="showPublishPanel = false">&times;</button>
                </div>
                <div class="flex justify-between min-h-100">
                    <div class="p-4">
                        <p class="text-sm mb-4">Select a date to publish on:</p>
                        <date-picker :inline="true"
                                     v-model="publish_date"></date-picker>
                    </div>
                    <div class="py-4 px-8 w-100 leading-normal">
                        <p class="text-sm mb-4">Check that you have...</p>
                        <ul class="mt-4 pl-0 text-sm">
                            <li>completed all translations</li>
                            <li>written a good SEO description</li>
                            <li>set a title image</li>
                        </ul>
                    </div>
                </div>
                <div class="h-12 flex justify-end items-center border-b border-grey px-4">
                    <button type="button"
                            @click="showPublishPanel = false"
                            class="ml-4 p-2 uppercase tracking-wide text-xs font-bold bg-grey text-black">Cancel</button>
                    <busy-button :busy="waiting"
                                 button-text="Publish"
                                 class="p-2 rounded text-xs font-bold bg-black text-white uppercase tracking-wide mx-4"
                                 @clicked="publish"></busy-button>
                </div>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
    import DatePicker from "vuejs-datepicker";
    import BusyButton from "../BusyButton";

    export default {
        components: {
            DatePicker,
            BusyButton
        },

        props: ['init-draft', 'init-publish-date', 'post-id'],

        data() {
            return {
                showPublishPanel: false,
                publish_date: this.initPublishDate ? new Date(this.initPublishDate) : Date.now(),
                is_draft: this.initDraft,
                waiting: false
            };
        },

        computed: {
            button_text() {
                return this.is_draft ? 'Publish' : 'Retract';
            }
        },

        methods: {
            doPublishAction() {
                if(!this.is_draft) {
                    return this.retract();
                }

                this.showPublishPanel = true;
            },

            publish() {
                const date = new Date(this.publish_date).toISOString().substr(0,10);
                this.waiting = true;
                axios.post("/multilingual-posts/published-posts", {
                    publish_date: date,
                    post_id: this.postId
                }).then(({data}) => this.changedStatus(data))
                     .catch(err => console.log(err)).then(() => this.waiting = false);
            },

            changedStatus(post) {
                this.$emit('published-status-changed', post);
                this.is_draft = post.is_draft;
                this.showPublishPanel = false;
            },

            retract() {
                this.waiting = true;
                axios.delete(`/multilingual-posts/published-posts/${this.postId}`)
                    .then(({data}) => this.changedStatus(data))
                    .catch(err => console.log(err))
                    .then(() => this.waiting = false);
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>