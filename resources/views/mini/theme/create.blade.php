<style>
    .input-group-addon{
        border: none;

    }
    .colorpicker-element .input-group-addon i{
        width: 30px;
        height: 30px;
        margin-top: -5px;
    }
</style>

<script>
    function show(k,v){
        $('#show-k').val(k);
        $('#show-v').val(v);

    }
</script>
<div class="ibox float-e-margins">

    <div class="ibox-content">

        <form action="{{route('admin.mini.theme.item.store',['theme_id'=>request('theme_id')])}}" method="post" id="store">


            <div class="panel-body">

                <div class="form-group">
                    <label class="col-sm-2 control-label text-right">*标题:</label>

                    <div class="col-sm-8">

                        <input type="text" class="form-control taginput" name="title" placeholder="" value="" />

                    </div>

                </div>

            </div>

            <div class="panel-body">

                <div class="form-group">
                    <label class="col-sm-2 control-label text-right">*封面图</label>

                    <div class="col-sm-8">

                        <div id="upload-img"  class="pull-left col-sm-4">
                            <span id="imguping"  data-style="expand-right"  class="but ladda-button " type="submit" disabled ><span id="scspan">上传封面</span></span>
                        </div>

                        <img  style="margin-left: -180px;"  id="img-img" width="150" height="180" src="" alt="">

                        <input  type="hidden" id="img" class="form-control taginput" name="img" placeholder="" value="" />


                    </div>


                </div>

            </div>

            <div id="param">

                <div class="panel-body">

                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">*自定义属性：</label>

                        <div class="col-sm-3">
                            <div class="input-group">
                                <span class="input-group-addon">key</span>
                                <input type="text" class="form-control taginput" name="key[]" placeholder="" id="show-k"  />
                            </div>

                        </div>

                        <div class="col-sm-3">
                            <div class="input-group">
                                <span class="input-group-addon">value</span>
                                <input type="text" class="form-control taginput" name="value[]" placeholder="" id="show-v" />
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="input-group colorpicker-component color" data-color="#000000" title="Using data-color attribute in the colorpicker element">
                                <input style="display: none" type="text" class="form-control color_input" value="#000000"/>
                                <span class="input-group-addon color-box"><i></i></span>
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <a class="btn btn-primary" onclick="add('param',param)">添加</a>
                        </div>
                    </div>

                </div>

                <div class="param">


                </div>


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


<script type="text/javascript">

    $('#param').on('click','.color-box',function () {
        var color=$(this).siblings('.color_input').val();
        $(this).siblings('.color_input').parent().parent().siblings('.col-sm-3').eq(1).find('input').val(color);
    })
    $(function () {
        $('.color').colorpicker();

    });

</script>


@include('wechat-platform::mini.theme.script')
@include('wechat-platform::includes.common')

<script>

    var max = 50;

    function add(id, str) {

        var div = $('.' + id);
        var len = div.find(".panel-body").length;
        if (len < max) {
            div.append(str);
        }
        $('.color').colorpicker();
        return;
    }

    $("body").on("click", ".delete", function (e) {
        $(this).parent().parent().parent('div').remove();

    });

    $('#store').ajaxForm({

        beforeSubmit:function (data) {
            var input = [];
            $.each(data, function (k, v) {
                if (v.name !== "lenght") {
                    input[v.name] = v.value;
                }
            })

            if(input['title']==''){
                swal("保存失败!", '请输入标题', "error")
                return false;
            }

            if(input['img']==''){
                swal("保存失败!", '请上传封面图', "error")
                return false;
            }




        },

        success: function (result) {
            if (!result.status) {
                swal("保存失败!", result.message, "error")
            } else {
                swal({
                    title: "保存成功！",
                    text: "",
                    type: "success"
                }, function () {
                    location = "{{route('admin.mini.theme.item',['theme_id'=>request('theme_id')])}}";
                });
            }

        }
    });

    // 初始化Web Uploader图片上传
    $(document).ready(function () {
        // 初始化Web Uploader
        var uploader = WebUploader.create({
            auto: true,
            swf: '{{url('libs/webuploader-0.1.5/Uploader.swf')}}',
            server: '{{route('admin.wechat.mini.upload',['_token'=>csrf_token()])}}',
            pick: '#upload-img',
            fileVal: 'file',
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        })

        //图片上传成功
        uploader.on('uploadSuccess', function (file,res) {
            if(res.status){
                $("#img-img").attr('src',res.data)
                $("#img").val(res.data);
                $('#img-img').show();
            }else{
                swal({
                    title: "上传图片失败",
                    text: "",
                    type: "error"
                }, function () {
                    location = '';
                });

            }

        });
    });

</script>






