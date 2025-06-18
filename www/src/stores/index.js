import { createPinia } from "pinia"
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

export * from './modules/user'
export * from './modules/setting'
export * from './modules/grammar'
export * from './modules/word'

const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

export default pinia