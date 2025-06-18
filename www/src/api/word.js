import request from "@u/request";

const pathLists = {
    'wordsForToday': '/word/today',
    'wordsForNextDay': '/word/next-day',
    'wordForChallenge': '/word/challenge'
}

export const getWordsForToday = () => {
    return request.get(pathLists['wordsForToday'])
    .then(response => {
        return response
    })
    .catch(error => {
        throw error
    })
}

export const getWordsForNextDay = () => {
    return request.get(pathLists['wordsForNextDay'])
    .then(response => {
        return response
    })
    .catch(error => {
        throw error
    })
}

export const getWordForChallenge = () => {
    return request.get(pathLists['wordForChallenge'])
    .then(response => {
        return response
    })
    .catch(error => {
        throw error
    })
}