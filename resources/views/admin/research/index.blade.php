@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Collector</div>
                    <div class="card-body">
                        <a href="{{ url('/admin/research/create') }}" class="btn btn-success btn-sm" title="Add New Collector">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <form method="GET" action="{{ url('/admin/research') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <span class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-striped sorting tablesorter">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Name</th><th>Status</th><th>Comment</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($collector as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }} {{ $item->surname }}</td>
                                        <td>
                                            {!! Form::select('research_status', \App\Collector::researchStatuses(), $item->research_status, [
                                                'class' => 'form-control',
                                                'data-id' => $item->id,
                                                'data-field' => 'research_status'
                                            ]) !!}                                        </td>
                                        <td>
                                            {{ $item->research_comment }}
                                        </td>
                                        <td>
                                            <a href="{{ url('/admin/research/' . $item->id) }}" title="View Collector"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/admin/research/' . $item->id . '/edit') }}" title="Edit Collector"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
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
        (function($) {
            var filters = {
                'status': '',
            };

            var textExtractor = function(node) {
                var $node = $(node);
                var value =  $node.find('input').val() || $node.find('select').val() || $node.text();
                return value;
            };

            var update = function(_this) {
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
                }, function(msg) {
                    console.log(msg);
                }, function(msg) {
                    alert('error: ', msg.error_text);
                }, 'research_flow', 'POST');
            };

            $(document).ready(function(){
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

                $('tbody').on('change', '.form-control', function() {
                    var _this = $(this);
                    update(_this);
                });
            });
        })($ || jQuery);
    </script>
@endsection
