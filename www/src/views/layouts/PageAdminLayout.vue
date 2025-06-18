<template>
    <div id="page_admin_layout_container">
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

</style>