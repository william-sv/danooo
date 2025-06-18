<template>
    <div class="card-item-container">
        <!-- <div class="card-learned-progress">
            <el-text size="large" type="danger">{{ learnedProgress[0] }}</el-text> / <el-text size="large">{{ learnedProgress[1] }}</el-text>
            <el-button @click="refresh" type="warning" text>刷新</el-button>
        </div> -->
        <div class="card-title">{{ currentGrammar.grammarForm }}</div>
        <div class="card-meanings">
            <el-scrollbar>
                <div v-for="meaning in currentGrammar.meaning" class="meaning-items">
                    <div class="meaning-item">
                        <el-text type="info">【释义】</el-text>
                        <el-text>{{ meaning.meaningKorean }}</el-text>
                        <el-text>（{{ meaning.meaningChinese }}）</el-text>
                    </div>
                    <div v-if="meaning.examples" class="meaning-item">
                        <el-text type="info">【例句】</el-text>
                        <el-text>{{ meaning.examples[0].korean }}</el-text>
                        <el-text>（{{ meaning.examples[0].chinese }}）</el-text>
                    </div>
                    
                </div>
                <div v-if="currentGrammar.conjugationRules" class="meaning-item">
                    <div v-if="currentGrammar.conjugationRules.adjective">
                        <div  class="meaning-item">
                            <el-text type="danger" size="large">【形容词】</el-text>
                        </div>
                        <div  class="meaning-item">
                            <el-text type="info">【规则】</el-text>
                            <el-text>{{ currentGrammar.conjugationRules.adjective.rules }}</el-text>
                        </div>
                        <div  class="meaning-item" v-if="currentGrammar.conjugationRules.adjective.tense">
                            <el-text type="info">【时态】</el-text>
                            <el-text>{{ currentGrammar.conjugationRules.adjective.tense.pastTense }}, </el-text>
                            <el-text>{{ currentGrammar.conjugationRules.adjective.tense.presentTense }}, </el-text>
                            <el-text>{{ currentGrammar.conjugationRules.adjective.tense.futureTense }}</el-text>
                        </div>
                    </div>
                </div>
                <div v-if="currentGrammar.conjugationRules" class="meaning-item">
                    <div v-if="currentGrammar.conjugationRules.verb">
                        <div  class="meaning-item">
                            <el-text type="danger" size="large">【动词】</el-text>
                        </div>
                        <div  class="meaning-item">
                            <el-text type="info">【规则】</el-text>
                            <el-text>{{ currentGrammar.conjugationRules.verb.rules }}</el-text>
                        </div>
                        <div  class="meaning-item" v-if="currentGrammar.conjugationRules.verb.tense">
                            <el-text type="info">【时态】</el-text>
                            <el-text>{{ currentGrammar.conjugationRules.verb.tense.pastTense }}, </el-text>
                            <el-text>{{ currentGrammar.conjugationRules.verb.tense.presentTense }}, </el-text>
                            <el-text>{{ currentGrammar.conjugationRules.verb.tense.futureTense }}</el-text>
                        </div>
                    </div>
                </div>
                <div v-if="currentGrammar.conjugationRules" class="meaning-item">
                    <div v-if="currentGrammar.conjugationRules.noun">
                        <div  class="meaning-item">
                            <el-text type="danger" size="large">【名词】</el-text>
                        </div>
                        <div  class="meaning-item">
                            <el-text type="info">【规则】</el-text>
                            <el-text>{{ currentGrammar.conjugationRules.noun.rules }}</el-text>
                        </div>
                        <div  class="meaning-item">
                            <el-text type="info">【时态】</el-text>
                            <el-text>{{ currentGrammar.conjugationRules.noun.tense.pastTense }}, </el-text>
                            <el-text>{{ currentGrammar.conjugationRules.noun.tense.presentTense }}, </el-text>
                            <el-text>{{ currentGrammar.conjugationRules.noun.tense.futureTense }}</el-text>
                        </div>
                    </div>
                </div>
            </el-scrollbar>
        </div>
    </div>
</template>

<script setup>
import { onMounted,computed } from 'vue'
import { grammarStore } from '@s'

const grammar = grammarStore()

const props = defineProps({
    currentGrammar: {
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
//      grammar.fetchTodayGrammar(forceRefresh)
// }

const formatAppliesToData = (data,title) => {

    return data.join('/ ') + ' - ' + title
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
    height: calc(100vh - 250px);
    margin-top: 20px;
}
.meaning-items {
    margin-bottom: 20px;
}
.meaning-item {
    margin-bottom: 10px;
}
</style>