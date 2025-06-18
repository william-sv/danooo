<template>
    <div id="page_header_container">
        <el-row style="width: 100vw;">
            <el-col :lg="2" :xl="2" :md="3" class="hidden-sm-and-down">
                <a href="/"><img style="width: 100px; height: 50px" src="@/assets/logo.svg" alt="Site logo" /></a>
            </el-col>
            <el-col :lg="17" :xl="17" :md="15" class="hidden-sm-and-down"></el-col>
            <el-col :lg="5" :xl="5" :md="6">
                <el-menu mode="horizontal" :default-active="menuActivePath" :ellipsis="false" :router="true" @select="handleSelect">
                    <el-menu-item v-for="item in headerMenus" :index="item.path" :key="item.path">
                        {{item.label}}
                    </el-menu-item>
                </el-menu>
            </el-col>
        </el-row>
    </div>
</template>

<script setup>
import { ref,reactive } from 'vue'
import { settingStore } from '@s'

const setting = settingStore()
const { headerMenus,menuActivePath } = storeToRefs(setting)


const handleSelect = (key, keyPath) => {
  setting.setMenuActivePath = key
}
</script>

<style scoped>
#page_header_container {
    width: 100vw;
    height: 60px;
    max-height: 60px;
    border-bottom: 1px solid var(--el-menu-border-color);
}
.el-menu--horizontal.el-menu{
    border-bottom: none;
}

</style>