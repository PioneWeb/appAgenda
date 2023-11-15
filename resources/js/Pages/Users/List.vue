<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CardHeader from "../../Components/CardHeader.vue";
import {CirclePlus, DeleteFilled, Edit, Printer, Setting, Delete} from '@element-plus/icons-vue';
// import {HomeIcon} from "@heroicons/vue/24/solid";
</script>

<template>
    <AppLayout title="Lista Aziende">
        <div class="py-6 px-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">
                <card-header :title="$t('Users')" :icon="Edit" :tasti="tasti" @search="this.searchTable"></card-header>
                <el-table :data="utenti" stripe style="width: 100%" @row-click="handleClick" @selection-change="handleSelectionChange">
                    <el-table-column type="selection" />
                    <el-table-column label="ID" prop="id" width="80" sortable />
                    <el-table-column label="medico" prop="doctor_id" sortable >
                        <template #default="scope">
                            {{ scope.row.medico?.name }}
                        </template>
                    </el-table-column>
                    <el-table-column label="nome" prop="name" sortable />
                    <el-table-column label="indirizzo" prop="indirizzo" sortable />
                    <el-table-column label="email" prop="email" sortable />
                    <el-table-column label="verificata" prop="email_verified_at" sortable  width="120">
                        <template #default="scope">
                            <div v-if="scope.row.email_verified_at===null"></div>
                            <div v-else>{{ moment(scope.row.email_verified_at).format('DD/MM/YYYY') }}</div>
                        </template>
                    </el-table-column>
                    <el-table-column label="cap" prop="cap" sortable width="80" />
                    <el-table-column label="provincia" prop="provincia" sortable width="120" />
                    <el-table-column label="tipo utente" prop="user_type.descrizione" sortable  width="120">
                        <template #default="scope">
                            <el-tag v-if="scope.row.user_type.id === 1" size="small" type="danger">{{scope.row.user_type.descrizione}}</el-tag>
                            <el-tag v-if="scope.row.user_type.id === 2" size="small">{{scope.row.user_type.descrizione}}</el-tag>
                            <el-tag v-if="scope.row.user_type.id === 4" size="small" type="success">{{scope.row.user_type.descrizione}}</el-tag>
                            <el-tag v-if="scope.row.user_type.id === 3" size="small" type="warning">{{scope.row.user_type.descrizione}}</el-tag>
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
import {ElMessage} from "element-plus";

export default {
    name: "Utenti",
    props: {
        utenti: Object,
    },
    data() {
        return {
            utenti: [],
            tasti: [
                { id: 1, name: 'Nuovo FK', type: "info", icon:CirclePlus, click: this.creaUtente },
                { id: 1, name: 'Nuovo', type: "info", icon:CirclePlus, click: this.create },
                { id: 2, name: 'Salva', type: "success", icon:Edit },
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
        creaUtente(){
            axios.get(this.route('utenti.genera')).then(result => {
                ElMessage({message: 'Creata nuova azienda.',type: 'success'});
                this.$inertia.get(route("users.list"));
            });
        },
        create() {
            this.$inertia.get(this.route('utenti.create'));
        },
        handleClick(row,column,event){
            let col = column.property;
            switch (col) {
                case 'accorpa':
                    break;
                default:
                    this.$inertia.get(this.route('users.edit',{
                        id:row.id
                    }));
            }
        },
        paginate() {
            this.tableLoading = true;
            this.SessionStorage.setItem('utenti_list_search', JSON.stringify(this.search));
            this.SessionStorage.setItem('utenti_list_order', this.sortingOrder);
            this.SessionStorage.setItem('utenti_list_column', this.sortingColumn);
            this.SessionStorage.setItem('utenti_list_page', this.currentPage, true);
            this.SessionStorage.setItem('utenti_list_page_size', this.pageSize, true);
            axios.post(route("users.paginate"),{
                pageSize: this.pageSize,
                page: this.currentPage,
                sort: this.sortingColumn,
                order: this.sortingOrder,
                search: this.search,
            }).then( result => {
                this.utenti = result.data.data;
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
        this.search = this.SessionStorage.getItem('utenti_list_search', this.search,true);
        this.sortingOrder = this.SessionStorage.getItem('utenti_list_order', this.sortingOrder,false);
        this.sortingColumn = this.SessionStorage.getItem('utenti_list_column', this.sortingColumn,false);
        this.currentPage = this.SessionStorage.getItem('utenti_list_page', this.currentPage, true);
        this.pageSize = this.SessionStorage.getItem('utenti_list_page_size', this.pageSize, true);
        this.paginate();
    }
}
</script>
<style scoped>

</style>
