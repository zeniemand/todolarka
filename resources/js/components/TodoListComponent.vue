<template>
     <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="addTask">
                    <add-todo
                            v-bind:todos="todos"
                            v-on:addTodo="addTodo"

                    />
                    </div>

                    <hr>

                    <div class="card-header">Список задач:</div>
                    <label for="mySel">Сортировать задания:</label>
                    <select name="mySel" id="mySel" v-model="filter">
                        <option value="all">Все</option>
                        <option value="completed">Выполненные</option>
                        <option value="not-completed">Не завершенные</option>
                    </select>

                    <Loader v-if="loading"/>

                    <div class="card-body">
                        <table class="table">
                            <div v-if="empty">
                                <thead class="thead-dark">
                                <tr >
                                    <th>Задача</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>


                                <todoitem
                                        v-for="(todo, index) of filteredTodos"
                                        v-bind:todo="todo"
                                        v-bind:index="index"
                                        v-on:remove-todo="removeTodo"
                                />

                                </tbody>
                            </div>
                            <div v-else>
                                <tr >
                                    <td>нет задач</td>
                                </tr>
                            </div>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import todoitem from './TodoItemComponent'
    import addTodo from './AddTodoComponent'
    import Loader from './LoaderComponent'
    export default {
        name: "TodoListComponent",
        components: {
            todoitem,
            addTodo,
            Loader
        },
        data(){
            return{
                empty: true,
                todo: {},
                loading: true,
                todos: [],
                is_refresh: false,
                filter: 'all'
            }
        },
        computed: {
            filteredTodos(){

                switch (this.filter){
                    case 'all':
                        return this.todos
                    break
                    case 'completed':
                        return this.todos.filter(t => t.completed )
                    break
                    case 'not-completed':
                        return this.todos.filter(t => !t.completed )
                    break
                }
            }
        },
        mounted(){
            this.getTodos()
        },
        methods: {
            checkTodos(){

                //Если получаем пустой не массив и существующую переменную впринципе:
                if(typeof   this.todos !== 'undefined' && this.todos.length > 0){
                    return
                }
                else{
                    this.empty = false
                }

            },
            removeTodo(id){

                //Удаление элемента из БД:
                axios.post('/delete-todo', {id}).then(response => {
                    if(response.data === 1) this.getTodos()
                })

            },
            addTodo(text){

                axios.post('/add-todo', {text}).then(response => {
                    //Обновляем список данных из бд:
                    this.getTodos()
                })

            },
            getTodos(){
                axios.get('/get-todos').then(response => {
                    //Для наслаждения лодером, задается искуственная задержка:
                    setTimeout(() => {
                        //данные ответа сервера собираются в массив тудус:
                        this.todos = response.data
                        this.checkTodos()
                        //Убераем лодер, передавая значение флагу:
                        this.loading = false
                    }, 1000)


                })
            }
        }


    }
</script>

<style scoped>

.addTask {
    padding-top: 20px;
}


</style>