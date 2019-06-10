@extends('layouts.app')

@section('content')
  <div class="container-fluid">
  <div class="row">
  <div class="col-md-12">
  <div class="card">
    <div class="card-header">События</div>
    <div class="card-body">
      <form method="GET" action="{{ url('/admin/events') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
        <div class="input-group">
          <input type="text" class="form-control" name="search" placeholder="Поиск..." value="{{ request('search') }}">
          <span class="input-group-append">
            <button class="btn btn-secondary" type="submit">Искать</button>
          </span>
        </div>
      </form>
      <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#newEvent">
        Создать событие
      </button>
      <div class="modal fade new-event-modal" id="newEvent" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Новое событие</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <label>Название</label>
                <input name="name" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>Дата и время</label>
                <input name="starts_at" type="datetime-local" class="form-control">
            </div>
            <div class="form-group">
                <label>Максимально число участников</label>
                <input name="max_attendees" type="number" class="form-control">
            </div>
            <div class="form-group">
                <label>Участники</label>
                <select name="collectors" type="text" class="form-control new-event-modal__collectors">
                @foreach($acceptedCollectors as $collector)
                  <option value="{{$collector->id}}">{{$collector->surname}} {{$collector->name}}</option>
                @endforeach
                </select>
                <small id="emailHelp" class="form-text text-muted">Начните вводить имя или фамилию сборщика</small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            <button type="button" class="btn btn-primary">Сохранить</button>
          </div>
          </div>
        </div>
      </div>
    <br/>
    <br/>
    <div>
    <table class="table table-striped sorting tablesorter">
    <thead>
      <tr>
      <th>#</th>
      </tr>
    </thead>
      <tbody>
      @foreach($events as $event)
      <?php /** @var \App\Event $event */ ?>
      <tr>
        <td>{{ $item->id }}</td>
      </tr>
      @endforeach
      </tbody>
    </table>
    <div class="pagination-wrapper"> {!! $events->appends(['search' => Request::get('search')])->render() !!} </div>
    </div>
    </div>
  </div>
  </div>
  </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript" src="/js/jquery.tablesorter.min.js"></script>
  <script type="text/javascript">
  (function ($) {
  var filters = {
  'status': '',
  };

  var textExtractor = function (node) {
  var $node = $(node);
  var value = $node.find('input').val() || $node.find('select').val() || $node.text();
  return value;
  };

  var update = function (_this) {
  var id = _this.data('id');
  var field = _this.data('field');
  var value = _this.val();
  if (_this.attr('type') == 'checkbox') {
    value = _this.prop('checked');
  }

  smartAjax('/admin/ajax/accepted/save', {
    id: id,
    field: field,
    value: value,
    _method: "PATCH",
  }, function (msg) {
    console.log(msg);
  }, function (msg) {
    alert('error: ', msg.error_text);
  }, 'interview_flow', 'POST');
  };

  $(document).ready(function () {
  $('.filter').on('change', function (e) {
    var _this = $(this);
    var filter = _this.attr('name').split(/.+\[(.+)\]/)[1];
    var value = _this.val();
    filters[filter] = value;
    console.log($('#filter-form').submit());
  });

  $('.tablesorter').tablesorter({
    textExtraction: textExtractor
  });

  $('tbody').on('change', '.form-control, .ajaxable', function () {
    var _this = $(this);
    update(_this);
  });
  });
  })($ || jQuery);
  </script>
@endsection
