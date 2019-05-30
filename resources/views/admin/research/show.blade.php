@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Collector {{ $collector->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/research') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/research/' . $collector->id . '/edit') }}" title="Edit Collector"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <?php
                                        /** @var \App\Collector $collector */
                                ?>
                                    <tr>
                                        <th>ID</th><td>{{ $collector->id }}</td>
                                    </tr>
                                    <tr><th> Имя </th><td> {{ $collector->name }} </td></tr>
                                    <tr><th> Фамилия </th><td> {{ $collector->surname }} </td></tr>
                                    <tr><th> Отчество </th><td> {{ $collector->middlename }} </td></tr>
                                    <tr><th> Дата рождения </th><td> {{ $collector->birthday }} </td></tr>
                                    <tr><th> Email </th><td> {{ $collector->email }} </td></tr>
                                    <tr><th> Телефон </th><td> {{ $collector->phone }} </td></tr>
                                    <tr><th> Гражданство РФ </th><td> {{ $collector->has_citizenship }} </td></tr>
                                    <tr><th> О себе </th><td> {{ $collector->aboutself }} </td></tr>
                                    <tr><th> fb </th><td> {{ $collector->social_fb }} </td></tr>
                                    <tr><th> twitter </th><td> {{ $collector->social_tw }} </td></tr>
                                    <tr><th> vk </th><td> {{ $collector->social_vk }} </td></tr>
                                    <tr><th> IP </th><td> {{ $collector->reg_ip }} </td></tr>
                                    <tr><th> Referrer </th><td> {{ $collector->origin }} </td></tr>
                                    <tr><th> ok_about_myinfo </th><td> {{ $collector->ok_about_myinfo }} </td></tr>
                                    <tr><th> Дата регистрации </th><td> {{ $collector->date }} </td></tr>
                                    <tr><th> UTM </th><td> {{ $collector->utm_list }} </td></tr>
                                    <tr><th> Status </th><td> {{ $collector->status }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
