<script setup>
import {Check, Close, AlarmClock, Phone, Edit, Printer, Cloudy, Delete, Calendar} from '@element-plus/icons-vue';
</script>

<template>
    <el-card class="box-card">
        <template #header>
            <div class="card-header">
                <span>Appuntamenti del giorno {{ moment(appuntamenti.data).format('D MMM Y') }}</span>
                <el-button type="primary" class="mr-3.5 float-right" >Bottone</el-button>
            </div>
        </template>
        <div v-if="appuntamenti.length>0" v-for="item in appuntamenti" :key="item" class="flex">

            <div class="h-10 w-1/12 p-2 m-2.5 border-gray-600 text-gray-500 border rounded-md text-sm text-center ">{{ item.doctor.name  }}</div>

            <div class="h-10 w-1/12 p-2 m-2.5 border-gray-600 text-gray-500 border rounded-md text-sm text-center ">{{ moment(item.data).format('D/M/Y')  }}</div>
            <div class="h-10 w-1/12 p-2 m-2.5 border-gray-600 text-gray-500 border rounded-md text-sm text-center ">{{ moment(item.ora).format('HH:mm')  }}</div>
            <div class="h-10 w-1/12 p-2 m-2.5 border-gray-600 text-gray-500 border rounded-md text-sm text-center ">{{ item.clinic.nome  }}</div>

            <div v-if="item.patient !== null" class="h-10 w-2/12 p-2 m-2.5 border-red-600 text-gray-500 border rounded-md text-sm ">{{ item.patient.name }}</div>
            <div v-if="item.patient === null" class="h-10 w-2/12 p-2 m-2.5 border-blue-600 text-gray-500 border rounded-md text-sm ">{{ item.denominazione }}</div>

            <div class="h-10 w-6/12 p-2 m-2.5 border-gray-600 text-gray-500 border rounded-md text-sm text-center "></div>

            <div class="h-10 w-1/12 p-2 m-2.5 border-gray-600 border rounded-md text-center">
                <el-icon class="m-1" color="green"><Edit /></el-icon>
                <el-icon v-if="item.patient_id === null" class="m-1" color="blue"><Phone /></el-icon>
                <el-icon v-else class="m-1" color="red"><Cloudy /></el-icon>
                <el-icon class="m-1" color="red"><Delete /></el-icon>
                <el-icon v-if="item.stato === 1" color="green"><Check /></el-icon>
                <el-icon v-if="item.stato === 2" color="yellow"><Close /></el-icon>
                <el-icon v-if="item.stato === 3" color="red"><AlarmClock /></el-icon>
            </div>

        </div>
        <div v-else class="text-red-400">Non ci sono appuntamenti per oggi {{ moment(appuntamenti.data).format('D MMM Y') }}</div>
    </el-card>
</template>

<script>
export default {
    name: "corpo lista",
    props: {
        ambulatori: Object,
        medici: Object,
        appuntamenti: Object
    },
    data() {
        return {
        }
    },
    methods:{
    }
}
</script>

<style scoped>
</style>
