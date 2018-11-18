import axios from 'axios'

export default() => {
    return axios.create({
        baseURL: `http://intraportal.net/im/api`,
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
            
        }
    })
}
