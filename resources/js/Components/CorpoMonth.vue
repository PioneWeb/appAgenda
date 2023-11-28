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
import multiMonthPlugin from '@fullcalendar/multimonth'
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
                plugins: [dayGridPlugin, interactionPlugin, timeGridPlugin, listPlugin/*, multiMonthPlugin*/],
                initialView: 'dayGridMonth',
                contentHeight: 680,
                contentWidth: 'auto',
                dateClick: this.handleDateClick,
                datesSet: this.handleMonthChange,
                scrollTimeReset: false,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek' /*,multiMonth*/
                },
                dayMaxEventRows: true,
                timeGrid: {
                    dayMaxEventRows: 1 // adjust to 6 only for timeGridWeek/timeGridDay
                },
                slotMinTime: "08:00:00",
                slotMaxTime: "18:00:00",
                eventColor: '#2c3e50',
                locale: itLocale,
                droppable: true,
                editable: true,
                events: this.appuntamenti
            },
        }
    }
}
</script>

<style scoped>

</style>
