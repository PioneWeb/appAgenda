<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CardHeader from "../../Components/CardHeader.vue";
import {CirclePlus, DeleteFilled, Edit, Printer, Setting, Delete} from '@element-plus/icons-vue';
// import {HomeIcon} from "@heroicons/vue/24/solid";
</script>

<template>
    <AppLayout title="Lista Ambulatori">

        <div class="py-6 px-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">
                <card-header :title="$t('Prescriptions')" :icon="Edit" :tasti="tasti" @search="this.searchTable"></card-header>

                <el-table :data="ricette" stripe style="width: 100%" @row-click="handleClick" @selection-change="handleSelectionChange">
                    <el-table-column type="selection" />
                    <el-table-column label="ID" prop="id" width="80" sortable />
                    <el-table-column label="medico" prop="doctor.name" sortable />
                    <el-table-column label="paziente" prop="patient.name" sortable />
                    <el-table-column label="farmaci" prop="farmaci" sortable  />
                    <el-table-column label="motivo" prop="motivo" sortable />
                    <el-table-column label="tipo" prop="tipo" sortable width="120" >
                        <template #default="scope">
                            <el-tag v-if="scope.row.tipo === 1" effect="dark" size="small">Farmaci</el-tag>
                            <el-tag v-if="scope.row.tipo === 2" effect="dark" size="small" type="warning">Analisi</el-tag>
                            <el-tag v-if="scope.row.tipo === 3" effect="dark" size="small" type="info">Visite</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column label="stato" prop="attiva" sortable  width="180">
                        <template #default="scope">
                            <el-tag v-if="scope.row.attiva === true" size="small" type="success">Richiesto {{ moment(scope.row.created_at).format('DD MMMM YYYY') }}</el-tag>
                            <el-tag v-if="scope.row.attiva === false" size="small" type="danger">Prescritto {{ moment(scope.row.updated_at).format('DD MMMM YYYY') }}</el-tag>
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
        ricette: Object,
    },
    data() {
        return {
            ricette: [],
            tasti: [
                { id: 1, name: 'Nuovo', type: "info", icon:CirclePlus, click: this.create },
                { id: 2, name: 'Prescrivi', type: "success", icon:Edit, click: this.prescrivi },
                { id: 3, name: 'Stampa', type: "primary", icon:Printer },
                { id: 4, name: 'Elimina', type: "danger", icon:DeleteFilled }
            ],
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
            this.$inertia.get(this.route('prescriptions.create'));
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
                    this.$inertia.get(this.route('prescriptions.edit',{
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
            axios.post(route("prescriptions.paginate"),{
                pageSize: this.pageSize,
                page: this.currentPage,
                sort: this.sortingColumn,
                order: this.sortingOrder,
                search: this.search,
            }).then( result => {
                this.ricette = result.data.data;
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
        console.log('BBB ',this.selectedRows)
    }
}
</script>

<style scoped>

</style>
