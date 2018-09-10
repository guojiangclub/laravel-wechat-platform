<script>
    function pre(pre,pre_show) {

        var text = document.getElementById(pre).innerText;

        var result = JSON.stringify(JSON.parse(text), null, 2);

        document.getElementById(pre_show).innerText= result ;

    }
</script>
<div class="tabs-container">
    <ul class="nav nav-tabs">

        <li>
            <a  href="{{route('admin.mini.theme.item',['theme_id'=>request('theme_id'),'type'=>1])}}" aria-expanded="true">配色主题
            </a>
        </li>

        <li class="active">
            <a data-toggle="tab" href="#tab-1" aria-expanded="true">菜单主题
            </a>
        </li>

        <a href="{{route('admin.mini.theme.item.create',['theme_id'=>request('theme_id'),'name'=>request('name'),'type'=>request('type')])}}" class="btn btn-w-m btn-info pull-right">添加</a>

    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <div class="panel-body">

                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>标题</th>
                        <th>自定义参数</th>
                        <th>操作</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($lists)>0)
                        @foreach ($lists as $item)
                            <tr>
                                <td>
                                    {{$item->title}}
                                </td>
                                <td>
                                    <span style="display: none" id="pre{{$item->id}}">{!!$item->param!!}</span>
                                    <pre id="pre_show_{{$item->id}}"></pre>
                                    <script>
                                        pre("pre{{$item->id}}","pre_show_{{$item->id}}")
                                    </script>

                                </td>
                                <td>

                                    <a class="btn btn-xs btn-info add"
                                       href="{{route('admin.mini.theme.item.edit',['name'=>request('name'),'theme_id'=>request('theme_id'),'id'=>$item->id,'type'=>request('type')])}}">
                                        <i data-toggle="tooltip" data-placement="top"
                                           class="fa fa-edit"
                                           title="编辑"></i></a>

                                    <a class="btn btn-xs btn-info set"
                                       data-href="{{route('admin.mini.theme.setDefaultTheme',['theme_id'=>request('theme_id'),'id'=>$item->id,'type'=>request('type')])}}">
                                        <i data-toggle="tooltip" data-placement="top"
                                           class="fa fa-asterisk"
                                           title="设置成默认"></i></a>


                                    <a class="btn btn-xs btn-danger delete"
                                       data-href="{{route('admin.mini.theme.item.delete',['id'=>$item->id])}}">
                                        <i data-toggle="tooltip" data-placement="top"
                                           class="fa fa-trash"
                                           title="删除"></i></a>
                                </td>

                                <td>@if($item->is_default)
                                        <span class="label label-danger">默认</span>
                                    @endif</td>

                            </tr>
                        @endforeach
                    @endif


                    </tbody>
                </table>

                <div class="clearfix"></div>

                <tfoot>
                <tr>
                    <td colspan="6" class="footable-visible">
                        {!!$lists->appends(['limit'=>request('limit'),'type'=>request('type')])->render()!!}
                    </td>
                </tr>
                </tfoot>
            </div>
        </div>

    </div>
</div>


<script>
    $('.delete').on('click', function () {
        var that = $(this);
        var postUrl = that.data('href');
        var body = {
            _token: _token
        };
        swal({
            title: "确定要删除该菜单主题么?",
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

</script>

<script>
    $('.set').on('click', function () {
        var that = $(this);
        var postUrl = that.data('href');
        var body = {
            _token: _token
        };
        swal({
            title: "确定要设置该主题为默认菜单主题么?",
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
                        title: "设置成功！",
                        text: "",
                        type: "success"
                    }, function () {
                        location = '';
                    });
                } else {
                    swal({
                        title: "设置失败",
                        text: result.message,
                        type: "error"
                    });
                }
            });
        });
    });



</script>



