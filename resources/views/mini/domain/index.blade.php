<div class="ibox float-e-margins">

    <div class="ibox-content">

        <div class="panel-body">
            <div class="col-sm-2">

            </div>
            <div class="alert col-sm-8">
                <strong> 提示：需要先将域名登记到第三方平台的小程序服务器域名中，才可以调用接口进行配置.</strong>
                <br>
                <strong> 注意：域名格式只支持英文大小写字母，数字及'-'，不支持IP地址.
                    <span style="font-size: 16px;color: red">发布小程序默认覆盖以前域名地址.微信每月限制修改5次</span>
                </strong>
            </div>
        </div>

        <form action="{{route('admin.mini.domain.store')}}" method="post" id="store">


            <div class="panel-body">

                <div class="form-group">
                    <label class="col-sm-2 control-label text-right">request合法域名：</label>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">https://</span>
                            <input type="text" class="form-control taginput" name="requestdomain[]" placeholder=""

                                   @if(isset($requestdomain[0]))
                                   value="{{FilterHttpsAndWss($requestdomain[0])}}"
                                    @endif

                            />
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-primary" onclick="add('requestdomain',requestdomain)">添加</a>
                    </div>
                </div>

            </div>

            <div class="requestdomain">


                @if(count($requestdomain)>0)

                    @foreach($requestdomain as$k=> $item)

                        @if($k!=0)
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label text-right"></label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">https://</span>
                                            <input type="text" class="form-control taginput" name="requestdomain[]"
                                                   placeholder="" value="{{FilterHttpsAndWss($item)}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <a class="btn btn-danger delete">删除</a>
                                    </div>
                                </div>
                            </div>

                        @endif

                    @endforeach

                @endif


            </div>


            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label text-right">socket合法域名：</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">wss://</span>
                            <input type="text" class="form-control taginput" name="wsrequestdomain[]" placeholder=""

                                   @if(isset($wsrequestdomain[0]))
                                   value="{{FilterHttpsAndWss($wsrequestdomain[0])}}"
                                    @endif
                            />
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-primary" onclick="add('wsrequestdomain',wsrequestdomain)">添加</a>
                    </div>
                </div>
            </div>


            <div class="wsrequestdomain">

                @if(count($wsrequestdomain)>0)

                    @foreach($wsrequestdomain as$k=> $item)

                        @if($k!=0)
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label text-right"></label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">wss://</span>
                                            <input type="text" class="form-control taginput" name="wsrequestdomain[]"
                                                   placeholder="" value="{{FilterHttpsAndWss($item)}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <a class="btn btn-danger delete">删除</a>
                                    </div>
                                </div>
                            </div>

                        @endif

                    @endforeach

                @endif


            </div>


            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label text-right">uploadFile合法域名：</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">https://</span>
                            <input type="text" class="form-control taginput" name="uploaddomain[]" placeholder=""


                                   @if(isset($uploaddomain[0]))
                                   value="{{FilterHttpsAndWss($uploaddomain[0])}}"
                                    @endif

                            >
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-primary" onclick="add('uploaddomain',uploaddomain)">添加</a>
                    </div>
                </div>
            </div>


            <div class="uploaddomain">

                @if(count($uploaddomain)>0)

                    @foreach($uploaddomain as$k=> $item)

                        @if($k!=0)
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label text-right"></label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">https://</span>
                                            <input type="text" class="form-control taginput" name="uploaddomain[]"
                                                   placeholder="" value="{{FilterHttpsAndWss($item)}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <a class="btn btn-danger delete">删除</a>
                                    </div>
                                </div>
                            </div>

                        @endif

                    @endforeach

                @endif

            </div>


            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label text-right">downloadFile合法域名：</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">https://</span>
                            <input type="text" class="form-control taginput" name="downloaddomain[]" placeholder=""

                                   @if(isset($downloaddomain[0]))
                                   value="{{FilterHttpsAndWss($downloaddomain[0])}}"
                                    @endif

                            />
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <a class="btn btn-primary" onclick="add('downloaddomain',downloaddomain)">添加</a>
                    </div>

                </div>
            </div>


            <div class="downloaddomain">

                @if(count($downloaddomain)>0)

                    @foreach($downloaddomain as$k=> $item)

                        @if($k!=0)
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label text-right"></label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">https://</span>
                                            <input type="text" class="form-control taginput" name="downloaddomain[]"
                                                   placeholder="" value="{{FilterHttpsAndWss($item)}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <a class="btn btn-danger delete">删除</a>
                                    </div>
                                </div>
                            </div>

                        @endif

                    @endforeach

                @endif

            </div>


            <input type="hidden" name="_token" value="{{csrf_token()}}">

            <div class="panel-body">

                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit">保存</button>
                    </div>
                </div>

            </div>


        </form>

    </div>
</div>

@include('wechat-platform::mini.domain.script')
@include('wechat-platform::includes.common')

<script>
    var max = 4;

    function add(id, str) {
        var div = $('.' + id);
        var len = div.find(".panel-body").length;
        if (len < max) {
            div.append(str);
        }
        return;
    }

    $("body").on("click", ".delete", function (e) {
        $(this).parent().parent().parent('div').remove();

    });
</script>


<script>
    $('#store').ajaxForm({
        success: function (result) {
            if (!result.status) {
                swal("保存失败!", result.message, "error")
            } else {
                swal({
                    title: "保存成功！",
                    text: "",
                    type: "success"
                }, function () {
                    location = '';
                });
            }

        }
    });
</script>


