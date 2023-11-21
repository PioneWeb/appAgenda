

<template>
    <el-form :model="form" :inline="true" class="demo-form-inline">
        <div class="bg-slate-800 h-14 m-4 rounded-lg">
            <el-row :gutter="12">
                <el-col :span="6" class="m-1 p-2">
                    <el-form-item label="Ambulatorio" >
                        <el-select v-model="ambulatorio" class="m-0" placeholder="Select">
                            <el-option
                                v-for="item in ambulatori"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
                            />
                        </el-select>
                    </el-form-item>
                </el-col>
                <el-col :span="6" class="m-1 p-2">
                    <el-form-item label="Medico">
                        <el-select v-model="medico" class="m-0" placeholder="Select">
                            <el-option
                                v-for="item in medici"
                                :key="item.value"
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
    props: {
        ambulatori: Object,
        medici: Object,
    },
data() {
    return {
        ambulatori: 1,
        medici: 1
    }
    }
}
</script>
