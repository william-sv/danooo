import { createApp } from 'vue'
import ElementPlus from 'element-plus'
import zhCn from 'element-plus/es/locale/lang/zh-cn'
import 'element-plus/theme-chalk/el-message.css'
import 'element-plus/theme-chalk/display.css'
import 'element-plus/theme-chalk/el-loading.css'

import '@/styles/base_style.css'

import App from './App.vue'
import router from './router'
import pinia from './stores'

const app = createApp(App)

app.use(ElementPlus, {
    locale: zhCn,
})


app.use(pinia)
app.use(router)
app.mount('#app')
