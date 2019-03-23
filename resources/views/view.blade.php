@extends('layouts.master')
@section('title', 'Edit')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="panel-title"> View Blog </p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table id="view_details" class="table table-bordered table-hover">
                                <tbody>
                                <tr>
                                    <td> Title</td>
                                    <td> :</td>
                                    <td> {{ $blog->title }} </td>
                                </tr>
                                <tr>
                                    <td> Description</td>
                                    <td> :</td>
                                    <td> {!! $blog->description !!}</td>
                                </tr>
                                <tr>
                                    <td> Category</td>
                                    <td> :</td>
                                    <td> {{ $blog->category }} </td>
                                </tr>
                                <tr>
                                    <td> Status</td>
                                    <td> :</td>
                                    <td> @php $status = $blog->status ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>' ;  @endphp {!! $status !!}   </td>
                                </tr>
                                <tr>
                                    <td> Image</td>
                                    <td> :</td>
                                    <td><img src="{{ asset($blog->file_path) }}" class="img-responsive img-thumbnail">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop