@if($users->isNotEmpty())
        <select name="user_id" class="form-control{{ $errors->has('user_id') ? ' is-invalid' : '' }}" required autofocus
                @if(!empty($form)) onchange="event.preventDefault(); document.getElementById('{{ $form }}').submit();" @endif
        >
            @if(!empty($default)) <option>{{ $default }}</option> @endif

            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach

        </select>
@endif
