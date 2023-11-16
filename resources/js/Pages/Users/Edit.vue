
<template>
    <AppLayout title="Lista Aziende">
        <div class="py-6 px-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">
                <card-header :title="$t('Edit_user')" :icon="Edit" :tasti="tastiEditUtente"></card-header>



                <el-form :model="utente" :rules="rules" ref="form" label-position="top">
                    <el-page-header @click="routeToList()" title="Torna alla lista" class="mb-10">
                        <template #content>
                            <span v-if="utente.id" class="text-xl">Modifica - {{ utente.name }}</span>
                            <span v-else class="text-xl">Crea nuovo utente</span>
                        </template>
                    </el-page-header>
                    <el-divider content-position="left"></el-divider>

                    <el-row :gutter="30" class="mb-5">
                        <el-col :span="12">
                            <el-form-item prop="name" label="Nome">
                                <el-input v-model="utente.name" class="w-full" clearable placeholder="Ragione sociale"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="6">
                            <el-form-item prop="email" label="Email">
                                <el-input v-if="utente.email_verified_at===null" v-model="utente.email" class="w-full" clearable placeholder="Email">
                                    <template #append>
                                        <el-tooltip
                                        class="box-item"
                                        effect="dark"
                                        content="Email non verificata"
                                        placement="top"
                                        >
                                            <el-button style="color: red; font-weight: bold;" :icon="Close" @click="verifica()" />
                                    </el-tooltip>
                                    </template>
                                </el-input>
                                <el-input v-else v-model="utente.email" class="w-full" clearable placeholder="Email">
                                    <template #append>
                                        <el-tooltip
                                            class="box-item"
                                            effect="dark"
                                            :content="'Email verificata il '+moment(utente.email_verified_at).format('DD/MM/YYYY')"
                                            placement="top"
                                        >
                                            <el-button style="color: #13ce66; font-weight: bold;" :icon="Check" disabled />
                                        </el-tooltip>
                                    </template>
                                </el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="6">
                            <el-form-item prop="telefono" label="Telefono">
                                <el-input v-model="utente.telefono" class="w-full" clearable placeholder="Telefono"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row :gutter="30" class="mb-5">


                        <el-col :span="16">
                            <el-form-item prop="localita" label="Località">
                                <el-input v-model="utente.localita" class="w-full" clearable placeholder="Email"></el-input>
                            </el-form-item>
                        </el-col>

                        <el-col :span="4">
                            <el-form-item prop="cap" label="Cap">
                                <el-input v-model="utente.cap" class="w-full" clearable placeholder="Cap"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="4">
                            <el-form-item prop="provincia" label="Provincia">
                                <el-input v-model="utente.provincia" class="w-full" clearable placeholder="provincia"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>

                    <el-row :gutter="30" class="mb-5">
                        <el-col :span="4">
                            <el-form-item prop="user_type" label="tipo utente">
                                <el-button v-if="utente.user_type.id === 2"  type="primary" plain disabled size="large">{{utente.user_type.descrizione}}</el-button>
                                <el-button v-if="utente.user_type.id === 4"  type="success" plain disabled size="large">{{utente.user_type.descrizione}}</el-button>
                                <el-button v-if="utente.user_type.id === 3"  type="warning" plain disabled size="large">{{utente.user_type.descrizione}}</el-button>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item prop="company_id" label="Azienda">
                                <el-select v-model="utente.company_id" class="w-full" placeholder="" clearable>
                                    <el-option v-for="item in aziende" :label="item.ragione_sociale" :value=item.id></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item prop="profile_photo_path" label="foto">
                                <img :src="utente.profile_photo_url" :alt="utente.name" class="rounded-full h-20 w-20 object-cover">
                            </el-form-item>
                        </el-col>
                    </el-row>

                    <el-row :gutter="30" class="mb-5">
                        <el-col :span="24">
                            <el-form-item prop="a" label="segretaria dei medici">
                                <el-button v-for="item in utente.medico" type="primary" plain disabled size="large">{{ item.name }}</el-button>
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
import {CirclePlus, DeleteFilled, Edit, Printer, Setting, Delete, Close, Check} from '@element-plus/icons-vue';
</script>

<script>
import {ElMessage, ElMessageBox} from "element-plus";

export default {
    name: "Utenti",
    props: {
        utenteProp: Object,
        aziendeProp: Object,
        idAzienda: null
    },
    data() {
        return {
            utente: {...this.utenteProp},
            aziende: {...this.aziendeProp},
            tastiEditUtente: [
                { id: 2, name: 'Salva', type: "success", icon:Edit, click: this.save },
                { id: 4, name: 'Elimina', type: "danger", icon:DeleteFilled }
            ]
        }
    },
    methods:{
        verifica(){
            ElMessageBox.confirm(
                "Attenzione stai per verificare l'email",
                'Attenzione',
                {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Annulla',
                    type: 'warning',
                }
            ).then(() => {
                console.log('aaa ', this.utente.id)
                axios.post(this.route("users.verify"), {
                    id: this.utente.id
                }).then(response => {
                ElMessage({
                    type: 'success',
                    message: 'Verifica salvata',
                });
                    this.$inertia.get(route('users.edit', response.data.id));

            });
            }).catch(() => {
                ElMessage({
                    type: 'info',
                    message: 'Operazione annullata'
                });
            });
        },
        save(){
            ElMessageBox.confirm(
                "Attenzione stai per salvare l'utente",
                'Attenzione',
                {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Annulla',
                    type: 'warning',
                }
            ).then(() => {
                axios.post(this.route("users.save"), this.utente).then(response => {
                    ElMessage({
                        type: 'success',
                        message: 'Utente salvato con successo',
                    });
                    if(!this.utente.id) {
                        this.$inertia.get(route('users.edit', response.data.id));
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
            this.$inertia.get(route("users.list"))
        }
    }
}
</script>

<style scoped>
.el-button{ font-size: 120%; width: 200px; height: 33px; }
</style>
