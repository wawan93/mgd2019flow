<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Name' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($collector->name) ? $collector->name : ''}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('surname') ? 'has-error' : ''}}">
    <label for="surname" class="control-label">{{ 'Surname' }}</label>
    <input class="form-control" name="surname" type="text" id="surname" value="{{ isset($collector->surname) ? $collector->surname : ''}}" >
    {!! $errors->first('surname', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Статус' }}</label>
    <select name="status" class="form-control" id="status" >
    @foreach (json_decode('{"new":"\u041d\u0435 \u043f\u0440\u043e\u0432\u0435\u0440\u0435\u043d","research":"\u0432 \u0440\u0438\u0441\u0451\u0440\u0447\u0435","research_done":"\u043f\u0440\u043e\u0448\u0451\u043b \u0440\u0438\u0441\u0451\u0440\u0447","interview_accepted":"\u0437\u0430\u043f\u0438\u0441\u0430\u043d \u043d\u0430 \u0441\u043e\u0431\u0435\u0441\u0435\u0434\u043e\u0432\u0430\u043d\u0438\u0435","accepted":"\u043f\u0440\u0438\u043d\u044f\u0442","declined":"\u043e\u0442\u043a\u043b\u043e\u043d\u0451\u043d","fired":"\u0443\u0432\u043e\u043b\u0435\u043d"}', true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($collector->status) && $collector->status == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
