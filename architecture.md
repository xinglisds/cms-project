## 🗂️ cms-project 项目结构说明（Laravel + MySQL）

本文件描述本项目的文件目录结构与数据库结构，用于开发者协作、代码组织、迁移/部署参考。

---

### ✅ 一、项目文件目录结构

```
cms-project/
├── app/
│   ├── Models/                  # 所有模型类（Article, Comment, Subscriber, Ad）
│   ├── Http/
│   │   ├── Controllers/         # 控制器：用户端 + 后台 admin/
│   │   ├── Middleware/          # 中间件，如 admin 权限控制
│   │   └── Requests/            # 表单验证类（如 StoreArticleRequest）
├── database/
│   ├── migrations/              # 数据库建表迁移文件
│   ├── factories/               # 数据工厂（用于测试填充）
│   └── seeders/                 # 数据填充器（如初始化数据）
├── public/
│   └── storage/                 # 图片访问路径（软链接）
├── resources/
│   ├── views/
│   │   ├── articles/            # 文章列表、详情页 Blade 视图
│   │   ├── comments/            # 评论模块 Blade 视图
│   │   ├── admin/               # 后台界面
│   │   └── layouts/             # 公共布局模板
├── routes/
│   ├── web.php                  # 前台路由
│   └── admin.php (可选)         # 可拆分后台路由
├── storage/
│   └── app/public/cover_images/ # 上传图片原始目录
├── .cursor/
│   └── rules.mdc               # Cursor 工程约束规则文件
├── tasks.md                    # 项目任务拆解列表（每个任务可被 LLM 执行）
├── .env                        # 本地配置环境变量
└── README.md
```

---

### ✅ 二、数据库结构（MySQL）

#### users 表（Breeze 默认）

| 字段名                       | 类型                | 描述       |
| ------------------------- | ----------------- | -------- |
| id                        | BIGINT            | 主键，自增    |
| name                      | VARCHAR           | 用户名      |
| email                     | VARCHAR（唯一）       | 邮箱，用于登录  |
| password                  | VARCHAR           | 加密密码     |
| role                      | ENUM(admin, user) | 用户角色     |
| email\_verified\_at       | TIMESTAMP         | 邮箱验证时间   |
| remember\_token           | VARCHAR           | 登录 token |
| created\_at / updated\_at | TIMESTAMP         | 时间戳      |

#### articles 表

| 字段名                       | 类型          | 描述        |
| ------------------------- | ----------- | --------- |
| id                        | BIGINT      | 主键，自增     |
| title                     | VARCHAR     | 文章标题      |
| slug                      | VARCHAR（唯一） | URL 片段    |
| content                   | LONGTEXT    | 正文内容      |
| cover\_image              | VARCHAR     | 封面图路径     |
| is\_imported              | BOOLEAN     | 是否 RSS 导入 |
| source\_url               | VARCHAR     | 原始链接      |
| created\_at / updated\_at | TIMESTAMP   | 时间戳       |

#### comments 表

| 字段名                       | 类型        | 描述      |
| ------------------------- | --------- | ------- |
| id                        | BIGINT    | 主键，自增   |
| article\_id               | BIGINT    | 外键：所属文章 |
| user\_id                  | BIGINT    | 外键：评论用户 |
| content                   | TEXT      | 评论内容    |
| created\_at / updated\_at | TIMESTAMP | 时间戳     |

#### subscribers 表

| 字段名                       | 类型          | 描述    |
| ------------------------- | ----------- | ----- |
| id                        | BIGINT      | 主键，自增 |
| email                     | VARCHAR（唯一） | 订阅邮箱  |
| created\_at / updated\_at | TIMESTAMP   | 时间戳   |

#### ads 表

| 字段名                       | 类型        | 描述              |
| ------------------------- | --------- | --------------- |
| id                        | BIGINT    | 主键，自增           |
| title                     | VARCHAR   | 广告标题            |
| image                     | VARCHAR   | 图片路径            |
| target\_url               | VARCHAR   | 跳转链接            |
| position                  | ENUM      | 展示位置（如 sidebar） |
| active\_from              | DATETIME  | 起始时间            |
| active\_to                | DATETIME  | 结束时间            |
| created\_at / updated\_at | TIMESTAMP | 时间戳             |

---

以上结构支持完整的文章管理、评论系统、订阅推送、广告组件和后台总览功能，可扩展 SEO、权限、定时发布等模块。
