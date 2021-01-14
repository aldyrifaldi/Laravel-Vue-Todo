import {isEmpty} from 'lodash';

export const setHttpToken = token => {
        if (isEmpty(token)) {
            // if token empty set default header authorization to null
            window.axios.defaults.headers.common['Authorization'] = null
        }
        window.axios.defaults.headers.common['Authorization'] = "Bearer "+token
}



export function setupInterceptor(redirector) {
    window.axios.interceptors.response.use((resp) => {
        if (resp.status == 401) {
            redirector();
            return resp;
        } else {
            return resp;
        }
    },(err) => {
        const route = err.response.config.route;
        if (route == 'login' || route == 'register') {
            return Promise.reject(err)
        }
        if (err.response.status == 401) {
            redirector();
            return err;
        } else {
            return err;
        }
    });
}
