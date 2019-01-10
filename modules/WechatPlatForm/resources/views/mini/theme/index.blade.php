<div class="tabs-container">
    <ul class="nav nav-tabs">

        <li class="active">
            <a data-toggle="tab" href="#tab-1" aria-expanded="true">主题组
                        </a>
        </li>
        <a onclick="create()" class="btn btn-w-m btn-info pull-right">添加</a>

        {{--<div id="upload-json"  class="pull-left col-sm-4" style="height: 30px">--}}
        {{--</div>--}}

    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th class="col-sm-3">名称</th>
                        <th class="col-sm-3">更新时间</th>
                        <th class="col-sm-3">操作</th>
                        <th class="col-sm-3"><a id="upload-json" data-style="expand-right"  class="btn pull-right" type="submit" disabled  >导入主题</a></th>
                    </tr>
                    </thead>
                    <tbody>

                    @if(count($lists)>0)
                        @foreach ($lists as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->updated_at}}</td>
                                <td>

                                    <a class="btn btn-xs btn-info add"
                                       href="{{route('admin.mini.theme.item',['theme_id'=>$item->id,'type'=>1])}}">
                                        <i data-toggle="tooltip" data-placement="top"
                                           class="fa fa-eye"
                                           title="查看主题"></i></a>

                                    <a class="btn btn-xs btn-info download"
                                       download="{{$item->name}}.json" href="{{route('admin.mini.theme.export',['theme_id'=>$item->id])}}">
                                        <i data-toggle="tooltip" data-placement="top"
                                           class="fa fa-download"
                                           title="下载主题"></i>
                                        </a>

                                    <a class="btn btn-xs btn-info" onclick='update("{{$item->id}}","{{$item->name}}")'>
                                        <i data-toggle="tooltip" data-placement="top"
                                           class="fa fa-edit"
                                           title="修改"></i>
                                    </a>

                                    <a class="btn btn-xs btn-danger delete"
                                       data-href="{{route('admin.mini.theme.delete',['id'=>$item->id])}}">
                                        <i data-toggle="tooltip" data-placement="top"
                                           class="fa fa-trash"
                                           title="删除"></i></a>
                                </td>
                                <td></td>

                            </tr>
                        @endforeach
                    @endif


                    </tbody>
                </table>

                <div class="clearfix"></div>

                <tfoot>
                <tr>
                    <td colspan="6" class="footable-visible">
                        {!!$lists->appends(['limit'=>request('limit')])->render()!!}
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
            title: "确定要删除该主题组么?",
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
                title: "添加主题组",
                text: "",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                confirmButtonText: "保存",
                cancelButtonText: "取消",
                animation: "slide-from-top",
                inputPlaceholder: "请输入主题组name"
            },
            function (inputValue) {
                if (!inputValue) {
                    swal.showInputError("请输入name");
                    return false
                }
                var url = "{{route('admin.mini.theme.store',['_token'=>csrf_token()])}}";
                var data = {'name': inputValue}
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
                            location.href = "{{route('admin.mini.theme.index')}}";

                        });
                    }
                });

            });
    }



    function update(id,name) {
        swal({
                title: "修改主题组",
                text: "",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                confirmButtonText: "保存",
                cancelButtonText: "取消",
                animation: "slide-from-top",
                inputPlaceholder: "请输入主题组name",
                inputValue: name
            },
            function (inputValue) {
                if (!inputValue) {
                    swal.showInputError("请输入name");
                    return false
                }
                var url = "{{route('admin.mini.theme.update',['_token'=>csrf_token()])}}";
                var data = {'name': inputValue,'id':id}
                $.post(url, data, function (ret) {

                    if (!ret.status) {
                        swal("修改失败!", ret.message, "warning");
                    } else {
                        swal({
                            title: "修改成功",
                            text: "",
                            type: "success",
                            confirmButtonText: "确定"
                        }, function () {
                            location.href = "{{route('admin.mini.theme.index')}}";

                        });
                    }
                });

            });
    }




    $(document).ready(function () {
        var uploader = WebUploader.create({
            auto: true,
            swf: '{{url('libs/webuploader-0.1.5/Uploader.swf')}}',
            server: '{{route('admin.mini.theme.upload',['_token'=>csrf_token()])}}',
            pick: '#upload-json',
            fileVal: 'file',
            accept: {

            }
        })

        uploader.on('uploadSuccess', function (file, res) {
            if (res.status) {
                swal({
                    title: "导入成功",
                    text: '',
                    type: "success"
                }, function () {
                    location = '';
                });
            } else {
                swal({
                    title: "导入失败",
                    text: res.message,
                    type: "error"
                }, function () {
                    location = '';
                });

            }

        });

    })


    </script>



