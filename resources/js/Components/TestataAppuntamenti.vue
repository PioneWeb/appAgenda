<template>
    <el-form :model="form" :inline="true" class="demo-form-inline">
        <div class="bg-slate-800 h-14 m-4 rounded-lg bg-white dark:bg-gray-900 dark:border-gray-900">
            <el-row :gutter="24">
                <el-col :span="9" class="m-1 p-2">
                    <el-form-item label="Ambulatorio" class="w-full">
                        <el-select v-model="filter.ambulatorio" class="m-0 w-full" placeholder="Select" multiple @change="$emit('cambiaAmbulatorio',filter.ambulatorio)">
                            <el-option
                                v-for="item in ambulatori"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
                            />
                        </el-select>
                    </el-form-item>
                </el-col>
                <el-col :span="9" class="m-1 p-2">
                    <el-form-item label="Medico" class="w-full">
                        <el-select v-model="filter.medico" class="m-0 w-full" placeholder="Select" multiple @change="$emit('cambiaMedico',filter.medico)">
                            <el-option
                                v-for="item in medici"
                                :key="item.key"
                                :label="item.label"
                                :value="item.value"
                            />
                        </el-select>
                    </el-form-item>
                </el-col>
            </el-row>
        </div>
    </el-form>
</template>

<script>

export default {
    name: "header appuntamenti",
    emits:["cambiaMedico","cambiaAmbulatorio"],
    props: {
        ambulatori: Object,
        medici: Object,
        filter: Object,
    },
    mounted() {
        this.medico = this.medici[0].id;
        this.ambulatorio = this.ambulatori[0].id;
    }
}
</script>
