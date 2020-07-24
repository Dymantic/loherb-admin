<template>
    <span>
        <button @click="showModal = true" class="px-2 py-1 border border-grey">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="h-4 fill-current mr-2"><path d="M14.83 4H20v6h-1v10H1V10H0V4h5.17A3 3 0 0 1 10 .76 3 3 0 0 1 14.83 4zM8 10H3v8h5v-8zm4 0v8h5v-8h-5zM8 6H2v2h6V6zm4 0v2h6V6h-6zM8 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>
            <span>Prezi</span>
        </button>
        <modal :show="showModal" @close="showModal = false">
            <div class="w-screen max-w-md p-6">
                <p class="font-bold text-xl mb-4">Prezi Embed</p>
                <p class="my-4 text-sm">Find the "view link" for your Prezi presentation, and paste it in below. It should be something like "https://prezi.com/view/25QVcyk0znxyTSlXFotI/"</p>
                <input type="text" v-model="insertion" class="w-full block border border-gray-200 p-2">
                <div class="flex justify-end mt-6">
                    <button @click="showModal = false" class="mr-4">Cancel</button>
                    <button @click="insertEmbed" class="btn btn-primary">Insert Prezi</button>
                </div>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
    export default {
        props: ['trix'],

        data() {
            return {
                showModal: false,
                insertion: '',
            };
        },

        computed: {
            view_link() {
                const end_in_slash = this.insertion[this.insertion.length - 1] === '/';

                return end_in_slash ? `${this.insertion}embed` : `${this.insertion}/embed`;
            }
        },

        methods: {
            insertEmbed() {
                const wrapped_iframe = `<iframe class="block mx-auto my-8 max-w-full" width="550" height="400" src="${this.view_link}" webkitallowfullscreen="1" mozallowfullscreen="1" allowfullscreen="1"></iframe></div>`;
                this.trix.attachment(wrapped_iframe);
                this.showModal = false;
                this.insertion = "";
            }
        }
    }
</script>
