<template>
    <img :src="isDark ? '/storage/logoNero.png' : '/storage/logoBianco.png'" alt="Logo" />
</template>
<script setup>
import { useDark } from '@vueuse/core';
const isDark = useDark()
</script>
