import Vue from "vue";
import beforeEach from "./beforeEach"
import VueRouter from "vue-router";
import auth from "../app/auth/router";
import home from "../app/home/router";

// merge all routes in one const
const routes = [...auth,...home]

Vue.use(VueRouter)

const router = new VueRouter({
    mode: "history",
    routes, // global declaration
})

router.beforeEach(beforeEach)

export default router;
