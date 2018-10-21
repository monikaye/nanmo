<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
 <head> 
  <meta charset="utf-8" /> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
  <title>@yield("title")</title> 
  <!-- Bootstrap Styles--> 
  <link href="/Admin/assets/css/bootstrap.css" rel="stylesheet" /> 
  <!-- FontAwesome Styles--> 
  <link href="/Admin/assets/css/font-awesome.css" rel="stylesheet" /> 
  <!-- Morris Chart Styles--> 
  <link href="/Admin/assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" /> 
  <!-- Custom Styles--> 
  <link href="/Admin/assets/css/custom-styles.css" rel="stylesheet" /> 

  <!-- Google Fonts--> 
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" /> 
 </head> 
 <body> 
  <div id="wrapper"> 
   <nav class="navbar navbar-default top-navbar" role="navigation"> 
    <div class="navbar-header"> 
     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse"> 
            <span class="sr-only">Toggle navigation</span> 
            <span class="icon-bar"></span> <span class="icon-bar"></span> 
            <span class="icon-bar"></span> 
     </button> 
     <a class="navbar-brand"><i class="fa fa-gear"></i> <strong>试用</strong>
        <strong  href="javascript:void(0)" onclick="javascript:history.back(-1);">返回</strong>
     </a>
     
    <ul class="nav navbar-top-links navbar-right"> 
     
      
     
     <!-- /.dropdown --> 
     <li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"> <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i> </a> 
      <ul class="dropdown-menu dropdown-user"> 
       <li><a href="/outlogin"><i class="fa fa-sign-out fa-fw"></i> 注销</a> </li> 
      </ul> 
      <!-- /.dropdown-user --> 
     </li> 
     <!-- /.dropdown --> 
    </ul> 
   </nav> 
   <!--/. NAV TOP  --> 
   <nav class="navbar-default navbar-side" role="navigation" > 
    <div id="sideNav" href="">
     <i class="fa fa-caret-right"></i>
    </div> 
    <div class="sidebar-collapse"> 
     <ul class="nav" id="main-menu"> 
      <li> <a class="cl" href=""><i class="fa fa-dashboard"></i> 试用管理</a> 
        <ul class="nav nav-third-level"> 
          <!-- <li> <a href="/member/create" name='12' class="co">添加日常任务</a> </li>  -->
          <li> <a href="/member" name='12' class="co">试用日常任务表</a> </li>
        </ul>
      </li>
      <li> <a class="cl" href=""><i class="fa fa-dashboard"></i> 小组长管理</a> 
        <ul class="nav nav-third-level"> 
          <!-- <li> <a href="/member/create" name='12' class="co">添加日常任务</a> </li>  -->
          <li> <a href="javascript:void(0)" onclick="nohref('addzhiban')">设置小组长</a> </li>
          <li> <a href="javascript:void(0)" onclick="nohref('zhiban')">小组长列表</a> </li>
          <li> <a href="javascript:void(0)" onclick="nohref('addfakuan')">新增罚款奖励</a> </li>
          <li> <a href="javascript:void(0)" onclick="nohref('fakuan')">罚款奖励列表</a> </li>
        </ul>
      </li>
      <li> <a href=""  class="cl"><i class="fa fa-bar-chart-o"></i> 手机管理</a> 
        <ul class="nav nav-third-level"> 
          <li> <a href="/phone/create" name='2' class="co">添加手机</a> </li>
          <li> <a href="/phone" name='2' class="co">手机列表</a> </li>
          <li> <a href="javascript:void(0)" onclick="nohref('addhongbao')">添加红包</a> </li> 
          <li> <a href="javascript:void(0)" onclick="nohref('hongbao')">红包列表</a> </li> 
        </ul>
      </li>
      <li> <a href=""  class="cl"><i class="fa fa-qrcode"></i> 银行卡信息管理</a> 
        <ul class="nav nav-third-level"> 
          <li> <a href="/card/create" name='3' class="co">添加银行卡</a> </li> 
          <li> <a href="/card" name='3' class="co">银行卡列表</a> </li> 
        </ul>
      </li> 
      <li> <a href=""  class="cl"><i class="fa fa-table"></i> 商店信息管理</a> 
        <ul class="nav nav-third-level"> 
          <li> <a href="/shop/create" name='4' class="co">添加商店</a> </li> 
          <li> <a href="/shop" name='4' class="co">商店列表</a> </li> 
        </ul>
      </li> 
      <li> <a href=""  class="cl"><i class="fa fa-edit"></i> 放单人管理 </a> 
        <ul class="nav nav-third-level"> 
          <li> <a href="/fuser/create" name='5' class="co">添加放单人</a> </li> 
          <li> <a href="javascript:void(0)" name='5' class="co"  onclick="nohref('fuser')">放单人列表</a> </li> 
        </ul>
      </li>
      <li> <a href=""  class="cl"><i class="fa fa-edit"></i> 汇总表 </a> 
        <ul class="nav nav-third-level"> 
          <li> <a href="javascript:void(0)" name='6' class="co" onclick="nohref('zhidu')">智度值日表</a> </li> 
          <li> <a href="javascript:void(0)" name='6' class="co" onclick="nohref('szhidu')">商店汇总表</a> </li> 
        </ul>
      </li>
      <li> <a href=""  class="cl"><i class="fa fa-edit"></i> 货号管理 </a> 
        <ul class="nav nav-third-level"> 
          <li> <a href="/huohao/create" name='7' class="co">添加货号</a> </li> 
          <li> <a href="/huohao" name='7' class="co">货号列表</a> </li> 
        </ul>
      </li> 
      <li> <a href=""  class="cl"><i class="fa fa-fw fa-file"></i> 售后管理</a> 
          <ul class="nav nav-third-level"> 
          <li> <a href="/saled/create" name='8' class="co">添加售后</a> </li> 
          <li> <a href="/saled" name='8' class="co">售后列表</a> </li> 
        </ul>
      </li>
      <li> <a href=""  class="cl"><i class="fa fa-fw fa-file"></i> 银行卡充值记录</a> 
          <ul class="nav nav-third-level"> 
          <li> <a href="javascript:void(0)" name='14' class="co" onclick="nohref('addcard/create')">充值银行卡</a> </li> 
          <li> <a href="javascript:void(0)" name='14' class="co" onclick="nohref('addcard')">银行卡记录</a> </li> 
        </ul>
      </li>
      <li> <a href="" class="cl"><i class="fa fa-desktop"></i>日志管理</a> 
        <ul class="nav nav-third-level"> 
          <li> <a href="javascript:void(0)" name='13' onclick="nohref('log')">查看日志</a> </li> 
        </ul>
      </li>
      <li> <a href="" class="cl"><i class="fa fa-desktop"></i>薪资管理</a> 
        <ul class="nav nav-third-level"> 
          <li> <a href="javascript:void(0)" name='15' onclick="nohref('adddixin')">添加底薪</a> </li>
          <li> <a href="javascript:void(0)" name='15' onclick="nohref('xinzi')">结算薪资</a> </li>
          <li> <a href="javascript:void(0)" name='15' onclick="nohref('jiesuaninfo')">已结算</a> </li>
        </ul>
      </li> 
      <li> <a href=""  class="cl"><i class="fa fa-sitemap"></i> 管理员管理<span class="fa arrow"></span></a> 
       <ul class="nav nav-second-level"> 
        <li> <a href=""  class="cl">节点管理</a> 
          <ul class="nav nav-third-level"> 
            <li> <a href="/node/create" name='9' class="co">添加节点</a> </li> 
            <li> <a href="/node" name='9' class="co">节点列表</a> </li> 
          </ul>
        </li> 
        <li> <a href=""  class="cl">角色管理</a> 
          <ul class="nav nav-third-level"> 
            <li> <a href="/role/create" name='10' class="co">角色添加</a> </li> 
            <li> <a href="/role" name='10' class="co">角色列表</a> </li> 
          </ul>
        </li> 
        <li> <a href=""  class="cl">会员管理<span class="fa arrow"></span></a> 
         <ul class="nav nav-third-level"> 
          <li> <a href="/user/create" name='11' class="co">添加会员</a> </li> 
          <li> <a href="/user" name='11' class="co">会员列表</a> </li> 
         </ul> 
        </li> 
       </ul> 
      </li> 
      <!-- <li> <a href=""><i class="fa fa-fw fa-file"></i> Empty Page</a> </li>  -->
     </ul> 
    </div> 
   </nav> 
   <!-- /. NAV SIDE  --> 
    <div id="page-wrapper"> 
    

    <div id="page-inner"> 
    
        @section("admin")
        @show
     
     
    </div> 
    <!-- /. PAGE INNER  --> 
   </div> 
   <!-- /. PAGE WRAPPER  --> 
  </div> 
  <!-- /. WRAPPER  --> 
  <!-- JS Scripts--> 
  <!-- jQuery Js --> 
  <script src="/Admin/assets/js/jquery-1.10.2.js"></script> 
  <script src="/Admin/assets/js/jquery.cookie.js"></script> 
  <!-- Bootstrap Js --> 
  <script src="/Admin/assets/js/bootstrap.min.js"></script> 
  <!-- Metis Menu Js --> 
  <script src="/Admin/assets/js/jquery.metisMenu.js"></script> 
  <!-- Morris Chart Js --> 
  <script src="/Admin/assets/js/morris/raphael-2.1.0.min.js"></script> 
  <script src="/Admin/assets/js/morris/morris.js"></script> 
  <script src="/Admin/assets/js/easypiechart.js"></script> 
  <script src="/Admin/assets/js/easypiechart-data.js"></script> 
  
  <script src="/Admin/assets/js/Lightweight-Chart/jquery.chart.js"></script> 
  <!-- Custom Js --> 
  <script src="/Admin/assets/js/custom-scripts.js"></script>
  <!-- // <script src="/Admin/assets/js/jquery-1.8.3.min.js"></script>  -->
  <script>
      function nohref(page){
                // alert(page);
                $.ajax({
                    type:"get",
                    url:'/'+page,
                    data:{
                    // page:page,
                },
                success:function(msg){
                        if(msg){
                            $("#page-inner").html(msg)
                            // alert(66);
                        }else {
                            
                            alert('无输出');
                        }
                    }
                });
      }  
     
      //导航栏缩进
      $('#sideNav').click(aa());
      function aa() {
          $('#sideNav').click(function(){
              $('.navbar-side').css("margin-left","-260px");
              $('#page-wrapper').css("margin-left","0px");
              $('#sideNav').click(bb());
          });
      }
      //导航栏出现
      function bb() {
          $('#sideNav').click(function(){
              $('.navbar-side').css("margin-left","0px");
              $('#page-wrapper').css("margin-left","260px");
              $('#sideNav').click(aa());
          });
      }
  </script>
 </body>
</html>