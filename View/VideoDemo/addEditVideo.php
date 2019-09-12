<extend name="../../Admin/View/Common/element_layout"/>

<block name="content">
    <div id="app" style="padding: 8px;" v-cloak>
        <el-card>
            <h3>阿里云视频上传</h3>
            <el-row>
                <el-col :span="8">
                    <div class="grid-content ">
                        <el-form ref="form" :model="form" label-width="160px">
                            <form style="display: none;">
                                <div class="content">
                                    <input @change="ChangeFiles()" name="video" type="file" id="files"><br><br>
                                    <input id="uploadAuth" value="">
                                    <input id="uploadAddress" value="">
                                    <input id="videoId" value="">
                                    <input id="cate_ids" value="">
                                </div>
                            </form>

                            <el-button style="float: left;" @click="getFilesUpload" type="primary">选择视频</el-button>

                            <el-button style="float: left;"
                                       @click="getAliyunUploadVoucher()"
                                       type="primary">开始上传
                            </el-button>

                            <div style="display: none;width:300px;height:30px;background-color:#ccc;float: left; margin-top: 5px; margin-left: 20px;" id="callback">
                                <div style="width:0%;height:30px;background-color:#409EFF;" id="plan"></div>
                            </div>
                        </el-form>
                    </div>
                </el-col>
                <el-col :span="16"><div class="grid-content "></div></el-col>
            </el-row>
        </el-card>
    </div>

    <style>

    </style>

    <script src="{$jsLink}/aliyun-js/lib/es6-promise.min.js"></script>
    <script src="{$jsLink}/aliyun-js/lib/aliyun-oss-sdk-5.2.0.min.js"></script>
    <script src="{$jsLink}/aliyun-js/aliyun-upload-sdk-1.4.0.min.js"></script>
    <script>
        $(document).ready(function () {
            new Vue({
                el: '#app',
                data: {
                    form: {
                        accesskey_id: '{$videoConf.accesskey_id}',
                        accesskey_secret: '{$videoConf.accesskey_secret}',
                        video_valid_time: '{$videoConf.video_valid_time}'
                    }
                },
                watch: {},
                filters: {},
                methods: {
                    onSubmit: function(){
                        var that = this;
                        var url = '{:U("addEditVideoConf")}';
                        var data = this.form;
                        that.httpGet(url,data, function (res) {
                            if(res.status){
                                that.$message.success('保存成功');
                            } else {
                                that.$message.error(res.msg);
                            }
                        });
                    },
                    getFilesUpload:function(){
                        var that = this;
                        var files = $('#files');
                        files.trigger('click');
                    },
                    ChangeFiles:function () {
                        var f = document.getElementById("files").files;
                        if(f.length == 0) return;
                        $('#callback').css('display','block');
                        layer.msg('已选择好文件,请点击上传');
                    } ,getAliyunUploadVoucher:function () {
                        var that = this;
                        var f = document.getElementById("files").files;
                        $("#callback").css('display','block');
                        if(f.length == 0) return layer.alert('文件不能为空');
                        if(!f[0].name || f[0].name == '') return layer.alert('文件不能为空');
                        layer.msg('正在处理，进度条完成后上传成功',{
                            time:2000}
                        );
                        that.httpGet("{:U('aliyunUploadVoucher')}",{
                            "title" : f[0].name,
                            "name" : f[0].name
                        },function (res) {
                            if(res.status){
                                $("#uploadAuth").val(res.data.upload_auth);
                                $("#uploadAddress").val(res.data.upload_address);
                                $("#videoId").val(res.data.video_id);
                                var userData = '{"Vod":{"StorageLocation":"","UserData":{"IsShowWaterMark":"false","Priority":"7"}}}';
                                uploader.addFile(f[0], null, null, null, userData);
                                uploader.startUpload();
                            } else {
                                layer.alert(res.msg);
                            }
                        });
                    }
                },
                mounted: function () {

                }
            })
        })
    </script>

    <script>
        var uploader = new AliyunUpload.Vod({
            // 文件上传失败
            'onUploadFailed': function (uploadInfo, code, message) {
                var index = parent.layer.getFrameIndex(window.name);
                layer.alert('文件上传失败', function () {
                    parent.layer.close(index);
                });
            },
            // 文件上传完成
            'onUploadSucceed': function (uploadInfo) {
                setTimeout(function () {
                    onUploadSucceed(uploadInfo.videoId);
                }, 2000);
            },
            // 文件上传进度
            'onUploadProgress': function (uploadInfo, totalSize, loadedPercent) {
                $("#plan").css("width", (loadedPercent * 80.00).toFixed(2) + "%");
            },
            // STS临时账号会过期，过期时触发函数
            'onUploadTokenExpired': function (uploadInfo) {
                var index = parent.layer.getFrameIndex(window.name);
                layer.alert('文件上传失败', function () {
                    parent.layer.close(index);
                })
            },
            onUploadCanceled: function (uploadInfo) {
                var index = parent.layer.getFrameIndex(window.name);
                layer.alert('文件上传失败', function () {
                    parent.layer.close(index);
                })
            },
            // 开始上传
            'onUploadstarted': function (uploadInfo) {
                var uploadAuth = document.getElementById("uploadAuth").value;
                var uploadAddress = document.getElementById("uploadAddress").value;
                var videoId = document.getElementById("videoId").value;
                uploader.setUploadAuthAndAddress(uploadInfo, uploadAuth, uploadAddress, videoId);
            },
            'onUploadEnd': function (uploadInfo) {

            }
        });

        var global_num = 81;
        /*
         * 上傳成功
         */
        function onUploadSucceed(video_id) {
            window.__GLOBAL_ELEMENT_LOADING_INSTANCE_ENABLE = false;
            var index = parent.layer.getFrameIndex(window.name);
            $.post("{:U('aliyunVideoPlay')}", {
                "video_id": video_id
            }).success(function (data) {
                var res = $.parseJSON(data);
                if(res.status){
                    $("#plan").css("width", (100.00).toFixed(2) + "%");
                    layer.alert('上传成功', function () {
                        parent.layer.close(index);
                    });
                } else {
                    //两秒后再请求
                    setTimeout(function () {
                        if(global_num > 95)  global_num = 95;
                        $("#plan").css("width", (global_num).toFixed(2) + "%");
                        global_num = global_num + 6;
                        onUploadSucceed(video_id);
                    }, 2000);
                }
            });
        }
    </script>

</block>
