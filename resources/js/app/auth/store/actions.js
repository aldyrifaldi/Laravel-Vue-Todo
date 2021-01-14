import {isEmpty} from "lodash";
import {setHttpToken} from "../../../helpers";

export const login = ({dispatch},{payload,context}) => {
    return axios.post("api/auth/login",payload,{route: "login"})
                .then((res) => {
                    dispatch('setToken',res.data.meta.token)
                    .then(() => {
                        dispatch("fetchUser",res.data.data)
                    })
                    return Promise.resolve()
                })
                .catch((err) => {
                    context.errors = err.response.data.errors
                    return Promise.reject()
                })
}

export const register = ({dispatch},{payload,context}) => {
    return axios.post("api/auth/register",payload)
                .then((res) => {
                    dispatch('setToken',res.data.meta.token)
                    .then(() => {
                        dispatch('fetchUser',res.data.data)
                    })
                    return Promise.resolve()
                })
                .catch((err) => {
                    context.errors = err.response.data.errors
                    return Promise.reject()
                })
}

export const logout = ({dispatch}) => {
    return axios.post("api/auth/logout")
            .then((res) => {
                dispatch('removeToken')
            })
            .catch(() => {
            })
}


export const setToken = ({commit,dispatch},token) => {
    if (isEmpty(token)) {
        return dispatch('checkTokenExists').then((res) => {
            // if token exist set default header authorization axios
            setHttpToken(token)
        })
    }
    // set token to localstorage
    commit('setToken',token)
    // set default header authorization axios
    setHttpToken(token)
}

export const removeToken = ({commit}) => {
    commit('setAuthenticated',false)
    commit('setUserData',null)
    commit('setToken',null)
    setHttpToken(null)
}

export const checkTokenExists = () => {
    const token = localStorage.getItem('access_token')
    if (isEmpty(token)) {
        return Promise.reject("NO_STORAGE_FOUND")
    }
    return Promise.resolve(token)
}


export const fetchUser = ({commit},user) => {
    axios.get("api/user")
    .then((res) => {
        commit('setAuthenticated',true)
        commit('setUserData',res.data)
    })
    .catch((err) => {
    })
}



