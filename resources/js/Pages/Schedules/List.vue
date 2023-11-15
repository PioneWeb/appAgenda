<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CardHeader from "../../Components/CardHeader.vue";
import {CirclePlus, DeleteFilled, Edit, Printer, Setting, Delete} from '@element-plus/icons-vue';
</script>

<template>
    <AppLayout title="Lista Ambulatori">

        <div class="py-6 px-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">
                <card-header :title="$t('Schedules')" :icon="Edit" :tasti="tasti" @search="this.searchTable"></card-header>

                <el-table :data="orari" stripe style="width: 100%"
                          @row-click="handleClick"
                          @selection-change="handleSelectionChange">
                    <el-table-column type="selection" />
                    <el-table-column label="ID" prop="id" width="80" sortable />
                    <el-table-column label="medico" prop="doctor.name" sortable />
                    <el-table-column label="ambulatorio" prop="clinic.nome" sortable />
                    <el-table-column label="tipo" prop="tipo" sortable  width="90">
                        <template #default="scope">
                            {{ this.tipi[scope.row.tipo] }}
                        </template>
                    </el-table-column>
                    <el-table-column label="giorno" prop="giorno" sortable width="120">
                        <template #default="scope">
                            {{ this.giorni[scope.row.giorno] }}
                        </template>
                    </el-table-column>
                    <el-table-column label="Visite" prop="quantita" sortable width="90" />
                    <el-table-column label="minuti" prop="minuti" sortable width="90" />
                    <el-table-column label="inizio" prop="inizio" sortable width="120" />
                    <el-table-column label="stato" prop="attivo" sortable  width="90">
                        <template #default="scope">
                            <el-tag v-if="scope.row.attivo === 1" size="small" type="success">Attivo</el-tag>
                            <el-tag v-else size="small" type="danger">Non attivo</el-tag>
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
    name: "Utenti",
    props: {
        orari: Object,
    },
    data() {
        return {
            orari: [],
            tasti: [
                { id: 1, name: 'Nuovo', type: "info", icon:CirclePlus, click: this.create },
                { id: 2, name: 'Prescrivi', type: "success", icon:Edit, click: this.prescrivi },
                { id: 3, name: 'Stampa', type: "primary", icon:Printer },
                { id: 4, name: 'Elimina', type: "danger", icon:DeleteFilled }
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
            this.paginate();
        },
        create() {
            this.$inertia.get(this.route('schedules.create'));
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
        handleClick(row,column,event){
            let col = column.property;

            switch (col) {
                case 'accorpa':
                    break;
                default:
                    this.$inertia.get(this.route('schedules.edit',{
                        id:row.id
                    }));
            }
        },
        paginate() {
            this.tableLoading = true;
            this.SessionStorage.setItem('ricette_list_search', JSON.stringify(this.search));
            this.SessionStorage.setItem('ricette_list_order', this.sortingOrder);
            this.SessionStorage.setItem('ricette_list_column', this.sortingColumn);
            this.SessionStorage.setItem('ricette_list_page', this.currentPage, true);
            this.SessionStorage.setItem('ricette_list_page_size', this.pageSize, true);
            axios.post(route("schedules.paginate"),{
                pageSize: this.pageSize,
                page: this.currentPage,
                sort: this.sortingColumn,
                order: this.sortingOrder,
                search: this.search,
            }).then( result => {
                this.orari = result.data.data;
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
            console.log('ID ',ids);
        },
    },
    mounted() {
        this.search = this.SessionStorage.getItem('ricette_list_search', this.search,true);
        this.sortingOrder = this.SessionStorage.getItem('ricette_list_order', this.sortingOrder,false);
        this.sortingColumn = this.SessionStorage.getItem('ricette_list_column', this.sortingColumn,false);
        this.currentPage = this.SessionStorage.getItem('ricette_list_page', this.currentPage, true);
        this.pageSize = this.SessionStorage.getItem('ricette_list_page_size', this.pageSize, true);
        this.paginate();
    }
}
</script>

<style scoped>

</style>
