import axios from "axios";
import Cookies from "js-cookie";

axios.defaults.withCredentials = true;

axios.interceptors.request.use(config => {
    const token = Cookies.get("access_token");
    if (token) config.headers.Authorization = `Bearer ${token}`;
    return config;
});

axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response?.status === 401) {
            // Обработка 401 - неавторизован
            Cookies.remove("access_token");
            Cookies.remove("refresh_token");
            localStorage.removeItem('username');
            localStorage.removeItem('fio');
            window.location.href = "/login";
        } else if (error.response?.status === 403) {
            window.location.href = "/error";
        }
        return Promise.reject(error);
    }
);

export default axios;