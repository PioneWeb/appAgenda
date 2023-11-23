<script setup>

import {AlarmClock, Check, Close, Cloudy, Delete, Edit, Phone} from "@element-plus/icons-vue";
</script>

<template>
    <el-table :data="appuntamenti" stripe style="width: 100%"
              @row-click="handleClick"
              @selection-change="handleSelectionChange">
        <el-table-column type="selection" />
        <el-table-column label="ID" prop="id" width="80" sortable />
        <el-table-column label="medico" prop="doctor.name" sortable />
        <el-table-column label="paziente" prop="patient.name" sortable >
            <template #default="scope">
                <el-tag v-if="scope.row.patient !== null" size="small" type="danger">{{scope.row.patient.name}}</el-tag>
                <el-tag v-if="scope.row.patient === null" size="small">{{ scope.row.denominazione }}</el-tag>
            </template>
        </el-table-column>
        <el-table-column label="ambulatorio" prop="clinic.nome" sortable />
        <el-table-column label="data" prop="data" sortable width="150" >
            <template #default="scope">
                {{ moment(scope.row.data).format('DD MMM YYYY') }}
            </template>
        </el-table-column>
        <el-table-column label="ora" prop="ora" sortable width="90" >
            <template #default="scope">
                {{ moment(scope.row.ora).format('HH:mm') }}
            </template>
        </el-table-column>
        <el-table-column label="azioni" prop="" sortable width="120" >
            <template #default="scope">
                <el-icon class="m-1" color="green"><Edit /></el-icon>
                <el-icon v-if="scope.row.patient_id === null" class="m-1" color="blue"><Phone /></el-icon>
                <el-icon v-else class="m-1" color="red"><Cloudy /></el-icon>
                <el-icon class="m-1" color="red"><Delete /></el-icon>
                <el-icon v-if="scope.row.stato === 1" color="green"><Check /></el-icon>
                <el-icon v-if="scope.row.stato === 2" color="yellow"><Close /></el-icon>
                <el-icon v-if="scope.row.stato === 3" color="red"><AlarmClock /></el-icon>
            </template>
        </el-table-column>

    </el-table>

    <el-pagination
        class="mt-6"
        v-model:currentPage="currentPage"
        :page-sizes="pageSizes"
        :page-size="pageSize"
        layout="total, sizes, prev, pager, next, jumper"
        :total="total"
        @size-change="handleSizeChange"
        @current-change="handleCurrentChange"
    >
    </el-pagination>
</template>


<script>
export default {
    name: "corpo lista",
    props: {
        ambulatori: Object,
        medici: Object,
        appuntamenti: Object,
        total: Number,
    },
    data() {
        return {
            ambulatori: [],
            medici: [],
            form: [],
            search: null,
            currentPage:1,
            pageSize: 12,
            sortingColumn: null,
            sortingOrder: null,
            pageSizes: [
                10,
                20,
                100
            ],
        }
    },
    methods:{
        handleSizeChange(val) {
            this.pageSize = val;
            this.paginate();
        },
        handleCurrentChange(val) {
            this.currentPage = val;
            this.paginate();
        },
    }
}
</script>
