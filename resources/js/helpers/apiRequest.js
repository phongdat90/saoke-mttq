import axios from 'axios';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

export const apiRequest = (url, methodType, data = {}, multipart = false, config = {}) => {
    let headers;
    headers = {};
    if (multipart) {
        headers['content-type'] = 'multipart/form-data';
    }
    return new Promise(
        (resolve, reject) => {
            axios({
                method: methodType,
                url: url,
                data: data,
                headers: headers,
                ...config
            })
                .then(response => {
                    resolve(response);
                })
                .catch(function (error) {
                    // if (error.response && error.response.status === 401) {
                    //     window.location.href = '/login';
                    //     //window.location.href = window.location.pathname.split('/')[1] + '/login';
                    // } else if (error.response && error.response.status === 403) {
                    //     window.location.href = '/401'
                    // }

                    reject(error.response);
                });
        });
};

export const buildParams = params =>  {
    if (!params) {
        return '';
    }
    let arr = [];
    Object.keys(params).forEach(function(key) {
        if (key !== 'filter') arr.push(`${key}=${encodeURIComponent(params[key])}`)
    });
    return '?' + arr.join('&');
};

