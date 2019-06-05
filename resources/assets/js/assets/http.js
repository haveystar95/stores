import Axios                from 'axios'

import laroute              from './laroute'
import config               from '../config'
import store                from '../store'
import objectToFormData     from "./object-to-formdata"

const http = Axios.create({
    baseURL: config.http.url,
    headers: config.http.defaultRequest.headers
});

/**
 * Sets the X-CSRFToken header for ajax non-GET request to make CSRF protection easy.
 */
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    http.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Add a request and response interceptor
 */
const beforeRequestSuccess = (config) =>
{
    config.headers.Authorization = `Bearer ${localStorage.getItem('token')}`;

    // store.dispatch('setLoading', true);

    return config;
};

const beforeRequestError = (error) =>
{
    // store.dispatch('setLoading', false);

    return Promise.reject(error);
};

const onSuccess = (response) =>
{
    // store.dispatch('setLoading', false);

    return response;
};

const onError = (error) =>
{
    switch (error.response.status) {
        case 401:
            store.dispatch('logout');
            break;
        default:
            break;
    }

    store.dispatch('setLoading', false);

    return Promise.reject(error);
};

http.interceptors.request.use(beforeRequestSuccess, beforeRequestError);
http.interceptors.response.use(onSuccess, onError);

/**
 * Laroute API
 *
 * @param name
 * @param parameters
 * @param data
 * @param formData
 * @returns {*}
 */
const api = (name, parameters = {}, data = {}, formData = false) =>
{
    let apiName = 'api.' + name;
    let route = laroute.get(apiName, parameters);

    if (typeof route === 'undefined' && config.debug === true) {
        console.error('Error, this route was not found', apiName, parameters);
        return {};
    }

    if (formData) {
        data = objectToFormData(data);
    }

    return http({
        url:    route.url,
        method: route.method.toLowerCase(),
        data:   data
    }).then(response => response.data).catch(error => Promise.reject(error.response));
};

export { http, api }
