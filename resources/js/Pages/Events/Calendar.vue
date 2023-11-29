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

        <el-dialog v-model="visible" :width="650" :title="!formEvento.id ? 'Aggiungi evento' : 'Modifica evento'">
            <el-form ref="form" label-position="top" :rules="rules" :model="formEvento">
                <el-row :gutter="10">
                    <el-col>
                        <el-form-item prop="title" label="Nome">
                            <el-input v-model="formEvento.title"></el-input>
                            <el-input type="hidden" v-model="formEvento.id"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item prop="start" label="Inizio">
                            <el-date-picker
                                class="w-full"
                                v-model="formEvento.start"
                                type="datetime"
                                format="DD/MM/YYYY HH:mm"
                                value-format="YYYY/MM/DD HH:mm"
                                :default-value="data"
                            />
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item prop="end" label="Fine">
                            <el-date-picker
                                class="w-full"
                                v-model="formEvento.end"
                                type="datetime"
                                format="DD/MM/YYYY HH:mm"
                                value-format="YYYY/MM/DD HH:mm"
                                :default-value="data"
                            />
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item prop="doctor_id" label="Medico">
                            <el-select v-model="formEvento.doctor_id" class="w-full" placeholder="" clearable filterable>
                                <el-option v-for="item in medici" :label="item.label" :key="item.value" :value="item.value"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item prop="clinic_id" label="Ambulatorio">
                            <el-select v-model="formEvento.clinic_id" class="w-full" placeholder="" clearable filterable>
                                <el-option v-for="item in ambulatori" :label="item.label" :key="item.value" :value="item.value"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item prop="patient_id" label="Paziente">
                            <el-select v-model="formEvento.patient_id" class="w-full" placeholder="" clearable filterable>
                                <el-option v-for="item in pazienti" :label="item.label" :key="item.value" :value="item.value"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>
            <el-divider></el-divider>
            <div class="inline-flex items-center justify-between w-full">
                <el-button v-if="formEvento.id" type="danger" @click="eliminaEvento()" plain>elimina</el-button>
                <el-button type="primary" @click="visible = false" plain>Annulla</el-button>
                <el-button type="success" @click="aggiungiEvento()" plain>{{ !formEvento.id ? 'Aggiungi' : 'Modifica' }}</el-button>
            </div>

        </el-dialog>
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
        pazienti: Object,
        filter: Object,
        appuntamenti: Object,
        orari: Object,
    },
    components: {
        FullCalendar
    },
    data() {
        return {
            formEvento: {
                title: null,
                start: null,
                nota: null,
                end: null,
                color: null,
                doctor_id: null,
                clinic_id: null,
                patient_id: null
            },
            visible: false,
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
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                dayMaxEventRows: true,
                slotMinTime: "09:00:00",
                slotMaxTime: "12:00:00",
                slotDuration: {
                    minute: 20
                },
                eventColor: '#076c7d',
                locale: itLocale,
                droppable: true,
                editable: true,
                theme: 'Slate'
            },
            mobileCalendar: {
                plugins: [listPlugin],
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
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                dayMaxEventRows: true,
                timeGrid: {
                    dayMaxEventRows: 1
                },
                slotMinTime: "08:00:00",
                slotMaxTime: "20:00:00",
                eventColor: '#2c3e50',
                locale: itLocale,
                droppable: true,
                editable: true,
            }
        }
    },
    methods: {
        handleDateClick(arg){
            this.visible = true;
            this.data = arg.dateStr;
            this.formEvento = {
                title: 'Nuovo appuntamento',
                start: this.data,
                end: this.moment(this.data).add('1','hour').format('YYYY-MM-DD HH:mm'),
                doctor_id: this.filter.medico[0],
                clinic_id: this.filter.ambulatorio[0],
                patient_id: null
            }
        },
        handleMonthChange(payload){
            this.filter.start = payload.startStr
            this.filter.end = payload.endStr
            this.paginate()
        },
        handleEventClick(clickInfo) {
            this.visible = true;
            let evento = this.calendarOptions.events.find(x => {
                return String(x.id) === String(clickInfo.event._def.publicId);
            });
            this.visible = true;
            this.formEvento = {
                id: evento.id,
                title: evento.title,
                start: this.moment(evento.start).format("YYYY/MM/DD HH:mm"),
                end: this.moment(evento.end).format("YYYY/MM/DD HH:mm"),
                doctor_id: clickInfo.event._def.extendedProps.doctor_id,
                clinic_id: clickInfo.event._def.extendedProps.clinic_id,
                patient_id: clickInfo.event._def.extendedProps.patient_id
            }
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
        aggiungiEvento(){
            let index = this.calendarOptions.events.map(x => {
                return parseInt(x.id);
            }).indexOf(this.formEvento.id);
            this.visible = false;
            axios.post(route("events.update", {
                id: parseInt(this.formEvento.id)
            }), {
                id: this.formEvento.id,
                title: this.formEvento.title,
                start: this.moment(this.formEvento.start).format("YYYY/MM/DD HH:mm"),
                end: this.moment(this.formEvento.end).format("YYYY/MM/DD HH:mm"),
                doctor_id: this.formEvento.doctor_id,
                patient_id: this.formEvento.patient_id,
                clinic_id: this.formEvento.clinic_id
            }).then(result => {
                this.calendarOptions.events[index] = result.data;
                ElMessage({
                    type: 'success',
                    message: 'Evento modificato con successo',
                });
            });
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
                this.calendarOptions.events = result.data
                this.mobileCalendar.events = result.data
            });
        },
    },
    created() {
        // this.filter.start = this.moment().format("YYYY/MM/DD HH:mm")
        // this.filter.end = this.moment().format("YYYY/MM/DD HH:mm")
        // this.paginate();
    }
}
</script>

<style>
.fc-theme-standard .fc-list-day-cushion {
    background-color: hsla(202.8, 74.7%, 18.6%, 0.83);
}
.fc-theme-standard:hover .fc-list-day-cushion:hover {
    background-color: hsla(129.8, 73.5%, 16.3%, 0.83);
}
.fc .fc-list-event:hover td {
    background-color: hsla(129.8, 73.5%, 16.3%, 0.83);
}
.fc-direction-ltr .fc-list-day-text, .fc-direction-rtl .fc-list-day-side-text {
    float: left;
    color: #FFF;
}
.el-form-item {
    margin-bottom: 0px;
}
.fc .fc-popover-header {
    align-items: center;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    padding: 3px 4px;
    color: #1a202c;
}
.fc-theme-standard .fc-popover {
    background-color: #51698c;
    border: 1px solid #000;
}
.el-select__tags .el-tag--info {
    background-color: rgba(134, 38, 0, 0.98);
}
</style>

