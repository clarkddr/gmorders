<template>
    <div class="min-h-screen bg-gray-900 text-gray-100">
        <header class="border-b border-gray-800 bg-gray-900/80 backdrop-blur">
            <div class="max-w-7xl mx-auto px-4 py-4">
                <h1 class="text-lg font-semibold">{{ title }}</h1>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 py-6">
            <div class="rounded-lg shadow-md bg-gray-900 border border-gray-800 p-6">
                <slot></slot>
            </div>
        </main>
    </div>
</template>

<script setup>
const props = defineProps({
    title: String
});
</script>
