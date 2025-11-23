import axios from "axios";

axios.defaults.withCredentials = true;

const API_URL = "http://localhost:8000/api";

export default {
    async login(login, password) {
        const response = await axios.post(`${API_URL}/login`, { login, password });
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
        await axios.post(`${API_URL}/logout`);
    },

    // Добавляем метод для очистки данных
    clearAuthData() {
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