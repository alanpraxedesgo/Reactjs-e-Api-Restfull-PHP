import React from "react";
import axios from 'axios';

const api = axios.create({
    baseURL:"http://localhost/taskdev/api/"
});

api.interceptors.response.use(function(response){
    return response;
},function(error){
    return Promise.reject(error);
})

api.interceptors.request.use(function(request){
    const app_name = process.env.REACT_APP_NAME;
    const token = localStorage.getItem("@Permission"+app_name+":token");
    if(token && request.url.indexOf('viacep') === -1 && request.url.indexOf('googleapis') === -1){
        request.headers.authorization = `Bearer ${token}`;
    }
    return request;
})

export default api;