import request from "@u/request";

const pathLists = {
    'grammarsForToday': '/grammar/today',
    'grammarsForNextDay': '/grammar/next-day',
    'grammarForChallenge': '/grammar/challenge'
}

export const getGrammarsForToday = () => {
    return request.get(pathLists['grammarsForToday'])
    .then(response => {
        return response
    })
    .catch(error => {
        throw error
    })
}
export const getGrammarsForNextDay = () => {
    return request.get(pathLists['grammarsForNextDay'])
    .then(response => {
        return response
    })
    .catch(error => {
        throw error
    })
}

export const getGrammarForChallenge = () => {
    return request.get(pathLists['grammarForChallenge'])
    .then(response => {
        return response
    })
    .catch(error => {
        throw error
    })
}