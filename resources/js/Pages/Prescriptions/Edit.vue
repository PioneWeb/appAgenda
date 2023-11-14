<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CardHeader from "../../Components/CardHeader.vue";
import {CirclePlus, DeleteFilled, Edit, Printer, Setting, Delete} from '@element-plus/icons-vue';
</script>

<template>
    <AppLayout title="Lista Aziende">
        <div class="py-6 px-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">
                <card-header :title="$t('Edit_prescriptons')" :icon="Edit" :tasti="tastiEditAzienda"></card-header>

                <el-form :model="ricetta" :rules="rules" ref="form" label-position="top">
                    <el-page-header @click="routeToList()" title="Torna alla lista" class="mb-10">
                        <template #content>
                            <span v-if="ricetta.id" class="text-xl">Modifica - {{ ricetta.tipo }}</span>
                            <span v-else class="text-xl">Crea nuova ricetta</span>
                        </template>
                    </el-page-header>
                    <el-divider content-position="left"></el-divider>
                    <el-row :gutter="30" class="mb-5">
                        <el-col :span="10">
                            <el-form-item prop="farmaci" label="Farmaci">
                                <el-input v-model="ricetta.farmaci" class="w-full" clearable placeholder="Farmaci"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item prop="motivo" label="Motivo">
                                <el-input v-model="ricetta.motivo" class="w-full" clearable placeholder="Motivo"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-form-item prop="attivo" label="Stato">
                            <el-tag v-if="ricetta.attiva === true" size="large" type="success">Richiesto il {{ moment(ricetta.created_at).format('DD MMMM YYYY') }}</el-tag>
                            <el-tag v-else size="large" type="danger">Prescritto il {{ moment(ricetta.updated_at).format('DD MMMM YYYY') }}</el-tag>
                        </el-form-item>
                    </el-row>

                    <el-row :gutter="30" class="mb-5">
                        <el-col :span="8">
                            <el-form-item prop="doctor.name" label="Medico">
                                <el-input v-model="ricetta.doctor.name" class="w-full" clearable placeholder="Medico"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item prop="patient.name" label="Paziente">
                                <el-input v-model="ricetta.patient.name" class="w-full" clearable placeholder="Paziente"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item prop="clinic.nome" label="Ambulatorio">
                                <el-input v-model="ricetta.clinic.nome" class="w-full" clearable placeholder="Ambulatorio"></el-input>
                            </el-form-item>
                        </el-col>

                    </el-row>


                </el-form>
            </div>
        </div>
    </AppLayout>

</template>

<script>
import {ElMessage, ElMessageBox} from "element-plus";

export default {
    name: "Ricetta",
    props: {
        ricettaProp: Object,
    },
    data() {
        return {
            ricetta: {...this.ricettaProp},
            tastiEditAzienda: [
                { id: 2, name: 'Salva', type: "success", icon:Edit, click: this.save },
                { id: 4, name: 'Elimina', type: "danger", icon:DeleteFilled }
            ]
        }
    },
    methods:{
        save(){
            ElMessageBox.confirm(
                "Attenzione stai per salvare l'ambulatorio",
                'Attenzione',
                {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Annulla',
                    type: 'warning',
                }
            ).then(() => {
                axios.post(this.route("prescriptions.save"), this.ricetta).then(response => {
                    ElMessage({
                        type: 'success',
                        message: 'Ambulatorio salvata con successo',
                    });
                    if(!this.ricetta.id) {
                        this.$inertia.get(route('prescriptions.edit', response.data.id));
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
            this.$inertia.get(route("prescriptions.list"))
        }
    }
}
</script>

<style scoped>

</style>
