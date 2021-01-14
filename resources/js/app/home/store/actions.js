import { reject } from "lodash";
import {setHttpToken} from "../../../helpers";


export const addTodo = ({dispatch},{payload,context}) => {
    return new Promise((resolve,reject) => {
        axios.post("api/todo",payload)
        .then((res) => {
            dispatch("getTodos",{
                payload: {
                    completed: payload.completed
                }
            })
            resolve()
        })
        .catch((err) => {
            reject(err.response)
        })
    })
}


export const getTodos = ({commit},{payload}) => {
    return new Promise((resolve,reject) => {
        axios.get("api/todo?completed="+ payload.completed)
        .then((res) => {
            commit('setTodos',res.data.data)
            resolve(res.data.data)
        })
        .catch(err => {
            reject()
        })
    })
}

export const getTodo = ({commit},{payload}) => {
    return new Promise((resolve,reject) => {
        axios.get("api/todo/"+payload.id)
        .then((res) => {
            resolve(res.data.data)
        })
        .catch(err => {
            reject(err.response)
        })
    })
}

export const searchTodo = ({commit},{payload}) => {
    return axios.get("api/todo?search_query="+payload.search_query)
    .then((res) => {
                console.log(res.data.data);
                commit('setTodos',res.data.data)
    })
}


export const deleteTodo = ({dispatch},{payload}) => {
    return new Promise((resolve,reject) => {
        axios.delete("api/todo/"+payload.id)
        .then(res => {
            dispatch("getTodos",{
                payload: {
                    completed: payload.completed
                }
            })
            resolve()
        })
        .catch((err) => {
            reject()
        })
    })
}


export const checkUncheck = ({dispatch},{payload}) => {
    return new Promise((resolve,reject) => {
        axios.post("api/todo/check-uncheck/"+payload.id+"?_method=put",payload)
        .then(res => {
            console.log(payload);
            dispatch("getTodos",{
                payload: {
                    completed: payload.completed == 0 ? 1 : 0
                }
            })
            resolve()
        })
        .catch(err => {
            reject()
        })
    })
}

export const updateTodo = ({dispatch},{payload}) => {

    return new Promise((resolve,reject) => {
        axios.put("api/todo/"+payload.id,payload)
        .then(res => {
            dispatch("getTodos",{
                payload: {
                    completed: payload.completed
                }
            })
            resolve()
        })
        .catch(err => {
            reject()
        })
    })
}
