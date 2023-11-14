<template>
    <component :class="item.type" @click="item.click()" class="inline-flex items-center p-1 border-gray-600 text-gray-500 border rounded-md text-sm w-24">
        <slot name="append" />
            <component :is="item.icon" class="inline-flex items-center w-4 h-4 mr-2" />
            {{ item.name }}
        <slot />
    </component>
</template>

<script>
import {CirclePlus, DeleteFilled, Edit, Printer, Lock} from "@element-plus/icons-vue";

export default {
    name: "ActionButton",
    computed: {
        DeleteFilled() {
            return DeleteFilled
        },
        Printer() {
            return Printer
        },
        Edit() {
            return Edit
        },
        CirclePlus() {
            return CirclePlus
        }
    },
    props: {
        item: Object
    }
}
</script>

<style scoped>
/*.success{
    color: #13ce66;
    border-color: #13ce66;
}
.info{
    color: #a4a3a3;
    border-color: #a4a3a3;
}
.primary{
    color: #3266f3;
    border-color: #3266f3;
}
.danger{
    color: #f56c6c;
    border-color: #f56c6c;
}
.warning{
    color: #e6a23c;
    border-color: #e6a23c;
}
.default{
    color: #ccc;
    border-color: #666;
}*/
.success:hover{
    color: #FFF;
    background-color: #13ce66;
}
.info:hover{
    color: #FFF;
    background-color: #a4a3a3;
}
.primary:hover{
    color: #FFF;
    background-color: #3266f3;
}
.danger:hover{
    color: #FFF;
    background-color: #f56c6c;
}
.warning:hover{
    color: #FFF;
    background-color: #e6a23c;
}
.default:hover{
    color: #3768f1;
    border-color: #141414;
    background-color: #141414;
}
</style>


<!--<el-button class="button text-indigo-700 " type="success" :icon="CirclePlus" plain @click="open"><span>{{ $t('Nuovo') }}</span></el-button>-->
<!--<el-button class="button text-indigo-700 " type="info" :icon="Edit" plain @click="open"><span>{{ $t('Save') }}</span></el-button>-->
<!--<el-button class="button text-indigo-700 " type="primary" :icon="Printer" plain @click="open"><span>{{ $t('Print') }}</span></el-button>-->
<!--<el-button class="button text-indigo-700 " type="danger" :icon="DeleteFilled" plain @click="open"><span>{{ $t('Delete') }}</span></el-button>-->
