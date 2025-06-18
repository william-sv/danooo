<template>
    <div class="word-container">
        <div>
            <WordItem :currentWord="current" :learnedProgress="learnedProgress"  />
            <div class="card-learned-progress-items">
                <el-row>
                    <el-col :span="10"><el-text type="danger">{{ learnedProgress[0] }}</el-text> / <el-text>{{ learnedProgress[1] }}</el-text><el-divider direction="vertical" /></el-col>
                    <el-col :span="10"><el-text type="danger">{{ learnedProgress[2] }}</el-text> / <el-text>{{ learnedProgress[3] }}</el-text><el-divider direction="vertical" /></el-col>
                    <el-col :span="4"><el-button @click="refresh" size="small" type="warning" text>刷新</el-button></el-col>
                </el-row> 
            </div>
            <div class="word-card-button-items">
                <el-row :gutter="20">
                    <el-col :span="6"><el-button class="el-button-item" type="primary" @click="prevBtn">上一个</el-button></el-col>
                    <el-col :span="6"><el-button class="el-button-item" type="primary">收藏</el-button></el-col>
                    <el-col :span="6"><el-button class="el-button-item" type="primary">跳过</el-button></el-col>
                    <el-col :span="6"><el-button class="el-button-item" type="primary" @click="nextBtn">下一个</el-button></el-col>
                </el-row>
            </div>
        </div>
    </div>
</template>

<script setup>
import WordItem from '@c/word/WordItem.vue'
import {ref, reactive, onMounted} from 'vue'
import { wordStore } from '@s'


const word = wordStore()
const { current,learnedProgress } = storeToRefs(word)

function prevBtn(){
    word.prev()  
}
function nextBtn(){
    word.next()
}
function refresh(){
    word.fetchNextDatWord()
}
onMounted(() => {
    word.fetchTodayWord()
})

</script>

<style scoped>
.word-container {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100vw;
    height: calc(100vh - 60px);
}
.card-learned-progress-items {
    position: fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    width:80vw;
    bottom: 60px;
}
.word-card-button-items{
    position: fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    width:80vw;
    bottom: 20px;
}
.btn-items {
    width: 5vw;
    height: 20vw;
}
.el-button-item {
    width: 100%;
}
</style>