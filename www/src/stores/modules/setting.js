import { defineStore } from 'pinia';

export const settingStore = defineStore('setting', {
    state: () =>({
        _headerMenus: [
            { path: '/word', label: '单词' },
            { path: '/grammar', label: '语法' },
            { path: '/home', label: '我的' }
        ],
        _menuActivePath: '/',
    }),
    getters: {
        headerMenus(state){
            return state._headerMenus
        },
        menuActivePath(state){
            return state._menuActivePath
        }
    },
    actions: {
        setMenuActivePath(data){
            this._menuActivePath = data
        }
    },
    persist: true
})