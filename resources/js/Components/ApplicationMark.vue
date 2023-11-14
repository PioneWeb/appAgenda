<template>
    <img :src="isDark ? '/storage/logoNero.jpg' : '/storage/logoBianco.jpg'" alt="Logo" />
</template>
<script setup>
import { useDark } from '@vueuse/core';
const isDark = useDark()
</script>
