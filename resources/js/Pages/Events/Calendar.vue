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
                <FullCalendar ref="calendario" class="hidden lg:flex h-[70vh]" :options="calendarOptions" />
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
import EventService from "eventservice";
export default {
    name: "corpo lista",
    emits:["paginate"],
    props: {
        ambulatori: Object,
        medici: Object,
        filter: Object,
        appuntamenti: Object
    },
    components: {
        FullCalendar // make the <FullCalendar> tag available
    },
    data() {
        return {
            appuntamenti: [],
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
                eventClick: this.handleEventClick,
                eventDrop: this.handleDrop,
                eventResize: this.handleDrag,
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
                eventClick: this.handleEventClick,
                eventDrop: this.handleDrop,
                eventResize: this.handleDrag,
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
        handleEventClick(clickInfo) {
            console.log(clickInfo)
            // let evento = this.calendarOptions.events.find(x => {
            //     return String(x.id) === String(clickInfo.event._def.publicId);
            // });
            // this.visible = true;
            // this.formEvento = {
            //     id: evento.id,
            //     title: evento.title,
            //     start: this.moment(evento.start).format("YYYY/MM/DD HH:mm"),
            //     nota: evento.nota.nota,
            //     color: evento.nota.color,
            //     end: this.moment(evento.end).format("YYYY/MM/DD HH:mm")
            // }
        },
        handleDrop(dropInfo) {
            let index = this.calendarOptions.events.map(x => {
                return parseInt(x.id);
            }).indexOf(parseInt(dropInfo.event._def.publicId));
            axios.post(route("events.update", {
                id: parseInt(dropInfo.event._def.publicId)
            }), {
                id: this.user_id,
                title: dropInfo.event._def.title,
                start: this.moment(this.calendarOptions.events[index].start)
                    .add(dropInfo.delta.milliseconds,"ms")
                    .add(dropInfo.delta.months, 'M')
                    .add(dropInfo.delta.years, 'y')
                    .add(dropInfo.delta.days, 'd').format("YYYY/MM/DD HH:mm"),
                end: this.moment(this.calendarOptions.events[index].end)
                    .add(dropInfo.delta.milliseconds,"ms")
                    .add(dropInfo.delta.months, 'M')
                    .add(dropInfo.delta.years, 'y')
                    .add(dropInfo.delta.days, 'd').format("YYYY/MM/DD HH:mm"),
                doctor_id: dropInfo.event._def.extendedProps.doctor_id,
                patient_id: dropInfo.event._def.extendedProps.patient_id,
                clinic_id: dropInfo.event._def.extendedProps.clinic_id
            }).then(result => {
                this.calendarOptions.events[index] = result.data;
                ElMessage({
                    type: 'success',
                    message: 'Evento modificato con successo',
                });
            })
        },
        handleDrag(info) {
            console.log(info)
            let index = this.calendarOptions.events.map(x => {
                return parseInt(x.id);
            }).indexOf(parseInt(info.event._def.publicId));
            axios.post(route("events.update", {
                id: parseInt(info.event._def.publicId)
            }), {
                id: this.user_id,
                title: info.event._def.title,
                start: this.moment(this.calendarOptions.events[index].start).format("YYYY/MM/DD HH:mm"),
                end: this.moment(this.calendarOptions.events[index].end)
                    .add(info.endDelta.milliseconds,"ms")
                    .add(info.endDelta.months, 'M')
                    .add(info.endDelta.years, 'y')
                    .add(info.endDelta.days, 'd').format("YYYY/MM/DD HH:mm"),
                doctor_id: info.event._def.extendedProps.doctor_id,
                patient_id: info.event._def.extendedProps.patient_id,
                clinic_id: info.event._def.extendedProps.clinic_id
            }).then(result => {
                this.calendarOptions.events[index] = result.data;
                ElMessage({
                    type: 'success',
                    message: 'Evento modificato con successo',
                });
            })
        },
        controllaMedico(val) {
            this.filter.medico = val;
            this.paginate();
        },
        controllaAmbulatorio(val) {
            this.filter.ambulatorio = val;
            this.paginate();
        },
        paginate() {
            axios.post(route("events.paginate"),{
                sort: this.sortingColumn,
                order: this.sortingOrder,
                filter: this.filter
            }).then( result => {
                this.appuntamenti = result.data;
            });
        },
    },
    created() {
        this.paginate();
    }
}
</script>

<style scoped>
.el-form-item {
    margin-bottom: 0px;
}
</style>

