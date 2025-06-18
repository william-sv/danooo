import axios from "axios"
import { ElMessage } from 'element-plus'

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

const axiosInstance = axios.create({
    // baseURL: "https://api.songji.top",
    baseURL: API_BASE_URL,
    timeout: 30000,
    headers: { "Content-Type": "application/json;charset=UTF-8", 'X-Requested-With': 'XMLHttpRequest' },
    withCredentials: true
})

axiosInstance.interceptors.request.use(
    config => {
        config.headers['Authorization'] = 'Bearer c89s7ZM9E0iCWPm7XsvKw0zrBvzYEppY'
        // config.headers['Authorization'] = `Bearer ${userStore.token}`
        const csrfToken = document.cookie.match(/csrfToken=([^;]+)/)?.[1]
        if (csrfToken) {
            config.headers['x-csrf-token'] = csrfToken
        }
        return config
    },
    error => {
        return Promise.reject(error)
    }
)

axiosInstance.interceptors.response.use(
    (response) => {
        const { code, message, data } = response.data
        if(code !== 200 ){
            ElMessage.error(message || '请求失败')
            return Promise.reject(new Error(message || '请求失败'))
        }
        return data
    },
    (error) => {
        if(error.response){
            const { status } = error.response
            let errorMessage = '请求失败'
            switch (status) {
                case 400:
                  errorMessage = '请求参数错误'
                  break
                case 401:
                  errorMessage = '请重新登录'
                  break
                case 500:
                  errorMessage = '服务器内部错误'
                  break
                default:
                  errorMessage = error.message
                  break
              }
            ElMessage.error(errorMessage)
        } else {
            ElMessage.error('网络错误，请稍后再试')
        }

        return Promise.reject(error)
    }
)

export default axiosInstance