
@extends("Admin.AdminPublic.adminpublic")
@section("admin")
<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add
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
                            <form role="form"  action="/user" method="post" enctype="multipart/form-data">

                                
                                <div class="form-group">
                                    <label>账号</label>
                                    <input class="form-control" type="text" name="username"/>
                                </div>
                                <div class="form-group">
                                    <label>密码</label>
                                    <input class="form-control" type="password" name="password"/>
                                </div>
                                <div class="form-group">
                                    <label>确认密码</label>
                                    <input class="form-control" type="password" name="repassword"/>
                                </div>
                                
                                <!-- 
                                <div class="form-group">
                                    <label>File input</label>
                                    <input type="file">
                                </div>
                                 -->
                                 {{csrf_field()}}
                                <button type="submit" class="btn ">添加</button>
                                <!-- <button type="reset" class="btn btn-default">Reset Button</button> -->
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
@section('title','会员添加')