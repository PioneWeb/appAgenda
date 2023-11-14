<template>
    <AppLayout title="Lista Tipi Ticket">
        <div class="py-6 px-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">
                <card-header :title="$t('TicketsType')" :icon="Ticket" :tasti="tasti" @search="this.searchTable"></card-header>

                <el-table
                    :data="ticketsType"
                    stripe
                    style="width: 100%"
                    @row-click="handleClick"
                    @selection-change="handleSelectionChange"
                >
                    <el-table-column type="selection" />
                    <el-table-column label="ID" prop="id" width="40" />
                    <el-table-column label="Nome" prop="nome" />
                    <el-table-column label="Azienda" prop="company.ragione_sociale" />
                    <el-table-column label="Priorità" prop="priority" width="140" />
                </el-table>

            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Ticket} from "@element-plus/icons-vue";
import CardHeader from "../../Components/CardHeader.vue";
</script>

<script>
import {CirclePlus, DeleteFilled, Edit, Printer} from "@element-plus/icons-vue";

export default {
    name: "TicketsType",
    props: {
        ticketsTypeProp: Object,
    },
    data() {
        return {
            ticketsType: [],
            tasti: [
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
    methods: {
        paginate() {
            this.tableLoading = true;
            this.SessionStorage.setItem('ticketsType_list_search', JSON.stringify(this.search));
            this.SessionStorage.setItem('ticketsType_list_order', this.sortingOrder);
            this.SessionStorage.setItem('ticketsType_list_column', this.sortingColumn);
            this.SessionStorage.setItem('ticketsType_list_page', this.currentPage, true);
            this.SessionStorage.setItem('ticketsType_list_page_size', this.pageSize, true);
            axios.post(route("tipitickets.paginate"), {
                pageSize: this.pageSize,
                page: this.currentPage,
                sort: this.sortingColumn,
                order: this.sortingOrder,
                search: this.search,
            }).then(result => {
                this.ticketsType = result.data.data;
                this.total = result.data.total
            });
        },
        handleClick(row){
            this.$inertia.get(this.route('tipitickets.edit',{
                id: row.id
            }));
        },
        create() {
            this.$inertia.get(this.route('tipitickets.create'));
        },
        handleSelectionChange(selectedRows) {
            const ids = selectedRows.map((row) => row.id);
            console.log('ID ',ids);

        },
    },
    mounted() {
        this.filter = this.SessionStorage.getItem('ticketsType_list_search', this.search,true);
        this.sortingOrder = this.SessionStorage.getItem('ticketsType_list_order', this.sortingOrder,false);
        this.sortingColumn = this.SessionStorage.getItem('ticketsType_list_column', this.sortingColumn,false);
        this.currentPage = this.SessionStorage.getItem('ticketsType_list_page', this.currentPage, true);
        this.pageSize = this.SessionStorage.getItem('ticketsType_list_page_size', this.pageSize, true);
        this.paginate();
    }
}
</script>

<style scoped>

</style>
