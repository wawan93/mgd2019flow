@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Отклонённые</div>
          <div class="card-body">
            <form method="GET" action="{{ url('/admin/accepted') }}" accept-charset="UTF-8"
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
              <table class="table table-striped sorting tablesorter">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Имя</th>
                  <th>Телефон</th>
                  <th>Email</th>
                  <th>Статус</th>
                  <th>Вердикт ресерча</th>
                  <th>Комментарий ресерча</th>
                  <th>Дата интервью</th>
                  <th>Коммент</th>
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
                    <td>
                        {!! Form::select('status', \App\Collector::allStatuses(), $item->status, [
                            'class' => 'form-control',
                            'data-id' => $item->id,
                            'style' => 'min-width: 150px',
                            'data-field' => 'status'
                        ]) !!}
                    </td>
                    <td>
                        {!! Form::select('research_status', \App\Collector::researchStatuses(), $item->research_status, [
                            'class' => 'form-control',
                            'data-id' => $item->id,
                            'style' => 'min-width: 150px',
                            'data-field' => 'research_status'
                        ]) !!}
                    </td>
                    <td>{{ $item->research_comment }}</td>
                    <td>
                      <input
                          data-id="{{ $item->id }}"
                          data-field="interview_date"
                          name="interview_date"
                          type="datetime-local"
                          class="form-control"
                          style="width: 250px;"
                          value="{{ $item->interview_date ?
                           \Carbon\Carbon::createFromTimeString($item->interview_date)->toDateTimeLocalString() :
                            "" }}"
                      />
                    </td>
                    <td>
                      {!! Form::textarea(
                        'comment',
                        $item->comment,
                        [
                          'class' => 'form-control',
                          'data-id' => $item->id,
                          'style' => 'min-width: 300px',
                          'rows' => '3',
                          'cols' => '20',
                          'data-field' => 'comment',
                        ]
                      ) !!}
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

        smartAjax('/admin/ajax/declined/save', {
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
