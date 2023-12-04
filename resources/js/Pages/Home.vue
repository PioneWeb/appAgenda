<template>
    <AppLayout title="Home">
        <div class="py-6 px-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">
                <card-header :title="$t('Home')" :icon="HomeIcon" :tasti="tasti" nascondi-search></card-header>
                <el-row :gutter="16">
                    <el-col :span="4">
                        <InfoCard :title="$t('Companies')" icon="Warning" linkIcon="ArrowRight" :value="companies" link="companies.list" subTitle="Lista Aziende"/>
                    </el-col>
                    <el-col :span="4">
                        <InfoCard :title="$t('Users')" icon="Warning" linkIcon="ArrowRight" :value="users" link="users.list" subTitle="Lista Utenti"/>
                    </el-col>
                    <el-col :span="4">
                        <InfoCard :title="$t('Clinics')" icon="CaretTop" linkIcon="ArrowRight" :value="ambulatori" link="clinics.list" subTitle="Lista Ambulatori"/>
                    </el-col>
                    <el-col :span="4">
                        <InfoCard :title="$t('Schedules')" icon="CaretTop" linkIcon="ArrowRight" :value="orari" link="schedules.list" subTitle="Lista Orari"/>
                    </el-col>
                    <el-col :span="4">
                        <InfoCard :title="$t('Prescriptions')" icon="CaretTop" linkIcon="ArrowRight" :value="ricette" link="prescriptions.list" subTitle="Lista Ricette"/>
                    </el-col>
                    <el-col :span="4">
                        <InfoCard :title="$t('Events')" icon="CaretTop" linkIcon="ArrowRight" :value="appuntamenti" link="events.calendar" subTitle="Lista Eventi"/>
                    </el-col>
                </el-row>

            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { HomeIcon } from '@heroicons/vue/24/solid';
import CardHeader from "../Components/CardHeader.vue";
import InfoCard from "../Components/InfoCard.vue";
</script>

<script>
export default {
    name: "Home",
    props: {
        companies: Object,
        users: Object,
        ambulatori: Object,
        orari: Object,
        ricette: Object,
        appuntamenti: Object,
    },
    data() {
        return {
            //percentage: 100*this.ticketClosed/this.tickets,
            percentage2: 0,
            percentage3: 0,
            //azService: this.aziendeService.length,
            colors: [
                { color: '#f56c6c', percentage: 20 },
                { color: '#e6a23c', percentage: 40 },
                { color: '#5cb87a', percentage: 60 },
                { color: '#1989fa', percentage: 80 },
                { color: '#6f7ad3', percentage: 100 },
            ],
            // tasti: [
            //     { id: 4, name: 'Default', type: "default", icon:DeleteFilled, click: this.prova },
            //     { id: 3, name: 'Stampa', type: "primary", icon:Printer, click:"prova()" },
            //     { id: 2, name: 'Salva', type: "success", icon:Edit, click:"prova()" },
            //     { id: 1, name: 'Nuovo', type: "info", icon:CirclePlus, click:"prova()" },
            //     { id: 3, name: 'Warning', type: "warning", icon:Printer, click:"prova()" },
            //     { id: 4, name: 'Elimina', type: "danger", icon:DeleteFilled, click:"prova()" },
            // ]
        }
    },
    methods: {
        prova() {
            alert('ciao')
        },
        increase() {
            this.percentage += 10
            if (this.percentage > 100) {
                this.percentage = 100
            }
        },
        decrease() {
            this.percentage -= 10
            if (this.percentage < 0) {
                this.percentage = 0
            }
        }
    },
    mounted() {
        setInterval(() => {
            this.percentage2 = (this.percentage2 % 100) + 1
        }, 150)
        setInterval(() => {
            this.percentage3 = (this.percentage3 % 100) + 10
        }, 1000)
    }
}
</script>

<style scoped>
.demo-progress .el-progress--line {
    margin-bottom: 15px;
    width: 350px;
}
.demo-progress .el-progress--circle {
    margin-right: 15px;
}
</style>
