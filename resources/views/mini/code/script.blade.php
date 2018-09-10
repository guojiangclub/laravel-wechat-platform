<script>

    $('.tester-delete').on('click', function () {
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


    function tester_create() {
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

