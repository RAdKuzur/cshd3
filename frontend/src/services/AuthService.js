import axios from "axios";

axios.defaults.withCredentials = true;

const API_URL = "http://localhost:8000/api";

export default {
    async login(login, password) {
        const response = await axios.post(`${API_URL}/login`, { login, password });
        return response.data;
    },

    async check() {
        return axios.get(`${API_URL}/check`);
    },

    async logout() {
        await axios.post(`${API_URL}/logout`);
    },

    // Добавляем метод для проверки статуса авторизации
    async isAuthenticated() {
        try {
            await this.check();
            return true;
        } catch (error) {
            return false;
        }
    }
};