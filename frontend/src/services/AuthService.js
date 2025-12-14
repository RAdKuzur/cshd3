import axios from "axios";
import Cookies from "js-cookie";
import {BACKEND_URL} from "@/router.js";

axios.defaults.withCredentials = true;


export default {
    async login(email, password) {
        const response = await axios.post(`${BACKEND_URL}api/login`, { email, password });
        if (response.data) {
            localStorage.setItem('username', response.data.username);
            localStorage.setItem('fio', response.data.fio);
        }
        return response.data;
    },

    async check() {
        try {
            const response = await axios.get(`${API_URL}/check`);
            localStorage.setItem('username', response.data.username);
            localStorage.setItem('fio', response.data.fio);
            return response;
        } catch (error) {
            console.error('Check failed:', error);
            this.clearAuthData();
            throw error;
        }
    },

    async logout() {
        this.clearAuthData();
        await axios.post(`${BACKEND_URL}api/logout`);
    },

    // Добавляем метод для очистки данных
    clearAuthData() {
        Cookies.remove('access_token')
        Cookies.remove('refresh_token')
        localStorage.removeItem('username');
        localStorage.removeItem('fio');
    },

    getProfile() {
        return {
            username: localStorage.getItem('username'),
            fio: localStorage.getItem('fio')
        };
    }
};