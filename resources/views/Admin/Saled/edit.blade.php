


@extends("Admin.AdminPublic.adminpublic")
@section("admin")
<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit
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
                            <form role="form" class="form" action="/saled/{{$info->id}}" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>微信备注</label>
                                    <input class="form-control" type="text" placeholder="{{$info->wxname}}"   readonly="readonly"/>
                                </div>
                                <div class="form-group">
                                    <label>旺旺号</label>
                                    <input class="form-control" type="text" placeholder="{{$info->wwname}}"   readonly="readonly"/>
                                </div>
                                <div class="form-group">
                                    <label>发生日期</label>
                                    <input class="form-control" type="text" placeholder="{{$info->hap_time}}" readonly="readonly"/>
                                </div>
                                <div class="form-group">
                                    <label>本金</label>
                                    <input class="form-control" type="text" placeholder="{{$info->fmoney}}"  readonly="readonly"/>
                                </div>
                                <div class="form-group">
                                    <label>订单号</label>
                                    <input class="form-control" type="text" placeholder="{{$info->orders}}"  readonly="readonly"/>
                                </div>
                                <div class="form-group">
                                    <label>店铺名</label>
                                    <input class="form-control" type="text" placeholder="{{$shop->shopname}}"  readonly="readonly"/>
                                </div>
                                <div class="form-group">
                                    <label>货号</label>
                                    <input class="form-control" type="text" placeholder="{{$huohao->huohao}}"  readonly="readonly"/>
                                </div>
                                <div class="form-group">
                                    <label>放单人</label>
                                    <input class="form-control" type="text" placeholder="{{$fuser->username}}"  readonly="readonly"/>
                                </div>
                                <div class="form-group">
                                    <label>赔偿手机</label>
                                    <select class="form-control" name="fphone"  onblur="ab()">
                                        <option value="">请选择</option>
                                        @foreach($phone as $values)
                                        <option value="{{$values->id}}" @if($values->id==$info->fphone) selected @endif >{{$values->phonenum}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>原因</label>
                                    <input class="form-control"  onblur="ab()" type="text" name="why" value="{{$info->why}}"/>
                                </div>
                                <div class="form-group">
                                    <label>处理结果</label>
                                    <select class="form-control" name="result"  onblur="ab()">
                                        <option value="">请选择</option>
                                        <option value="1" @if($info->result==1) selected @endif >处理成功</option>
                                        <option value="2" @if($info->result==2) selected @endif>处理中</option>
                                        <option value="3" @if($info->result==3) selected @endif>处理失败</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>赔偿金额</label>
                                    <input class="form-control"  onblur="ab()" type="text" placeholder="{{$info->smoney}}" name="smoney"/>
                                </div>
                                <input type="hidden" name="oldmoney" value="{{$info->smoney}}">
                                <div class="form-group">
                                    <label>完结日期</label>
                                    <input class="form-control" onblur="ab()" type="text" name="over_time" value="{{$info->over_time}}"/>
                                </div>
                                
                                <!-- 
                                <div class="form-group">
                                    <label>File input</label>
                                    <input type="file">
                                </div>
                                 -->
                                 {{method_field("PUT")}}
                                 {{csrf_field()}}
                                <button type="submit" disabled="true" class="btn btn-default saled">保存</button>
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
<script src="/Admin/assets/js/jquery-1.8.3.min.js"></script>
<script>
    function ab(){
        var fphone    = $("select[name='fphone']").val();
        var why       = $("input[name='why']").val();
        var result    = $("select[name='result']").val();
        var smoney    = $("input[name='smoney']").val();
        var over_time = $("input[name='over_time']").val();

        if(fphone != "" && why != "" && result != "" && smoney != "" && over_time != ""){
            $('.saled').attr("disabled",false);
        }
    }
</script>

@endsection
@section('title','手机卡修改')