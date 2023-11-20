<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CardHeader from "../../Components/CardHeader.vue";
import {CirclePlus, DeleteFilled, Edit, Printer, Setting, Delete} from '@element-plus/icons-vue';
</script>

<template>
    <AppLayout title="Lista Appuntamenti Mese">

        <div class="py-6 px-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">
                <card-header :title="$t('EventsMonth')" :icon="Edit" :tasti="tasti" @search="this.searchTable"></card-header>

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

export default {
    name: "Appuntamenti Mese",
    props: {
        appuntamentiProp: Object,
    },
    data() {
        return {
            appuntamenti: [],
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
            // ElMessageBox.confirm(
            //     "Attenzione stai per fare ",
            //     'Attenzione',
            //     {
            //         confirmButtonText: 'OK',
            //         cancelButtonText: 'Annulla',
            //         type: 'warning',
            //     }
            // )
            this.$inertia.get(this.route('events.list',{
                tp:1
            }));
        },
        giorno() {
            this.$inertia.get(this.route('events.day',{
                tp:2
            }));
        },
        settimana() {
            this.$inertia.get(this.route('events.week',{
                tp:3
            }));
        },
        mese() {
            this.$inertia.get(this.route('events.month',{
            id: 2,
            ms: 11,
            cl: 2
        }));
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
        //this.paginate();
        this.appuntamenti = this.appuntamentiProp;
    }
}
</script>

<style scoped>

</style>
