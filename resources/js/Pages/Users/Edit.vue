
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
                                            <el-button style="color: red; font-weight: bold; width: 50px !important;" :icon="Close" @click="verifica()" />
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
                                            <el-button style="color: #13ce66; font-weight: bold; width: 50px !important;" :icon="Check" disabled />
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
                                <el-input v-model="utente.localita" class="w-full" clearable placeholder="Località"></el-input>
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
                                <el-popconfirm
                                    v-if="$page.props.roles[0].name==='amministratore'"
                                    width="300"
                                    confirm-button-text="Si, Cambia"
                                    cancel-button-text="No, Annulla"
                                    :icon="InfoFilled"
                                    icon-color="#626AEF"
                                    title="Sei sicuro di cambiare tipo di account?"
                                    @confirm="this.dialogFormVisible = true"
                                ><template #reference>
                                    <el-button v-if="utente.user_type.id === 2"  type="primary" plain  size="large">{{utente.user_type.descrizione}}</el-button>
                                    <el-button v-if="utente.user_type.id === 4"  type="success" plain  size="large">{{utente.user_type.descrizione}}</el-button>
                                    <el-button v-if="utente.user_type.id === 3"  type="warning" plain  size="large">{{utente.user_type.descrizione}}</el-button>
                                </template>
                                </el-popconfirm>
                                <el-popconfirm
                                    v-else
                                    width="300"
                                    cancel-button-text="Annulla"
                                    :icon="InfoFilled"
                                    icon-color="#626AEF"
                                    title="Non hai i permessi necessari per fare questa operazione?"
                                ><template #reference>
                                    <el-button v-if="utente.user_type.id === 2"  type="primary" plain  size="large">{{utente.user_type.descrizione}}</el-button>
                                    <el-button v-if="utente.user_type.id === 4"  type="success" plain  size="large">{{utente.user_type.descrizione}}</el-button>
                                    <el-button v-if="utente.user_type.id === 3"  type="warning" plain  size="large">{{utente.user_type.descrizione}}</el-button>
                                </template>
                                </el-popconfirm>
                            </el-form-item>
                        </el-col>
                        <el-col :span="6">
                            <el-form-item prop="company_id" label="Azienda">
                                <el-select v-model="utente.company_id" class="w-full" placeholder="" clearable>
                                    <el-option v-for="item in aziende" :label="item.ragione_sociale" :value=item.id></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :span="6">
                            <el-form-item prop="current_team_id" label="Team">
                                <el-select v-model="utente.current_team_id" class="w-full" placeholder="" clearable>
                                    <el-option v-for="item in team" :label="item.name" :value=item.id></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item prop="profile_photo_path" label="foto">
                                <img :src="utente.profile_photo_url" :alt="utente.name" class="rounded-full h-20 w-20 object-cover">
                            </el-form-item>
                        </el-col>
                        <el-divider></el-divider>
                    </el-row>
                </el-form>

                    <el-row :gutter="30" class="mb-5">

                        <el-col :span="12">
                            <h1>Lista pazienti e segretarie</h1>
                            <el-form-item v-if="utente.user_type_id === 2" prop="a">
                                <el-table :data="utente.patients" stripe style="width: 100%">
                                    <el-table-column prop="patients.user_type_id" label="tipo" width="100">
                                        <template #default="scope">
                                            <el-tag v-if="scope.row.user_type_id === 3" effect="dark" size="small">Paziente</el-tag>
                                            <el-tag v-if="scope.row.user_type_id === 4" effect="dark" size="small" type="warning">Segretaria</el-tag>
                                        </template>
                                    </el-table-column>
                                    <el-table-column prop="name" label="Nome" />
                                    <el-table-column prop="email" label="Email" width="250" />
                                    <el-table-column prop="telefono" label="Telefono" />
                                </el-table>
                            </el-form-item>

                            <el-form-item v-if="utente.user_type_id === 3" prop="a" label="medico">
                                <el-button style="height: 24px !important;" v-for="item in utente.medico" type="danger" plain disabled size="large">{{ item.name }}</el-button>
                            </el-form-item>

                            <el-form-item v-if="utente.user_type_id === 4" prop="a" label="segretaria di ">
                                <el-button style="height: 24px !important;" v-for="item in utente.medico" type="primary" plain disabled size="large">{{ item.name }}</el-button>
                            </el-form-item>
                        </el-col>


                        <el-col v-if="utente.user_type_id === 2" :span="12">
                            <h1>Lista ambulatori utilizzati
                                <button v-if="this.difference.length > 0" href="#"
                                   class="float-right rounded-md bg-blue-200 px-3.5 py-2.5 text-sm font-semibold shadow-sm border-blue-700
                                   hover:bg-blue-500 hover:text-white text-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                                   @click="associaCliMed()"
                                >Associa ambulatorio</button>
                            </h1>
                            <el-form-item v-if="utente.user_type_id === 2" prop="a">
                                <el-table :data="utente.clinics" stripe style="width: 100%">
                                    <el-table-column prop="nome" label="Nome" />
                                    <el-table-column prop="indirizzo" label="Indirizzo" width="250" />
                                    <el-table-column prop="localita" label="Località" />
                                    <el-table-column prop="telefono" label="Telefono" />
                                    <el-table-column label="..." width="70">
                                        <template #default="scope">
                                            <el-button style="font-weight: normal; width: 24px !important; height: 24px !important; border-radius: 50%;" type="danger" plain size="small" :icon="DeleteFilled" @click="eliminaAmbulatorio(scope.row)"></el-button>
                                        </template>
                                    </el-table-column>
                                </el-table>
                            </el-form-item>

                        </el-col>

                    </el-row>

                    <el-row :gutter="30" class="mb-5">

                    </el-row>


            </div>
        </div>

        <el-dialog v-model="dialogFormVisible" title="Scegli il tipo di utente" width="450">
            <el-form :model="form">
                <el-form-item label="Tito">
                    <el-select v-model="form.tipo" placeholder="Seleziona il tipo di utente">
                        <el-option v-for="tipo in tipiProp" :label="tipo.descrizione" :value="tipo.id" />
                    </el-select>
                </el-form-item>
            </el-form>
            <template #footer>
              <span class="dialog-footer">
                <el-button @click="dialogFormVisible = false">Annulla</el-button>
                <el-button type="primary" @click="salvaTipoUtente">
                  Conferma
                </el-button>
              </span>
            </template>
        </el-dialog>

        <el-dialog v-model="dialogClinic" title="Associa Medico Ambulatorio" width="450">
            <el-form :model="formCli">
                <el-form-item label="Ambulatori">
                    <el-select v-model="formCli.id" placeholder="Seleziona l'ambulatorio">
                        <el-option v-for="cli in difference" :label="cli.nome" :value="cli.id" />
                    </el-select>
                </el-form-item>
            </el-form>
            <template #footer>
              <span class="dialog-footer">
                <el-button @click="dialogClinic = false; ElMessage({ type: 'info', message: 'Operazione annullata' });">Annulla</el-button>
                <el-button type="primary" @click="associaAmbulatorio">
                  Conferma
                </el-button>
              </span>
            </template>
        </el-dialog>

    </AppLayout>

</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CardHeader from "../../Components/CardHeader.vue";
import {CirclePlus, DeleteFilled, Edit, Printer, Setting, Delete, Close, Check} from '@element-plus/icons-vue';
import InfoCard from "../../Components/InfoCard.vue";
import {ElMessage} from "element-plus";
</script>

<script>
import {ElMessage, ElMessageBox} from "element-plus";
import {Edit, Warning, CirclePlus, DeleteFilled, Printer, InfoFilled, CaretBottom, ArrowRight, CaretTop, Minus, Plus, Upload } from '@element-plus/icons-vue';
export default {
    name: "Utenti",
    props: {
        utenteProp: Object,
        aziendeProp: Object,
        teamProp: Object,
        tipiProp: Object,
        ambulatoriProp: Object,
        idAzienda: null
    },
    data() {
        return {
            utente: {...this.utenteProp},
            aziende: {...this.aziendeProp},
            team: {...this.teamProp},
            ambulatori: {...this.ambulatoriProp},
            tastiEditUtente: [
                { id: 2, name: 'Salva', type: "success", icon:Edit, click: this.save },
                { id: 4, name: 'Elimina', type: "danger", icon:DeleteFilled }
            ],
            difference: [],
            dialogClinic: false,
            formCli: {
                id: null
            },
            dialogFormVisible: false,
            form: {
                tipo: null
            },
            search: null,
            currentPage:1,
            pageSize: 5,
            sortingColumn: null,
            sortingOrder: null,
            pageSizes: [
                5,
            ],
            total: 0
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
                ElMessage({ type: 'info', message: 'Operazione annullata' });
            });
        },
        associaCliMed(){
            this.dialogClinic = true;
        },
        associaAmbulatorio(){
            this.dialogClinic = false;
            ElMessageBox.confirm(
                "Attenzione stai per associare l'ambulatorio a questo medico",
                'Attenzione',
                {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Annulla',
                    type: 'warning',
                }
            ).then(() => {
                axios.get(this.route("clinics.associate", {
                    id: this.formCli.id,
                    doctor: this.utente.id
                })).then(response => {
                    ElMessage({
                        type: 'success',
                        message: 'Ambulatorio eliminato con successo',
                    });
                    this.$inertia.get(route('users.edit', response.data.id));
                });

            }).catch(() => {
                ElMessage({
                    type: 'info',
                    message: 'Operazione annullata'
                });
            })
        },
        salvaTipoUtente(){
            this.utente.user_type_id = this.form.tipo;
            this.utente.user_type.id = this.form.tipo;
            this.utente.user_type.descrizione = this.tipiProp.find(x => x.id === this.form.tipo).descrizione;
            this.dialogFormVisible = false;
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
        },
        eliminaAmbulatorio(row){
            ElMessageBox.confirm(
                "Attenzione stai per eliminare l'ambulatorio",
                'Attenzione',
                {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Annulla',
                    type: 'warning',
                }
            ).then(() => {
                axios.get(this.route("clinics.dissociate", {
                    id: row.id,
                    doctor: this.utente.id
                })).then(response => {
                    ElMessage({
                        type: 'success',
                        message: 'Ambulatorio eliminato con successo',
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
    },
    mounted() {
        this.form.tipo = this.utente.user_type_id;
        const a = Object.values(this.ambulatori);
        const b = Object.values(this.utente.clinics);
        for (const item of a) {
            let found = false;
            for (const element of b) {
                if (Object.keys(item).every((key) => item[key] === element[key])) {
                    found = true;
                    break;
                }
            }
            if (!found) {
                this.difference.push(item);
            }
        }

    }
}
</script>

<style scoped>

h1{ font-size: 130% !important; font-weight: bold !important; margin-bottom: 20px; }

.el-button{ font-size: 120%; width: 120px; height: 33px; }

:global(h2#card-usage ~ .example .example-showcase) {
     background-color: var(--el-fill-color) !important;
 }

.el-statistic {
    --el-statistic-content-font-size: 28px;
}

.statistic-card {
    height: 100%;
    padding: 20px;
    border-radius: 4px;
    background-color: var(--el-bg-color-overlay);
}

.statistic-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    font-size: 12px;
    color: var(--el-text-color-regular);
    margin-top: 16px;
}

.statistic-footer .footer-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.statistic-footer .footer-item span:last-child {
    display: inline-flex;
    align-items: center;
    margin-left: 4px;
}

.green {
    color: var(--el-color-success);
}
.red {
    color: var(--el-color-error);
}
</style>
