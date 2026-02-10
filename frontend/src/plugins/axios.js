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

axios.interceptors.response.use(
    response => response,
    error => {
        const authStore = useAuthContextStore();

        if (error.response?.status === 401) {
            Cookies.remove("access_token");
            Cookies.remove("refresh_token");
            authStore.user = null;
            // придумать перенаправление (см. пример ниже)
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
