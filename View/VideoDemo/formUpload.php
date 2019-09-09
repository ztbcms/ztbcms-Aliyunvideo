<extend name="../../Admin/View/Common/element_layout"/>

<block name="content">
    <div id="app" style="padding: 8px;" v-cloak>
        <el-card>
            <h3>表单上传dump</h3>
            <el-row>
                <el-col :span="8">
                    <div class="grid-content ">
                        <el-form ref="form" :model="form" label-width="80px">

                            <el-form-item>
                                <el-col :span="3">
                                    <el-button type="primary" @click="uploadAliyunVideo">选择视频</el-button>
                                </el-col>

                                <div class="imgListItem" v-if="use_video_url">
                                    <img :src="use_video_url"  style="width: 128px;height: 128px;">
                                    <div class="deleteMask" @click="deleteUseVideo">
                                        <span style="line-height: 128px;font-size: 22px" class="el-icon-delete"></span>
                                    </div>
                                </div>
                            </el-form-item>


                            <el-form-item>
                                <el-button type="primary" @click="onSubmit">保存</el-button>
                            </el-form-item>
                        </el-form>
                    </div>
                </el-col>
                <el-col :span="16"><div class="grid-content "></div></el-col>
            </el-row>


        </el-card>
    </div>

    <style>

    </style>

    <script>
        $(document).ready(function () {
            new Vue({
                el: '#app',
                data: {
                    form: {

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
                        layer.open({
                            type: 2,
                            title: '选择使用视频',
                            content: "{:U('Aliyunvideo/VideoPanel/fileUploadPanel',['type'=>1])}",
                            area: ['80%', '80%']
                        })
                    },
                    onUploadedFile:function (event) {
                        //获取视频
                        var files = event.detail.files;

                        console.log(files);
                        return;
                    }
                },
                mounted: function () {
                    window.addEventListener('ZTBCMS_ALIYUNVIDEO_VIDEO_FILE', this.onUploadedFile.bind(this));
                }
            })
        })
    </script>
</block>
