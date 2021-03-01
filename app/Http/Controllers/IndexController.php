<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\{Todo, User};

class IndexController extends Controller
{
    //
    public $title;

    public function __construct()
    {
        $this->title = 'Мой список дел';
    }


    public function index(){


        $data = Todo::all()->toArray();


        $todos = [];

        //Приведение данных из БД к нужному виду для передачи в компонент:
        foreach ($data as $key => $array){
            foreach($array as $val){
                $todos[] = $val;
            }
        }


        return view('site.index')->with([
            'title' => $this->title,
            'todos' => $data
        ]);
    }

    public function getTodos(){
        $todos = Todo::all()->toArray();

        return json_encode($todos);
    }

    public function addTodo(Request $request){

        //Создание экземпляра модели списка:
        $todo = new Todo();

        $todo->list = $request->text;
        $todo->completed = 0;

        if($todo->save()){
            return true;
        }

        return false;
    }

    public function deleteTodo(Request $request){
        $id = $request->id;

        $todo = Todo::find($id);

        if($todo->delete()) return true;

        return false;

    }

}
