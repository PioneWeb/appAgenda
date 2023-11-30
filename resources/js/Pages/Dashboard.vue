<template>
    <AppLayout title="Dashboard">
        <div class="py-6 px-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">
                <card-header :title="$t('Dashboard')" :icon="Setting" nascondi-search>"></card-header>
                <Welcome />
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import {CirclePlus, DeleteFilled, Edit, Printer, Setting} from '@element-plus/icons-vue';
import CardHeader from "../Components/CardHeader.vue";
import {HomeIcon} from "@heroicons/vue/24/solid";
</script>

<script>
export default {
    name: "Dashboard",
    data() {
        return {
            cardHeader:{
                title: String,
            }
        }
    }
}
</script>
