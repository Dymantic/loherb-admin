<template>
    <div>
        <trix-vue image-upload-path="/test-images" save-path="/test-save" v-model="html"></trix-vue>
    </div>
</template>

<script type="text/babel">
    export default {
        data() {
            return {
                html: '<p>Hello sexy, you kitten you</p>'
            };
        }
    }
</script>

<style scoped lang="scss" type="text/scss">

</style>