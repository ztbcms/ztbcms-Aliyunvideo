<extend name="../../Admin/View/Common/element_layout"/>
<block name="title"></block>

<block name="content">
    <div id="app" v-cloak>
        <div class="wrapper">
            <div class="content-wrapper" style="margin-left:0;width:100%;">
                <section class="content">
                    <el-card  style="margin-bottom: 10px;" >
                        <!-- 基本信息-->
                        <div class="col-sm-2 col-md-2 col-lg-2 padding-l_0">
                            <el-input placeholder="新增分组" v-model="cate_name"></el-input>
                        </div>
                        <el-button style="margin-left: 20px;margin-top: 20px;"type="primary" @click="confirm" >保存</el-button>
                    </el-card>
            </div>
        </div>
        </section>
    </div>

</block>

<block name="footer">

    <script>
        $(document).ready(function () {
            new Vue({
                el: "#app",
                data: function () {
                    return {
                        cate_id:'{:I("get.cate_id")}',
                        cate_name : ''
                    };
                },
                mounted: function () {
                    if(this.cate_id){
                        this.getDetail();
                    }
                },
                methods: {
                    closeIframe: function () {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                    },
                    getDetail: function () {
                        var that = this;
                        var url = '{:U("VideoGroup/getGroupFind")}';
                        var data = {
                            cate_id:that.cate_id
                        };
                        that.httpGet(url,data, function (res) {
                            if(res.status){
                                that.cate_name = res.data.cate_name;
                            }
                        });
                    },
                    closePanel: function(){
                        if(parent.window.layer){
                            parent.window.layer.closeAll();
                        }else{
                            window.close();
                        }
                    },
                    confirm: function () {
                        var that  = this;
                        $.ajax({
                            url: "{:U('VideoGroup/addEditGroup')}",
                            data: {
                                cate_id:that.cate_id,
                                cate_name:that.cate_name
                            },
                            dataType: 'json',
                            type: 'post',
                            success: function (res) {
                                if(res.status){
                                    that.closePanel();
                                } else {
                                    that.$message.error(res.msg);
                                }
                            }
                        })
                    }
                }
            });
        });
    </script>

</block>