## 阿里云视频点播

实际使用建议在有效期前两个小时更新视频路径

视频点播报错可参考 https://error-center.aliyun.com/status/product/vod 以下网址

1	视频点播	AuthInfo.NotExist	查询客户对应的Accesskey、bucket、domain信息为空	如多次遇到类似情况，请通过工单反馈给我们。

2	视频点播	OperationDenied.Suspended	Your VOD service is suspended.	账号已欠费，请充值

3	视频点播	UserNotFound	Your VOD service has not opened.	未找到该用户，上传，播放：需要开通点播服务才可以使用

4	视频点播	OperationDenied	Your account does not open VOD service yet.	账号未开通视频点播服务

5	视频点播	EDITING_PROJECT_VIDEOCOUNT_OFFSET	Video Count of the Editing Project is Exceeded Max	当前编辑项目中的视频数量已经超出限制（最多20个）

6	视频点播	Forbidden	User not authorized to operate on the specified resource.	用户无权限执行该操作

7	视频点播	EDITING_PROJECT_TOTOALDURATION_OFFSET	Total Duration of the Editing Project is Exceeded Max	当前编辑项目中的视频时长已经超出限制（最长2小时）

8	视频点播	VideoIdsExceededMax	The VideoIds exceeded maximum.	指定参数个数超过限制，批量删除最多支持20个VideoId

9	视频点播	InvalidVideoStream.Damaged	The video stream has been Damaged.	视频流信息已损坏，播放：获取到视频流信息才可以播放

10	视频点播	InvalidVideo.NotFound	The Video not exist.	视频ID不存在

11	视频点播	VideoListExceededMax	The video list exceeded maximum.	翻页总条数超过最大限制，获取视频信息列表。最大支持获取前5000条

12	视频点播	InvalidVideo.Damaged	The video has been Damaged.	视频创建有误或已被损坏

