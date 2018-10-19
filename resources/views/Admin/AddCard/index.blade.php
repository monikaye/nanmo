
<div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     <h2>银行卡充值信息</h2>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>银行卡号</th>
                                    <th>充值金额</th>
                                    <th>录入人</th>
                                    <th>添加时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
								@foreach($info as $value)
                                <tr class="odd gradeX">
									
                                    <td>{{$value->cardid}}</td>
                                    <td>{{$value->addmoney}}</td>
                                    <td>{{$value->userid}}</td>
				                    <td>{{$value->create_time}}</td>
                                    <td>
							            <button class="btn btn-danger acddel" value="{{$value->id}}">删除</button>{{csrf_field()}}{{method_field("DELETE")}}
                                        <a href="/addcard/{{$value->id}}/edit" class="btn btn-info">修改</a>
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
</div>
<script src="/Admin/assets/js/jquery-1.8.3.min.js"></script>
<script>
            $('.acddel').click(function(){
                de = $(this);
                var qud = confirm('您确定要删除？');
                if(!qud) {
                    return false;
                }
                var id = de.attr('value');
                $.ajax({
                    type:"get",
                    url:"/acddel",
                    data:{
                    id:id,
                },
                success:function(msg){
                        if(msg == 1){
                            // $(".panel-body").html(msg)
                            de.parent().parent().remove();
                        }else {
                            alert('请选择要删除的对象');
                        }
                    }
                });
            });



</script>
                <!-- /. ROW  -->

@section('title','银行卡充值信息')