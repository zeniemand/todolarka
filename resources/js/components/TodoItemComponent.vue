<template>

    <tr  >
        <th>
            <span v-bind:class="{done: todo.completed}">

                <input type="checkbox" @change="todo.completed = !todo.completed" > Задача №{{index + 1}} : {{todo.list | uppercase}}
            </span>
        </th>
        <th><button class="rm" v-on:click="$emit('remove-todo', todo.id)" >&times;</button></th>
    </tr>
</template>

<script>
    export default {
        name: "todoitem",
        data(){
            return {
                    title: '',
                    is_checked: false
                }

        },
        props:{
            todo:{
                type: Object,
                required: true
            },
            index:{
                type: Number
            }
        },
        filters: {
          uppercase(value){
              return value.toLocaleUpperCase()
          }
        }
    }
</script>

<style scoped>
    .rm {
        background: red;
        color: #fff;
        border-radius: 50%;
        font-weight: bold;
    }

    /* Класс, для зачеркивания списка, когда нажали выполнено: */
    .done {
        text-decoration: line-through;
    }

</style>