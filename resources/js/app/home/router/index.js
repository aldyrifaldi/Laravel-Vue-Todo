import {CompletedTasks, Home} from "../components"

export default [
    {
        path: "/",
        name: "home",
        component: Home,
        meta: {
            guest: false,
            authenticated: true
        }
    },
    {
        path: "/completed-tasks",
        name: "completed-tasks",
        component: CompletedTasks,
        meta: {
            guest: false,
            authenticated: true
        }
    }
]
