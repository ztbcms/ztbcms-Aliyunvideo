<extend name="../../Admin/View/Common/element_layout"/>

<block name="content">
    <div id="app" style="padding: 8px;" v-cloak>
        <el-card>
            <h3>阿里云设置</h3>
            <el-row>
                <el-col :span="8">
                    <div class="grid-content ">
                        <el-form ref="form" :model="form" label-width="160px">
                            <el-form-item label="accesskey_id">
                                <el-input v-model="form.accesskey_id"></el-input>
                            </el-form-item>

                            <el-form-item label="accesskey_secret">
                                <el-input v-model="form.accesskey_secret"></el-input>
                            </el-form-item>

                            <el-form-item label="视频的有效期">
                                <el-input type="number" placeholder="天" v-model="form.video_valid_time"></el-input>
                            </el-form-item>

                            <el-form-item>
                                <el-button type="primary" @click="onSubmit">保存成功</el-button>
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
                    }
                },
                mounted: function () {

                }
            })
        })
    </script>
</block>
