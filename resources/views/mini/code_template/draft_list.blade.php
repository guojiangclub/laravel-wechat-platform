<div class="tabs-container">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true">草稿箱 <span
                        class="badge">{{count($draft_list)}}</span></a>
        </li>
        <li>
            <a href="{{route('admin.mini.template.lists',['type'=>2])}}">模板库<span
                        class="badge">{{count($template_list)}}</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <div class="panel-body">
                @if(count($draft_list)>0)
                    *每个小程序只保留最新一次的上传记录
                    <br>
                    <br>
                @endif
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>版本号</th>
                        <th style="width:400px;">描述</th>
                        <th>来源小程序appid</th>
                        <th>来源小程序</th>
                        <th>上传开发者</th>
                        <th>最近提交时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($draft_list)>0)
                        @foreach ($draft_list as $item)
                            <tr>
                                <td>{{$item['draft_id']}}</td>
                                <td>{{$item['user_version']}}</td>
                                <td>{{$item['user_desc']}}</td>
                                <td>{{$item['source_miniprogram_appid']}}</td>
                                <td>{{$item['source_miniprogram']}}</td>
                                <td>{{$item['developer']}}</td>
                                <td>{{date('Y-m-d H:i:s',$item['create_time'])}}</td>

                                <td>

                                    <a class="btn btn-xs btn-info create"
                                       data-href="{{route('admin.mini.template.store',['draft_id'=>$item['draft_id']])}}">
                                        添加模板
                                    </a>

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
    $('.create').on('click', function () {
        var that = $(this);
        var postUrl = that.data('href');
        var body = {
            _token: _token
        };
        swal({
            title: "确定要添加到小程序模板库吗?",
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
                        title: "添加成功！",
                        text: "",
                        type: "success"
                    }, function () {
                        location = "{{route('admin.mini.template.lists',['type'=>2])}}";
                    });
                } else {
                    swal({
                        title: "添加失败",
                        text: result.message,
                        type: "error"
                    });
                }
            });
        });
    });
</script>





