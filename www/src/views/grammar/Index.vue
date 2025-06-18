<template>
    <div class="grammar-container">
        <div>
            <GrammarItem :currentGrammar="current" :learnedProgress="learnedProgress"  />
            <div class="card-learned-progress">
                <div class="learned-progress-item">
                    <el-text size="large" type="danger">{{ learnedProgress[0] }}</el-text> / <el-text size="large">{{ learnedProgress[1] }}</el-text>
                    <el-button @click="refresh" type="warning" text>刷新</el-button>
                </div>
            </div>
            <div class="grammar-card-button-items">
                <el-row :gutter="20">
                    <el-col :span="6"><el-button  class="el-button-item" type="primary" @click="prevBtn">上一个</el-button></el-col>
                    <el-col :span="6"><el-button  class="el-button-item" type="primary">收藏</el-button></el-col>
                    <el-col :span="6"><el-button  class="el-button-item" type="primary">跳过</el-button></el-col>
                    <el-col :span="6"><el-button  class="el-button-item" type="primary" @click="nextBtn">下一个</el-button></el-col>
                </el-row>
            </div>
        </div>
        

    </div>
</template>

<script setup>
import GrammarItem from '@c/grammar/GrammarItem.vue'
import {ref, reactive, onMounted} from 'vue'
import { grammarStore } from '@s'


const grammar = grammarStore()
const { current,learnedProgress } = storeToRefs(grammar)

function prevBtn(){
    grammar.prev()  
}
function nextBtn(){
    grammar.next()
}
function refresh(){
     grammar.fetchNextDatGrammar()
}

onMounted(() => {
    grammar.fetchTodayGrammar()
})

</script>

<style scoped>
.grammar-container {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100vw;
    height: calc(100vh - 60px);
}
.card-learned-progress {
    position: absolute;
    bottom: 60px;
    display: flex;
    justify-content: center;
    align-items: center;
    width:80vw;
}
.learned-progress-item {
    width: 60vw;
    text-align: center;
}
.grammar-card-button-items{
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