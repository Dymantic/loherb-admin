<template>
    <button type="button" @click="$emit('clicked')" class="relative" :class="{'opacity-75': busy}">
        <span :class="{'opacity-0': busy}">{{ buttonText }}</span>
        <span v-if="busy" class="waiting-state flex items-center justify-center pin absolute z-40">
            <div></div>
            <div></div>
            <div></div>
        </span>
    </button>
</template>

<script type="text/babel">
    export default {
        props: ['busy', 'button-text']
    }
</script>

<style scoped lang="scss" type="text/scss">
    .waiting-state {
        & > div {
            width: .5rem;
            height: .5rem;
            margin: 0 .25rem;
            background: currentColor;
            border-radius: 50%;
            animation-name: fadeInOut;
            animation-duration: .5s;
            animation-fill-mode: both;
            animation-iteration-count: infinite;
            animation-timing-function: ease-in-out;
            animation-direction: alternate;
        }

        & > div:nth-child(1) {
            animation-delay: 0s;
        }

        & > div:nth-child(2) {
            animation-delay: .125s;
        }

        & > div:nth-child(3) {
            animation-delay: .35s;
        }
    }

    @keyframes fadeInOut {
        from {opacity: 0}
        to {opacity: 1}
    }
</style>