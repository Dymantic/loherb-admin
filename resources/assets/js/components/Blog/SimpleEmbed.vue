<template>
  <span>
    <button @click="show = true" class="px-2 py-1 border border-grey">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current" viewBox="0 0 20 20">
  <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
</svg>
      Embed code
    </button>
      <modal :show="show" @close="show = false">
          <div class="w-screen max-w-md p-6">
            <header class="font-bold text-xl mb-4">Embed snippet in post</header>
          <p class="text-sm mb-4">Paste in a snippet of code to embed in your post.</p>
          <textarea class="border border-grey block w-full p-2 h-32" v-model="insertion"></textarea>
          <div class="button-bar mt-6 flex justify-end">
            <button class="mr-4" @click="show = false">Cancel</button>
            <button @click="doInsert" class="btn btn-primary">Embed Snippet</button>
          </div>
          </div>
      </modal>

  </span>
</template>

<script>
export default {
  props: ["trix"],
  data() {
    return {
      show: false,
      insertion: ""
    };
  },
  methods: {
    doInsert() {
      const snippet = `<div class="mx-auto">${this.insertion}</div>`;
      this.trix.attachment(snippet);
      this.show = false;
      this.insertion = "";
    }
  }
};
</script>

