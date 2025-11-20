import axios from "axios";

axios.defaults.withCredentials = true; // важно для HttpOnly cookies

const API_URL = "http://localhost:8000/api";

export default {
    // Логин
    async login(login, password) {
        const response = await axios.post(`${API_URL}/login`, { login, password });
        return response.data; // сервер уже выставляет access_token + refresh_token в cookie
    },

    // Проверка авторизации
    async check() {
        return axios.get(`${API_URL}/check`); // эндпоинт на бэкенде возвращает 200 если токен валидный
    },

    // Логаут
    async logout() {
        await axios.post(`${API_URL}/logout`);
    }
};