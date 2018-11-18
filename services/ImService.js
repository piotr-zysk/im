import Api from '@/../services/Api'

export default {
    getGroups () {
        return Api().get('/groups')
    },
    getTest (params) {
        return Api().get('/groups?limit=1&headword=' + params.word)
    }
}