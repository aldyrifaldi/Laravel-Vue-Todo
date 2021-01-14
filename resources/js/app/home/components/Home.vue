<template>
    <div>
        <TopBar/>
        <div class="container mt-3">
            <div class="row">
                <div class="col-10">
                    <div class="form-group">
                    <input v-model="inputSearch" @keyup="search" type="text" placeholder="Search here....." class="form-control rounded">
                    </div>
                </div>
                <div class="col-auto text-right align-self-center">
                    <div class="form-group align-self-center">
                        <button class="btn btn-sm btn-primary btn-block" @click="openModalCreate">Add</button>
                    </div>
                </div>
            </div>
            <div class="card" v-if="todos.data.length == 0">
                <div class="card-body">
                    <h4 class="text-center text-capitalize text-muted">Todo Tidak ada</h4>
                </div>
            </div>
            <div class="row mb-4">
                <div v-for="todo in todos.data" :key="todo.id" class="col-md-4 my-2">
                    <div class="card">
                        <div class="card-header text-right">
                            <button @click="openModalUpdate(todo.id)" class="btn btn-outline-warning">edit</button>
                            <button @click="remove(todo.id)" class="btn text-cap btn-outline-danger">delete</button>
                            <button @click="checkTodo(todo.id)" class="btn text-cap btn-outline-success">Check</button>
                        </div>
                        <div class="card-body">
                            <h4>{{todo.title}}</h4>
                            <p>{{todo.text}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal tambah todo -->
        <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 ref="modalTitle" class="modal-title">Add Your Todo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form ref="formTodo" @submit.prevent="submitTodo">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="form-group">
                              <label for="">Title</label>
                              <input ref="formTitle"  type="text" name="title" id="title" v-model="title" class="form-control" placeholder="Type your title" aria-describedby="helpId">
                              <!-- <small class="text-danger" v-if="errors.title">{{errors.title[0]}}</small> -->
                            </div>
                            <div class="form-group">
                              <label for="">Text</label>
                              <textarea  type="text" name="text" id="text" v-model="text" class="form-control" rows="5" placeholder="Type your text" aria-describedby="helpId"></textarea>
                              <!-- <small class="text-danger" v-if="errors.text">{{errors.text[0]}}</small> -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TopBar from "../../../components/TopBar"
import {mapActions,mapGetters} from "vuex";
export default {
    data() {
        return {
            title: null,
            text: null,
            inputSearch: null,
        }
    },
    components: {
        TopBar
    },
    computed: {
        ...mapGetters({
            todos: "home/todos"
        }),
    },
    mounted: function() {
        this.getTodos({
            payload: {
                completed: 0,
            }
        })
    },
    methods: {
        ...mapActions({
            addTodo: "home/addTodo",
            getTodos: "home/getTodos",
            getTodo: "home/getTodo",
            deleteTodo: "home/deleteTodo",
            updateTodo: "home/updateTodo",
            searchTodo: "home/searchTodo",
            checkUncheck: "home/checkUncheck",
        }),
        submitTodo() {
            let submitButton = $('button[type=submit]')
            submitButton.html(`
                <i class="fas fa-circle-notch fa-spin   "></i>
            `)
            let dataId = this.$refs.formTitle.attributes.data
            if (dataId) {
                this.updateTodo({
                    payload: {
                        id: dataId,
                        title: this.title,
                        text: this.text,
                        completed: 0,
                    }
                })
                .then((res) => {
                    submitButton.html(`
                        <i class="fas fa-check    "></i>
                    `)
                    $('.modal').modal('hide')
                    $('.modal').on('hidden.bs.modal', function () {
                        submitButton.html('Save')
                    });
                    this.form.reset()
                })
               .catch((err) => {
                   submitButton.html(`
                        Save
                    `)
                })
            }
            else {
                this.addTodo({
                    payload: {
                        title: this.title,
                        text: this.text,
                        completed: 0,
                    },
                })
                .then((res) => {
                    submitButton.html(`
                        <i class="fas fa-check    "></i>
                    `)
                    $('.modal').modal('hide')
                    $('.modal').on('hidden.bs.modal', function () {
                        submitButton.html('Save')
                    });
                    this.form.reset()
                })
               .catch((err) => {
                   submitButton.html(`
                        Save
                    `)
                })
            }
        },
        remove(id) {
            this.deleteTodo({
                payload: {
                    id:id,
                    completed: 0,
                }
            })
        },
        openModalCreate() {
            this.title = ''
            this.text = ''
            this.$refs.formTitle.removeAttribute('data')
            this.$refs.modalTitle.innerHTML = 'Tambah Todo'
            $('.modal').modal('show')
        },
        openModalUpdate(id) {
            this.$refs.modalTitle.innerHTML = 'Ubah Todo'
            this.$refs.formTitle.attributes.data = id
            this.getTodo({
                payload: {
                    id:id,
                }
            })
            .then((res) => {
                console.log(res.title);
                this.title = res.title
                this.text = res.text
                $('.modal').modal('show')
            })
        },
        search() {
            this.searchTodo({
                payload: {
                    search_query: this.inputSearch,
                    completed: 0,
                }
            })
        },
        checkTodo(id) {
            this.checkUncheck({
                payload: {
                    id: id,
                    completed: 1
                }
            })
        }
    }
}
</script>
