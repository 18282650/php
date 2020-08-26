<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台登录-X-admin2.0</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    @include('admin.public.styles')
    @include('admin.public.script')
</head>
<body class="login-bg">

    <div class="login">
        <div class="message">后台管理登录</div>
        @if(is_object($errors))
            @if(count($errors)>0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @else
            <div class="alert alert-danger">
                <ul>
                    <li>{{ $errors }}</li>
                </ul>
            </div>
        @endif
        <div id="darkbannerwrap"></div>

        <form method="post" class="layui-form" action="{{ url('admin/doLogin') }}">
            @csrf
            <input name="username" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input name="code" style="width: 150px;float: left" lay-verify="required" placeholder="验证码"  type="text" class="layui-input">
            {{--<img src="{{ url('admin/code') }}" alt="" style="float: right" onclick="this.src='{{ url('admin/code') }}?' + Math.random()">--}}
            <a onclick="javascript:re_captcha();" style="float: right">
                <img src="{{ URL('/code/captcha/1') }}" id="127ddf0de5a04167a9e427d883690ff6">
            </a>
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
    </div>

    <script>
        $(function  () {
            layui.use('form', function(){
              var form = layui.form;
              // layer.msg('玩命卖萌中', function(){
              //   //关闭后的操作
              //   });
              //监听提交
              form.on('submit(login)', function(data){
                // alert(888)
                /*layer.msg(JSON.stringify(data.field),function(){
                    location.href='inx.html'
                });
                return false;*/
              });
            });
        })
        function re_captcha() {
            $url = "{{ URL('/code/captcha') }}";
            $url = $url + "/" + Math.random();
            document.getElementById('127ddf0de5a04167a9e427d883690ff6').src = $url;
        }

    </script>
</body>
</html>
