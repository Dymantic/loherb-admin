<template>
  <span>
    <button @click="show = true" class="px-2 py-1 border border-grey">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
        <path d="M0 0h24v24H0z" fill="none"></path>
        <path
          d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-8 12.5v-9l6 4.5-6 4.5z"
        ></path>
      </svg> Embed Video
    </button>
      <modal :show="show" @close="show = false">
          <div class="w-screen max-w-md p-6">
            <header class="font-bold text-xl mb-4">Video Embed</header>
          <p class="text-sm mb-4">Copy and paste the Youtube embed code into the box below and then click the button. To find the embed code, look for the "share" option under the video on YouTube, and then select embed.</p>
          <textarea class="border border-grey block w-full p-2 h-32" v-model="insertion"></textarea>
          <div class="button-bar mt-6 flex justify-end">
            <button class="mr-4" @click="show = false">Cancel</button>
            <button @click="doInsert" class="btn btn-primary">Embed Video</button>
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
      const wrapped_iframe = `<div class="aspect-16-9">${this.insertion}</div>`;
      this.trix.attachment(wrapped_iframe);
      this.show = false;
      this.insertion = "";
    }
  }
};
</script>

