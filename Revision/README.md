# 文档版本管理插件

Typecho是一个多用户内容编辑平台，对于这类站点来说，内容是最有价值的东西。

版本管理系统我们用得很多，TE是否也能提供一套文档内容的版本机制呢？

首先，TE的钩子点刚好预留了相关机制。Widget_Contents_Post_Edit/Widget_Contents_Page_Edit均留出了write(内容完成保存)、finishPublish(内容保存完后，完成发布相关数据操作)、finishSave(内容保存完后，完成草稿相关数据操作)三个钩子点。

一般来说，内容正式发布时，才有保留版本的意义。所以，插件只要在Widget_Contents_Post_Edit/Widget_Contents_Page_Edit的finishPublish钩子点注册相关操作即可。

设计机制是简单快速的，做UI是做费时的，所以该插件先实现版本保存的机制，后续的版本查看、对比、内容反转等UI操作功能后续再说吧。

功能清单：

  * [*] 发布文档时保存版本
  * [ ] 版本查看 #1
  * [ ] 版本对比
  * [ ] 版本发转恢复
  * [ ] 版本清理？