<extend name="../../Admin/View/Common/element_layout"/>

<block name="content">

    <div id="app" style="padding: 8px;" v-cloak>
        <el-card>
            <h3>选择视频</h3>

            <div>
                <template v-for="(file, index) in form.uploadedFileList">
                    <div class="imgListItem">
                        <img :src="file.cover_url" :alt="file.cover_url" style="width: 128px;height: 128px;">
                        <div class="deleteMask" @click="deleteItem(index)">
                            <span style="line-height: 128px;font-size: 22px" class="el-icon-delete"></span>
                        </div>
                    </div>
                </template>
            </div>

            <el-button type="primary" @click="uploadAliyunVideo">上传视频</el-button>
            <el-button type="primary" @click="onSubmit">保存</el-button>
        </el-card>
    </div>

    <style>
        .imgListItem {
            height: 128px;
            border: 1px dashed #d9d9d9;
            border-radius: 6px;
            display: inline-flex;
            margin-right: 10px;
            margin-bottom: 10px;
            position: relative;
            cursor: pointer;
            vertical-align: top;
        }

        .deleteMask {
            position: absolute;
            top: 0;
            left: 0;
            width: 128px;
            height: 128px;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.6);
            color: #fff;
            font-size: 40px;
            opacity: 0;
        }

        .deleteMask:hover {
            opacity: 1;
        }
    </style>

    <script>
        $(document).ready(function () {
            new Vue({
                el: '#app',
                data: {
                    form: {
                        uploadedFileList : []
                    }
                },
                watch: {},
                filters: {},
                methods: {
                    onSubmit: function(){
                        console.log(this.form);
                        this.$message.success('提交成功');
                    },
                    uploadAliyunVideo:function () {
                        //type 的字段可自行添加或编辑
                        var url = "{:U('Aliyunvideo/VideoPanel/fileUploadPanel',['type'=>1])}";
                        url += "&is_group=1";  //是否开启分组功能 1为开启
                        url += "&is_delete=1"; //是否开启删除功能 1为开启
                        layer.open({
                            type: 2,
                            title: '选择使用视频',
                            content: url,
                            area: ['80%', '595px;']
                        })
                    },
                    deleteItem: function (index) {
                        this.form.uploadedFileList.splice(index, 1)
                    }, onUploadedFile:function (event) {
                        //获取视频
                        var that = this;
                        var files = event.detail.files;
                        $.ajax({
                            url: "{:U('VideoDemo/aliyunVideoPlay')}",
                            data: {
                                video_id : files
                            }, dataType: 'json',
                            type: 'post',
                            success: function (res) {
                                that.form.uploadedFileList.push(res.data);
                            }
                        });
                    }
                },
                mounted: function () {
                    window.addEventListener('ZTBCMS_ALIYUNVIDEO_VIDEO_FILE', this.onUploadedFile.bind(this));
                }
            })
        })
    </script>
</block>
