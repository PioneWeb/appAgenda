<template>
    <AppLayout title="Lista Aziende">
        <div class="py-6 px-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">

                <card-header :title="$t('New Ticket')" :icon="Ticket" :tasti="tastiNewTicket" ></card-header>


                <el-form :model="ticket" :rules="rulesNew" ref="form" label-position="top">
                    <el-page-header @click="routeToList()" title="Torna alla lista" class="mb-10">
                        <template #content>
                            <span v-if="ticket.id" class="text-xl">Modifica - {{ ticket.note }}</span>
                            <span v-else class="text-xl">Crea nuovo ticket</span>
                        </template>
                    </el-page-header>
                    <el-divider content-position="left">
                        <!--<span class="text-xl">DATI ANAGRAFICI</span>-->
                    </el-divider>
                    <el-row :gutter="30" class="mb-5">

                        <el-col :span="8">
                            <el-form-item prop="ticket" label="Il ticket verrà creato da">
                                <div v-if="ticket.props!==undefined">{{ $page.props.auth.user.name+' per '+$page.props.azienda.ragione_sociale }}</div>
                                <div v-else>{{ $page.props.auth.user.name+' per azienda mancante' }}</div>
                            </el-form-item>
                        </el-col>

                        <el-col :span="8">
                            <el-form-item prop="ticket_type_id" label="Scegli che tipo di ticket">
                                <el-select v-model="ticket.ticket_type_id" class="w-full h-8 mb-4" placeholder="Tipo">
                                    <el-option
                                        v-for="item in ticketType"
                                        :key="item.id"
                                        :label="item.nome"
                                        :value="item.id"
                                    />
                                </el-select>
                            </el-form-item>
                        </el-col>

                        <el-col :span="8">
                            <el-form-item prop="service_id" label="Scegli che tipo di servizio">
                                <el-select v-model="ticket.service_id" class="w-full h-8 mb-4" placeholder="Tipo">
                                    <el-option
                                        v-for="item in services"
                                        :key="item.id"
                                        :label="item.name"
                                        :value="item.id"
                                    />
                                </el-select>
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
import {CirclePlus, DeleteFilled, Edit, Printer, Setting, Delete, Ticket, Lock} from '@element-plus/icons-vue';
import {ListboxOption, ListboxOptions} from "@headlessui/vue";
import ActionButton from "../../Components/ActionButton.vue";
// import {HomeIcon} from "@heroicons/vue/24/solid";
</script>

<script>
import {ElMessage, ElMessageBox} from "element-plus";

export default {
    name: "New Ticket",
    props: {
        ticketProp: Object,
    },
    data() {
        return {
            ticket:[],
            services: [],
            ticketType: [],
            tastiNewTicket: [
                { id: 2, name: 'Crea', type: "success", icon: Edit, click: this.creaTicket }
            ],
            rulesNew: {
                ticket_type_id: [{required: true, message: "Tipo richiesto", trigger: ['change', 'blur']}],
                service_id: [{required: true, message: "Servizio richiesto", trigger: ['change', 'blur']}],
            }
        }
    },
    methods:{
        routeToList() {
            this.$inertia.get(route("tickets.list"))
        },
        getService() {
            axios.get(this.route('service.serviceList')).then(result => {
                this.services = result.data;
            })
        },
        getTicketType() {
            axios.get(this.route('tipitickets.ticketTypeList')).then(result => {
                this.ticketType = result.data;
            })
        },
        creaTicket() {
            this.$refs.form.validate(valid => {
                        if (valid) {
                            this.ticket.customer_id = this.$page.props.auth.user.id;
                            console.log(this.ticket);
                            axios.post(this.route('tickets.creaTicket'), {
                                "customer_id": this.ticket.customer_id,
                                "service_id": this.ticket.service_id,
                                "ticket_type_id": this.ticket.ticket_type_id,
                            }).then((result) => {
                                ElMessage({
                                    type: 'success',
                                    message: 'Salvataggio ticket effettuato',
                                });
                            });

                        }
                    });
                }
    },
    mounted() {
        this.getService();
        this.getTicketType();
    }
}
</script>

<style scoped>

</style>
