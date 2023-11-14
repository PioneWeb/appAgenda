<template>
    <AppLayout title="Lista Aziende">
        <div class="py-6 px-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">
                <card-header :title="$t('Companies')" :icon="Edit" :tasti="tasti" @search="this.searchTable"></card-header>
                <el-table :data="aziende"
                          stripe
                          style="width: 100%"
                          @row-click="handleClick"
                          @selection-change="handleSelectionChange"
                >
                    <el-table-column type="selection" />
                    <el-table-column label="ID" prop="id" width="80" sortable />
                    <el-table-column label="ragione sociale" prop="ragione_sociale" sortable />
                    <el-table-column label="email" prop="email" sortable />
                    <el-table-column label="telefono" prop="telefono" sortable />
                    <el-table-column label="indirizzo" prop="indirizzo" sortable />
                    <el-table-column label="cap" prop="cap" sortable width="120" />
                    <el-table-column label="provincia" prop="provincia" sortable width="120" />
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

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CardHeader from "../../Components/CardHeader.vue";
import {CirclePlus, DeleteFilled, Edit, Printer, Setting, Delete} from '@element-plus/icons-vue';
// import {HomeIcon} from "@heroicons/vue/24/solid";
</script>


<script>
import {ElMessage} from "element-plus";

export default {
    name: "Aziende",
    props: {
        aziende: Object,
    },
    data() {
        return {
            aziende: [],
            tasti: [
                { id: 1, name: 'Nuovo', type: "info", icon:CirclePlus, click: this.creaAzienda },
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
        creaAzienda(){
            axios.get(this.route('companies.genera')).then(result => {
                ElMessage({message: 'Creata nuova azienda.',type: 'success'});
                this.$inertia.get(route("companies.list"));
            });
        },
        paginate() {
            this.tableLoading = true;
            this.SessionStorage.setItem('aziende_list_search', JSON.stringify(this.search));
            this.SessionStorage.setItem('aziende_list_order', this.sortingOrder);
            this.SessionStorage.setItem('aziende_list_column', this.sortingColumn);
            this.SessionStorage.setItem('aziende_list_page', this.currentPage, true);
            this.SessionStorage.setItem('aziende_list_page_size', this.pageSize, true);
            axios.post(route("companies.paginate"),{
                pageSize: this.pageSize,
                page: this.currentPage,
                sort: this.sortingColumn,
                order: this.sortingOrder,
                search: this.search,
            }).then( result => {
                this.aziende = result.data.data;
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
        handleClick(row,column,event){
            let col = column.property;

            switch (col) {
                case 'accorpa':
                    break;
                default:
                    this.$inertia.get(this.route('companies.edit',{
                        id:row.id
                    }));
            }
        },
        handleSelectionChange(selectedRows) {
            const ids = selectedRows.map((row) => row.id);
            console.log('ID ',ids);

        },
    },
    mounted() {
        this.filter = this.SessionStorage.getItem('aziende_list_search', this.search,true);
        this.sortingOrder = this.SessionStorage.getItem('aziende_list_order', this.sortingOrder,false);
        this.sortingColumn = this.SessionStorage.getItem('aziende_list_column', this.sortingColumn,false);
        this.currentPage = this.SessionStorage.getItem('aziende_list_page', this.currentPage, true);
        this.pageSize = this.SessionStorage.getItem('aziende_list_page_size', this.pageSize, true);
        this.paginate();
    }
}
</script>
<style scoped>

</style>
