<template>
    <div>
        <div class="p-4 border-b border-grey-light flex justify-between items-center">
            <div>
                <a :href="`/blog/posts/${post.id}/edit`"
                   class="no-underline hover:underline text-black">
                    <p class="my-2 font-bold">{{ post.title['en'] }}</p>
                </a>
                <p>
                        <span v-for="category in post.categories"
                              :key="category.id"
                              class="uppercase text-xs mr-4"
                        >{{ category.title['en'] }}</span>
                </p>
            </div>
            <div class="w-48 text-center">
                <p :class="publish_colour" class="my-2 uppercase text-sm font-bold tracking-wide">{{ publish_status }}</p>
                <p v-if="!post.is_draft" class="text-xs text-grey-dark">{{ post.publish_date_string }}</p>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['post'],

        computed: {
            publish_status() {
                if(this.post.is_draft) {
                    return "Draft";
                }

                if(this.post.is_live) {
                    return "Published";
                }

                return "Scheduled";
            },

            publish_colour() {
                if(this.post.is_draft) {
                    return "text-red";
                }

                if(this.post.is_live) {
                    return "text-green";
                }

                return "text-orange";
            }
        }
    }
</script>
