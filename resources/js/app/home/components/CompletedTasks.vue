<template>
    <div>
        <TopBar/>
         <div class="card mt-4" v-if="todos.data.length == 0">
            <div class="card-body">
                <h4 class="text-center text-capitalize text-muted">Not Have Completed Tasks</h4>
            </div>
        </div>
        <div class="card mt-4" v-if="todos.data.length > 0">
            <div class="row mb-4">
                <div v-for="todo in todos.data" :key="todo.id" class="col-md-4 my-2">
                    <div class="card">
                        <div class="card-header text-right">
                            <button @click="uncheckTodo(todo.id)" class="btn text-cap btn-outline-danger">Uncheck</button>
                        </div>
                        <div class="card-body">
                            <h4>{{todo.title}}</h4>
                            <p>{{todo.text}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TopBar from "../../../components/TopBar"
import {mapActions,mapGetters} from "vuex";

export default {
    components: {
        TopBar
    },
    mounted: function() {
        this.getTodos({
            payload: {
                completed: 1,
            }
        })
    },
    computed: {
        ...mapGetters({
            todos: "home/todos"
        })
    },
    methods: {
        ...mapActions({
            checkUncheck: "home/checkUncheck",
            getTodos: "home/getTodos"
        }),
        uncheckTodo(id) {
            this.checkUncheck({
                payload: {
                    id: id,
                    completed: 0
                }
            })
        }
    }
}
</script>
