<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CardHeader from "../../Components/CardHeader.vue";
import {CirclePlus, DeleteFilled, Edit, Printer, Setting, Delete} from '@element-plus/icons-vue';
</script>

<template>
    <AppLayout title="Lista Appuntamenti Giorno">
        <el-card class="box-card mt-2 mx-4">
            <el-form :model="form" :inline="true" class="demo-form-inline">
                <el-form-item label="Ambulatorio" >
                    <el-select v-model="ambulatorio" class="m-0" placeholder="Select">
                        <el-option
                            v-for="item in ambulatori"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item label="Medico">
                    <el-select v-model="medico" class="m-0" placeholder="Select">
                        <el-option
                            v-for="item in medici"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                        />
                    </el-select>
                </el-form-item>
            </el-form>
        </el-card>

        <div class="py-6 px-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">
                <card-header :title="$t('EventsDay')" :icon="Edit" :tasti="tasti" @search="this.searchTable"></card-header>

                <el-table :data="appuntamenti" stripe style="width: 100%"
                          @row-click="handleClick"
                          @selection-change="handleSelectionChange">
                    <el-table-column type="selection" />
                    <el-table-column label="ID" prop="id" width="80" sortable />
                    <el-table-column label="medico" prop="doctor.name" sortable />
                    <el-table-column label="paziente" prop="patient.name" sortable >
                        <template #default="scope">
                            <el-tag v-if="scope.row.patient !== null" size="small">{{scope.row.patient.name}}</el-tag>
                            <el-tag v-if="scope.row.patient === null" size="small" type="danger">Appuntamento telefonico</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column label="ambulatorio" prop="clinic.nome" sortable />
                    <el-table-column label="data" prop="data" sortable width="150" >
                        <template #default="scope">
                            {{ moment(scope.row.data).format('DD MMMM YYYY') }}
                        </template>
                    </el-table-column>
                    <el-table-column label="ora" prop="ora" sortable width="90" >
                        <template #default="scope">
                            {{ moment(scope.row.ora).format('HH:mm') }}
                        </template>
                    </el-table-column>

                </el-table>

                <el-pagination
                    class="mt-6"
                    v-model:currentPage="currentPage"
                    :page-sizes="pageSizes"
                    :page-size="pageSize"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="total"
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                >
                </el-pagination>

            </div>
        </div>

    </AppLayout>

</template>

<script>
import {ElMessage, ElMessageBox} from "element-plus";
import moment from "moment";

export default {
    name: "Appuntamenti",
    props: {
        appuntamenti: Object,
        ambulatoriProp: Object,
        mediciProp:Object
    },
    data() {
        return {
            appuntamenti: [],
            ambulatori: [],
            medici: [],
            tasti: [
                { id: 1, name: 'Nuovo', type: "info", icon:CirclePlus, click: this.create },
                { id: 2, name: 'Lista', type: "success", icon:Edit, click: this.lista },
                { id: 3, name: 'Giorno', type: "success", icon:Edit, click: this.giorno },
                { id: 4, name: 'Settimana', type: "success", icon:Edit, click: this.settimana },
                { id: 5, name: 'Mese', type: "primary", icon:Edit, click: this.mese },
                { id: 6, name: 'Stampa', type: "primary", icon:Printer }
            ],
            giorni:['Domenica','Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato'],
            tipi:['Rappresentante','Visita','Vaccino'],
            search: null,
            currentPage:1,
            pageSize: 12,
            sortingColumn: null,
            sortingOrder: null,
            pageSizes: [
                10,
                20,
                100
            ],
            total: 0
        }
    },
    methods:{
        searchTable(val){
            this.search = val;
            //this.paginate();
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
            this.$inertia.get(this.route('events.list',{
                data: moment().format('YYYY-MM-DD')
            }));
        },
        giorno() {
            this.filter = [{
                tp: 1,
                dt: moment().format('YYYY-MM-DD'),
                id: 2,
                cl: 1,
            }]
            this.paginate();
        },
        settimana() {
            this.filter = [{
                tp: 2,
                dt: moment().format('YYYY-MM-DD'),
                id: 2,
                cl: 1,
            }]
            this.paginate();
        },
        mese() {
            this.filter = [{
                tp: 3,
                dt: moment().format('YYYY-MM-DD'),
                id: 2,
                cl: 1,
            }]
            this.paginate();
        },
        getWeekStartEndDates(date) {
            // Ottieni il giorno della settimana della data specificata
            const dayOfWeek = moment(date).day();

            // Calcola la data di inizio settimana
            const weekStart = moment(date).subtract(dayOfWeek - 1, "days");

            // Calcola la data di fine settimana
            const weekEnd = moment(date).add(7 - dayOfWeek, "days");

            // Restituisci le date di inizio e fine settimana
            return [weekStart, weekEnd];
        },
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
            this.SessionStorage.setItem('appuntamenti_list_search', JSON.stringify(this.search));
            this.SessionStorage.setItem('appuntamenti_list_order', this.sortingOrder);
            this.SessionStorage.setItem('appuntamenti_list_column', this.sortingColumn);
            this.SessionStorage.setItem('appuntamenti_list_page', this.currentPage, true);
            this.SessionStorage.setItem('appuntamenti_list_page_size', this.pageSize, true);
            axios.post(route("events.paginate"),{
                pageSize: this.pageSize,
                page: this.currentPage,
                sort: this.sortingColumn,
                order: this.sortingOrder,
                search: this.search,
            }).then( result => {
                this.appuntamenti = result.data.data;
                this.total = result.data.total
            });
        },
        handleSizeChange(val) {
            this.pageSize = val;
            //this.paginate();
        },
        handleCurrentChange(val) {
            this.currentPage = val;
            //this.paginate();
        },
        handleSelectionChange(selectedRows) {
            const ids = selectedRows.map((row) => row.id);
            console.log('ID ',ids);
        },
    },
    mounted() {
        this.search = this.SessionStorage.getItem('appuntamenti_list_search', this.search,true);
        this.sortingOrder = this.SessionStorage.getItem('appuntamenti_list_order', this.sortingOrder,false);
        this.sortingColumn = this.SessionStorage.getItem('appuntamenti_list_column', this.sortingColumn,false);
        this.currentPage = this.SessionStorage.getItem('appuntamenti_list_page', this.currentPage, true);
        this.pageSize = this.SessionStorage.getItem('appuntamenti_list_page_size', this.pageSize, true);
        this.ambulatori = this.ambulatoriProp;
        this.medici = this.mediciProp;
    }
}
</script>

<style scoped>

</style>
