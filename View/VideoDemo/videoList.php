<extend name="../../Admin/View/Common/element_layout"/>

<block name="content">
    <div id="app" style="padding: 8px;" v-cloak>
        <el-card>
            <h3>视频列表</h3>

            <div class="filter-container">
                <el-input v-model="listQuery.video_id" placeholder="video_id" style="width: 200px;"
                          class="filter-item">
                </el-input>

                <el-button class="filter-item" type="primary" @click="getList" icon="el-icon-search">搜索</el-button>

                <el-button class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-edit" @click="getAddEditGoods">
                    添加
                </el-button>

            </div>
            <el-table
                    :key="tableKey"
                    :data="list"
                    border
                    fit
                    highlight-current-row
                    style="width: 100%;"
            >
                <el-table-column label="ID" prop="id"  align="center" width="80">
                    <template slot-scope="scope">
                        <span>{{ scope.row.id }}</span>
                    </template>
                </el-table-column>

                <el-table-column label="视频封面">
                    <template slot-scope="{row}">
                        <a v-if="row.is_aliyun == '1'" target="_blank" :href="row.url">
                            <img :src="row.cover_url" style="width: 100px;">
                        </a>
                        <span v-if="row.is_aliyun == '0'">上传失败</span>
                    </template>
                </el-table-column>

                <el-table-column label="video_id">
                    <template slot-scope="{row}">
                        <el-tag>{{ row.video_id }}</el-tag>
                    </template>
                </el-table-column>

                <el-table-column label="该凭证上传是否成功" width="150px" align="center">
                    <template slot-scope="scope">
                        <span>{{ scope.row.is_aliyun_name }}</span>
                    </template>
                </el-table-column>

                <el-table-column label="上传时间" width="150px" align="center">
                    <template slot-scope="scope">
                        <span>{{ scope.row.add_time_name }}</span>
                    </template>
                </el-table-column>

                <el-table-column label="最后编辑时间" width="150px" align="center">
                    <template slot-scope="scope">
                        <span>{{ scope.row.edit_time_name }}</span>
                    </template>
                </el-table-column>

                <el-table-column label="视频有效期" width="150px" align="center">
                    <template slot-scope="scope">
                        <span>{{ scope.row.expire_time_name }}</span>
                    </template>
                </el-table-column>


                <el-table-column label="管理" align="center" width="230" class-name="small-padding fixed-width">
                    <template slot-scope="{row}">
                        <el-button size="mini" type="danger" @click="deleteVideo(row.id)">
                            删除
                        </el-button>
                    </template>
                </el-table-column>

            </el-table>

            <div class="pagination-container">
                <el-pagination
                        background
                        layout="prev, pager, next, jumper"
                        :total="total"
                        v-show="total>0"
                        :current-page.sync="listQuery.page"
                        :page-size.sync="listQuery.limit"
                        @current-change="getList"
                >
                </el-pagination>
            </div>

        </el-card>
    </div>

    <style>
        .filter-container {
            padding-bottom: 10px;
        }
        .pagination-container {
            padding: 32px 16px;
        }
    </style>

    <script>
        $(document).ready(function () {
            new Vue({
                el: '#app',
                data: {
                    form: {},
                    tableKey: 0,
                    list: [],
                    total: 0,
                    listQuery: {
                        page: 1,
                        limit: 20,
                        video_id : ''
                    }
                },
                watch: {},
                filters: {

                },
                methods: {
                    getAddEditGoods:function () {
                        var that = this;
                        layer.open({
                            type: 2,
                            title: ['上传视频'],
                            content: "{:U('addEditVideo')}",
                            area: ['100%', '100%'],
                            end:function(){
                                that.getList();
                            }
                        })
                    },
                    getList: function() {
                        var that = this;
                        var url = '{:U("videoList")}';
                        var data = {
                            listQuery: that.listQuery
                        };
                        that.httpGet(url, data, function(res){
                            if(res.status){
                                that.list = res.data.items;
                                that.page = res.data.page;
                                that.total = parseInt(res.data.total_items);
                                that.page_count = res.data.total_pages;
                                that.postData = res.data.postData;
                            }else{
                                layer.msg(res.msg, {time: 1000});
                            }
                        });
                    },
                    deleteVideo: function(id) {
                        var that = this;
                        var url = '{:U("deleteVideo")}';
                        var data = {
                            'id' : id
                        };
                        that.httpGet(url, data, function(res){
                            that.getList();
                        });
                    }
                },
                mounted: function () {
                    this.getList();
                }

            })
        })
    </script>
</block>
