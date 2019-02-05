@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Последние переводы пользователей</div>

                    <div class="card-body">
                        <table width=100% class="table table-hover">
                            <thead>
                            <tr>
                                <th>Дата перевода</th>
                                <th>Имя пользователя</th>
                                <th>Сумма</th>
                                <th>Статус</th>
                                <th></th>
                            </tr>
                            </thead>

                            @foreach($users as $user)
                                <tr>
                                    <td>{{ dt_format($user->transfer_date) }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>${{ $user->transfer_amount }}</td>
                                    <td>{{ $user->transfer_status ? 'Завершен' : 'В ожидании' }}</td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
