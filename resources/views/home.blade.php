@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Перевод денег</div>

                <div class="card-body">

                    @if(session('status') == 'success')
                        <div class="alert alert-success" role="alert">
                            Операция проведена. ${{ price_format(session('amount')) }} были зарезервированы с вашего счета.
                        </div>
                    @elseif(session('status') == 'fail')
                        <div class="alert alert-danger" role="alert">
                            Ошибка. Не достаточно средств на счете.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('enroll') }}" id="transfer-form">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">Пользователь</label>

                            <div class="col-md-6">
                                <select name="receiver_id" class="form-control{{ $errors->has('receiver_id') ? ' is-invalid' : '' }}" required autofocus>
                                    @if(!empty($default)) <option>{{ $default }}</option> @endif

                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach

                                </select>

                                @if ($errors->has('receiver_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('receiver_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount" class="col-sm-4 col-form-label text-md-right">Сумма</label>

                            <div class="col-md-6">
                                <input id="amount" type="number" step=".01" min="1" max="{{ auth()->user()->balance }}" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" required>

                                @if ($errors->has('amount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-sm-4 col-form-label text-md-right">Дата и время</label>

                            <div class="col-md-4">
                                <input id="date" type="date" name="date" class="form-control{{ $errors->has('date_time') ? ' is-invalid' : '' }}" required>
                            </div>
                            <div class="col-md-2 pl-0">
                                <input id="time" type="time" name="time" class="form-control{{ $errors->has('date_time') ? ' is-invalid' : '' }}" required>
                            </div>
                            <div class="col-md-6 offset-md-4">
                                <input id="datetime" type="hidden" name="date_time" class="form-control{{ $errors->has('date_time') ? ' is-invalid' : '' }}">

                                @if ($errors->has('date_time'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_time') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Перевести
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Завершенные операции</div>

                <div class="card-body">
                    <table width=100% class="table table-hover">
                        <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Тип</th>
                            <th>Кому / От кого</th>
                            <th>Сумма</th>
                        </tr>
                        </thead>

                        @foreach($flow as $operation)
                            <tr>
                                <td>{{ dt_format($operation->updated_at) }}</td>
                                <td>{{ $operation->is_transfer ? 'Перевод' : 'Поступление' }}</td>
                                <td>{{ $operation->name }}</td>
                                <td>${{ $operation->amount }}</td>
                            </tr>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
