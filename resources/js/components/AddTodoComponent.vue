<template>
    <form v-on:submit.prevent="onSubmit">
        <input type="text" v-model="title">
        <button type="submit">Добавить задачу</button>
    </form>
</template>

<script>
    export default {
        name: "AddTodoComponent",
        data(){
            return {
                title: '',
                todos_new: this.todos
            }
        },
        props:[
            'todos'
        ],
        methods:{
            onSubmit(){
                //если в строке есть нечто записанное, то генерируется событие добавления:
                if(this.title.trim()){
                    //генерация события и передача с ним данных:
                    this.$emit('addTodo', this.title)
                    //Очищение строки ввода:
                    this.title = ''
                }

            }
        }
    }
</script>

<style scoped>

    form {
        display: flex;
    }

    input {
        width: 400px;
    }

</style>