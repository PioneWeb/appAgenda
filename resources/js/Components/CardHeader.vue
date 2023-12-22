<template>
    <div class="flex flex-wrap items-center justify-between my-2">
        <div class="inline-flex items-center text-2xl h-16">
            <component :is="icon" class="w-8 h-8 mr-4" /> {{ title }}
        </div>

        <div v-if="!nascondiSearch" class="inline-flex items-center text-2xl h-16">
            <el-input v-model="search" size="small" @keyup="$emit('search',search)" :placeholder="$t('Type_to_search')" />
        </div>

        <div class="flex flex-wrap items-center justify-start gap-2">
            <ActionButton :item="tasto" v-for="tasto in tasti">
                <template #append></template>
                <template #default></template>
            </ActionButton>
        </div>
    </div>
</template>

<script setup>
import ActionButton from "./ActionButton.vue";
</script>

<script>

export default {
    name: "cardHeader",
    emits:["search"],
    props: {
        modelValue: String,
        title: String,
        icon: String,
        tasti: Array,
        nascondiSearch: {
          type: Boolean,
          default: false
        }
    },
    data() {
        return {
            search: this.modelValue
        }
    },
    watch: {
        modelValue(val) {
            this.search = val;
        }
    },
    mounted() {
        //console.log(this.tasti)
    }
}
</script>
