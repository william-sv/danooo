import { defineStore } from 'pinia';
import dayjs from 'dayjs';
import _ from 'lodash';
import { ElMessage, ElLoading} from 'element-plus'


import { getGrammarsForToday,getGrammarForChallenge,getGrammarsForNextDay } from '@/api/grammar'

export const grammarStore = defineStore('grammar', {
    state: () =>({
        _todayGrammar: [],
        _current: {},
        _learned: [],
        _unlearned: [],
        _challengeGrammar: {},
        loadedTimestamp: 0
    }),
    getters: {
        todayGrammar(state){
            return state._todayGrammar
        },
        current(state){
            return state._current
        },
        challengeGrammar(state){
            return state._challengeGrammar
        },
        learnedProgress(state){
            return [state._learned.length + 1, state._todayGrammar.length]
        },
    },
    actions: {
        async fetchTodayGrammar(forceRefresh = false){
            const todayTimestamp = dayjs().startOf('day').unix();
            const cachedTimestamp = this.loadedTimestamp;
            if((!forceRefresh) && cachedTimestamp == todayTimestamp  && this._todayGrammar.length > 0){
                return;
            }
            const loadingInstance = ElLoading.service()
            const data = await getGrammarsForToday();
            this.setTodayGrammar(data['grammars'])
            this.loadedTimestamp = todayTimestamp;
            loadingInstance.close()
            ElMessage({
                type: 'success',
                message: '数据已更新！'
            })
        },
        async fetchNextDatGrammar(){
            const loadingInstance = ElLoading.service()
            const todayTimestamp = dayjs().startOf('day').unix();
            const data = await getGrammarsForNextDay();
            this.setTodayGrammar(data['grammars'])
            this.loadedTimestamp = todayTimestamp;
            loadingInstance.close()
            ElMessage({
                type: 'success',
                message: '数据已更新！'
            })

        },
        async fetchChallengeGrammar(){
            const data = await getGrammarForChallenge()
            this._challengeGrammar = data
        },
        setTodayGrammar(data){
            this._todayGrammar = data
            this._learned = []
            this._current = data[0]
            this._unlearned = _.tail(data)
        },
        prev(){
            if (_.isEmpty(this._learned)) {
                ElMessage({
                    type: 'warning',
                    message: '前面没有更多数据了！'
                })
                console.warn('没有已学数据可操作');
                return false;
            }
            const _moved = _.last(this._learned);
            this._learned = _.initial(this._learned);
            this._unlearned = _.concat([this._current], this._unlearned);
            this._current = _moved
        },
        next(){
            if (_.isEmpty(this._unlearned)) {
                ElMessage({
                    type: 'warning',
                    message: '后面没有更多数据了！'
                })
                console.warn('没有未学数据可操作');
                return false;
            }
            const _moved = _.head(this._unlearned);
            this._unlearned = _.tail(this._unlearned);
            this._learned = _.concat(this._learned, [this._current]);
            this._current = _moved
        },
    },
    persist: true
})