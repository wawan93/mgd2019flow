@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Собеседования</div>
          <div class="card-body">
            <form method="GET" action="{{ url('/admin/interview') }}" accept-charset="UTF-8"
                class="form-inline my-2 my-lg-0 float-right" role="search">
              <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Поиск..."
                     value="{{ request('search') }}">
                <span class="input-group-append">
                  <button class="btn btn-secondary" type="submit">
                    <i class="fa fa-search"></i>
                  </button>
                </span>
              </div>
            </form>

            <br/>
            <br/>
            <div class="">
              <table class="table table-striped sorting tablesorter collector-table interview-table">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Имя</th>
                  <th>Телефон</th>
                  <th>Email</th>
                  <th>Вердикт ресерча</th>
                  <th>Комментарий ресерча</th>
                  <th>Дата интервью</th>
                  <th>Статус</th>
                  <th>Вердикт</th>
                  <th>Коммент</th>
                  <th>Паспорт</th>
                </tr>
                </thead>
                <tbody>
                @foreach($collector as $item)
                  <?php /** @var \App\Collector $item */ ?>
                  <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->surname }} {{ $item->name }} {{ $item->middlename }} </td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->research_status_text }}</td>
                    <td>{{ $item->research_comment }}</td>
                    <td>
                      <input
                          data-id="{{ $item->id }}"
                          data-field="interview_date"
                          name="interview_date"
                          type="datetime-local"
                          class="form-control"
                          style="width: 220px;"
                          value="{{ $item->interview_date ?
                           \Carbon\Carbon::createFromTimeString($item->interview_date)->toDateTimeLocalString() :
                            "" }}"
                      />
                    </td>
                    <td>
                      {!! Form::select('status', \App\Collector::allStatuses(), $item->status, [
                        'class' => 'form-control',
                        'data-id' => $item->id,
                        'style' => 'min-width: 120px',
                        'data-field' => 'status'
                      ]) !!}
                    </td>
                    <td>
                      {!! Form::select('interview_status', \App\Collector::researchStatuses(), $item->interview_status, [
                        'class' => 'form-control',
                        'data-id' => $item->id,
                        'style' => 'min-width: 120px',
                        'data-field' => 'interview_status'
                      ]) !!}
                    </td>
                    <td>
                      {!! Form::textarea(
                        'comment',
                        $item->comment,
                        [
                          'class' => 'form-control',
                          'data-id' => $item->id,
                          'style' => 'min-width: 120px',
                          'rows' => '3',
                          'data-field' => 'comment',
                        ]
                      ) !!}
                    </td>
                    <td class="collector-table__passport">
                      <a class="collector-table__toggle-passport-button" href="#">показать (2/4)</a>
                      <div class="collector-table__passport-fields">
                        <label class="col-form-label col-form-label-sm">
                          Фамилия
                          {!! Form::text(
                              'surname',
                              $item->surname,
                              [
                                'class' => 'form-control form-control-sm',
                                'data-id' => $item->id,
                                'data-field' => 'surname',
                                'placeholder' => 'Константинопольский',
                                'style' => 'min-width: 120px',
                              ]
                          ) !!}
                        </label>
                        <label class="col-form-label col-form-label-sm">
                          Имя
                          {!! Form::text(
                              'name',
                              $item->name,
                              [
                                'class' => 'form-control form-control-sm',
                                'data-id' => $item->id,
                                'data-field' => 'name',
                                'placeholder' => 'Константин',
                                'style' => 'min-width: 120px',
                              ]
                          ) !!}
                        </label>
                        <label class="col-form-label col-form-label-sm">
                          Отчество
                          {!! Form::text(
                              'middlename',
                              $item->middlename,
                              [
                                'class' => 'form-control form-control-sm',
                                'data-id' => $item->id,
                                'data-field' => 'middlename',
                                'placeholder' => 'Константинович',
                                'style' => 'min-width: 120px',
                              ]
                          ) !!}
                        </label>
                        <label class="col-form-label col-form-label-sm">
                          Дата рождения
                          {!! Form::date(
                              'birthday',
                              $item->birthday,
                              [
                                'class' => 'form-control form-control-sm',
                                'data-id' => $item->id,
                                'data-field' => 'birthday',
                                'style' => 'min-width: 120px',
                              ]
                          ) !!}
                        </label>
                        <label class="col-form-label col-form-label-sm">
                          Серия и номер
                          {!! Form::text(
                              'passport_number',
                              $item->passport_number,
                              [
                                'class' => 'form-control form-control-sm',
                                'data-id' => $item->id,
                                'data-field' => 'passport_number',
                                'placeholder' => '0000 111111',
                                'style' => 'min-width: 120px',
                                'maxlength' => '20'
                              ]
                          ) !!}
                        </label>
                        <label class="col-form-label col-form-label-sm">Дата выдачи
                          {!! Form::date(
                              'passport_issue_date',
                              $item->passport_issue_date,
                              [
                                'class' => 'form-control form-control-sm',
                                'data-id' => $item->id,
                                'data-field' => 'passport_issue_date',
                                'style' => 'min-width: 120px',
                              ]
                          ) !!}
                        </label>
                        <label class="col-form-label col-form-label-sm">Выдан
                        {!! Form::textarea(
                            'passport_issued_by',
                            $item->passport_issued_by,
                            [
                              'class' => 'form-control form-control-sm',
                              'data-id' => $item->id,
                              'data-field' => 'passport_issued_by',
                              'placeholder' => 'УФМС России по г. Москве...',
                              'rows' => '3',
                            ]
                        ) !!}
                        </label>
                        <label class="col-form-label col-form-label-sm">Прописка
                          {!! Form::textarea(
                              'passport_address',
                              $item->passport_address,
                              [
                                'class' => 'form-control form-control-sm',
                                'data-id' => $item->id,
                                'data-field' => 'passport_address',
                                'placeholder' => 'Пятницкая 31с2',
                                'rows' => '3',
                              ]
                          ) !!}
                        </label>
                      </div>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
              <div class="pagination-wrapper"> {!! $collector->appends(['search' => Request::get('search')])->render() !!} </div>
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

        smartAjax('/admin/ajax/interview/save', {
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

        $('tbody').on('change', '.form-control', function () {
          var _this = $(this);
          update(_this);
        });
      });
    })($ || jQuery);
  </script>
@endsection
