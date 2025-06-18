<template>
    <div class="card-item-container">
        <!-- <div class="card-learned-progress">
            <div>
                <el-text size="large" type="danger">{{ learnedProgress[0] }}</el-text> / <el-text size="large">{{ learnedProgress[1] }}</el-text>
                <el-button @click="refresh" type="warning" text>刷新</el-button>
            </div>
        </div> -->
        <div class="card-title">{{ currentWord.word }}<el-text> [{{ currentWord.romanization }}]</el-text></div>
        <div class="card-meanings">
            <el-scrollbar>
                <div v-for="meaning in currentWord.meanings" class="card-meaning-item">
                    <div class="meaning-item">
                        <el-text class="card-meaning-pos" type="danger">{{ meaning.pos }}</el-text>
                        <el-text v-if="meaning.origin" size="small" type="info">【词源：{{ meaning.origin }}】</el-text>
                        <el-text size="large" >{{ meaning.word_cn }}</el-text>
                    </div>
                    <div class="meaning-item">
                        <el-text type="info">【释义】</el-text>
                        <el-text>{{ meaning.definition_ko }}</el-text>
                        <el-text>（{{ meaning.definition_cn }}）</el-text>
                    </div>
                    <div v-if="meaning.example" class="meaning-item">
                        <el-text type="info">【例句】</el-text>
                        <el-text>{{  meaning.example[0].ko }}</el-text>（<el-text>{{  meaning.example[0].cn }}</el-text>）
                    </div>
                    <div class="meaning-item" v-if="meaning.synonym">
                        <el-text type="info">【同义】</el-text>
                        <el-text>{{ formatMeaningData(meaning.synonym) }}</el-text>
                    </div>
                    <div class="meaning-item" v-if="meaning.antonym">
                        <el-text type="info">【反义】</el-text>
                        <el-text>{{ formatMeaningData(meaning.antonym) }}</el-text>
                    </div>
                </div>
            </el-scrollbar>
        </div>
    </div>
</template>

<script setup>
import { onMounted,computed } from 'vue'
import { wordStore } from '@s'
const word = wordStore()

const props = defineProps({
    currentWord: {
        type: Object,
        required: true,
    },
    learnedProgress: {
        type: Array,
        default: [0,0],
        required: true
    }
})

// function refresh(){
//     let forceRefresh = true
//     word.fetchTodayWord(forceRefresh)
// }

const formatMeaningData = (data) => {

    return data.join(', ')
}

</script>

<style scoped>
.card-item-container {
    width: 80vw;
    height: calc(100vh - 100px);
}
.card-title {
    font-size: 2em;
    text-align: center;
}
.card-learned-progress {
    position: absolute;
    right: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.card-meanings {
    height: calc(100vh - 270px);
    margin-top: 20px;
}
.card-meaning-item {
    margin-bottom: 20px;
}
.card-meaning-pos {
    margin-right: 10px;
}
.meaning-item {
    margin-bottom: 10px;
}
</style>