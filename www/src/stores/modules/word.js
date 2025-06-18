import { defineStore } from 'pinia';
import dayjs from 'dayjs';
import _ from 'lodash';
import { ElMessage,ElLoading} from 'element-plus'


import { getWordsForToday,getWordForChallenge,getWordsForNextDay } from '@/api/word'

export const wordStore = defineStore('word', {
    state: () =>({
        _todayWord: [],
        _current: {},
        _learned: [],
        _unlearned: [],
        _challengeWord: {},
        _current_day: 1,
        _current_day_count: 1,
        loadedTimestamp: 0
    }),
    getters: {
        todayWord(state){
            return state._todayWord
        },
        current(state){
            return state._current
        },
        current_day(state){
            return state._current_day
        },
        current_day_count(state){
            return state._current_day_count
        },
        challengeWord(state){
            return state._challengeWord
        },
        learnedProgress(state){
            return [state._learned.length + 1, state._todayWord.length, state._current_day, state._current_day_count]
        },
    },
    actions: {
        async fetchTodayWord(){
            const todayTimestamp = dayjs().startOf('day').unix();
            const cachedTimestamp = this.loadedTimestamp;
            if(cachedTimestamp == todayTimestamp  && this._todayWord.length > 0){
                return;
            }
            const loadingInstance = ElLoading.service()
            const data = await getWordsForToday();
            this.setTodayWord(data['words'],data['day'],data['day_count'])
            this.loadedTimestamp = todayTimestamp;
            loadingInstance.close()
            ElMessage({
                type: 'success',
                message: '数据已更新！'
            })
        },
        async fetchNextDatWord(){
            const loadingInstance = ElLoading.service()
            const todayTimestamp = dayjs().startOf('day').unix();
            const data = await getWordsForNextDay();
            this.setTodayWord(data['words'],data['day'],data['day_count'])
            this.loadedTimestamp = todayTimestamp;
            loadingInstance.close()
            ElMessage({
                type: 'success',
                message: '数据已更新！'
            })

        },
        async fetchChallengeWord(){
            const data = await getWordForChallenge()
            this._challengeWord = data
        },
        setTodayWord(data,day,day_count){
            this._todayWord = data
            this._learned = []
            this._current = data[0]
            this._unlearned = _.tail(data)
            this._current_day = day
            this._current_day_count = day_count
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