<div class="ibox float-e-margins">

    <div class="ibox-content">

        <form action="{{route('admin.mini.theme.item.store',['theme_id'=>request('theme_id'),'type'=>2])}}" method="post" id="store">


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
                    <label class="col-sm-2 control-label text-right">*自定义参数:</label>

                    <div class="col-sm-8 bars_textarea">

                        <textarea  class="form-control" name="param" id="" cols="30" rows="10"></textarea>

                    </div>

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

@include('wechat-platform::includes.common')
<script>

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


            if(input['param']==''){
                swal("保存失败!", '自定义参数', "error")
                return false;
            }

            if(!isJsonString(input['param'])){
                swal({
                    title: "保存失败!",
                    text: '请输入正确的json格式',
                    type: "error"
                });
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
                    location = "{{route('admin.mini.theme.item',['theme_id'=>request('theme_id')])}}"+'&type=2';
                });
            }

        }
    });


    function isJsonString(str) {
        try {
            if (typeof JSON.parse(str) == "object") {
                return true;
            }
        } catch (e) {
        }
        return false;

    }


</script>






