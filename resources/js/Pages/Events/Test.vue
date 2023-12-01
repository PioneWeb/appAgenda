<template>
    <app-layout>
        <template #header>
            <div class="flex flex-none items-center justify-between">
                <div>
                    <h1 class="text-base font-semibold leading-6 text-gray-900">
                        <time datetime="2023-01-22" class="sm:hidden">Jan 22, 2023</time>
                        <time datetime="2023-01-22" class="hidden sm:inline">January 22, 2023</time>
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">Saturday</p>
                </div>
                <div class="flex items-center">
                    <div class="relative flex items-center rounded-md bg-white shadow-sm md:items-stretch">
                        <button type="button" class="flex h-9 w-12 items-center justify-center rounded-l-md border-y border-l border-gray-300 pr-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pr-0 md:hover:bg-gray-50">
                            <span class="sr-only">Previous day</span>
                            <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                        </button>
                        <button type="button" class="hidden border-y border-gray-300 px-3.5 text-sm font-semibold text-gray-900 hover:bg-gray-50 focus:relative md:block">Today</button>
                        <span class="relative -mx-px h-5 w-px bg-gray-300 md:hidden" />
                        <button type="button" class="flex h-9 w-12 items-center justify-center rounded-r-md border-y border-r border-gray-300 pl-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pl-0 md:hover:bg-gray-50">
                            <span class="sr-only">Next day</span>
                            <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                        </button>
                    </div>
                    <div class="hidden md:ml-4 md:flex md:items-center">
                        <Menu as="div" class="relative">
                            <MenuButton type="button" class="flex items-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                Day view
                                <ChevronDownIcon class="-mr-1 h-5 w-5 text-gray-400" aria-hidden="true" />
                            </MenuButton>

                            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                <MenuItems class="absolute right-0 z-10 mt-3 w-36 origin-top-right overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="py-1">
                                        <MenuItem v-slot="{ active }">
                                            <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Day view</a>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Week view</a>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Month view</a>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Year view</a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                        <div class="ml-6 h-6 w-px bg-gray-300" />
                        <button type="button" class="ml-6 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Add event</button>
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
                                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Day view</a>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Week view</a>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Month view</a>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Year view</a>
                                    </MenuItem>
                                </div>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </div>
        </template>

        {{ moment().calendar() }}

        <div class="flex gap-6">
            <div class="isolate flex flex-auto overflow-hidden bg-white rounded-lg relative">
                <div ref="container" class="flex flex-auto flex-col overflow-auto">
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
                    <div class="flex w-full flex-auto">
                        <div class="w-14 flex-none bg-white ring-1 ring-gray-100" />
                        <div class="grid flex-auto grid-cols-1 grid-rows-1">
                            <!-- Horizontal lines -->
                            <div class="col-start-1 col-end-2 row-start-1 grid divide-y divide-gray-100" style="grid-template-rows: repeat( 24, minmax(7rem, 1fr))">
                                <div ref="containerOffset" class="row-end-1 h-7"></div>
                                <div v-for="hour in hours">
                                    <div>
                                        <div class="sticky left-0 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400">{{ hour }}</div>
                                    </div>
                                    <div />
                                </div>
                            </div>

                            <!-- Events -->
                            <ol class="col-start-1 col-end-2 row-start-1 grid grid-cols-1" style="grid-template-rows: 1.75rem repeat(288, minmax(0, 1fr)) auto">
                                <li class="relative mt-px flex" style="grid-row: 20 / span 12">
                                    <a href="#" class="group absolute inset-1 flex flex-col overflow-y-auto rounded-lg bg-amber-50 p-2 text-xs leading-5 hover:bg-amber-100">
                                        <p class="order-1 font-semibold text-amber-700">Breakfast</p>
                                        <p class="text-amber-500 group-hover:text-amber-700">
                                            <time datetime="2023-01-22T06:00">2:30 AM</time>
                                        </p>
                                    </a>
                                </li>
                                <li class="relative mt-px flex" style="grid-row: 62 / span 12">
                                    <a href="#" class="group absolute inset-1 flex flex-col overflow-y-auto rounded-lg bg-blue-50 p-2 text-xs leading-5 hover:bg-blue-100">
                                        <p class="order-1 font-semibold text-blue-700">Breakfast</p>
                                        <p class="text-blue-500 group-hover:text-blue-700">
                                            <time datetime="2023-01-22T06:00">5:00 AM</time>
                                        </p>
                                    </a>
                                </li>
                                <li class="relative mt-px flex" style="grid-row: 152 / span 12">
                                    <a href="#" class="group absolute inset-1 flex flex-col overflow-y-auto rounded-lg bg-pink-50 p-2 text-xs leading-5 hover:bg-pink-100">
                                        <p class="order-1 font-semibold text-pink-700">Flight to Paris</p>
                                        <p class="order-1 text-pink-500 group-hover:text-pink-700">John F. Kennedy International Airport</p>
                                        <p class="text-pink-500 group-hover:text-pink-700">
                                            <time datetime="2023-01-22T07:30">12:30</time>
                                        </p>
                                    </a>
                                </li>
                                <li class="relative mt-px flex" style="grid-row: 134 / span 18">
                                    <a href="#" class="group absolute inset-1 flex flex-col overflow-y-auto rounded-lg bg-indigo-50 p-2 text-xs leading-5 hover:bg-indigo-100">
                                        <p class="order-1 font-semibold text-indigo-700">Sightseeing</p>
                                        <p class="order-1 text-indigo-500 group-hover:text-indigo-700">Eiffel Tower</p>
                                        <p class="text-indigo-500 group-hover:text-indigo-700">
                                            <time datetime="2023-01-22T11:00">11:00 AM</time>
                                        </p>
                                    </a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sticky top-40 bg-white rounded-lg h-fit hidden w-1/2 max-w-md flex-none px-8 py-10 md:block">
                <div class="flex items-center text-center text-gray-900">
                    <button type="button" class="-m-1.5 flex flex-none items-center justify-center p-1.5 text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Previous month</span>
                        <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                    </button>
                    <div class="flex-auto text-sm font-semibold">Gennaio 2024</div>
                    <button type="button" class="-m-1.5 flex flex-none items-center justify-center p-1.5 text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Next month</span>
                        <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                    </button>
                </div>
                <div class="mt-6 grid grid-cols-7 text-center text-xs leading-6 text-gray-500">
                    <div>L</div>
                    <div>M</div>
                    <div>M</div>
                    <div>G</div>
                    <div>V</div>
                    <div>S</div>
                    <div>D</div>
                </div>
                <div class="isolate mt-2 grid grid-cols-7 gap-px rounded-lg bg-gray-200 text-sm shadow ring-1 ring-gray-200">
                    <button v-for="(day, dayIdx) in days" :key="day.date" type="button" :class="['py-1.5 hover:bg-gray-100 focus:z-10', day.isCurrentMonth ? 'bg-white' : 'bg-gray-50', (day.isSelected || day.isToday) && 'font-semibold', day.isSelected && 'text-white', !day.isSelected && day.isCurrentMonth && !day.isToday && 'text-gray-900', !day.isSelected && !day.isCurrentMonth && !day.isToday && 'text-gray-400', day.isToday && !day.isSelected && 'text-indigo-600', dayIdx === 0 && 'rounded-tl-lg', dayIdx === 6 && 'rounded-tr-lg', dayIdx === days.length - 7 && 'rounded-bl-lg', dayIdx === days.length - 1 && 'rounded-br-lg']">
                        <time :datetime="day.date" :class="['mx-auto flex h-7 w-7 items-center justify-center rounded-full', day.isSelected && day.isToday && 'bg-indigo-600', day.isSelected && !day.isToday && 'bg-gray-900']">{{ day.date.split('-').pop().replace(/^0/, '') }}</time>
                    </button>
                </div>
            </div>
        </div>

    </app-layout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { ChevronDownIcon, ChevronLeftIcon, ChevronRightIcon, EllipsisHorizontalIcon } from '@heroicons/vue/20/solid'
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import AppLayout from "../../Layouts/AppLayout.vue";
import moment from "moment/moment";

const days = [
    { date: '2023-12-25' },
    { date: '2023-12-26' },
    { date: '2023-12-27' },
    { date: '2023-12-28' },
    { date: '2023-12-29' },
    { date: '2023-12-30' },
    { date: '2023-12-31' },
    { date: '2023-01-01', isCurrentMonth: true },
    { date: '2023-01-02', isCurrentMonth: true },
    { date: '2023-01-03', isCurrentMonth: true },
    { date: '2023-01-04', isCurrentMonth: true },
    { date: '2023-01-05', isCurrentMonth: true },
    { date: '2023-01-06', isCurrentMonth: true },
    { date: '2023-01-07', isCurrentMonth: true },
    { date: '2023-01-08', isCurrentMonth: true },
    { date: '2023-01-09', isCurrentMonth: true },
    { date: '2023-01-10', isCurrentMonth: true },
    { date: '2023-01-11', isCurrentMonth: true },
    { date: '2023-01-12', isCurrentMonth: true },
    { date: '2023-01-13', isCurrentMonth: true },
    { date: '2023-01-14', isCurrentMonth: true },
    { date: '2023-01-15', isCurrentMonth: true },
    { date: '2023-01-16', isCurrentMonth: true },
    { date: '2023-01-17', isCurrentMonth: true },
    { date: '2023-01-18', isCurrentMonth: true },
    { date: '2023-01-19', isCurrentMonth: true },
    { date: '2023-01-20', isCurrentMonth: true, isToday: true },
    { date: '2023-01-21', isCurrentMonth: true },
    { date: '2023-01-22', isCurrentMonth: true, isSelected: true },
    { date: '2023-01-23', isCurrentMonth: true },
    { date: '2023-01-24', isCurrentMonth: true },
    { date: '2023-01-25', isCurrentMonth: true },
    { date: '2023-01-26', isCurrentMonth: true },
    { date: '2023-01-27', isCurrentMonth: true },
    { date: '2023-01-28', isCurrentMonth: true },
    { date: '2023-01-29', isCurrentMonth: true },
    { date: '2023-01-30', isCurrentMonth: true },
    { date: '2023-01-31', isCurrentMonth: true },
    { date: '2023-02-01' },
    { date: '2023-02-02' },
    { date: '2023-02-03' },
    { date: '2023-02-04' },
]

const container = ref(null)
const containerNav = ref(null)
const containerOffset = ref(null)
//
// const today = moment();
// const month = today.month();
// const year = today.year();
//
// const firstDay = moment(`${year}-${month+1}-01`);
// console.log('first',firstDay._i)
// const numberOfDays = firstDay.daysInMonth();
// const lastDay = moment(`${year}-${month+1}-${numberOfDays}`);
// console.log('last',lastDay._i);
//
// const firstDayWeekday = firstDay.weekday();
// const endDayWeekday = lastDay.weekday();
// console.log(firstDayWeekday, moment(firstDayWeekday).format('dddd'), endDayWeekday);
//
// const startDay = firstDay.startOf('day').subtract(4, 'd');
// console.log(firstDay._i, startDay._i);

const today = moment();
const month = today.month();
const year = today.year();

const firstDay = moment(`${year}-${month + 1}-01`);
const firstDayWeekday = firstDay.weekday();
const numberOfDays = firstDay.daysInMonth();
const lastDay = moment(`${year}-${month + 1}-${numberOfDays}`);
const endDayWeekday = lastDay.weekday();
let startDay;
if (firstDayWeekday === 1) {
    startDay = firstDay.startOf('day'); // La data di inizio è già lunedì
} else {
    startDay = firstDay.startOf('day').subtract( firstDayWeekday, 'd');
}
let stopDay;
if (endDayWeekday === 1) {
    stopDay = lastDay.startOf('day'); // La data di inizio è già lunedì
} else {
    stopDay = lastDay.startOf('day').add( endDayWeekday+1, 'd');
}
console.log('Data di inizio:', startDay.format('YYYY-MM-DD'));
console.log('Data di fine:', lastDay.format('YYYY-MM-DD'));


onMounted(() => {
    // Set the container scroll position based on the current time.
    const currentMinute = new Date().getHours() * 60
    container.value.scrollTop =
        ((container.value.scrollHeight - containerNav.value.offsetHeight - containerOffset.value.offsetHeight) *
            currentMinute) /
        1440
})
</script>

<script>
export default {
    computed: {
        hours() {
            let result = [];
            let nowHour = new Date().setUTCHours(0, 0, 0, 0);
            nowHour = new Date(nowHour).getHours();

            for(let i = nowHour-1; i < 24; i++){
                result.push(i+':00');
            }
            return result
        },
    },
}
</script>
