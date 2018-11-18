import axios from 'axios'

export default() => {
    return axios.create({
        baseURL: `http://intraportal.net/im/api`,
        withCredentials: false,
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
}
