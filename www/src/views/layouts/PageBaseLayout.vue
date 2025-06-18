<template>
    <div id="page_base_layout_container">
        <el-container>
            <el-header>
                <PageHeader />
            </el-header>
            <el-main>
                <PageMain />
            </el-main>
        </el-container>
    </div>
</template>

<script setup>
import PageMain from '@v/layouts/PageMain.vue'
import PageHeader from '@v/layouts/PageHeader.vue'
</script>

<style scoped>
.el-main {
    width: 100vw;
    height: calc(100vh - 60px);
    padding: 0;
}
.el-header {
    padding: 0;
}
</style>