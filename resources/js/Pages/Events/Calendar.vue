<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CardHeader from "../../Components/CardHeader.vue";
import {
    Edit,
    Printer,
} from '@element-plus/icons-vue';
import TestataAppuntamenti from "../../Components/TestataAppuntamenti.vue";

</script>

<template>
    <AppLayout title="Lista Appuntamenti">

        <testata-appuntamenti :medici="medici" :ambulatori="ambulatori" :filter="filter" @cambiaMedico="this.controllaMedico" @cambiaAmbulatorio="this.controllaAmbulatorio"></testata-appuntamenti>

        <div class="p-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">
                <card-header :title="$t('Events')" :icon="Edit" :tasti="tasti" @search="this.searchTable" nascondi-search></card-header>
                <FullCalendar class="hidden lg:flex h-[70vh]" :options="calendarOptions" />
                <FullCalendar class="flex lg:hidden h-[70vh]" :options="mobileCalendar" />
            </div>
        </div>
    </AppLayout>
</template>


<script>
import {ElMessage, ElMessageBox} from "element-plus";
import moment from "moment/moment";
import {Calendar, CirclePlus, Printer} from "@element-plus/icons-vue";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction'
import itLocale from '@fullcalendar/core/locales/it';
import multiMonthPlugin from '@fullcalendar/multimonth'
export default {
    name: "corpo lista",
    emits:["paginate"],
    props: {
        ambulatori: Object,
        medici: Object,
        appuntamenti: Object,
        filter: Object
    },
    components: {
        FullCalendar // make the <FullCalendar> tag available
    },
    data() {
        return {
            filter: {
                tp: 0,
                medico: null,
                ambulatorio: null,
                start:null,
                end:null,
                search: null
            },
            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin, timeGridPlugin, listPlugin/*, multiMonthPlugin*/],
                initialView: 'listWeek',
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
                events: this.appuntamenti,
                theme: 'Slate'
            },
            mobileCalendar: {
                plugins: [listPlugin/*, multiMonthPlugin*/],
                initialView: 'list',
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
            }
        }
    },
    methods: {
        handleDateClick(arg){

        },
        handleMonthChange(payload){
            this.filter.start = payload.startStr
            this.filter.end = payload.endStr
            this.paginate()
        },
        controllaMedico(val) {
            this.filter.medico = val;
        },
        controllaAmbulatorio(val) {
            this.filter.ambulatorio = val;
        },
        paginate() {
            axios.post(route("events.paginate"),{
                sort: this.sortingColumn,
                order: this.sortingOrder,
                filter: this.filter
            }).then( result => {
                console.log(result.data.data)
                this.appuntamenti = result.data.data;
            });
        },
    }
}
</script>

<style scoped>
.el-form-item {
    margin-bottom: 0px;
}
</style>

