<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CardHeader from "../../Components/CardHeader.vue";
import {Edit} from '@element-plus/icons-vue';
</script>

<template>
    <AppLayout title="Lista Aziende">
        <div class="py-6 px-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">
                <card-header :title="$t('Edit_schedules')" :icon="Edit" :tasti="tastiEditAzienda"></card-header>

                <el-form :model="orario" :rules="rules" ref="form" label-position="top">
                    <el-page-header @click="routeToList()" title="Torna alla lista" class="mb-10">
                        <template #content>
                            <span v-if="orario.id" class="text-xl">Modifica - {{ orario.tipo }}</span>
                            <span v-else class="text-xl">Crea nuova ricetta</span>
                        </template>
                    </el-page-header>
                    <el-divider content-position="left"></el-divider>

                    <el-row :gutter="30" class="mb-5">
                        <el-col :span="10">
                            <el-form-item prop="doctor.name" label="Medico">
                                <el-select v-model="orario.doctor_id" class="w-full" placeholder="" clearable filterable>
                                    <el-option v-for="item in medici" :label="item.name" :key="item.id" :value="item.id"></el-option>
                                </el-select>

                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item prop="clinic.nome" label="Ambulatorio">
                                <el-select v-model="orario.clinic_id" class="w-full" placeholder="" clearable filterable>
                                    <el-option v-for="item in ambulatori" :label="item.nome" :key="item.id" :value="item.id"></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :span="4">
                            <el-form-item prop="attivo" label="Stato" @click="attivaDisattiva(orario)">
                                <el-tag v-if="!orario.id || orario.attivo === 1" size="large" type="success">ORARIO ATTIVO</el-tag>
                                <el-tag v-else size="large" type="danger">ORARIO NON ATTIVO</el-tag>
                            </el-form-item>
                        </el-col>

                    </el-row>

                    <el-row :gutter="30" class="mb-5">
                        <el-col :span="6">
                            <el-form-item prop="giorno" label="Giorno">
                                <el-select v-model="orario.giorno" class="w-full" placeholder="" clearable>
                                    <el-option v-for="item in giorni" :label="item.name" :value=item.id></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :span="6">
                            <el-form-item prop="tipo" label="Tipo appuntamento">
                                <el-select v-model="orario.tipo" class="w-full" placeholder="" clearable>
                                    <el-option v-for="item in tipi" :label="item.name" :value=item.id></el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :span="4">
                            <el-form-item prop="quantita" label="Numero appuntamenti">
                                <el-input-number v-model="orario.quantita" class="w-full" clearable placeholder="Quantita"></el-input-number>
                            </el-form-item>
                        </el-col>
                        <el-col :span="4">
                            <el-form-item prop="quantita" label="Durata appuntamento minuti">
                                <el-input-number v-model="orario.minuti" class="w-full" clearable placeholder="Minuti"></el-input-number>
                            </el-form-item>
                        </el-col>
                        <el-col :span="4">
                            <el-form-item prop="inizio" label="Orario inizio">
                                <el-time-picker v-model="orario.inizio" value-format="HH:mm" format="HH:mm" class="w-full" clearable placeholder="Giorno"></el-time-picker>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-divider content-position="left"></el-divider>
                    <el-row :gutter="30" class="mb-5">

                        <el-card class="box-card">
                            <template #header>
                                <div v-if="orario.giorno" class="card-header text-lg ">
                                    Orari {{ tipi[orario.tipo].name }} del {{ giorni[orario.giorno].name }}
                                </div>
                            </template>
                            <div v-for="orario in orario_calcolato" class="text-lg item text-center font-mono">{{ orario }}</div>
                        </el-card>

                    </el-row>


                </el-form>
            </div>
        </div>
    </AppLayout>

</template>

<script>
import {ElMessage, ElMessageBox} from "element-plus";

export default {
    name: "Orario",
    props: {
        orariProp: Object,
        mediciProp: Object,
        ambulatoriProp: Object
    },
    data() {
        return {
            orario: {...this.orariProp},
            medici: {...this.mediciProp},
            ambulatori: {...this.ambulatoriProp},
            tastiEditAzienda: [
                { id: 2, name: 'Salva', type: "success", icon:Edit, click: this.save },
            ],
            orari: [],
            giorni:[
                {id: 0, name: 'Domenica'},
                {id: 1, name: 'Lunedì'},
                {id: 2, name: 'Martedì'},
                {id: 3, name: 'Mercoledì'},
                {id: 4, name: 'Giovedì'},
                {id: 5, name: 'Venerdì'},
                {id: 6, name: 'Sabato'},
            ],
            tipi:[ {id: 0, name: 'Informatori'},{id: 1, name: 'Visite'},{id: 2, name: 'Vaccini'} ],
        }
    },
    computed: {
        orario_calcolato() {
            let date = []
            if(this.orario && this.orario.inizio && this.orario.quantita) {
                let ore = this.orario.inizio.split(':');
                let data = new Date(2023, 0, 1, Number(ore[0]), Number(ore[1]), 0, 0);
                for (let i=0; i<this.orario.quantita; i++){
                    const c = i < 9 ? "0" + (i+1) : i+1;
                    date.push(c+' - '+this.prendiOrario(data));
                    data.setMinutes(data.getMinutes() + this.orario.minuti)
                }
            }

            return date
        }
    },
    methods:{
        attivaDisattiva(row){
            let idOrario = row.id;
            let attivo = row.attivo;
            if(attivo===null) attivo=0
            axios.post(this.route("schedules.sino"), {id:idOrario, attivo:attivo}).then(response => {
                if(response.data.attivo===1){
                    ElMessage({
                        type: 'success',
                        message: 'Orario attivato',
                    });
                }else{
                    ElMessage({
                        type: 'error',
                        message: 'Orario disattivato',
                    });
                }
                if(this.orario.id) {
                    this.$inertia.get(route('schedules.edit', response.data.id));
                }
            });
        },
        prendiOrario(data) {
            const ora = data.getHours();
            const minuti = data.getMinutes();
            const oraFormattata = ora < 10 ? "0" + ora : ora;
            const minutiFormattati = minuti < 10 ? "0" + minuti : minuti;
            return `${oraFormattata}:${minutiFormattati}`;
        },
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
                axios.post(this.route("schedules.save"), this.orario).then(response => {
                    ElMessage({
                        type: 'success',
                        message: 'Ambulatorio salvata con successo',
                    });
                    if(!this.orario.id) {
                        this.$inertia.get(route('schedules.edit', response.data.id));
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
            this.$inertia.get(route("schedules.list"))
        }
    },
    mounted() {
        //this.orari
    }
}
</script>

<style scoped>

</style>
