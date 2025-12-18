import axios from "axios";
import {BACKEND_URL} from "@/router.js";

export const createSimpleThing = async (dataToSend) => {
    const response = await axios.post(
        BACKEND_URL + '/api/things/store',
        dataToSend,
        {
            headers: {
                'Content-Type': 'application/json',
            }
        }
    )
    return response
}

export const createCompositeThing = async (dataToSend) => {
    const response = await axios.post(
        BACKEND_URL + '/api/things/composite-store',
        dataToSend,
        {
            headers: {
                'Content-Type': 'application/json',
            }
        }
    )
    return response
}