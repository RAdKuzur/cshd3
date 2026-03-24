import axios from "axios";
import Cookies from "js-cookie";
import { useAuthContextStore } from "@/services/AuthContext";
import router from "@/router.js";

axios.defaults.withCredentials = true;

axios.interceptors.request.use(config => {
    const token = Cookies.get("access_token");
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

let isRefreshing = false;
let queue = [];

axios.interceptors.response.use(
    response => response,
    async error => {
        const authStore = useAuthContextStore();
        const originalRequest = error.config;

        if (error.response?.status === 400) {
            // Обработка сообщения об ошибке
            if(error.response?.data?.message === 'unsupported file type') {
                router.push('/bad-request');
            } else {
                // Общая обработка для других 400 ошибок
                router.push('/bad-request');
            }
        }

        if (error.response?.status === 401 && !originalRequest._retry) {console.log(originalRequest)
            if(error.response?.data?.error === 'Invalid signed url')
            {
                router.push('/signed-url-error');
            }

            originalRequest._retry = true;

            if (isRefreshing) {

                return new Promise((resolve) => {
                    queue.push(() => resolve(axios(originalRequest)));
                });
            }

            isRefreshing = true;

            try {
                await authStore.refresh();

                queue.forEach(cb => cb());
                queue = [];

                return axios(originalRequest);
            } catch (e) {
                authStore.user = null;
                router.push('/login');
            } finally {
                isRefreshing = false;
            }
        }

        if (error.response?.status === 403) {
            if(error.response?.data?.error === 'Licence error')
            {
                router.push('/licence-error');
            }
            else if(error.response?.data?.error === 'Tech work')  {
                router.push('/tech-work');
            }
            else if(error.response?.data?.error === 'Forbidden'){
                router.push('/forbidden');
            }
            else if(error.response?.data?.error === 'Develop'){
                router.push('/develop-page');
            }
        }
        if (error.response?.status === 404) {
            router.push('/not-found');
        }
        if (error.response?.status === 500) {
            router.push('/iternal-error');
        }

        return Promise.reject(error);
    }
);

export default axios;