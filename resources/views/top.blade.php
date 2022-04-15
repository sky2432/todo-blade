<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TodoList</title>
    <style>
        .container {
            width: 50%;
            margin: 0 auto;
        }

        th,
        td {
            border: 1px solid #ccc;
        }

        .error {
            color: red;
        }

    </style>
</head>

<body>
    <div class="container">
        <h1>TodoList</h1>
        <table>
            @foreach ($todos as $todo)
                <tr>
                    <td>
                        <form id="nameForm{{ $todo->id }}"
                            action="{{ route('todo.update', ['todo' => $todo->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="text" value="{{ $todo->name }}" name="name">
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('todo.complete', ['todo' => $todo->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="submit" value="完了">
                        </form>
                    </td>
                    <td>
                        <button type="submit" form="nameForm{{ $todo->id }}">変更</button>
                    </td>
                    <td>
                        <form action="{{ route('todo.destroy', ['todo' => $todo->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="削除">
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        <h2>新規登録</h2>
        <form action="{{ route('todo.store') }}" method="POST">
            @csrf
            <input type="text" name="name">
            <input type="submit" value="登録">
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
        </form>
    </div>
</body>

</html>
