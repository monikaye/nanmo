                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>操作</th>
                                	<th>排序</th>
                                    <th>微信备注名</th>
                                    <th>所在手机编号</th>
                                    <th>旺旺号</th>
                                    <th>订单号</th>
                                    <th>淘气值</th>            
                                    <th>店铺名称</th>
                                    <th>性别</th>
                                    <th>偏远地区</th>
                                    <th>付款金额</th>
                                    <th>超级会员</th>
                                    <th>佣金</th>
                                    <th>礼物</th>
                                    <th>放单人</th>
                                    <th>绩效</th>
                                    <th>货号</th>
                                    <th>备注</th>
                                    <th>付款手机</th>
                                    <th>额外付款金额</th>
                                    <th>录入人</th>
                                    <th>试用日期</th>
                                    <th>操作</th>
                                    <th>售后</th>
                                </tr>
                            </thead>
                            <?php $cc = 1; ?>
                            <tbody>
								@foreach($data as $value)
                                <tr class="odd gradeX">
                                    <td class="ttt">
                                        <input type="checkbox" name='check' value="{{$value->id}}">
                                    </td>
									<td><?php echo $cc++; ?></td>
                                    <td>{{$value->username}}</td>
                                    <td>{{$value->pnum}}</td>
                                    <td>{{$value->wwname}}</td>
                                    <td>{{$value->orders}}</td>
                                    <td>{{$value->tqnum}}</td>
                                    <td>{{$value->shopname}}</td>
                                    @if($value->sex==1)
                                    <td>男</td>
                                    @elseif($value->sex == 2)
                                    <td>女</td>
				                    @elseif($value->sex == 3)
                                    <td>未知</td>
				                    @elseif($value->sex == 0)
                                    <td>未知</td>
									@endif
                                    @if($value->ifyuan==1)
                                    <td>是</td>
                                    @elseif($value->ifyuan == 2)
                                    <td>不是</td>
				                    @elseif($value->ifyuan == 3)
                                    <td>未知</td>
						            @elseif($value->ifyuan == 0)
                                    <td>未知</td>
									@endif
                                    <td>{{$value->fmoney}}</td>
									@if($value->ifsuper == 1)
                                    <td>是</td>
                                    @elseif($value->ifsuper == 2)
                                    <td>不是</td>
				                    @elseif($value->ifsuper == 3)
                                    <td>未知</td>
				                    @elseif($value->ifsuper == 0)
                                    <td>未知</td>
									@endif
                                    <td>{{$value->ymoney}}</td>
                                    <td>{{$value->gift}}</td>
                                    <td>{{$value->fname}}</td>
                                    <td>{{$value->jixiao}}</td>
                                    <td>{{$value->huohao}}</td>
                                    <td>{{$value->remark}}</td>
                                    <td>{{$value->ppnum}}</td>
                                    <td>{{$value->extra}}</td>
                                    <td>{{$value->uname}}</td>
                                    <td>{{$value->shuadan_time}}</td>
                                    <td>
                                    	<form action="/member/{{$value->id}}" method="post">
							                <button class="btn btn-danger">删除</button>{{csrf_field()}}{{method_field("DELETE")}}
							            </form>
							            
                                    </td>
                                    <td>
                                        <a class="btn btn-info membid" value="{{$value->id}}" @if($value->saled) disabled @endif >售后</a>
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a class="btn btn-info quanxuan">全选</a>
                        <a class="btn btn-danger shanchu">删除</a>
                        <a class="btn btn-info xiugai">修改</a>
                        <label class="checkbox-inline xiugaikuang" style="display:none;">
                            <select class="form-control input-sm pd" name="pd">
                                <option value="">所在手机编号</option>
                                @foreach($phone as $va)
                                <option value="{{$va->id}}">{{$va->phonenum}}</option>
                                @endforeach
                            </select>
                            <select class="form-control input-sm sd" name="sd">
                                <option value="">店铺列表</option>
                                @foreach($shop as $ve)
                                <option value="{{$ve->id}}">{{$ve->shopname}}</option>
                                @endforeach
                            </select>
                            <input type="text" name='fy' class="form-control input-sm" placeholder="付款金额">
                            <input type="text" name='yy' class="form-control input-sm" placeholder="佣金">
                            <input type="text" name='gt' class="form-control input-sm" placeholder="礼物">
                            <select class="form-control input-sm fd" name="fd">
                                <option value=" ">放单人</option>
                                @foreach($fuser as $value)
                                <option value="{{$value->fid}}">{{$value->fname}}</option>
                                @endforeach
                            </select>
                            <input type="text" name='jx' class="form-control input-sm" placeholder="绩效">
                            <select class="form-control input-sm hh" name="hh">
                                <option value=" ">货号</option>
                                @foreach($huohao as $val)
                                <option value="{{$val->id}}">{{$val->huohao}}</option>
                                @endforeach
                            </select>
                            <input type="text" name='bz' class="form-control input-sm" placeholder="备注">
                            <select class="form-control input-sm fpd" name="fpd">
                                <option value=" ">付款手机</option>
                                @foreach($phone as $va)
                                <option value="{{$va->id}}">{{$va->phonenum}}</option>
                                @endforeach
                            </select>
                            <input type="text" name='ey' class="form-control input-sm" placeholder="额外付款金额">
                            <input type="text" name='sm' class="form-control input-sm" placeholder="使用日期">
                            <a class="btn btn-info queding">确认修改</a>
                        </label>
                        <form action="/daoru" onSubmit="return confirm('您确定要导入？');" method="post" enctype="multipart/form-data" class='daodao btn'>
                            <label><input type="file" name='file[]' multiple="true"></label>
                            <!-- <label  style="width: 70%;">
                                <input type="file" value="" name="goods_img[]" style="width: 40%;height: 30px;" id="goods_img" multiple="true">
                            </label> -->
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-info daoru">导入</button>
                            

                        </form>
                        <a href="/dao" class="btn btn-info">导出</a>
                        
                    </div>
                    <a href="javascript:void(0)" onclick="page(<?php echo $prev ?>)" class="btn btn-info"><<</a>
                    @if($sums <= 10)
                        @foreach($pp as $key=>$val)
                            @if($val == $page)
                            {{$val}}
                            @else
                            <a href="javascript:void(0)" onclick="page({{$val}})">{{$val}}</a>
                            @endif
                        @endforeach
                    @else
                        
                            @if($page<=3)
                                @if($page==1)
                                1
                                @else
                                <a href="javascript:void(0)" onclick="page(1)">1</a>
                                @endif
                                @if($page==2)
                                2
                                @else
                                <a href="javascript:void(0)" onclick="page(2)">2</a>
                                @endif
                                @if($page==3)
                                3
                                @else
                                <a href="javascript:void(0)" onclick="page(3)">3</a>
                                @endif
                                <a href="javascript:void(0)">...</a>
                                <a href="javascript:void(0)" onclick="page(<?php echo $sums ?>)">{{$sums}}</a>
                                @elseif($page>3 && ($sums-$page) >=3)
                                <a href="javascript:void(0)" onclick="page(1)">1</a>
                                <a href="javascript:void(0)">...</a>
                                <a href="javascript:void(0)" onclick="page(<?php echo $prev ?>)"><?php echo $prev; ?></a>
                                {{$page}}
                                
                                <a href="javascript:void(0)" onclick="page(<?php echo $next ?>)"><?php echo $next; ?></a>
                                <a href="javascript:void(0)">...</a>
                                <a href="javascript:void(0)" onclick="page(<?php echo $sums ?>)">{{$sums}}</a>
                                @elseif(($sums-$page) <3)
                                <a href="javascript:void(0)" onclick="page(1)">1</a>
                                <a href="javascript:void(0)">...</a>
                                @if($page==($sums-2))
                                    {{$sums-2}}
                                @else
                                <a href="javascript:void(0)" onclick="page(<?php echo $sums-2 ?>)">{{$sums-2}}</a>
                                @endif
                                @if($page==($sums-1))
                                    {{$sums-1}}
                                @else
                                <a href="javascript:void(0)" onclick="page(<?php echo $sums-1 ?>)">{{$sums-1}}</a>
                                @endif
                                @if($page==$sums)
                                    {{$sums}}
                                @else
                                <a href="javascript:void(0)" onclick="page(<?php echo $sums ?>)">{{$sums}}</a>
                                @endif
                            @endif
                            
                    @endif
                    <a href="javascript:void(0)" onclick="page(<?php echo $next ?>)" class="btn btn-info">>></a>
                    <script src="/Admin/assets/js/jquery-1.8.3.min.js"></script>
                    <script>

                            $('.shanchu').click(function(){
                                var qud = confirm('您确定要删除？');
                                if(!qud) {
                                    return false;
                                }
                                var a = '';
                                $('input[type=checkbox]:checked').each(function(){
                                    a = $(this).attr('value') + ',' + a;
                                });
                                del = $('input[type=checkbox]:checked');
                                // alert(a);
                                $.ajax({
                                    type:"get",
                                    url:"/del",
                                    data:{
                                    a:a,
                                },
                                success:function(msg){
                                        if(msg){
                                            // $(".panel-body").html(msg)
                                            del.parent().parent().remove();
                                        }else {
                                            
                                            alert('请选择要删除的对象');
                                        }
                                    }
                                })
                            });
                            $('.quanxuan').toggle(function(){
                                            $('input[type="checkbox"]').prop('checked',true);
                            },function(){
                                            $('input[type="checkbox"]').prop('checked',false);
                            });

                            $('.ttt').toggle(function(){
                                $(this).children('input').prop('checked',true);
                            },function(){
                                $(this).children('input').prop('checked',false);
                            }); 


                            $('.xiugai').toggle(function(){
                                $('.xiugai').html('收起');
                                $('.xiugaikuang').show();
                            },function(){
                                $('.xiugai').html('修改');
                                $('.xiugaikuang').hide();
                            });    
                            
                            $('.queding').click(function(){
                                var qud = confirm('您确定要修改？');
                                if(!qud) {
                                    return false;
                                }

                                var a = '';
                                //获取要修改的id组成字符串
                                $('input[type=checkbox]:checked').each(function(){
                                    a = $(this).attr('value') + ',' + a;
                                });
                                //获取修改的所在手机编号
                                var pd = $('.pd').val();
                                //获取店铺id
                                var sd = $('.sd').val();
                                //获取付款金额
                                var fy = $('input[name="fy"]').val();
                                //获取佣金
                                var yy = $('input[name="yy"]').val();
                                //获取礼物
                                var gt = $('input[name="gt"]').val();
                                //获取放单人
                                var fd = $('.fd').val();
                                //获取绩效
                                var jx = $('input[name="jx"]').val();
                                //获取货号
                                var hh = $('.hh').val();
                                //获取备注
                                var bz = $('input[name="bz"]').val();
                                //获取付款手机
                                var fpd = $('.fpd').val();
                                //获取额外付款金额
                                var ey = $('input[name="ey"]').val();
                                //获取试用日期
                                var sm = $('input[name="sm"]').val();
                                // alert(pd+1);alert(sd+2);alert(fy+3);alert(yy+4);alert(gt+5);alert(fd+6);alert(jx+7);alert(hh+8);alert(bz+9);alert(fpd+10);alert(ey+11);alert(sm+12);
                                $.ajax({
                                    type:"get",
                                    url:"/pledit",
                                    data:{
                                        a:a,
                                        pd:pd,
                                        sd:sd,
                                        fy:fy,
                                        yy:yy,
                                        gt:gt,
                                        fd:fd,
                                        jx:jx,
                                        hh:hh,
                                        bz:bz,
                                        fpd:fpd,
                                        ey:ey,
                                        sm:sm,
                                    },
                                    success:function(msg){
                                        if(msg == 1 ){
                                            
                                            alert('修改成功,请刷新页面');
                                        }else {
                                            if(msg == 2){
                                                alert('店铺与货号不匹配')
                                            }else{
                                                alert('修改失败');
                                            }
                                        }
                                    }
                                });


                            });
                            //试用转售后
                            $(".membid").click(function(){
                                // alert(44);
                                var mem    = $(this);
                                var membid = $(this).attr("value");
                                $.ajax({
                                    type:"get",
                                    url:"/m_saled",
                                    data:{
                                        membid:membid
                                    },
                                    success:function(msg){
                                        if(msg == 1 ){
                                            mem.attr('disabled',true);
                                            alert('添加售后成功');
                                        }else {
                                            if(msg == 2){
                                                alert('添加售后失败');
                                            }
                                        }
                                    }
                                });

                            });

                    </script>


