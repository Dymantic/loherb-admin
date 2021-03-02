<template>
    <div class="max-w-lg mx-auto my-12">
        <div class="flex items-center">
            <div class="mr-6">
                <label class="flex items-center">
                    <span>Chinese</span>
                    <input type="radio" :checked="value === 'zh'" value="zh" name="lh_lang_select" @input="$emit('input', 'zh')" class="hidden">
                    <div class="w-4 h-4 inline-block border border-b ml-1" :class="{'bg-black': value === 'zh'}"></div>
                </label>
            </div>
            <div class="">
                <label class="flex items-center">
                    <span>English</span>
                    <input type="radio" :checked="value === 'en'" value="en" name="lh_lang_select" @input="$emit('input', 'en')" class="hidden">
                    <div class="w-4 h-4 inline-block border border-b ml-1" :class="{'bg-black': value === 'en'}"></div>
                </label>
            </div>

        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['value']
    }
</script>
