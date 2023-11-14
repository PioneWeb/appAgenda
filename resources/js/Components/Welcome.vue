<template>
    <div class="overflow-y-auto h-[46rem] ">
        <div class="p-2 lg:p-4 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">

            <el-row>
                <el-col :span="4">
                    <el-date-picker
                        v-model="value2"
                        type="date"
                        placeholder="Pick a day"
                        :disabled-date="disabledDate"
                        :shortcuts="shortcuts"
                        :size="size"
                    />
                </el-col>
                <el-col :span="8">
                    <el-input v-model="input1" :placeholder="$t('Please_input')">
                        <template #prepend>Http://</template>
                    </el-input>
                </el-col>
                <el-col :span="8">
                    <el-input
                        v-model="input3"
                        :placeholder="$t('Please_input')"
                        class="input-with-select"
                    >
                        <template #prepend>
                            <el-select v-model="select" placeholder="Select" style="width: 115px">
                                <el-option label="Restaurant" value="1" />
                                <el-option label="Order No." value="2" />
                                <el-option label="Tel" value="3" />
                            </el-select>
                        </template>
                        <template #append>
                            <el-button :icon="Search" />
                        </template>
                    </el-input>
                </el-col>
                <el-col :span="4">
                    <el-switch
                        v-model="value2"
                        class="ml-2"
                        style="--el-switch-on-color: #13ce66; --el-switch-off-color: #ff4949"
                    />
                </el-col>
            </el-row>
            <el-divider />
<!--            <el-row :gutter="10">-->
<!--                <el-col :span="24" class="mb-6">-->
<!--                    <el-carousel :interval="4000" type="card" height="400px">-->
<!--                        <el-carousel-item v-for="item in card"  :key="item">-->
<!--                            <h3 class="text-2xl">{{ item.nome }} {{ item.data }}</h3>-->
<!--                            <img :src="item.foto" class="image"/>-->
<!--                        </el-carousel-item>-->
<!--                    </el-carousel>-->

<!--                </el-col>-->
<!--            </el-row>-->
<!--            <el-divider />-->
            <el-row>
                <el-pagination background layout="prev, pager, next" :total="1000" />
            </el-row>

        </div>

        <div class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
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
                        <el-descriptions-item label="Username">Pione</el-descriptions-item>
                        <el-descriptions-item label="Telephone">055 430352</el-descriptions-item>
                        <el-descriptions-item label="Name" :span="2">Luca Mistretta</el-descriptions-item>
                        <el-descriptions-item label="Remarks"><el-tag size="small">Indirizzo</el-tag></el-descriptions-item>
                        <el-descriptions-item label="Address">Via E. Spinucci 141 50141 Firenze (FI)</el-descriptions-item>
                    </el-descriptions>
                </p>

                <p class="mt-4 text-sm">
                    <el-button  class="text-indigo-700 dark:text-indigo-300" @click="open"><span>Alert</span></el-button>
                </p>
            </div>

            <div>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                        <path stroke-linecap="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    <h2 class="ml-3 text-xl font-semibold text-gray-900 dark:text-white">
                        <a href="https://laracasts.com">Laracasts</a>
                    </h2>
                </div>

                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                    Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development. Check them out, see for yourself, and massively level up your development skills in the process.
                </p>
                <p class="mt-4 text-sm">
                    <el-button  class="text-indigo-700 dark:text-indigo-300" @click="notifica"><span>notifica</span></el-button>
                </p>
                <el-alert title="success alert" type="success" />
                <el-alert title="info alert" type="info" />
                <el-alert title="warning alert" type="warning" />
                <el-alert title="error alert" type="error" />
            </div>

            <div>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <h2 class="ml-3 text-xl font-semibold text-gray-900 dark:text-white">
                        <a href="https://tailwindcss.com/">Tailwind</a>
                    </h2>
                </div>

                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                    Laravel Jetstream is built with Tailwind, an amazing utility first CSS framework that doesn't get in your way. You'll be amazed how easily you can build and maintain fresh, modern designs with this wonderful framework at your fingertips.
                </p>
                <el-popconfirm
                    width="220"
                    confirm-button-text="OK"
                    cancel-button-text="No, Thanks"
                    :icon="InfoFilled"
                    icon-color="#626AEF"
                    title="Are you sure to delete this?"
                >
                    <template #reference>
                        <el-button class="text-indigo-700 dark:text-indigo-300">Delete</el-button>
                    </template>
                </el-popconfirm>
            </div>

            <div>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    <h2 class="ml-3 text-xl font-semibold text-gray-900 dark:text-white">
                        Authentication
                    </h2>
                </div>

                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                    Authentication and registration views are included with Laravel Jetstream, as well as support for user email verification and resetting forgotten passwords. So, you're free to get started with what matters most: building your application.
                </p>
                <el-button class="text-indigo-700 dark:text-indigo-300" @click="visible = true"><span>Drawer</span></el-button>
                <el-button class="text-indigo-700 dark:text-indigo-300" @click="dialogVisible = true"><span>Dialog</span></el-button>
            </div>
        </div>
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
import { Setting, CircleCloseFilled, Search } from '@element-plus/icons-vue';
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
            value2: true,
            input1: null,
            input2: null,
            input3: null,
            card: [
                {titolo:"Yummy hamburger",nome:"Buonizzimo ",data:"12/05/2023", foto: "https://media.istockphoto.com/id/993443062/it/foto/una-mano-che-tiene-e-rilascia-monete.jpg?s=612x612&w=0&k=20&c=XGQH0JBmFVwy4s5ZuaOZmqv5O9sUt-m3viiB8sbVqY8="},
                {titolo:"b",nome:"asdasd asd ",data:"12/05/2023", foto:"https://media.istockphoto.com/id/1367041336/it/foto/cdn-content-delivery-network-illustrazione-3d.jpg?s=612x612&w=0&k=20&c=VuQugn6Nm2zpOdfUT6gguS0b1n1eeSHL_z5PbqFjC1M="},
                {titolo:"c",nome:"ccccc",data:"12/05/2023", foto:"https://media.istockphoto.com/id/833851716/it/foto/denaro-denaro-e-denaro.jpg?s=612x612&w=0&k=20&c=CeK-_oAimjgRY_AdOCOtk-zcBKfRwBSHYHch_2MIa8o="},
                {titolo:"d",nome:"ddddd",data:"12/05/2023", foto:"https://media.istockphoto.com/id/139677465/it/foto/fiore-di-cactus.jpg?s=612x612&w=0&k=20&c=3e8IC3HSHY6Ez9LAVfjTmp5zHEg6m9-wvSbStgDjmZQ="},
                {titolo:"e",nome:"eeeee",data:"12/05/2023", foto:"https://media.istockphoto.com/id/139696640/it/foto/scoiattolo-foraggiamento-close-up.jpg?s=612x612&w=0&k=20&c=M4SU1NSOhGaPmrQE3aRWuEdr4B9UFW0-SPxRAxFSimI="},
                {titolo:"f",nome:"fffff",data:"12/05/2023", foto:"https://media.istockphoto.com/id/833851672/it/foto/denaro-denaro-e-denaro.jpg?s=612x612&w=0&k=20&c=LfCnaq9sHK7Oy15V6ohSA7johml4Wfx9LXTL0naCiU0="},
                {titolo:"Yummy hamburger",nome:"Buonizzimo ",data:"12/05/2023", foto:"https://media.istockphoto.com/id/139745694/it/foto/sexy-stomaco-1.jpg?s=612x612&w=0&k=20&c=dMmD2OJUeCWL5hfSaxretObBV5fGnghL07GdVIdfN8E="},
                {titolo:"b",nome:"bbbbb",data:"12/05/2023", foto:"https://media.istockphoto.com/id/1363358735/it/foto/business-center-di-napoli-italia.jpg?s=612x612&w=0&k=20&c=O58gnd_qAgX5eE0ujC5_uLx22fi4iONQVlXzZcfQd-o="},
                {titolo:"c",nome:"ccccc",data:"12/05/2023", foto:"https://media.istockphoto.com/id/1426025681/it/foto/mano-delluomo-aggiungendo-un-blocco-di-cubo-di-legno-in-cima-con-la-lettera-c-testo-cdn.jpg?s=612x612&w=0&k=20&c=yL_XVvolwk818qhNpzPa6zzOV6BfCHQjrQ-kQ2adqic="},
                {titolo:"d",nome:"ddddd",data:"12/05/2023", foto:"https://media.istockphoto.com/id/139680576/it/foto/bussola-e-mappa-macro.jpg?s=612x612&w=0&k=20&c=eAQMePq9_F1S9oTPJsEm4nkinO5SHTbbblY-ZyUJaYg="},
                {titolo:"e",nome:"eeeee",data:"12/05/2023", foto:"https://media.istockphoto.com/id/179252880/it/foto/moneta-di-cioccolato-cdn-dollari-un-grafico.jpg?s=612x612&w=0&k=20&c=JddGN-nO8tgdwqzv9ygTSOYn7hxtMhC-TweqemWzW7c="},
                {titolo:"f",nome:"fffff",data:"12/05/2023", foto:"https://media.istockphoto.com/id/1474890310/it/foto/concetto-di-testo-della-rete-per-la-distribuzione-di-contenuti-cdn-neon-infrastruttura-di-rete.jpg?s=612x612&w=0&k=20&c=bkO8LLKUhYF-ImEnbDFxt83o4RkT8HOv8kGPlz87A54="},
            ]
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
        }
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
