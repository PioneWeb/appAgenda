<template>
    <AppLayout title="Tickets">
        <div class="py-6 px-4">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg pb-4">
                <card-header :title="$t('Tickets')" :icon="Ticket" :tasti="tastiEditTicket" @search="this.searchTable"></card-header>

                <el-form :model="ticket" :rules="rules" ref="form" label-position="top">
                    <el-page-header @click="routeToList()" title="Torna alla lista" class="mb-10">
                        <template #content>
                            <span v-if="ticket.id" class="text-xl">Ticket - {{ ticket.ticket }}</span>
                            <span v-else class="text-xl">Crea nuovo ticket</span>
                        </template>
                    </el-page-header>
                    <el-divider content-position="left">
                        <!--<span class="text-xl">DATI ANAGRAFICI</span>-->
                    </el-divider>
                    <el-row :gutter="30" class="mb-5">
                        <el-col :span="2">
                            <el-form-item prop="data" label="Data">
                                {{ moment(ticket.data).format('DD/MM/Y') }}
                            </el-form-item>
                        </el-col>
                        <el-col :span="2">
                            <el-form-item prop="ora" label="Ora">
                                {{ ticket.ora }}
                            </el-form-item>
                        </el-col>
                        <el-col :span="4">
                            <el-form-item prop="customer_id" label="Cliente">
                                {{ ticket.customer.name }}
                            </el-form-item>
                        </el-col>

                        <el-col :span="8">
                            <el-form-item prop="user_id" label="Utente">
                                <el-select multiple v-model="ticket.users_id" class="m-2" placeholder="Select" v-if="$page.props.roles[0].name==='amministratore'">
                                    <el-option
                                        v-for="item in utentiAziende"
                                        :key="item.id"
                                        :label="item.name"
                                        :value="item.id"
                                    />
                                </el-select>
                                <span v-else v-for="item in utentiAziende" >
                                    <label >{{ item.name }}, </label>&nbsp;
                                </span>
                            </el-form-item>
                        </el-col>

                        <el-col :span="2">
                            <el-form-item prop="ticket_type_id" label="Tipo">
                                {{ ticket.ticket_type.nome }}
                            </el-form-item>
                        </el-col>

                        <el-col :span="2">
                            <el-form-item prop="service_id" label="Servizio">
                                {{ ticket.service.name }}

                            </el-form-item>
                        </el-col>

                        <el-col :span="2">
                            <el-form-item prop="stato" label="Stato">
                                <el-switch
                                    :disabled="ticket.stato ? disabled : '' "
                                    size="large"
                                    v-model="ticket.stato"
                                    class="ml-2"
                                    style="--el-switch-on-color: #13ce66; --el-switch-off-color: #ff4949"
                                />
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-divider content-position="left">
                        <!--<span class="text-xl">DATI ANAGRAFICI</span>-->
                    </el-divider>

                </el-form>

                <ul role="list" class="space-y-6">
                    <li v-for="(activityItem, activityItemIdx) in ticket.messages" :key="activityItem.id" class="relative flex gap-x-4r">
                        <div :class="[activityItemIdx === ticket.messages.length - 1 ? 'h-6' : '-bottom-6', 'absolute left-0 top-0 flex w-6 justify-center ']">
                            <div class="w-px bg-gray-200 dark:bg-gray-700" />
                        </div>
                        <img :src="activityItem.user.profile_photo_url" alt="" class="relative mt-3 h-6 w-6 flex-none rounded-full" />
                        <div class="flex-auto rounded-md p-3 ring-1 ring-inset ring-gray-200 dark:ring-gray-700">
                            <div class="flex justify-between gap-x-4">
                                <div class="py-0.5 text-xs leading-5 text-gray-500">
                                    <span class="font-medium text-gray-900 dark:text-white">{{ activityItem.user.name }}</span> ha commentato
                                </div>
                                <time :datetime="activityItem.created_at" class="flex-none py-0.5 text-xs leading-5 text-gray-500">{{ moment(activityItem.created_at).fromNow()}}</time>
                            </div>
                            <p class="text-sm leading-6 text-gray-500">{{ activityItem.messaggio }}</p>
                        </div>
                    </li>
                </ul>
<!--                dark:focus:border-indigo-600 dark:focus:ring-1-->
                <div v-if="ticket.stato!==false" class="mt-6 flex gap-x-3">
                    <img :src="$page.props.auth.user.profile_photo_url" alt="" class="h-6 w-6 flex-none rounded-full" />
                    <div class="relative flex-auto">
                        <div class="overflow-hidden rounded-lg pb-12 shadow-sm">
                            <label for="comment" class="sr-only">Add your comment</label>
                            <textarea rows="2" name="comment" id="comment"
                              class="block w-full resize-none border-1 rounded-lg focus-within:ring-2 dark:focus-within:text-white bg-transparent py-1.5 text-gray-400 placeholder:text-gray-400 sm:text-sm sm:leading-6"
                              placeholder="Scrivi qui il tuo problema..." />
                        </div>
                        <div class="absolute inset-x-0 bottom-0 flex justify-end py-2 pl-3 pr-2">
                            <action-button :item="{name: 'Commenta',type: 'success',icon: Edit, click: this.commenta}" ></action-button>
                        </div>
                    </div>
                </div>

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
import 'moment/locale/it'
</script>

<script>
import {ElMessage, ElMessageBox} from "element-plus";

export default {
    name: "Tickets",
    props: {
        ticketProp: Object,
        codice_1: null,
        codice_2: null
    },
    data() {
        return {
            ticket: {...this.ticketProp},
            services: [],
            ticketType: [],
            users: [],
            utentiAziende: [],
            tastiEditTicket: [
                { id: 2, name: 'Salva', type: "success", icon: Edit, click: this.save },
                { id: 4, name: 'Elimina', type: "danger", icon: DeleteFilled }
            ],
        }
    },
    methods:{
        commenta(){
            ElMessageBox.confirm(
                'Vuoi salvare questo messaggio',
                'Attenzione',
                {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Annulla',
                    type: 'warning',
                }
            ).then(() => {
                axios.post(this.route('tickets.comment'), {
                    "messaggio": document.getElementById("comment").value,
                    "ticket_id": this.ticket.id
                }).then((result) => {
                    ElMessage({
                        type: 'success',
                        message: 'Salvataggio messaggio effettuato',
                    });
                    //if(!this.ticket.id) {
                        this.$inertia.get(route('tickets.edit', result.data.id));
                    //}
                });
            }).catch(() => {
                ElMessage({
                    type: 'info',
                    message: 'Salvataggio annullato',
                })
            })
        },
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
        getUtenti() {
            axios.get(this.route('users.usersList')).then(result => {
                this.users = result.data;
            })
        },
        save(){
            this.$refs.form.validate(valid => {
                if (valid) {
                    ElMessageBox.confirm(
                        'Vuoi salvare questo ticket',
                        'Attenzione',
                        {
                            confirmButtonText: 'OK',
                            cancelButtonText: 'Annulla',
                            type: 'warning',
                        }
                    ).then(() => {
                        axios.post(this.route('tickets.save'), this.ticket).then((result) => {
                            ElMessage({
                                type: 'success',
                                message: 'Salvataggio ticket effettuato',
                            });
                        });
                    }).catch(() => {
                        ElMessage({
                            type: 'info',
                            message: 'Salvataggio annullato',
                        })
                    })
                }
            });
        },
        getTicketUtenti() {
            axios.get(this.route('users.ticketUsersList')).then(result => {
                this.utentiAziende = result.data;
            })
        }
    },
    mounted() {
        this.getService();
        this.getUtenti();
        this.getTicketUtenti();
        this.getTicketType();
    }
}
</script>
<style scoped>
.navbar-wrapper {
    position: relative;
    border-bottom: 1px solid #000;
    height: 125px;
    padding: 0 12px 0 24px;
    background-image: radial-gradient(transparent 2px,#444 1px);
    background-size: 4px 4px;
    backdrop-filter: saturate(30%) blur(1px);
    -webkit-backdrop-filter: saturate(30%) blur(1px);
    top: 0;
}
</style>
