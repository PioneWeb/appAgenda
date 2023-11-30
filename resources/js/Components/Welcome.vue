<template>
    <div class="overflow-y-auto h-[46rem] ">
        <div class="p-2 lg:p-4 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700"></div>


            <el-row>
                <el-col :span="11" class="mt-10">
                    <div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                            <h2 class="ml-3 text-xl font-semibold text-gray-900 dark:text-white">
                                <a href="https://laravel.com/docs">Documentazione</a>
                            </h2>
                        </div>
                        <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                            <el-descriptions
                                title="Lista verticale"
                                :column="4"
                                :size="size"
                                direction="vertical"
                                :style="blockMargin"
                            >
                                <el-descriptions-item label="Nome" :span="2">{{ $page.props.auth.user.name }}</el-descriptions-item>
                                <el-descriptions-item label="Username">{{ $page.props.auth.user.email }}</el-descriptions-item>
                                <el-descriptions-item label="Telephone">{{ $page.props.auth.user.telefono }}</el-descriptions-item>
                                <el-descriptions-item label="Indirizzo">{{ $page.props.auth.user.indirizzo }}</el-descriptions-item>
                                <el-descriptions-item label="Località">{{ $page.props.auth.user.localita }}</el-descriptions-item>
                                <el-descriptions-item label="Cap">{{ $page.props.auth.user.cap }}</el-descriptions-item>
                                <el-descriptions-item label="Provincia"><el-tag size="large">{{ $page.props.auth.user.provincia }}</el-tag></el-descriptions-item>
                            </el-descriptions>
                        </p>
                    </div>
                </el-col>

                <el-col :span="3" class="mt-10 text-center border-l border-l-gray-300">
                    <h1>Appuntamenti</h1>
                    <el-switch
                        active-text="Si"
                        inactive-text="No"
                        v-model="appuntamenti"
                        width="60"
                        style="--el-switch-on-color: #13ce66; --el-switch-off-color: #ff4949"
                        inline-prompt
                    />
                </el-col>
                <el-col :span="3" class="mt-10 text-center">
                    <h1>Ricette</h1>
                    <el-switch
                        active-text="Si"
                        inactive-text="No"
                        v-model="ricette"
                        width="60"
                        style="--el-switch-on-color: #13ce66; --el-switch-off-color: #ff4949"
                        inline-prompt
                    />
                </el-col>
                <el-col :span="3" class="mt-10 text-center">
                    <h1>Analisi</h1>
                    <el-switch
                        active-text="Si"
                        inactive-text="No"
                        v-model="analisi"
                        width="60"
                        style="--el-switch-on-color: #13ce66; --el-switch-off-color: #ff4949"
                        inline-prompt
                    />
                </el-col>
                <el-col :span="3" class="mt-10 text-center">
                    <h1>Visite</h1>
                    <el-switch
                        active-text="Si"
                        inactive-text="No"
                        v-model="visite"
                        width="60"
                        style="--el-switch-on-color: #13ce66; --el-switch-off-color: #ff4949"
                        inline-prompt
                    />
                </el-col>

            </el-row>
            <el-divider/>
            <el-row>
                <el-col :span="24">
                    <p class="mt-4 text-sm">
                        <el-button  class="text-indigo-700 dark:text-indigo-300" @click="open"><span>Alert</span></el-button>
                        <el-button class="text-indigo-700 dark:text-indigo-300" @click="visible = true"><span>Drawer</span></el-button>
                        <el-button class="text-indigo-700 dark:text-indigo-300" @click="dialogVisible = true"><span>Dialog</span></el-button>
                        <el-button class="text-indigo-700 dark:text-indigo-300" @click="salvaPreferenze"><span>Salva</span></el-button>
                    </p>
                </el-col>
            </el-row>

        </div>



    <el-drawer v-model="visible" :show-close="false">
        <template #header="{ close, titleId, titleClass }">
            <h4 :id="titleId" :class="titleClass">This is a custom header!</h4>
            <el-button type="danger" @click="close">
                <el-icon class="el-icon--left"><CircleCloseFilled /></el-icon>
                Close
            </el-button>
        </template>
        This is drawer content.
    </el-drawer>

    <el-dialog
        v-model="dialogVisible"
        title="Tips"
        width="30%"
        :before-close="handleClose"
    >
        <span>This is a message</span>
        <template #footer>
      <span class="dialog-footer">
        <el-button @click="dialogVisible = false">Cancel</el-button>
        <el-button type="primary" @click="dialogVisible = false">
          Confirm
        </el-button>
      </span>
        </template>
    </el-dialog>

</template>
https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png
<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Setting, CircleCloseFilled, Check, Close } from '@element-plus/icons-vue';
</script>

<script>
import {ElMessage, ElMessageBox, ElNotification} from "element-plus";

import { ElDrawer } from "element-plus";

export default {
    name: "Welcome",
    data() {
        return {
            dialogVisible:false,
            visible:false,
            appuntamenti: true,
            analisi: false,
            ricette: false,
            visite: false
        }
    },
    methods:{
        open() {
            ElMessageBox.confirm(
                'Stai per inviare un email di sollecito ',
                'Attenzione invio solleciti',
                {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Annulla',
                    type: 'warning',
                }
            ).then(() => {
                ElMessage({
                    type: 'warning',
                    message: 'Operazione valida',
                });
            }).catch(() => {
                ElMessage({
                    type: 'info',
                    message: 'Operazione annullata',
                });
            });
        },
        notifica() {
            ElNotification({
                title: 'Success',
                message: 'This is a success message',
                type: 'success',
                position: 'bottom-right',
                // offset: 300,
            })
        },
        salvaPreferenze() {
            axios.post(this.route("preferences.save"), this.ambulatorio).then(response => {
                ElMessage({
                    type: 'success',
                    message: 'Preferenze salvate con successo',
                });
            });
        },
    }
}
</script>
<style scoped>
.el-alert {
    margin: 10px 0 0;
}
.el-alert:first-child {
    margin: 0;
}
</style>
