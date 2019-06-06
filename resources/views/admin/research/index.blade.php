@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Ресёрч</div>
                    <div class="card-body">
                        <form method="GET" action="{{ url('/admin/research') }}" accept-charset="UTF-8"
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
                                    <th>dob</th>
                                    <th>about</th>
                                    <th>Гражданство</th>
                                    <th>Соцсети</th>
                                    <th>Статус</th>
                                    <th>Вердикт</th>
                                    <th>Коммент</th>
                                    <th>Дата</th>
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
                                        <td>{{ $item->birthday }}</td>
                                        <td>{{ $item->aboutself }}</td>
                                        <td>{{ $item->has_citizenship }}</td>
                                        <td>
                                            @if($item->social_vk)
                                                <span>
                                                    VK: <a target="_blank" href="{{ $item->social_vk }}">{{ $item->social_vk }}</a>
                                                </span> <br>
                                            @endif
                                            @if($item->social_tw)
                                                <span>
                                                    TW: <a target="_blank" href="{{ $item->social_tw }}">{{ $item->social_tw }}</a>
                                                </span> <br>
                                            @endif
                                            @if($item->social_fb)
                                                <span>
                                                    FB: <a target="_blank" href="{{ $item->social_fb }}">{{ $item->social_fb }}</a>
                                                </span> <br>
                                            @endif
                                            @if($item->social_other)
                                                <span>
                                                    {{ $item->social_other }}
                                                </span>
                                            @endif
                                        </td>
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
                                        <td>
                                            {!! Form::textarea(
                                                'research_comment',
                                                $item->research_comment,
                                                [
                                                    'class' => 'form-control',
                                                    'data-id' => $item->id,
                                                    'style' => 'min-width: 300px',
                                                    'rows' => '4',
                                                    'cols' => '20',
                                                    'data-field' => 'research_comment',
                                                ]
                                            ) !!}
                                        </td>
                                        <td>
                                            {{ $item->date }}
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

                smartAjax('/admin/ajax/research/save', {
                    id: id,
                    field: field,
                    value: value,
                    _method: "PATCH",
                }, function (msg) {
                    console.log(msg);
                }, function (msg) {
                    alert('error: ', msg.error_text);
                }, 'research_flow', 'POST');
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
