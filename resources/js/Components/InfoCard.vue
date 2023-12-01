<template>
    <div class="statistic-card">
        <el-statistic :value="Intl.NumberFormat('it-IT', { maximumSignificantDigits: 3 }).format(value)" title="New transactions today">
            <template #title>
                <div class="flex inline-flex items-center text-xl">
                    {{ title }}
                </div>
            </template>
        </el-statistic>
        <div class="statistic-footer">
            <div class="footer-item">
                <span>{{ subTitle }}</span>
<!--                Intl.NumberFormat('it_IT').format(value)
Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(value)
-->
<!--                <span class="green">-->
<!--                  {{  Intl.NumberFormat("en-IN", { maximumSignificantDigits: 3 }).format(percent)  }}-->
<!--                    <component :is="icon" class="w-4 h-4" />-->
<!--                </span>-->
            </div>
            <div class="footer-item ">
                <a :href="route(link)">
                    <component :is="linkIcon" class="w-4 h-4" />
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import {ArrowRight, CaretTop} from "@element-plus/icons-vue";

export default {
    name: "InfoCard",
    components: {ArrowRight, CaretTop},
    props: {
        title: String,
        icon: String,
        percent: Number,
        value: String,
        subTitle: String,
        linkIcon: String,
        link: String,
    },
    mounted() {
        console.log(this.value);
    }
}
</script>


<style scoped>
:global(h2#card-usage ~ .example .example-showcase) {
    background-color: var(--el-fill-color) !important;
}

.el-statistic {
    --el-statistic-content-font-size: 28px;
}

.statistic-card {
    height: 100%;
    padding: 20px;
    border-radius: 4px;
    background-color: var(--el-bg-color-overlay);
    border: 1px #6b7280 solid;
}

.statistic-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    font-size: 12px;
    color: var(--el-text-color-regular);
    margin-top: 16px;
}

.statistic-footer .footer-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.statistic-footer .footer-item span:last-child {
    display: inline-flex;
    align-items: center;
    margin-left: 4px;
}

.green {
    color: var(--el-color-success);
}
.red {
    color: var(--el-color-error);
}

</style>
