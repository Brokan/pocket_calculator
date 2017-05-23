@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div id="calculator" class="panel panel-default">
                <div class="panel-heading">Calculator</div>

                <div class="panel-body calculator">
                    <div class="row">
                        <div class="col-xs-9">
                            <input type="text" name="calc" value="0" class="form-control" />
                        </div>
                        <div class="col-xs-3">
                            <button name="action[clear]" value="clear" class="btn btn-danger" >C</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">
                            <button name="num[1]" value="1" class="btn btn-default" >1</button>
                        </div>
                        <div class="col-xs-3">
                            <button name="num[2]" value="2" class="btn btn-default" >2</button>
                        </div>
                        <div class="col-xs-3">
                            <button name="num[3]" value="3" class="btn btn-default" >3</button>
                        </div>
                        <div class="col-xs-3">
                            <button name="action[sum]" value="sum" class="btn btn-primary" >+</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">
                            <button name="num[4]" value="4" class="btn btn-default" >4</button>
                        </div>
                        <div class="col-xs-3">
                            <button name="num[5]" value="5" class="btn btn-default" >5</button>
                        </div>
                        <div class="col-xs-3">
                            <button name="num[6]" value="6" class="btn btn-default" >6</button>
                        </div>
                        <div class="col-xs-3">
                            <button name="action[min]" value="min" class="btn btn-primary" >-</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">
                            <button name="num[7]" value="7" class="btn btn-default" >7</button>
                        </div>
                        <div class="col-xs-3">
                            <button name="num[8]" value="8" class="btn btn-default" >8</button>
                        </div>
                        <div class="col-xs-3">
                            <button name="num[9]" value="9" class="btn btn-default" >9</button>
                        </div>
                        <div class="col-xs-3">
                            <button name="action[mult]" value="mult" class="btn btn-primary" >X</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">
                            <button name="num[.]" value="." class="btn btn-default" >.</button>
                        </div>
                        <div class="col-xs-3">
                            <button name="num[0]" value="0" class="btn btn-default" >0</button>
                        </div>
                        <div class="col-xs-3">
                            <button name="action[eq]" value="eq" class="btn btn-success" >=</button>
                        </div>
                        <div class="col-xs-3">
                            <button name="action[div]" value="div" class="btn btn-primary" >/</button>
                        </div>
                    </div>
                </div>
                <div class="panel-body logs">
                    @if($isAuthorised)
                        <input type="hidden" name="urlLogSave" value="{{ action('HomeController@logSave') }}" />
                        <input type="hidden" name="urlLogLoadById" value="{{ action('HomeController@logLoadById') }}" />
                        <input type="hidden" name="urlLogLoadByName" value="{{ action('HomeController@logLoadByName') }}" />
                    @endif
                    <div class="row">
                        <div class="col-xs-12">
                            <label for="logs_list">Logs</label>
                            <textarea id="logs_list" name="logs" class="form-control" rows="10"></textarea>
                        </div>
                    </div>
                    @if($isAuthorised)
                        <div class="row">
                            <div class="col-xs-9">
                                <input type="text" name="log_name" value="" class="form-control" placeholder="Log name to save" />
                            </div>
                            <div class="col-xs-3">
                                <button name="save_log" value="save" class="btn btn-primary" >Save</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="logs_list">Load logs</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-9">
                                <input type="text" name="search" value="" class="form-control" placeholder="Log name to load" />
                            </div>
                            <div class="col-xs-3">
                                <button name="log_load" value="save" class="btn btn-primary" >Load</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-9">
                                <select name="search" class="form-control" >
                                    <option value="">Select saved</option>
                                    @foreach($savedLogs as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
