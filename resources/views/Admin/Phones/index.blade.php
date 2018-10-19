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
                    <div id="dataTables-example_filter" class="dataTables_filter">
                        <form action="/pho"  method="post" enctype="multipart/form-data">
                            <label>发单数量</label>
                            <label>
                                <input type="search" class="form-control input-sm date" placeholder='大于' value="" name='bigd'>
                            </label>
                            <label>
                                <input type="search" class="form-control input-sm date" placeholder='小于' value="" name='smalld'>
                            </label>
                            <label>
                                <select class="form-control input-sm" name="cardid">
                                    <option value="">银行卡号</option>
                                    @foreach($card as $vs)
                                    <option value="{{$vs->id}}">{{$vs->number}}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label>
                                <select class="form-control input-sm" name="phoneid">
                                    <option value="">手机编号</option>
                                    @foreach($phone as $va)
                                    <option value="{{$va->id}}">{{$va->phonenum}}</option>
                                    @endforeach
                                </select>
                            </label>
                            <br>
                            <label>发卡片量</label>
                            <label>
                                <input type="search" class="form-control input-sm date" placeholder='大于' value="" name='bigc'>
                            </label>
                            <label>
                                <input type="search" class="form-control input-sm date" placeholder='小于' value="" name='smallc'>
                            </label>
                            
                            

                            <br>
                            
                            <label>
                                {{csrf_field()}}
                                <input type="submit" class="form-control input-sm date"  value='搜索'>
                            </label>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>手机编号</th>
                                    <th>手机号</th>
                                    <th>微信号</th>
                                    
                                    <th>发单量</th>
                                    <th>发卡量</th>
                                    <th>银行卡号</th>
                                    <th>商家</th>
                                    
                                    <th>添加时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
								@foreach($info as $pho)
                                <tr class="odd gradeX">
									
                                    <td>{{$pho->phonenum}}</td>
                                    <td>{{$pho->pnumber}}</td>
                                    <td>{{$pho->wxnumber}}</td>
                                                                        <td>{{$pho->countday}}</td>
                                    <td>{{$pho->fcard}}</td>
                                    <td>{{$pho->number}}</td>
                                    <td>{{$pho->shopmark}}</td>
                                    
                                    <td><?php echo date('Y-m-d',$pho->create_time) ?></td>
                                    <td>
                                    	<form action="/phones/{{$pho->id}}" method="post" class='btn'>
							                <button class="btn btn-danger">删除</button>{{csrf_field()}}{{method_field("DELETE")}}
							            </form>
                                        <a href="/phones/{{$pho->id}}/edit" class="btn btn-info">修改</a>
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
@section('title','手机信息表')