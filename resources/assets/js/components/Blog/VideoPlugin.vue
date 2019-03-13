<template>
  <span>
    <div @click="show = true" class="modal-btn">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
        <path d="M0 0h24v24H0z" fill="none"></path>
        <path
          d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-8 12.5v-9l6 4.5-6 4.5z"
        ></path>
      </svg> Embed Video
    </div>
    <div class="modal-outer" :class="{'open': show}">
      <div class="modal-inner">
        <div>
          <header>Video Embed</header>
          <p>Copy and paste the Youtube embed code into the box below and then click the button. To find the embed code, look for the "share" option under the video on YouTube, and then select embed.</p>
          <textarea class="border border-grey" v-model="insertion"></textarea>
          <div class="button-bar">
            <button class="cancel" @click="show = false">Cancel</button>
            <button @click="doInsert">Embed Video</button>
          </div>
        </div>
      </div>
    </div>
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
      this.trix.attachment(this.insertion);
      this.show = false;
      this.insertion = "";
    }
  }
};
</script>

<style scoped>
.modal-outer {
  display: none;
  position: fixed;
  z-index: 9999;
  background: rgba(0, 0, 0, 0.6);
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
}

.modal-outer.open {
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-inner {
  padding: 2rem;
  background: #fff;
}

.modal-inner > div {
  display: block;
  max-width: 100%;
  width: 30rem;
  font-family: sans-serif;
}

.modal-inner header {
  font-size: 1.25rem;
  font-weight: bold;
  margin: 1rem 0;
  color: #282828;
}

.modal-inner p {
  font-size: 0.85rem;
  line-height: 1.5;
  margin: 1rem 0;
}

.modal-inner textarea {
  width: 100%;
  display: block;
  resize: none;
  height: 10rem;
  padding: 0.5rem;
  font-size: 1.125rem;
}

.modal-inner button {
  display: inline-block;
  margin-left: auto;
  margin-top: 1rem;
  background: #ff0000;
  color: #fff;
  text-transform: uppercase;
  padding: 0.25rem 0.5rem;
  border: none;
  box-shadow: 1px 1px 3px silver;
  border-radius: 4px;
  font-weight: 700;
  letter-spacing: 0.05rem;
}

.button-bar {
  display: flex;
  justify-content: flex-end;
}

.modal-inner button.cancel {
  background: transparent;
  color: #333;
}

.button-bar button {
  margin-left: 1rem;
}

.modal-inner button:hover {
  background: #d42d2d;
}

.modal-inner button.cancel:hover {
  background: transparent;
  color: #ff0000;
}

.modal-btn {
  display: flex;
  align-items: center;
  border: 1px solid silver;
  padding: 2px 4px;
  cursor: pointer;
}

.modal-btn svg {
  margin-right: 0.5rem;
}

* {
  box-sizing: border-box;
}
</style>

