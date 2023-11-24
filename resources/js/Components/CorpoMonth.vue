<script setup>
import {Check, Close, AlarmClock, Phone, Edit, Printer, Cloudy, Delete, Calendar} from '@element-plus/icons-vue';

</script>

<template>
<!--    <el-card class="box-card">-->
<!--        <template #header>-->
<!--            <div class="card-header">-->
<!--                <span>Appuntamenti del mese di {{ moment(appuntamenti.data).format('MMMM') }}</span>-->
<!--                <el-button type="primary" class="mr-3.5 float-right" >Bottone</el-button>-->
<!--            </div>-->
<!--        </template>-->
            <el-col :span="22" class="">
                <FullCalendar :options="calendarOptions" />
            </el-col>

            <div v-if="appuntamenti.length>0" class="flex"></div>
        <div v-else class="text-red-400">Non ci sono appuntamenti per oggi {{ moment(appuntamenti.data).format('D MMM Y') }}</div>

<!--    </el-card>-->
</template>

<script>
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction'
import itLocale from '@fullcalendar/core/locales/it';
export default {
    name: "corpo lista",
    props: {
        ambulatori: Object,
        medici: Object,
        appuntamenti: Object
    },
    components: {
        FullCalendar // make the <FullCalendar> tag available
    },
    data() {
        return {
            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin, timeGridPlugin, listPlugin],
                initialView: 'dayGridMonth',
                contentHeight: 680,
                contentWidth: 'auto',
                dateClick: this.handleDateClick,
                datesSet: this.handleMonthChange,
                scrollTimeReset: false,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                dayMaxEventRows: true,
                timeGrid: {
                    dayMaxEventRows: 1 // adjust to 6 only for timeGridWeek/timeGridDay
                },
                minTime: "08:00",
                maxTime: "18:00",
                eventColor: '#2c3e50',
                locale: itLocale,
                droppable: true,
                editable: true,
                events: [
                    {title: 'Paolo Rossi', date: '2023-11-24', start:'2023-11-24 12:00:00',end:'2023-11-24 12:15:00',  textColor: '#AAF'},
                    {title: 'Nome Cognome', date: '2023-11-23', start:'2023-11-23 12:00:00',end:'2023-11-23 12:15:00', textColor: '#FAA'}
                ]
            },
        }
    }
}
</script>

<style scoped>

</style>
