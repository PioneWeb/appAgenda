<template>

    <AppLayout title="Modifica tipo ticket">

        <div class="py-6 px-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">
                <card-header :title="$t('Tickets_types')" :icon="Ticket" :tasti="tasti" ></card-header>

                <el-form :model="tipoTicket" :rules="rules" ref="form" label-position="top">

                    <el-page-header @click="routeToList()" title="Torna alla lista" class="mb-10">
                        <template #content>
                            <span v-if="tipiTicket.id" class="text-xl">Modifica - {{ tipiTicket.nome }}</span>
                            <span v-else class="text-xl">Crea nuovo tipo ticket</span>
                        </template>
                    </el-page-header>
                    <el-divider content-position="left"></el-divider>
                    <el-row :gutter="30" class="mb-5">
                        <el-col :span="12">
                            <el-form-item prop="nome" label="Denominazione">
                                <el-input v-model="tipiTicket.nome" class="w-full" clearable placeholder="Denominazione"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="6">
                            <el-form-item v-if="this.$attrs.azienda.id!==1" prop="company_id" label="Azienda">
                                {{ this.aziende.ragione_sociale }}
                            </el-form-item>
                            <el-form-item v-else prop="company_id" label="Azienda">
                                <el-select v-model="tipiTicket.company_id" class="w-full" placeholder="" clearable>
                                    <el-option v-for="item in aziende" :label="item.ragione_sociale" :value=item.id></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :span="6">
                            <el-form-item prop="priority" label="priority">
                                <el-slider v-model="tipiTicket.priority" :step="10" show-stops />
                            </el-form-item>
                        </el-col>
                    </el-row>
                </el-form>

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
    import {ElMessage, ElMessageBox} from "element-plus";

    export default {
        name: "Edit tipi ticket",
        props: {
            tipiTicketsProp: Object,
            aziendeProp: Object,
            company: null
        },
        data() {
            return {
                tipiTicket: {...this.tipiTicketsProp},
                aziende: {...this.aziendeProp},
                tasti: [
                    { id: 1, name: 'Nuovo', type: "info", icon:CirclePlus, click: this.create },
                    { id: 2, name: 'Salva', type: "success", icon:Edit, click: this.save  },
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
            save(){
                ElMessageBox.confirm(
                    "Attenzione stai per salvare il tipo ticket",
                    'Attenzione',
                    {
                        confirmButtonText: 'OK',
                        cancelButtonText: 'Annulla',
                        type: 'warning',
                    }
                ).then(() => {
                    axios.post(this.route("tipitickets.save"), this.tipiTicket).then(response => {
                        ElMessage({
                            type: 'success',
                            message: 'Tipo ticket salvato con successo',
                        });
                        if(!this.tipiTicket.id) {
                            this.$inertia.get(route('tipitickets.edit', response.data.id));
                        }
                    });
                }).catch(() => {
                    ElMessage({
                        type: 'info',
                        message: 'Operazione annullata'
                    });
                })
            },
            create() {
                this.$inertia.get(this.route('tipitickets.create'));
            },
            routeToList() {
                // this.leave = () => {
                //     return new Promise((resolve, reject) => {
                //         this.save().then(() => {
                //             this.$inertia.get(route("aziende.list"))
                //         }).catch(() => {});
                //         resolve("ok");
                //     });
                // }
                this.$inertia.get(route("tipitickets.list"))
            },
        }
    }
</script>

<style scoped>

</style>
