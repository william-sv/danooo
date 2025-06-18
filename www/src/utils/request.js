import axiosInstance from "./axios"


const request = {
    get (url, params = {}) {
        return axiosInstance.get(url, { params })   
            .then(response => {
                return response
            })
            .catch(error => {
                console.error('GET request failed:', error);
                
                throw error;  
            })
    },
    post(url, data={}) {
        return axiosInstance.post(url, data)
            .then(response => {
                return response
            })
            .catch(error => {
                console.error('POST request failed:', error);
                
                throw error;  
            })
    }
}

export default request