<template>
    <div id="page_main_container">
        <RouterView />
    </div>
</template>

<script setup>

</script>

<style scoped>
#page_main_container {
    width: 100vw;
    height: calc(100vh - 60px);
    padding: 0;
    margin: 0;
    overflow-y: auto;
    overflow-x: hidden;
}
</style>