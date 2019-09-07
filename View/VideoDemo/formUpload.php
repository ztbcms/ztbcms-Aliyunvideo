<extend name="../../Admin/View/Common/element_layout"/>

<block name="content">
    <div id="app" style="padding: 8px;" v-cloak>
        <el-card>
            <h3>表单上传dump</h3>
            <el-row>
                <el-col :span="8">
                    <div class="grid-content ">
                        <el-form ref="form" :model="form" label-width="80px">
                            <el-form-item label="活动名称">
                                <el-input v-model="form.name"></el-input>
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
                        name: '',
                        region: '',
                        start_date: '',
                        start_time: '',
                        end_date: '',
                        end_time: '',
                        delivery: 0,
                        type: [],
                        enable: '1',
                        desc: ''
                    }
                },
                watch: {},
                filters: {},
                methods: {
                    onSubmit: function(){
                        console.log(this.form)
                        this.$message.success('提交成功');
                    },
                    onCancel: function(){
                        this.$message.error('已取消');
                    }
                },
                mounted: function () {

                }
            })
        })
    </script>
</block>
