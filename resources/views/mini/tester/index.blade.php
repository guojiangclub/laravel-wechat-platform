<div class="tabs-container">
    <ul class="nav nav-tabs">

        <li class="active">
            <a data-toggle="tab" href="#tab-1" aria-expanded="true">体验微信 <span
                        class="badge">{{count($lists)}}</span></a>
        </li>
        <a onclick="create()" class="btn btn-w-m btn-info pull-right">添加体验微信</a>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <div class="panel-body">

                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>微信号</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($lists)>0)
                        @foreach ($lists as $item)
                            <tr>
                                <td>{{$item->wechatid}}</td>
                                <td>

                                    <a class="btn btn-xs btn-danger delete"
                                       data-href="{{route('admin.mini.tester.delete',['id'=>$item->wechatid,'appid'=>request('appid')])}}">
                                        <i data-toggle="tooltip" data-placement="top"
                                           class="fa fa-trash"
                                           title="删除"></i></a>
                                </td>

                            </tr>
                        @endforeach
                    @endif

                    </tbody>
                </table>

                <div class="clearfix"></div>
            </div>
        </div>

    </div>
</div>

@include('wechat-platform::includes.common')

<script>
    $('.delete').on('click', function () {
        var that = $(this);
        var postUrl = that.data('href');
        var body = {
            _token: _token
        };
        swal({
            title: "确定要删除该体验者微信么?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确认",
            cancelButtonText: '取消',
            closeOnConfirm: false
        }, function () {
            $.post(postUrl, body, function (result) {
                if (result.status) {
                    swal({
                        title: "删除成功！",
                        text: "",
                        type: "success"
                    }, function () {
                        location = '';
                    });
                } else {
                    swal({
                        title: "删除失败",
                        text: result.message,
                        type: "error"
                    });
                }
            });
        });
    });


    function create() {
        swal({
                title: "添加体验微信",
                text: "",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                confirmButtonText: "保存",
                cancelButtonText: "取消",
                animation: "slide-from-top",
                inputPlaceholder: "请输入微信号"
            },
            function (inputValue) {
                if (inputValue == "") {
                    swal.showInputError("请输入微信号");
                    return false
                }
                var url = "{{route('admin.mini.tester.store',['_token'=>csrf_token()])}}";
                var appid = "{{request('appid')}}";
                var data = {'wechatid': inputValue, 'appid': appid}

                $.post(url, data, function (ret) {
                    if (!ret.status) {
                        swal("创建失败!", ret.message, "warning");
                    } else {
                        swal({
                            title: "创建成功",
                            text: "",
                            type: "success",
                            confirmButtonText: "确定"
                        }, function () {
                            location.href = "";

                        });
                    }
                });

            });
    }


</script>





