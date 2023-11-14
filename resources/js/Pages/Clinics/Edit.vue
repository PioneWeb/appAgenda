<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CardHeader from "../../Components/CardHeader.vue";
import {CirclePlus, DeleteFilled, Edit, Printer, Setting, Delete} from '@element-plus/icons-vue';
</script>


<template>
    <AppLayout title="Lista Aziende">
        <div class="py-6 px-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">
                <card-header :title="$t('Edit_clinics')" :icon="Edit" :tasti="tastiEditAzienda"></card-header>

                <el-form :model="ambulatorio" :rules="rules" ref="form" label-position="top">
                    <el-page-header @click="routeToList()" title="Torna alla lista" class="mb-10">
                        <template #content>
                            <span v-if="ambulatorio.id" class="text-xl">Modifica - {{ ambulatorio.nome }}</span>
                            <span v-else class="text-xl">Crea nuova azienda</span>
                        </template>
                    </el-page-header>
                    <el-divider content-position="left">

                    </el-divider>
                    <el-row :gutter="30" class="mb-5">
                        <el-col :span="10">
                            <el-form-item prop="nome" label="Denominazione">
                                <el-input v-model="ambulatorio.nome" class="w-full" clearable placeholder="Denominazione"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item prop="indirizzo" label="Indirizzo">
                                <el-input v-model="ambulatorio.indirizzo" class="w-full" clearable placeholder="Indirizzo"></el-input>
                            </el-form-item>
                        </el-col>

                        <el-col :span="4">
                            <el-form-item v-if="$page.props.auth.user.user_type_id===2" prop="ambulatorio.doctor" label="Medico">
                                {{ $page.props.auth.user.name }}
                            </el-form-item>
                            <el-form-item v-else prop="ambulatorio.doctor_id" label="Medico">
                                <el-select v-model="ambulatorio.doctor_id" class="w-full" placeholder="" clearable>
                                    <el-option v-for="item in medici" :label="item.name" :value=item.id></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>


                    </el-row>

                    <el-row :gutter="30" class="mb-5">
                        <el-col :span="8">
                            <el-form-item prop="localita" label="Localita">
                                <el-input v-model="ambulatorio.localita" class="w-full" clearable placeholder="Localita"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="4">
                            <el-form-item prop="provincia" label="Provincia">
                                <el-input v-model="ambulatorio.provincia" class="w-full" clearable placeholder="Provincia"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="4">
                            <el-form-item prop="cap" label="Cap">
                                <el-input v-model="ambulatorio.cap" class="w-full" clearable placeholder="Cap"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="4">
                            <el-form-item prop="telefono" label="Telefono">
                                <el-input v-model="ambulatorio.telefono" class="w-full" clearable placeholder="Telefono"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-form-item prop="attivo" label="Stato">
                            <el-switch
                                size="large"
                                v-model="ambulatorio.attivo"
                                class="ml-2"
                                style="--el-switch-on-color: #13ce66; --el-switch-off-color: #ff4949"
                                inactive-text="Disattivo"
                                active-text="Attivo"
                            />
                        </el-form-item>

                    </el-row>

                </el-form>
            </div>
        </div>
    </AppLayout>

</template>

<script>
import {ElMessage, ElMessageBox} from "element-plus";

export default {
    name: "Ambulatorio",
    props: {
        ambulatorioProp: Object,
        medici: Object
    },
    data() {
        return {
            ambulatorio: {...this.ambulatorioProp},
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
                axios.post(this.route("clinics.save"), this.ambulatorio).then(response => {
                    ElMessage({
                        type: 'success',
                        message: 'Ambulatorio salvata con successo',
                    });
                    if(!this.ambulatorio.id) {
                        this.$inertia.get(route('clinics.edit', response.data.id));
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
            this.$inertia.get(route("clinics.list"))
        }
    }
}
</script>

<style scoped>
.el-tag__content{ font-size: 150% !important; font-weight: bold !important; }
</style>
