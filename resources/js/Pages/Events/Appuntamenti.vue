<template>
    <app-layout>
        <template #header>
            <div class="flex flex-none items-center justify-between">
                <div>
                    <h1 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-300">
                        <time :datetime="selected_date.format('YYYY-MM-DD')" class="sm:hidden">{{ selected_date.format('D MMM Y') }}</time>
                        <time :datetime="selected_date.format('YYYY-MM-DD')" class="hidden sm:inline">{{ selected_date.format('D MMMM Y') }}</time>
                    </h1>
                    <p class="mt-1 text-sm text-gray-500 capitalize">{{ selected_date.format('dddd') }}</p>
                </div>
                <div class="flex items-center">
                    <div class="relative flex items-center rounded-md bg-white shadow-sm md:items-stretch">
                        <button @click="change_day(true)" type="button" class="flex h-9 w-12 items-center justify-center rounded-l-md border-y border-l border-gray-300 pr-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pr-0 md:hover:bg-gray-50">
                            <span class="sr-only">Previous day</span>
                            <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                        </button>
                        <button type="button" class="hidden border-y border-gray-300 px-3.5 text-sm font-semibold text-gray-900 hover:bg-gray-50 focus:relative md:block">{{ selected_date.calendar().split(' a')[0]}}</button>
                        <span class="relative -mx-px h-5 w-px bg-gray-300 md:hidden" />
                        <button @click="change_day()" type="button" class="flex h-9 w-12 items-center justify-center rounded-r-md border-y border-r border-gray-300 pl-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pl-0 md:hover:bg-gray-50">
                            <span class="sr-only">Next day</span>
                            <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                        </button>
                    </div>
                    <div class="hidden md:ml-4 md:flex md:items-center">
                        <Menu as="div" class="relative">
                            <MenuButton type="button" class="flex items-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                Vista giorno
                                <ChevronDownIcon class="-mr-1 h-5 w-5 text-gray-400" aria-hidden="true" />
                            </MenuButton>

                            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                <MenuItems class="absolute right-0 z-10 mt-3 w-36 origin-top-right overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="py-1">
                                        <MenuItem v-slot="{ active }">
                                            <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Vista giorno</a>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Vista settimana</a>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Vista mese</a>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Vista anno</a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                        <div class="ml-6 h-6 w-px bg-gray-300" />
                        <button type="button"
                            class="ml-6 rounded-md bg-green-300 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-500"
                                @click="visualizzaLista"
                        >Lista</button>
                    </div>
                    <Menu as="div" class="relative ml-6 md:hidden">
                        <MenuButton class="-mx-2 flex items-center rounded-full border border-transparent p-2 text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Open menu</span>
                            <EllipsisHorizontalIcon class="h-5 w-5" aria-hidden="true" />
                        </MenuButton>

                        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                            <MenuItems class="absolute right-0 z-10 mt-3 w-36 origin-top-right divide-y divide-gray-100 overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <div class="py-1">
                                    <MenuItem v-slot="{ active }">
                                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Create event</a>
                                    </MenuItem>
                                </div>
                                <div class="py-1">
                                    <MenuItem v-slot="{ active }">
                                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Go to today</a>
                                    </MenuItem>
                                </div>
                                <div class="py-1">
                                    <MenuItem v-slot="{ active }">
                                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Vista giorno</a>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Vista settimana</a>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Vista mese</a>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Vista anno</a>
                                    </MenuItem>
                                </div>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </div>
        </template>

        <div class="flex gap-6 ">
            <div v-loading="loading" class="isolate flex flex-auto overflow-hidden bg-white rounded-lg relative">
                <div ref="container" class="flex flex-auto flex-col overflow-auto dark:bg-gray-600 dark:border-gray-600 overflow-x-hidden no-scrollbar">
                    <div ref="containerNav" class="sticky top-0 z-10 grid flex-none grid-cols-7 bg-white text-xs text-gray-500 shadow ring-1 ring-black ring-opacity-5 md:hidden">
                        <button type="button" class="flex flex-col items-center pb-1.5 pt-3">
                            <span>W</span>
                            <!-- Default: "text-gray-900", Selected: "bg-gray-900 text-white", Today (Not Selected): "text-indigo-600", Today (Selected): "bg-indigo-600 text-white" -->
                            <span class="mt-3 flex h-8 w-8 items-center justify-center rounded-full text-base font-semibold text-gray-900">19</span>
                        </button>
                        <button type="button" class="flex flex-col items-center pb-1.5 pt-3">
                            <span>T</span>
                            <span class="mt-3 flex h-8 w-8 items-center justify-center rounded-full text-base font-semibold text-indigo-600">20</span>
                        </button>
                        <button type="button" class="flex flex-col items-center pb-1.5 pt-3">
                            <span>F</span>
                            <span class="mt-3 flex h-8 w-8 items-center justify-center rounded-full text-base font-semibold text-gray-900">21</span>
                        </button>
                        <button type="button" class="flex flex-col items-center pb-1.5 pt-3">
                            <span>S</span>
                            <span class="mt-3 flex h-8 w-8 items-center justify-center rounded-full bg-gray-900 text-base font-semibold text-white">22</span>
                        </button>
                        <button type="button" class="flex flex-col items-center pb-1.5 pt-3">
                            <span>S</span>
                            <span class="mt-3 flex h-8 w-8 items-center justify-center rounded-full text-base font-semibold text-gray-900">23</span>
                        </button>
                        <button type="button" class="flex flex-col items-center pb-1.5 pt-3">
                            <span>M</span>
                            <span class="mt-3 flex h-8 w-8 items-center justify-center rounded-full text-base font-semibold text-gray-900">24</span>
                        </button>
                        <button type="button" class="flex flex-col items-center pb-1.5 pt-3">
                            <span>T</span>
                            <span class="mt-3 flex h-8 w-8 items-center justify-center rounded-full text-base font-semibold text-gray-900">25</span>
                        </button>
                    </div>
                    <div v-if="hours && hours.length > 0" class="flex w-full flex-auto">
                        <div class="w-14 flex-none bg-white ring-1 ring-gray-100 dark:ring-gray-500 dark:divide-gray-500 dark:bg-gray-600 dark:border-gray-600" />
                        <div class="grid flex-auto grid-cols-1 grid-rows-1">
                            <!-- Horizontal lines -->
                            <div class="col-start-1 col-end-2 row-start-1 grid divide-y divide-gray-100 dark:divide-gray-500" :style="'grid-template-rows: repeat(' + schedule.quantita +' , minmax(0, 1fr))'">
                                <div ref="containerOffset" class="row-end-1 h-7"></div>
                                <div v-for="hour in hours" class="hover:bg-amber-50">
                                    <div class="sticky left-0 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400">{{ hour }}</div>
                                </div>
                            </div>

                            <!-- Events -->
                            <ol class="col-start-1 col-end-2 row-start-1 grid grid-cols-1" :style="'grid-template-rows: 1.75rem repeat('+ space*schedule.quantita +', minmax(0, 1fr)) auto'">
                                <li v-for="(item,index) in eventi" class="mt-px flex" :style="'grid-row: '+calcola_ore(item,index)+' / span '+space">
                                    <a href="#" @click="editEvent(item)" class="w-full group relative inset-1 flex flex-col overflow-y-auto rounded-lg p-2 text-xs leading-5" :class="colors_classes[ambulatorio].background">
                                        <p :class="colors_classes[ambulatorio].time">
                                            <time :datetime="moment(item.start).format('YYYY/MM/DD HH:mm')">{{ moment(item.start).format('HH:mm') }}</time>
                                        </p>
                                        <p class="order-1 font-semibold" :class="colors_classes[ambulatorio].title">{{ item.title }}</p>
                                    </a>
                                </li>
                                <!-- Empty Event -->
                                <li v-for="(hour,index) in hours" @click="editEvent(hour)" class="relative flex rounded-md mx-1 my-1 mt-1 hover:bg-amber-50" :style="'grid-row: '+calcola_ore(hour,index)+' / span '+space">
                                    <a href="#" class="group absolute inset-1 flex flex-col overflow-y-auto rounded-lg p-2 text-xs leading-5 overflow-y-hidden no-scrollbar" >
                                        <p :class="colors_classes[ambulatorio].time">
                                            <time :datetime="dateFromHour(hour)">{{ dateFromHour(hour) }}</time>
                                        </p>
                                        <p class="order-1 font-semibold" :class="colors_classes[ambulatorio].title">Nessun evento</p>
                                    </a>
                                </li>
                            </ol>

                        </div>
                    </div>
                    <div v-else class="h-full flex items-center justify-center">
                        <div class="text-center">
                            <CalendarDaysIcon class="mx-auto h-12 w-12 text-gray-400"></CalendarDaysIcon>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900">Non ci sono orari di {{ selected_date.format('dddd') }}</h3>
                            <p class="mt-1 text-sm text-gray-500">Crea degli orari nuovi per inserire appuntamenti in questo giorno.</p>
                            <div class="mt-6">
                                <a :href="route('schedules.create')" type="button" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    <PlusIcon class="-ml-0.5 mr-1.5 h-5 w-5" aria-hidden="true" />
                                    Nuovi orari
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sticky top-40 bg-white rounded-lg h-fit hidden w-1/2 max-w-md flex-none px-8 py-10 md:block dark:bg-gray-600 dark:border-gray-600">
                <div class="flex items-center text-center text-gray-900">
                    <button @click="change_month(true)" type="button" class="-m-1.5 flex flex-none items-center justify-center p-1.5 text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Previous month</span>
                        <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                    </button>
                    <div class="flex-auto text-sm font-semibold">{{ selected_date.format('MMMM') }} {{ selected_date.format('Y') }}</div>
                    <button @click="change_month()" type="button" class="-m-1.5 flex flex-none items-center justify-center p-1.5 text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Next month</span>
                        <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                    </button>
                </div>
                <div class="mt-6 grid grid-cols-7 text-center text-xs leading-6 text-gray-500 dark:text-gray-300">
                    <div>L</div>
                    <div>M</div>
                    <div>M</div>
                    <div>G</div>
                    <div>V</div>
                    <div>S</div>
                    <div>D</div>
                </div>
                <div v-if="days.length > 0" class="isolate mt-2 grid grid-cols-7 gap-px rounded-lg bg-gray-200 text-sm shadow ring-1 ring-gray-200">
                    <button @click="select_date(day)" v-for="(day, dayIdx) in days" :key="day.date" type="button" :class="['py-1.5 hover:bg-gray-100 focus:z-10  dark:bg-gray-600 dark:border-gray-600', day.isCurrentMonth ? 'bg-white' : 'bg-gray-50', (day.isSelected || day.isToday) && 'font-semibold', day.isSelected && 'text-white', !day.isSelected && day.isCurrentMonth && !day.isToday && 'text-gray-900', !day.isSelected && !day.isCurrentMonth && !day.isToday && 'text-gray-400', day.isToday && !day.isSelected && 'text-indigo-400', dayIdx === 0 && 'rounded-tl-lg', dayIdx === 6 && 'rounded-tr-lg', dayIdx === days.length - 7 && 'rounded-bl-lg', dayIdx === days.length - 1 && 'rounded-br-lg']">
                        <time :datetime="day.date" :class="['mx-auto flex h-7 w-7 items-center justify-center rounded-full', day.isSelected && day.isToday && 'bg-indigo-600', day.isSelected && !day.isToday && 'bg-gray-900']">
                            {{ day.date.split('-').pop().replace(/^0/, '') }}
                        </time>
                    </button>
                </div>
                <hr class="my-3">

                <div>
                    <label for="medico" class="block text-sm font-medium leading-6 text-gray-900">Medico</label>
                    <div class="mt-2">
                        <select v-model="medico" @change="controlla_medico" name="medico" autocomplete="medico" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-md sm:text-sm sm:leading-6">
                            <option v-for="option in medici" :value="option.id" >{{ option.name }}</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <label for="ambulatorio" class="block text-sm font-medium leading-6 text-gray-900">Ambulatorio</label>
                    <div>
<!--                        <select v-model="ambulatorio" @change="controlla_ambulatorio" name="ambulatorio" autocomplete="ambulatorio" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">-->
<!--                            <option v-for="option in ambulatori" :value="option.id" >{{ option.nome }}</option>-->
<!--                        </select>-->

                        <RadioGroup v-model="ambulatorio">
                            <div class="space-y-2">
                                <RadioGroupOption  as="template" v-for="option in ambulatori" :key="option.name" :value="option.id" v-slot="{ active, checked }">
                                    <div @click="controlla_ambulatorio(option.id)" :class="[active ? 'border-red-600 ring-2 ring-red-600' : 'border-gray-300', 'relative block cursor-pointer rounded-lg border bg-white px-3 py-1 shadow-sm focus:outline-none sm:flex sm:justify-between']">
                                      <span class="flex items-center">
                                        <span class="flex flex-col text-sm">
                                          <RadioGroupLabel as="span" class="font-medium text-gray-900">{{ option.nome }}</RadioGroupLabel>
                                        </span>
                                      </span>
                                        <RadioGroupDescription as="span" class="mt-1 flex text-sm sm:ml-4 sm:mt-0 sm:flex-col sm:text-right">
                                            <span class="font-medium text-gray-900">{{ option.id }}</span>
                                        </RadioGroupDescription>
                                        <span :class="[active ? 'border' : 'border-2', checked ? 'border-red-600' : 'border-transparent', 'pointer-events-none absolute -inset-px rounded-lg']" aria-hidden="true" />
                                    </div>
                                </RadioGroupOption>
                            </div>
                        </RadioGroup>

                    </div>
                </div>

            </div>
        </div>

        <el-dialog v-model="dialogFormVisible" title="Inserisci il nome del paziente">
            <div v-if="this.appuntamento.id === undefined">
                Puoi scegliere un paziente già registrato dal combo box o inserirne uno nuovo non memorizzato.<br><hr><br>
            <el-form-item label="Paziente" :label-width="formLabelWidth">
                <el-select v-model="paziente" placeholder="Seleziona paziente" filterable allow-create>
                    <el-option v-for="item in pazienti" :label="item.name" :value="item.id" />
                </el-select>
            </el-form-item><br><hr>
            </div>
            <div v-else><hr>

                <span v-if="this.appuntamento.patient === null">
                    paziente:  <b> {{this.appuntamento.title}}</b><br>
                </span>
                <span v-else>
                    paziente:   <b> {{this.appuntamento.patient.name}}</b><br> telefono: {{this.appuntamento.patient.telefono}}<br> email: {{this.appuntamento.patient.email}}<br>
                </span><hr><br>
                Dati dell'appuntamento: {{this.appuntamento.id}}<br>
                del: {{moment(this.appuntamento.start).format('YYYY/MM/DD')}} alle {{moment(this.appuntamento.start).format('HH:mm')}}<br>
                medico: {{this.appuntamento.doctor.name}}<br>
                ambulatorio: {{this.appuntamento.clinic.nome}}<br>
                <hr>
            </div>
            <template #footer>
              <span class="dialog-footer">
                <el-button @click="this.dialogFormVisible = false">Annulla</el-button>
                <el-button v-if="this.appuntamento.id === undefined" type="primary" @click="saveEvent">
                  Salva
                </el-button>
                <el-button v-if="this.appuntamento.id !== undefined" type="primary" @click="deleteEvent">
                  Elimina
                </el-button>
              </span>
            </template>
        </el-dialog>

    </app-layout>
</template>

<script setup>
import { ChevronDownIcon, ChevronLeftIcon, ChevronRightIcon, EllipsisHorizontalIcon,PlusIcon, TrashIcon } from '@heroicons/vue/20/solid'
import { CalendarDaysIcon } from '@heroicons/vue/24/outline'
import {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems, RadioGroup,
    RadioGroupDescription,
    RadioGroupLabel,
    RadioGroupOption
} from '@headlessui/vue'
import AppLayout from "../../Layouts/AppLayout.vue";
import 'moment/locale/it'

</script>

<script>

import moment from "moment";

export default {
    name: "Test",
    props: {
        ambulatori: Object,
        medici: Object,
        appuntamenti: Object
    },
    data() {
      return {
          dialogFormVisible:false,
          form:[],
          formLabelWidth:'160px',
          colors: ['amber','red','indigo','lime','green','yellow','fuchsia','gray','teal','cyan','lightBlue','orange','lightGreen','emerald','rose','violet','sky','cyan','coolGray','trueGray','warmGray','blueGray','pink','purple','blue'],
          filter: {
              tp: 0,
              medico: null,
              ambulatorio: null,
              start: null,
              end: null,
              search: null
          },
          days: [],
          loading: false,
          selected_date: moment(),
          appuntamento:[],
          ambulatorio: null,
          medico: null,
          paziente: null,
          pazienti:[],
          eventi: [],
          colors_classes: [],
          schedule: {
              inizio: '0:0',
              fine: null,
              minuti: null,
              quantita: null
          }
      }
    },
    methods: {
        dateFromHour(hour) {
          return moment(this.selected_date).set({
              hour: hour.split(':')[0],
              minute: hour.split(':')[1],
          }).format('HH:mm');
        },
        get_days_for_calendar() {
            this.loading = true;
            this.days = [];
            const numberOfDays = 42;
            const today = this.moment();
            const month = this.selected_date ? this.selected_date.month() : today.month();
            const year = this.selected_date ? this.selected_date.year() : today.year();
            const firstDay = this.moment(`${year}-${month + 1}-01`).subtract(2,'days');
            const firstDayWeekday = firstDay.weekday();
            let startDay;
            if (firstDayWeekday === 1) {
                startDay = firstDay.startOf('day'); // La data di inizio è già lunedì
            } else {
                startDay = firstDay.startOf('day').subtract( firstDayWeekday, 'd');
            }
            for (let i = 0; i < numberOfDays; i++) {
                this.days.push({
                        date: startDay.format('YYYY-MM-DD'),
                        isCurrentMonth: startDay.month() === month,
                        isToday: startDay.isSame(today, 'day'),
                        isSelected: startDay.isSame(this.selected_date, 'day'),
                });
                startDay.add(1,'day');
            }
            this.filter = {
                medico: this.medico,
                ambulatorio: this.ambulatorio,
                start: moment(this.selected_date).format("YYYY/MM/DD HH:mm"),
                end: moment(this.selected_date).format("YYYY/MM/DD HH:mm")
            }

            axios.post(route("events.paginate"),{
                filter: this.filter
            }).then( result => {
                console.log(result.data)
                this.eventi = result.data
                if(this.medico!==null && this.ambulatorio!==null) {
                    this.get_schedules(this.eventi[0])
                }
                this.loading = false;
            });

        },
        get_patients() {
            axios.get(route("users.patientsList"), {
                'search': this.search,
                'page': this.currentPage,
                'page_size': this.pageSize,
                'sort': this.sortingColumn,
                'order': this.sortingOrder,
            }).then(result => {
                this.pazienti = result.data;
            });
        },
        get_schedules() {
            axios.post(route("schedules.orariList"), {
                'doctor_id': this.medico,
                'clinic_id': this.ambulatorio,
                'date': moment(this.selected_date).format("YYYY/MM/DD HH:mm"),
            }).then(result => {
                if(result.data.length === 0) {
                    this.schedule = {
                        inizio: '00:00',
                        fine: null,
                        minuti: null,
                        quantita: null
                    }
                    return
                }
                this.schedule = result.data
            });
        },
        get_hours_for_list() {
            let result = [];
            let today = moment(this.selected_date);
            today.set({
                hour:this.schedule.inizio.split(':')[0],
                minute:this.schedule.inizio.split(':')[1],
                second:0,
                millisecond:0
            })

            for(let i = 0; i < this.schedule.quantita; i++){
                result.push(today.format('HH:mm'));
                today.add(this.schedule.minuti,'minutes');
            }
            return result
        },
        change_day(previous) {
            this.selected_date = this.selected_date.add(previous ? -1 : 1,'day');
            this.get_days_for_calendar()
        },
        change_month(previous) {
            this.selected_date = this.selected_date.add(previous ? -1 : 1,'month');
            this.get_days_for_calendar()
        },
        select_date(day) {
            this.selected_date = this.moment(day.date);
            this.get_days_for_calendar()
        },
        controlla_medico(){
            this.filter.medico = this.medico;
            this.get_days_for_calendar()
        },
        controlla_ambulatorio(id){
            this.ambulatorio = id;
            this.filter.ambulatorio = this.ambulatorio;
            this.get_days_for_calendar()
        },
        calcola_ore(item,index) {
            if (typeof item !== 'object') {
                return this.calcola_ore({
                    start: this.dateFromHour(item),
                },index);
            }
            let precedente = 0;
            let op = [2,5,8,11,14,17,20,23,27,30,33,36,39,42,45,48,51,54,57,60,63,66,69,72,75,78,81,84,87,90,93,96,99,102,105,108,111,114,117,120,123,126,129,132,135,138,141,144,147,150,153,156,159,162,165,168,171,174,177,180,183,186,189,192,195,198,201,204,207,210,213,216,219,222,225,228,231,234,237,240,243,246,249,252,255,258,261,264,267,270,273,276,279,282,285,288,291,294,297,300,303,306,309,312,315,318,321,324,327,330,333,336,339,342,345,348,351,354,357,360,363,366,369,372,375,378,381,384,387,390,393,396,399,402,405,408,411,414,417,420,423,426,429,432,435,438,441,444,447,450,453,456,459,462,465,468,471,474,477,480,483,486,489,492,495,498,501,504,507,510,513,516,519,522,525,528,531,534,537,540,543,546,549,552,555,558,561,564,567,570,573,576,579,582,585,588,591,594,597,600,603,606,609,612,615,618,621,624,627,630,633,636,639,642,645,648,651,654,657,660,663,666,669,672,675,678,681,684,687,690,693,696,699,702,705,708,711,714,717,720,723,726,729,732,735,738,741,744,747,750,753,756,759,762,765,768,771,774,777]
            let start = moment(item.start).subtract(this.schedule.inizio.split(':')[0],'h').hour();
            let plus = moment(item.start).subtract(this.schedule.inizio.split(':')[1],'m').minute();
            let sp = Math.ceil(this.schedule.minuti/5);
            let ps
            if(sp===1){ ps=12 }
            if(sp===2){ ps=12 }
            if(sp===3){ ps=12 }
            if(sp===4){ ps=9 }
            if(sp===5){ ps=7 }
            if(sp===6){ ps=6 }
            precedente = ((start*ps)+((plus/this.schedule.minuti)*3))+2;
            //console.log(start,plus,this.schedule.minuti,sp,ps,precedente,index )

            if (item.id !== undefined) {
                return precedente;
            }else{ return op[index] }
        },
        editEvent(item){
            console.log('ID',item.id)
            this.appuntamento = item
            this.dialogFormVisible= true;
        },
        saveEvent(){
            this.dialogFormVisible= false;
            if (typeof this.appuntamento === 'object') {
                this.appuntamento = moment(item.start).format('HH:mm')
            }
            let inizio = this.dateFromHour(this.appuntamento);
            var ore = inizio.split(':')[0];
            var minuti = inizio.split(':')[1];
            let startDate = moment(this.selected_date).add(ore, 'hours').add(minuti, 'minutes').format('YYYY/MM/DD HH:mm');
            let endDate = moment(startDate).add(this.schedule.minuti,'minutes').format('YYYY/MM/DD HH:mm');
            let paziente_id;
            let descrizione;
            if( typeof(this.paziente) === "number" ) { paziente_id = this.paziente } else { descrizione = this.paziente }
            axios.post(route("events.save"), {
                'id':this.appuntamento.id,
                'start': startDate,
                'end': endDate,
                'doctor_id': this.medico,
                'clinic_id': this.ambulatorio,
                'patient_id': paziente_id,
                'descrizione': descrizione,
            }).then(result => {
                this.get_days_for_calendar()
            });
        },
        deleteEvent(){
            ElMessageBox.confirm(
                'Sei sicuro di eliminare?',
                'Attenzione',
                {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Annulla',
                    type: 'warning',
                }
            )
                .then(() => {
                    axios.get(route("events.delete",this.appuntamento.id))
                        .then(result => {
                            this.get_days_for_calendar()
                        });
                    ElMessage({
                        type: 'success',
                        message: 'Appuntamento eliminato',
                    })
                    this.dialogFormVisible= false;
                })
                .catch(() => {
                    ElMessage({
                        type: 'info',
                        message: 'Eliminazione cancellata',
                    })
                    this.dialogFormVisible= false;
                })

        },
        visualizzaLista(){
            this.$inertia.get(route("events.list"), {data: this.selected_date.format("YYYY/MM/DD")})
            //this.route({ name: 'events.list' })
            //this.route('events.list')
        }
    },
    computed: {
        hours() {
            return this.get_hours_for_list()
        },
        space() {
            return 3 //Math.ceil(((this.schedule.quantita-1)*this.schedule.minuti)/60)
        }
    },
    mounted() {
        this.medico = this.medici[0].id;
        this.ambulatorio = this.ambulatori[0].id;
        this.colors_classes = this.colors.map( color => {
            return {
                background: 'bg-'+color+'-50 hover:bg-'+color+'-100',
                time: 'text-'+color+'-500 group-hover:text-'+color+'-700',
                title: 'text-'+color+'-700',
            }
        });
        this.selected_date = moment().set({hour:0,minute:0,second:0,millisecond:0});
        this.get_days_for_calendar();
        this.get_schedules(this.eventi[0])
        this.get_patients()
    }
}
</script>
