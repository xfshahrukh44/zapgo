<div class="form-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('name', 'First Name') !!}
                {!! Form::text('name', $users->name ?? '', ['class' => 'form-control', 'required' => 'required']) !!}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('lname', 'Last Name') !!}
                {!! Form::text('lname', $users->last_name ?? '', ['class' => 'form-control', 'required' => 'required']) !!}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('email', 'Email') !!}
                {!! Form::email('email', $users->email ?? '', ['class' => 'form-control', 'required' => 'required']) !!}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('password', 'Password') !!}
                {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('password_confirmation', 'Confirm Password') !!}
                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('address', 'Address') !!}
                {!! Form::text('address', $users->address ?? '', ['class' => 'form-control', 'required' => 'required']) !!}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('state', 'State') !!}
                <select name="state" class="form-control" required>
                    <option value="">Select State</option>
                    @foreach($states as $val)
                        <option value="{{ $val }}" {{ $users->state == $val ? 'selected' : '' }}>{{ $val }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('city', 'City') !!}
                {!! Form::text('city', $users->city, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('zip', 'ZIP Code') !!}
                {!! Form::text('zip', $users->zip, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('role', 'Role') !!}
                <select name="role" class="form-control" required>
                    <option value="">Select State</option>
                    @foreach($roles as $val)
                        <option value="{{ $val->id }}" {{ $users->role == $val->id ? 'selected' : '' }}>{{ $val->name }}</option>
                    @endforeach
                </select>
                {{-- {!! Form::select('role', $roles, $users->role, ['class' => 'form-control', 'required' => 'required']) !!} --}}
            </div>
        </div>
        </div>
</div>

<div class="form-actions text-right pb-0">
    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Update', ['class' => 'btn btn-primary']) !!}
</div>
