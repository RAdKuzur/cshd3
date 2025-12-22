import axios from 'axios'
import Cookies from 'js-cookie'
import { BACKEND_URL } from '@/router.js'

axios.defaults.withCredentials = true

export async function loginApi(email, password) {
    const res = await axios.post(`${BACKEND_URL}api/login`, { email, password })
    return res.data
}

export async function logoutApi() {
    Cookies.remove('access_token')
    Cookies.remove('refresh_token')
    return axios.post(`${BACKEND_URL}api/logout`)
}

export async function refreshApi() {
    const res = await axios.post(`${BACKEND_URL}api/refresh`)
    return res.data
}
