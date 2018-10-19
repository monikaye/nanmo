
@extends("Admin.AdminPublic.adminpublic")
@section("admin")
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    设置值班员
                </div>
                @if(count($errors)>0)
                    @foreach ($errors->all() as $error)
                        <div class="mws-form-message error">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form"   action="/zhibancreate" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label>设置值班员</label>
                                    <select class="form-control fuserid" name="fuserid">
                                        <option value="">请选择</option>
                                        @foreach($data as $values)
                                            <option value="{{$values->id}}">{{$values->username}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label>日期</label>
                                    <input class="form-control date" type="text" name="date"/>
                                </div>
                                <!-- 
                                <div class="form-group">
                                    <label>File input</label>
                                    <input type="file">
                                </div>
                                 -->
                                <button type="submit" class="btn ">添加</button>
                                {{--type="submit"--}}
                            </form>
                        </div>

                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>

@endsection
@section('title','设置值班员')
