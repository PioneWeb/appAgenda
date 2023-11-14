<template>
    <AppLayout title="Lista tickets">
        <div class="py-6 px-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">
                <card-header :title="$t('Tickets')" :icon="Ticket" :tasti="tasti" @search="this.searchTable"></card-header>

                <el-table :data="tickets"
                          stripe
                          style="width: 100%"
                          @row-click="handleClick"
                          @selection-change="handleSelectionChange"
                >
                    <el-table-column type="selection" />
<!--                    <el-table-column label="ID" prop="id" width="40" />-->
                    <el-table-column label="Ticket" prop="ticket" width="140" />
                    <el-table-column label="Data" prop="data" width="110" sortable>
                        <template #default="scope">
                            {{ moment(scope.row.data).format('DD/MM/YYYY') }}
                        </template>
                    </el-table-column>
                    <el-table-column label="Ora" prop="ora" width="85" sortable>
                        <template #default="scope">
                            {{ scope.row.ora }}
                        </template>
                    </el-table-column>
                    <el-table-column label="Azienda" prop="customer.company.ragione_sociale" width="300" show-overflow-tooltip sortable/>
                    <el-table-column label="Customer" prop="customer.name" width="200" show-overflow-tooltip sortable />

                    <el-table-column label="User" width="200" show-overflow-tooltip sortable >
                        <template #default="scope">
                            <div v-if="!scope.row.users[0]" class="text-red-400">
                                utente non selezionato
                            </div>
                            <span v-else v-for="nome in scope.row.users" >
                                {{nome.name}},
                            </span>
                        </template>
                    </el-table-column>

                    <el-table-column label="Tipo" prop="ticket_type.nome" width="150" show-overflow-tooltip sortable />
                    <el-table-column label="Servizio" prop="service.name" show-overflow-tooltip sortable />
                    <el-table-column label="Mes." prop="messages" width="85" show-overflow-tooltip sortable >
                        <template #default="scope">
                            {{ scope.row.messages.length }}
                        </template>
                    </el-table-column>
                    <el-table-column label="Stato" prop="stato" width="60" >
                        <template #default="scope">
                            <el-button v-if="scope.row.stato===true" type="success" :icon="LockOpenIcon" plain circle />
                            <el-button v-else type="danger" :icon="LockClosedIcon" disabled plain circle />
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

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CardHeader from "../../Components/CardHeader.vue";
import {CirclePlus, DeleteFilled, Ticket, Edit, Printer, Setting, Delete, Unlock, Lock} from '@element-plus/icons-vue';
import {LockClosedIcon, LockOpenIcon} from "@heroicons/vue/24/solid";
</script>

<script>
import {ElMessage, ElMessageBox} from "element-plus";

export default {
    name: "Tickets",
    data() {
        return {
            tickets: [],
            users: [],
            tasti: [
                { id: 1, name: 'New Fak', type: "info", icon:CirclePlus, click: this.creaTicket },
                { id: 1, name: 'Nuovo', type: "info", icon:CirclePlus, click: this.nuovoTicket },
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
        handleSizeChange(val) {
            this.pageSize = val;
            this.paginate();
        },
        handleCurrentChange(val) {
            this.currentPage = val;
            this.paginate();
        },
        paginate() {
            this.tableLoading = true;
            this.SessionStorage.setItem('tikets_list_search', JSON.stringify(this.search));
            this.SessionStorage.setItem('tikets_list_order', this.sortingOrder);
            this.SessionStorage.setItem('tikets_list_column', this.sortingColumn);
            this.SessionStorage.setItem('tikets_list_page', this.currentPage, true);
            this.SessionStorage.setItem('tikets_list_page_size', this.pageSize, true);
            axios.post(route("tickets.paginate"),{
                pageSize: this.pageSize,
                page: this.currentPage,
                sort: this.sortingColumn,
                order: this.sortingOrder,
                search: this.search,
            }).then( result => {
                this.tickets = result.data.data;
                this.total = result.data.total
            });
        },
        handleClick(row,column){
            let col = column.property;
            switch (col) {
                case 'stato': row.id
                    ElMessageBox.confirm(
                        'Vuoi chiudere questo ticket',
                        'Attenzione',
                        {
                            confirmButtonText: 'OK',
                            cancelButtonText: 'Annulla',
                            type: 'warning',
                        }
                    ).then(() => {
                        axios.post(this.route('tickets.chiudiTicket'), {
                            "ticket_id": row.id
                        }).then((result) => {
                            ElMessage({
                                type: 'success',
                                message: 'Ticket chiuso',
                            });
                            this.$inertia.get(route('tickets.list', result.data.id));
                        });
                    }).catch(() => {
                        ElMessage({
                            type: 'info',
                            message: 'Operazione annullata',
                        })
                    })
                    break;
                default:
                    this.$inertia.get(this.route('tickets.edit',{
                        id:row.id
                    }));
            }
        },
        salvaTicketUser(row){
            console.log(row)
            alert('dfsdf sdf ')
        },
        nuovoTicket(){
            this.$inertia.get(this.route('tickets.newTicket',{
                id: 0
            }));
        },
        creaTicket(){
            axios.get(this.route('tickets.genera')).then(result => {
                ElMessage({message: 'Creato nuovo ticket.',type: 'success'});
                this.$inertia.get(route("tickets.list"));
            });
        },
        getUtenti() {
            axios.get(this.route('users.ticketUsersList')).then(result => {
                this.users = result.data;
            })
        },
        handleSelectionChange(selectedRows) {
            const ids = selectedRows.map((row) => row.id);
            console.log('ID ',ids);

        },
    },
    mounted() {
        this.filter = this.SessionStorage.getItem('tikets_list_search', this.search,true);
        this.sortingOrder = this.SessionStorage.getItem('tikets_list_order', this.sortingOrder,false);
        this.sortingColumn = this.SessionStorage.getItem('tikets_list_column', this.sortingColumn,false);
        this.currentPage = this.SessionStorage.getItem('tikets_list_page', this.currentPage, true);
        this.pageSize = this.SessionStorage.getItem('tikets_list_page_size', this.pageSize, true);
        this.paginate();
        this.getUtenti();
    }
}
</script>
<style scoped>

</style>
