<template>
    <AppLayout title="Lista Aziende">
        <div class="py-6 px-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">
                <card-header :title="$t('Edit_company')" :icon="Edit" :tasti="tastiEditAzienda"></card-header>

                <el-form :model="azienda" :rules="rules" ref="form" label-position="top">
                    <el-page-header @click="routeToList()" title="Torna alla lista" class="mb-10">
                        <template #content>
                            <span v-if="azienda.id" class="text-xl">Modifica - {{ azienda.ragione_sociale }}</span>
                            <span v-else class="text-xl">Crea nuova azienda</span>
                        </template>
                    </el-page-header>
                    <el-divider content-position="left">
<!--                        <span class="text-xl">DATI ANAGRAFICI</span>-->
                    </el-divider>
                    <el-row :gutter="30" class="mb-5">
                        <el-col :span="16">
                            <el-form-item prop="ragione_sociale" label="Ragione sociale">
                                <el-input v-model="azienda.ragione_sociale" class="w-full" clearable placeholder="Ragione sociale"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item prop="email" label="Email">
                                <el-input v-model="azienda.email" class="w-full" clearable placeholder="Email"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row :gutter="30" class="mb-5">
                        <el-col :span="8">
                            <el-form-item prop="piva" label="Partita iva">
                                <el-input v-model="azienda.piva" class="w-full" clearable placeholder="Partita iva"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item prop="telefono" label="Telefono">
                                <el-input v-model="azienda.telefono" class="w-full" clearable placeholder="Telefono"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item prop="cellulare" label="Cellulare">
                                <el-input v-model="azienda.cellulare" class="w-full" clearable placeholder="Cellulare"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row :gutter="30" class="mb-5">
                        <el-col :span="8">
                            <el-form-item prop="localita" label="Localita">
                                <el-input v-model="azienda.localita" class="w-full" clearable placeholder="Localita"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item prop="cap" label="Cap">
                                <el-input v-model="azienda.cap" class="w-full" clearable placeholder="Cap"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item prop="provincia" label="Crovincia">
                                <el-input v-model="azienda.provincia" class="w-full" clearable placeholder="Crovincia"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row :gutter="30" class="mb-5">
                        <el-col :span="8">
                            <el-form-item prop="iban" label="IBAN">
                                <el-input v-model="azienda.iban" class="w-full" clearable placeholder="IBAN"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item prop="codice_destinatario" label="Codice destinatario">
                                <el-input v-model="azienda.codice_destinatario" class="w-full" clearable placeholder="Codice destinatario"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item prop="pec" label="Pec">
                                <el-input v-model="azienda.pec" class="w-full" clearable placeholder="Pec"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>

                    <el-row :gutter="30" class="mb-5">


                        <el-col :span="6">
                            <el-form-item prop="pubblico">
                                <el-switch
                                    size="large"
                                    v-model="azienda.pubblico"
                                    class="ml-2"
                                    style="--el-switch-on-color: #13ce66; --el-switch-off-color: #ff4949"
                                    inactive-text="Azienda Pubblica"
                                    active-text="Azienda Privata"
                                />
                            </el-form-item>
                        </el-col>
                        <el-col :span="6">
                            <el-form-item prop="privato">
                                <el-switch
                                    size="large"
                                    v-model="azienda.privato"
                                    class="ml-2"
                                    style="--el-switch-on-color: #13ce66; --el-switch-off-color: #ff4949"
                                    active-text="Azienda"
                                    inactive-text="Privato"
                                />
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
import CardHeader from "../../Components/CardHeader.vue";
import {CirclePlus, DeleteFilled, Edit, Printer, Setting, Delete} from '@element-plus/icons-vue';
</script>

<script>
import {ElMessage, ElMessageBox} from "element-plus";

export default {
    name: "Aziende",
    props: {
        aziendaProp: Object,
    },
    data() {
        return {
            azienda: {...this.aziendaProp},
            tastiEditAzienda: [
            { id: 2, name: 'Salva', type: "success", icon:Edit, click: this.save },
            { id: 4, name: 'Elimina', type: "danger", icon:DeleteFilled }
        ]
        }
    },
    methods:{
        save(){
            ElMessageBox.confirm(
                "Attenzione stai per salvare l'azienda",
                'Attenzione',
                {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Annulla',
                    type: 'warning',
                }
            ).then(() => {
                axios.post(this.route("companies.save"), this.azienda).then(response => {
                    ElMessage({
                        type: 'success',
                        message: 'Azienda salvata con successo',
                    });
                    if(!this.azienda.id) {
                        this.$inertia.get(route('companies.edit', response.data.id));
                    }
                });
            }).catch(() => {
                ElMessage({
                    type: 'info',
                    message: 'Operazione annullata'
                });
            })
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
            this.$inertia.get(route("companies.list"))
        }
    }
}
</script>

<style scoped>

</style>
