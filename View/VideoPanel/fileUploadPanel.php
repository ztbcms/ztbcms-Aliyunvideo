<extend name="../../Admin/View/Common/element_layout"/>

<block name="content">
    <link rel="stylesheet" href="{$jsLink}/aliyun-css/imageManage.css">

    <div id="app" style="" v-cloak>
        <div>
            <el-container style="height: 550px; border: 1px solid #eee;">
                <el-aside width="300px" style="background-color: #fff;border-right:1px solid #eee;height: 100%;overflow: hidden;position: relative">
                    <div style="overflow: auto;height: 480px;border-bottom: 1px solid #eee">
                        <template v-for="(item,index) in cate_list">
                            <div  class="btn-block" v-bind:class="{ 'btn-block1': selectedCate == index }" @click="selectCate(index,item)">
                                {{item.cate_name}}
                            </div>
                        </template>
                    </div>
                    <div class="aside-bottom" style="position: absolute;margin-left: 15px;line-height: 45px;">
                        <el-button type="success" size="small" @click="addGroup">新增分组</el-button>
                        <el-button type="primary" size="small" @click="editGroup">编辑分组</el-button>
                        <el-button type="danger" size="small" @click="delGroup">删除分组</el-button>
                    </div>
                </el-aside>

                <el-container style="flex-wrap：wrap;!important;position: relative">
                    <el-header style="margin-top: 10px;">
                        <el-button style="float: left;" @click="upload" type="primary">选择视频</el-button>
                        <el-button style="float: left;" onclick="jiance();" type="primary">开始上传</el-button>
                        <el-button style="float: left;" type="success" @click="moveToGroup" v-show="start_move">移动至其他分组</el-button>
                        <div style="display: none;width:300px;height:30px;background-color:#ccc;float: left; margin-top: 5px; margin-left: 20px;" id="huitiao">
                            <div style="width:0%;height:30px;background-color:#409EFF;" id="jindu"></div>
                        </div>
                    </el-header>

                    <el-container style="padding-left: 20px;display:-webkit-box;!important;">
                        <template v-for="(item,index) in galleryList">
                            <div :key="index"
                                 class="imgListItme">
                                <img :src="item.cover_url"  @click="selectImgEvent(index)" style="width:140px;height: 140px;" />
                                <div style="position: absolute;bottom: 0;background-color: #f0f0f0;width: 142px;text-align: center;overflow: hidden"><span>{{item.filename}}</span>
                                </div>
                                <i class="el-icon-error" @click="delimgListItme(item)" ></i>
                                <div v-if="type >0 ? isSelect ==  item.video_id: item.is_select " class="is_check" @click="selectImgEvent(index)">
                                    <span style="line-height: 142px;" class="el-icon-check"></span>
                                </div>
                            </div>
                        </template>
                    </el-container>


                    <el-footer>
                        <el-pagination
                            :page-size="pagination.limit"
                            :current-page.sync="pagination.page"
                            :total="pagination.total_items"
                            background
                            layout="prev, pager, next"
                            @current-change="getGalleryList"
                        >
                    </el-pagination>

                    </el-footer>
                    <div class="footer" style="padding-left:20px;background-color: #fff;margin-top: 10px;height: 66px;border-top:#eee;line-height: 66px; ">
                        <el-checkbox v-model="check_all" @change="changeCheck" v-show="start_move">全选</el-checkbox>
                        <el-button type="success" @click="start_move = false" v-show="start_move"  style="width: 120px;">取消移动分组</el-button>
                        <el-button type="success" @click="moveGroup" v-show="!start_move" style="width: 120px;">开始移动分组</el-button>
                        <el-button type="primary" @click="confirm">确定</el-button>
                        <el-button type="default" @click="closePanel">取消</el-button>
                    </div>
                </el-container>
            </el-container>

        </div>


    </div>


    <script>
        $(document).ready(function () {
            new Vue({
                el: '#app',
                data: {
                    pagination: {
                        page: 1,
                        limit: 10,
                        total_pages: 0,
                        total_items: 0
                    },
                    galleryList: [], //图库
                    cate_id:"{$_GET['cate_id']}",


                    isIndeterminate:true,
                    checkAll: false,
                    checkedCities: ['上海', '北京'],
                    type:2,
                    isSelect:'',
                    activeName: 'uploadLocal',
                    uploadConfig: {
                        uploadUrl: "{:U('Video/UploadAdminApi/uploadImage')}",
                        max_upload: 6,//同时上传文件数
                        accept: 'image/*' //接收的文件类型，请看：https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input#attr-accept
                    },
                    uploadedLocalFileList: [], //本地上传的文件
                    form: {
                        search_date: [],
                        uid: '',
                        ip: '',
                        start_time: '',
                        end_time: '',
                        status: '',
                        sort_time: '',//排序：时间
                    },
                    orgin_type:0,
                    check_all:false,
                    selectedCate:'',
                    cate_list:[],
                    start_move:false
                },
                watch: {},
                computed: {
                    selectdImageList: function () {
                        var result = [];
                        if (this.activeName == 'uploadLocal') {
                            this.uploadedLocalFileList.forEach(function (file) {
                                result.push({
                                    url: file.url,
                                    name: file.name
                                })
                            })
                        }

                        if (this.activeName == 'gallery') {
                            this.galleryList.forEach(function (file) {
                                if (file.is_select) {
                                    result.push({
                                        url: file.url,
                                        name: file.name
                                    })
                                }
                            })
                        }

                        return result;
                    }
                },
                filters: {

                },
                methods: {
                    getGroupList: function () {
                        var that = this;
                        $.ajax({
                            url: "{:U('VideoGroup/getGroupList')}",
                            data: {

                            },
                            dataType: 'json',
                            type: 'post',
                            success: function (res) {
                                if(res.state){
                                    var data = res.data;
                                    that.cate_list = data.videoGroupList;
                                }
                                that.cate_id = data.videoGroupList[0]['id'];
                                that.getGalleryList();



//                                that.pagination.page = data.page;
//                                that.pagination.limit = data.limit;
//                                that.pagination.total_pages = data.total_pages;
//                                that.pagination.total_items = data.total_items;
//                                var list = [];
//                                data.items.video_list.map(function (item) {
//                                    item.is_select = false;
//                                    list.push(item);
//                                });
//                                that.galleryList = list
                            }
                        })
                    }, addGroup: function () {
                        var that = this;
                        layer.open({
                            type: 2,
                            title: '添加分组',
                            content: "{:U('VideoGroup/addEditGroup')}",
                            area: ['600px', '220px'],
                            end: function (res) {
                                that.getGroupList();
                            }
                        })
                    },editGroup: function () {
                        var that = this;
                        layer.open({
                            type: 2,
                            title: ' 编辑分组',
                            content: "{:U('VideoGroup/addEditGroup')}&cate_id="+that.cate_id,
                            area: ['600px', '220px'],
                            end: function (res) {
                                that.getGroupList();
                            }
                        })
                    },delGroup: function () {
                        var that = this;
                        layer.confirm('确认删除该分类吗？',{btn:['确认','取消']}, function () {
                            $.ajax({
                                url: "{:U('VideoGroup/delGroup')}",
                                data: {
                                    cate_id:that.cate_id
                                },
                                dataType: 'json',
                                type: 'post',
                                success: function (res) {
                                    if(res.status){
                                        that.getGroupList();
                                        layer.closeAll();
                                    }else{
                                        layer.msg(res.msg)
                                    }
                                }
                            })
                        })
                    } , getGalleryList: function () {
                        var that = this;
                        var where = {
                            page: that.pagination.page,
                            limit: that.pagination.limit,
                            group_id:that.cate_id
                        };
                        $.ajax({
                            url: "{:U('VideoPanel/getVideoList')}",
                            data: where,
                            dataType: 'json',
                            type: 'post',
                            success: function (res) {
                                var data = res.data;
                                that.pagination.page = data.page;
                                that.pagination.limit = data.videoGroupList;
                                that.pagination.total_pages = data.total_pages;
                                that.pagination.total_items = data.total_items;
                                $('#cate_ids').val(that.cate_id);
                                var list = [];
                                data.items.map(function (item) {
                                    item.is_select = false;
                                    list.push(item);
                                });
                                that.check_all = false;
                                that.galleryList = list
                            }
                        })
                    },


















                    moveGroup: function () {
                        this.start_move = true;
                        this.type = 2;
                    },
                    moveToGroup:function(){
                        var that = this;

                        var arr = [];
                        that.galleryList.forEach(function (item,index) {
                            if(item.is_select){
                                arr.push(item);
                            }
                        });

                        if(arr.length == 0){
                            layer.msg('请选择要移动的视频');return;
                        }
                        layer.open({
                            type: 2,
                            title: '移动至其它分组',
                            content: "{:U('Video/UploadVideo/selectGroup')}",
                            area: ['50%', '40%'],
                        })
                    },
                    selectCate: function (index,item) {
                        var that = this;
                        that.selectedCate = index;
                        that.cate_id = item.id;
                        that.getGalleryList();
                    },
                    changeCheck: function(){
                        var that = this;
                        that.galleryList.forEach(function(item,index){
                            item.is_select = that.check_all;
                        })
                    },
                    delimgListItme: function (item) {
                        var that = this;
                        layer.confirm('确认删除吗？',{btn:['确认','取消']}, function () {
                            $.ajax({
                                url: "{:U('Video/UploadVideo/delVideoListItem')}",
                                data: {video_id:item.id},
                                dataType: 'json',
                                type: 'post',
                                success: function (res) {
                                    that.getGalleryList();
                                    that.closePanel();
                                    that.type = that.orgin_type;
                                    that.start_move= false;
                                    that.check_all= false;
                                }
                            })
                        })
                    },
                    handleRemove: function () {

                    }, handleUploadSuccess: function (response, file, fileList) {
                        console.log(response)
                        if (response.status) {
                            this.uploadedLocalFileList.push({
                                name: response.data.name,
                                url: response.data.url,
                            })
                        }
                    },
                    handleUploadError: function () {
                        ELEMENT.Message.error('上传失败');
                    },
                    moveToOrderGroups: function (event) {
                        var that = this;
                        cate_id = event.detail.files;
                        var arr = [];
                        that.galleryList.forEach(function (item,index) {
                            if(item.is_select){
                                arr.push(item);
                            }
                        });
                        $.ajax({
                            url: "{:U('Video/UploadVideo/moveVideosToGroup')}",
                            data: {cate_id:cate_id,arr:arr},
                            dataType: 'json',
                            type: 'post',
                            success: function (res) {
                                that.getGalleryList();
                                that.type = that.orgin_type;
                                that.start_move = false;
                                that.check_all = false;
                            }
                        })
                    },
                    handleExceed: function(){
                        ELEMENT.Message.error('上传文件数量超限制');
                    },
                    selectImgEvent: function (index) {
                        this.galleryList[index]['is_select'] = true;
                        this.isSelect = this.galleryList[index].video_id;
                    },
                    confirm: function(){
                        var that= this;
                        files = that.isSelect;
                        if(that.type == 1){
                            event = new CustomEvent('ZTBCMS_UPLOAD_VIDEO', {
                                detail: {
                                    files: files
                                }
                            });
                        }else if(that.type == 2){
                            event = new CustomEvent('ZTBCMS_UPLOAD_CONTENT_VIDEO', {
                                detail: {
                                    files: files,
//                                type: that.type,
//                                itemIndex : that.itemIndex,
//                                content:that.content,
                                }
                            });
                        } else if(that.type == 3){
                            event = new CustomEvent('ZTBCMS_UPLOAD_INSTALL_VIDEO', {
                                detail: {
                                    files: files
                                }
                            });
                        }  else if(that.type == 4){
                            event = new CustomEvent('ZTBCMS_UPLOAD_USE_VIDEO', {
                                detail: {
                                    files: files
                                }
                            });
                        }  else if(that.type == 5){
                            event = new CustomEvent('ZTBCMS_UPLOAD_SELECTION_VIDEO', {
                                detail: {
                                    files: files
                                }
                            });
                        }
                        window.parent.dispatchEvent(event);
                        this.closePanel();
                    },
                    closePanel: function(){
                        if(parent.window.layer){
                            parent.window.layer.closeAll();
                        }else{
                            window.close();
                        }
                    }

                },
                mounted: function () {

                    this.getGroupList();
                    window.addEventListener('MOVE_GROUP', this.moveToOrderGroups.bind(this));
                    this.uploadConfig.max_upload = parseInt(this.getUrlQuery('max_upload') || this.uploadConfig.max_upload);
                    this.type = parseInt(this.getUrlQuery('type'));
                    this.orgin_type = parseInt(this.getUrlQuery('type'));
                    this.content = this.getUrlQuery('content');
                    this.itemIndex = this.getUrlQuery('itemIndex');
                }
            })
        })
    </script>
</block>
