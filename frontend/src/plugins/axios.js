import axios from "axios";
import Cookies from "js-cookie";
import { useAuthContextStore } from "@/services/AuthContext";

axios.defaults.withCredentials = true;

axios.interceptors.request.use(config => {
    const token = Cookies.get("access_token");
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

axios.interceptors.response.use(
    response => response,
    error => {
        const authStore = useAuthContextStore();

        if (error.response?.status === 401) {
            Cookies.remove("access_token");
            Cookies.remove("refresh_token");
            authStore.user = null;
        }

        if (error.response?.status === 403) {
            // опционально: флаг в store
        }

        return Promise.reject(error);
    }
);

export default axios;
