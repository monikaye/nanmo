
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             店铺汇总表
                        </div>
                        
                        <div class="panel-body">
                            
                            <div class="table-responsive">
                            <div class="col-sm-12">
                                <div id="dataTables-example_filter" class="dataTables_filter">
                                <form action="/szhidu"  method="post" enctype="multipart/form-data">
                                    <label>放单日期</label>
                                    <label>
                                        <input type="search" class="form-control input-sm date" placeholder='开始:20180911' value="" name='start'>
                                    </label>
                                    <label>
                                        <input type="search" class="form-control input-sm date" placeholder='结束:20180911' value="" name='stop'>
                                    </label>
                                    <label>
                                        <select class="form-control input-sm" name="shopid">
                                            <option value="">请选择店铺</option>
                                            @foreach($shop as $values)
                                            <option value="{{$values->id}}">{{$values->shopname}}</option>
                                            @endforeach
                                        </select>
                                    {{csrf_field()}}
                                    </label>
                                    <label>
                                        <input type="submit" class="form-control input-sm date"  value='搜索'>
                                    </label>
                                    <a href="/shopdaochu" class="btn btn-info">导出</a>
                                </form>

                                </div>
                            </div>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>店铺名称</th>
                                            <th>本金</th>
                                            <th>礼品红包</th>
                                            <th>操作费</th>
                                            <th>单数</th>
                                            <th>应收款</th>
                                            <th>放单日期</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($info as $v)
                                        <tr>
                                            <td>{{$v->shopid}}</td>
                                            <td>{{$v->f}}</td>
                                            <td>{{$v->y}}</td>
                                            <td>{{$v->huohao}}</td>
                                            <td>{{$v->num}}</td>
                                            <td>{{$v->cou}}</td>
                                            <td>{{$v->shuadan_time}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                            <script src="/Admin/assets/js/jquery-1.8.3.min.js"></script> 
                            <script>

                                    // $.get("/szhidu",{},function(data){
                                    //     alert(data);
                                    // });
                                    
                            </script>
                        </div>
                    </div>
                <!-- /. ROW  -->

@section('title','店铺汇总表')