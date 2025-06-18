<template>
    <div class="page-home-container">
        <div class="home-card">
            <el-card>
                <div class="home-avatar">
                    <img style="width: 100%; height: 100%" src="@/assets/logo.svg" />
                </div>
                <el-text>开发者：songlin1221@icloud.com</el-text>
            </el-card>
        </div>
    </div>
</template>

<script setup>

</script>

<style scoped>
.page-home-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100vw;
    height: calc(100vh - 100px);
}
.home-card {
    width: 50vw;
    height: 50vh;
}
.home-avatar {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 10vh;
}
</style>