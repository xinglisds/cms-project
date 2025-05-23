### 🧱 Laravel CMS 构建任务清单（项目名称：cms-project）

说明：每个任务是一个"最小可执行单元（atomic task）"，可被工程 LLM 单独执行并测试，任务拆分专注单一职责，具备明确输入、输出、验证标准。

> 本项目使用 **MySQL 数据库**，所有模型、迁移、查询、配置均基于 MySQL 编写。

---

#### ✅ Task 1: 初始化 Laravel 项目

* **目标**：使用 Laravel 安装新项目，并配置 `.env` 连接本地 MySQL 数据库（127.0.0.1）；部署时仅需切换 `.env` 即可连接云端数据库
* **输入**：MySQL 数据库连接信息（DB\_HOST/DB\_PORT/DB\_DATABASE/DB\_USERNAME/DB\_PASSWORD）
* **输出**：Laravel 项目运行成功，默认欢迎页可访问
* **测试**：浏览器访问 `/` 返回 Laravel 欢迎页

---

#### ✅ Task 2: 安装 Breeze 并启用用户系统

* **目标**：使用 `laravel/breeze` 添加认证功能
* **输入**：执行安装命令 + 运行 `migrate`
* **输出**：登录/注册界面、用户表、认证路由正常运行
* **测试**：注册新用户并登录成功

---

#### ✅ Task 3: 创建 `Article` 模型与迁移

* **目标**：使用 Artisan 创建模型、迁移和工厂
* **字段**：title, slug, content, cover\_image, is\_imported, source\_url
* **测试**：迁移成功，DB 中生成 `articles` 表

---

#### ✅ Task 4: 创建 `Comment` 模型与迁移

* **目标**：定义与 Article、User 的关联（BelongsTo）
* **字段**：article\_id, user\_id, content
* **测试**：可通过 Tinker 添加一条评论记录并查看关联

---

#### ✅ Task 5: 构建 `ArticleController` 与资源路由

* **目标**：实现文章的 index/show 路由与控制器
* **输出**：`/articles`, `/articles/{slug}` 能正确渲染文章内容
* **测试**：添加测试文章，访问详情页内容正确显示

---

#### ✅ Task 6: 使用 Blade 构建文章视图

* **目标**：实现布局文件 + 首页文章卡片列表 + 文章详情页
* **布局**：使用 `layouts/app.blade.php`，组件化文章卡片
* **测试**：首页和详情页排版正常，结构语义清晰

---

#### ✅ Task 7: 创建 `CommentController` + 添加评论表单

* **目标**：实现登录用户可提交评论，存入数据库
* **前提**：登录状态判断 + 表单验证
* **测试**：提交评论后页面刷新并显示评论

---

#### ✅ Task 8: 构建 Admin Middleware + 后台路由保护

* **目标**：设置 `role` 字段与中间件，限制后台访问
* **测试**：非 admin 用户访问 `/admin` 被拒绝

---

#### ✅ Task 9: 构建 Admin 后台面板（Dashboard）

* **目标**：创建 `/admin/dashboard` 页面，展示系统数据总览：文章数量、评论数量、订阅者数量，供管理员快速掌握内容和活跃度
* **技术**：Blade + Eloquent 聚合查询（count）
* **测试**：管理员登录后进入后台可看到统计数据：

  * 文章总数
  * 评论总数
  * Newsletter 邮箱订阅总数（newsletter）

---

#### ✅ Task 10: 后台文章发布与编辑

* **目标**：实现文章发布表单，支持上传封面图并使用 Laravel Storage 存储图片文件，默认存入本地 storage 目录，预留切换 AWS S3 云存储接口（通过 `.env` 配置 `FILESYSTEM_DISK` 切换）
* **技术说明**：

  * 使用 `$request->file('cover')->store('cover_images', 'public')` 存储封面图
  * 使用 `php artisan storage:link` 实现本地访问路径
  * 支持未来替换为 `Storage::disk('s3')->put(...)` 上传至 AWS S3
* **测试**：成功创建文章后，封面图文件存储成功，网页中可正确显示图片

---

#### ✅ Task 11: 实现文章 slug 自动生成 + 路由绑定

* **目标**：在保存文章时自动生成 slug，使用 `Route::modelBinding`
* **测试**：通过 `/articles/{slug}` 正确读取文章

---

#### ✅ Task 12: 添加订阅表单 + `Subscriber` 模型

* **目标**：实现 newsletter 邮箱订阅功能：用户在前台输入邮箱后，系统验证并保存至 `subscribers` 表，避免重复订阅，后续可用于群发邮件
* **逻辑**：

  * 表单提交：用户填写邮箱
  * 后端验证：检查格式、去重
  * 数据库存储：写入 `subscribers` 表
  * 成功反馈：页面显示订阅成功提示
* **扩展建议**：可在未来添加邮件发送任务或导出功能
* **测试**：输入邮箱提交后在 `subscribers` 表中新增记录，重复提交提示已订阅

---

#### ✅ Task 13: 创建广告模型 `Ad` + 展示组件

* **目标**：创建 `ads` 表，展示 `active` 广告图于文章右侧
* **测试**：上传广告图后能正确展示于页面组件中

---

#### ✅ Task 14: RSS 新闻导入命令

* **目标**：创建 `php artisan import:rss` 命令，解析 RSS 并入库为文章
* **测试**：运行命令后 `articles` 表中出现 RSS 文章

---

#### ✅ Task 15: 添加动态 SEO 标签支持

* **目标**：在文章视图中生成 `<title>` `<meta>` `<link rel="canonical">`
* **测试**：查看源码确认 meta 信息与文章匹配

---

#### ✅ Task 16: JSON-LD 数据注入（结构化数据）

* **目标**：每篇文章页内添加 `NewsArticle` JSON-LD 区块
* **测试**：使用 Google Rich Results Test 验证结构化信息

---

#### ✅ Task 17: 后台评论管理面板

* **目标**：列出所有评论，支持删除操作
* **测试**：管理员删除评论后页面刷新该评论消失

---

#### ✅ Task 18: 生成 sitemap 路由

* **目标**：在 `/sitemap.xml` 输出所有文章 URL
* **测试**：打开链接返回标准 XML 并可被 Google 识别
