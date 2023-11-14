<template>

    <AppLayout title="Modifica Servizio">

        <div class="py-6 px-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">
                <card-header :title="$t('Services')" :icon="Ticket" :tasti="tasti" ></card-header>

                <el-form :model="service" :rules="rules" ref="form" label-position="top">

                    <el-page-header @click="routeToList()" title="Torna alla lista" class="mb-10">
                        <template #content>
                            <span v-if="service.id" class="text-xl">Modifica - {{ service.name }}</span>
                            <span v-else class="text-xl">Crea nuovo servizio</span>
                        </template>
                    </el-page-header>
                    <el-divider content-position="left"></el-divider>
                    <el-row :gutter="30" class="mb-5">
                        <el-col :span="12">
                            <el-form-item prop="name" label="Nome del servizio">
                                <el-input v-model="service.name" class="w-full" clearable placeholder="Nome del servizio"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="6">
                            <el-form-item v-if="this.$attrs.azienda.id!==1" prop="company_id" label="Azienda">
                                {{ this.aziende.ragione_sociale }}
                            </el-form-item>
                            <el-form-item v-else prop="company_id" label="Azienda">
                                <el-select v-model="service.company_id" class="w-full" placeholder="" clearable>
                                    <el-option v-for="item in aziende" :label="item.ragione_sociale" :value=item.id></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :span="6">
                            <el-form-item prop="priority" label="Priorità">
                                <el-slider v-model="service.priority" :step="10" show-stops />
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
    name: "Edit Service",
    props: {
        serviceProp: Object,
        aziendeProp: Object
    },
    data() {
        return {
            service: {...this.serviceProp},
            aziende: {...this.aziendeProp},
            idAzienda: null,
            tasti: [
                { id: 1, name: 'Nuovo', type: "info", icon:CirclePlus, click: this.create },
                { id: 2, name: 'Salva', type: "success", icon:Edit, click: this.save },
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
    created(){

    },
    methods:{
        save(){
            ElMessageBox.confirm(
                "Attenzione stai per salvare il servizio",
                'Attenzione',
                {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Annulla',
                    type: 'warning',
                }
            ).then(() => {
                axios.post(this.route("services.save"), this.service).then(response => {
                    ElMessage({
                        type: 'success',
                        message: 'Servizio salvato con successo',
                    });
                    if(!this.service.id) {
                        this.$inertia.get(route('services.edit', response.data.id));
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
            this.$inertia.get(this.route('services.create'));
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
            this.$inertia.get(route("services.list"))
        }
}
}
</script>

<style scoped>

</style>
