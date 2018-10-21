@extends("Admin.AdminPublic.adminpublic")
@section("admin")
<div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     <h2>手机信息</h2>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>手机编号</th>
                                    <th>手机号码</th>
                                    <th>微信号</th>
                                    
                                    <th>微信零钱余额</th>
				   <th>银行卡主</th>            
                                    <th>关联银行卡号</th>
                                    <th>卡内余额</th>
                                    <th>添加时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
								@foreach($info as $value)
                                <tr class="odd gradeX">
									
                                    <td>{{$value->pnum}}</td>
                                    <td>{{$value->pnumber}}</td>
                                    <td>{{$value->wxnumber}}</td>
                                    
                                    <td>{{$value->pmoney}}</td>
				   <td>{{$value->cardname}}</td>
                                    <td>{{$value->cnumber}}</td>
                                    <td>{{$value->cmoney}}</td>
                                    <td><?php echo date('Y-m-d',$value->create_time) ?></td>
                                    <td>
                                    	<form action="/phone/{{$value->pid}}" method="post" class="btn">
							                <button class="btn btn-danger">删除</button>{{csrf_field()}}{{method_field("DELETE")}}
							            </form>
                                        <a href="/phone/{{$value->pid}}/edit" class="btn btn-info">修改</a>
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!!$info->appends($request)->render()!!}
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
</div>
                <!-- /. ROW  -->
@endsection
@section('title','手机卡表')