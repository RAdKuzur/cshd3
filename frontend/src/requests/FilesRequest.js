import axios from "axios";
import {BACKEND_URL, FILES_URL} from "@/router.js";



export const createFile = async (dataToSend) => {
    const response = await axios.post(
        FILES_URL + '/upload',
        dataToSend
        // Content-Type не указываем - axios сам выставит multipart/form-data с boundary
    );
    return response;
};

export const GetFile = async (fileId) => {
    const response = await axios.get(
        FILES_URL + '/' + fileId // Уточните правильный endpoint
    );
    return response;
};

export const DeleteFile = async (fileId) => {
    const response = await axios.delete(
        FILES_URL + '/' + fileId // Уточните правильный endpoint
    );
    return response;
};

export const createFilePHP = async (dataToSend) => {
    const response = await axios.post(
        BACKEND_URL + '/api/files',
        dataToSend,
        {
            headers: {
                'Content-Type': 'application/json',
            }
        }
    )
    return response
}

export const GetFilesListPHP = async (tableName,rowID) => {
    const response = await axios.get(
        BACKEND_URL + '/api/files/' + tableName + "/row/" + rowID
    );
    return response;
}

export const DeleteFilePHP = async (fileId) => {
    const response = await axios.delete(
        BACKEND_URL + '/api/files/' + fileId
    )
    return response
}