<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CardHeader from "../../Components/CardHeader.vue";
import {CirclePlus, DeleteFilled, Edit, Printer, Setting, Delete, Calendar} from '@element-plus/icons-vue';
import TestataAppuntamenti from "../../Components/TestataAppuntamenti.vue";
import CorpoLista from "../../Components/CorpoLista.vue";
import CorpoDay from "../../Components/CorpoDay.vue";
import CorpoWeek from "../../Components/CorpoWeek.vue";
import CorpoMonth from "../../Components/CorpoMonth.vue";

</script>

<template>
    <AppLayout title="Lista Appuntamenti">

        <testata-appuntamenti :medici="medici" :ambulatori="ambulatori" :filter="filter" @cambiaMedico="this.controllaMedico" @cambiaAmbulatorio="this.controllaAmbulatorio" @cambiaData="this.controllaData"></testata-appuntamenti>

        <div class="p-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">
                <card-header :title="$t('Events')" :icon="Edit" :tasti="tasti" @search="this.searchTable"></card-header>

                <CorpoLista v-if="filter.tp === 0" :appuntamenti="appuntamenti" :medici="medici" :ambulatori="ambulatori" :total="total"></CorpoLista>
                <CorpoDay v-if="filter.tp === 1" :appuntamenti="appuntamenti" :medici="medici" :ambulatori="ambulatori"></CorpoDay>
                <CorpoWeek v-if="filter.tp === 2" :appuntamenti="appuntamenti" :medici="medici" :ambulatori="ambulatori"></CorpoWeek>
                <CorpoMonth v-if="filter.tp === 3" :appuntamenti="appuntamenti" :medici="medici" :ambulatori="ambulatori"></CorpoMonth>

            </div>
        </div>

    </AppLayout>

</template>

<script>
import {ElMessage, ElMessageBox} from "element-plus";
import moment from "moment/moment";

export default {
    name: "Appuntamenti",
    props: {
        ambulatori: Object,
        medici: Object
    },
    data() {
        return {
            filter: {
                tp: 0,
                medico: null,
                ambulatorio: null,
                data: moment().format('YYYY-MM-DD'),
                search: null
            },
            appuntamenti: [],
            options: [
                {
                    value: 'Option1',
                    label: 'Option1',
                },
                {
                    value: 'Option2',
                    label: 'Option2',
                },
                {
                    value: 'Option3',
                    label: 'Option3',
                },
                {
                    value: 'Option4',
                    label: 'Option4',
                },
                {
                    value: 'Option5',
                    label: 'Option5',
                },
            ],
            tasti: [
                { id: 1, name: 'Nuovo', type: "info", icon:CirclePlus, click: this.create },
                { id: 2, name: 'Lista', type: "success", icon:Calendar, click: this.lista },
                { id: 3, name: 'Giorno', type: "success", icon:Calendar, click: this.giorno },
                { id: 4, name: 'Settimana', type: "success", icon:Calendar, click: this.settimana },
                { id: 5, name: 'Mese', type: "primary", icon:Calendar, click: this.mese },
                { id: 6, name: 'Stampa', type: "primary", icon:Printer }
            ],
            giorni:['Domenica','Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato'],
            tipi:['Rappresentante','Visita','Vaccino'],
            currentPage:1,
            pageSize: 12,
            sortingColumn: null,
            sortingOrder: null,
            pageSizes: [
                10,
                20,
                100
            ],
            total: null
        }
    },
    methods:{
        controllaMedico(val){
            this.filter.medico = val;
            this.paginate();
        },
        controllaAmbulatorio(val){
            this.filter.ambulatorio = val;
            this.paginate();
        },
        controllaData(val){
            console.log('DATA ',val)
            val === null ? this.filter.data = null : this.filter.data = moment(val).format('YYYY-MM-DD');
            this.paginate();
            console.log('DATAX ',this.filter.data)
        },
        searchTable(val){
            this.filter.search = val;
            this.paginate();
        },
        create() {
            this.$inertia.get(this.route('events.create'));
        },
        prescrivi() {
            ElMessageBox.confirm(
                "Attenzione stai per fare ",
                'Attenzione',
                {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Annulla',
                    type: 'warning',
                }
            )
        },
        lista() {
            this.filter.tp = 0;
            this.paginate();
        },
        giorno() {
            this.filter.tp = 1;
            this.paginate();
        },
        settimana() {
            this.filter.tp = 2;
            this.paginate();
        },
        mese() {
            this.filter.tp = 3;
            this.paginate();
        },
        // getWeekStartEndDates(date) {
        //     // Ottieni il giorno della settimana della data specificata
        //     const dayOfWeek = moment(date).day();
        //     // Calcola la data di inizio settimana
        //     const weekStart = moment(date).subtract(dayOfWeek - 1, "days");
        //     // Calcola la data di fine settimana
        //     const weekEnd = moment(date).add(7 - dayOfWeek, "days");
        //     // Restituisci le date di inizio e fine settimana
        //     return [weekStart, weekEnd];
        // },
        handleClick(row,column,event){
            let col = column.property;

            switch (col) {
                case 'accorpa':
                    break;
                default:
                    this.$inertia.get(this.route('events.edit',{
                        id:row.id
                    }));
            }
        },
        paginate() {
            this.tableLoading = true;
            this.SessionStorage.setItem('appuntamenti_list_filter', this.filter,true);
            this.SessionStorage.setItem('appuntamenti_list_order', this.sortingOrder);
            this.SessionStorage.setItem('appuntamenti_list_column', this.sortingColumn);
            this.SessionStorage.setItem('appuntamenti_list_page', this.currentPage);
            this.SessionStorage.setItem('appuntamenti_list_page_size', this.pageSize);
            axios.post(route("events.paginate"),{
                pageSize: this.pageSize,
                page: this.currentPage,
                sort: this.sortingColumn,
                order: this.sortingOrder,
                filter: this.filter
            }).then( result => {
                console.log(result)
                this.appuntamenti = result.data.data;
                this.total = result.data.total
            });
        },
        handleSizeChange(val) {
            this.pageSize = val;
            this.paginate();
        },
        handleCurrentChange(val) {
            this.currentPage = val;
            this.paginate();
        },
        handleSelectionChange(selectedRows) {
            const ids = selectedRows.map((row) => row.id);
        },
    },
    mounted() {
        this.filter = this.SessionStorage.getItem('appuntamenti_list_filter', this.filter,true);
        this.sortingOrder = this.SessionStorage.getItem('appuntamenti_list_order', this.sortingOrder,false);
        this.sortingColumn = this.SessionStorage.getItem('appuntamenti_list_column', this.sortingColumn,false);
        this.currentPage = this.SessionStorage.getItem('appuntamenti_list_page', this.currentPage, false);
        this.pageSize = this.SessionStorage.getItem('appuntamenti_list_page_size', this.pageSize, false);
        this.paginate();
    }
}
</script>

<style scoped>
.el-form-item {
    margin-bottom: 0px;
}
</style>
