<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="referrer" content="never">
    <title></title>
</head>
<body>


@if(request('url'))

    <div align="center">

        <img width="600" height="600" src="{{route('admin.wechat.img',['url'=>request('url')])}}" alt="">

    </div>

@endif

</body>
</html>
