# gitlab

## gitlab docker
```
// 拉取镜像
docker pull gitlab/gitlab-ce:latest

// 运行容器，映射宿主机路径可随意更改
docker run \
 -itd  \
 -p 9980:80 \
 -p 9922:22 \
 -v /usr/local/gitlab-test/etc:/etc/gitlab  \
 -v /usr/local/gitlab-test/log:/var/log/gitlab \
 -v /usr/local/gitlab-test/opt:/var/opt/gitlab \
 --restart always \
 --privileged=true \
 --name gitlab-test \
 gitlab/gitlab-ce

-i  以交互模式运行容器，通常与 -t 同时使用命令解释：
-t  为容器重新分配一个伪输入终端，通常与 -i 同时使用
-d  后台运行容器，并返回容器ID
-p 9980:80  将容器内80端口映射至宿主机9980端口，这是访问gitlab的端口
-p 9922:22  将容器内22端口映射至宿主机9922端口，这是访问ssh的端口
-v /usr/local/gitlab-test/etc:/etc/gitlab  将容器/etc/gitlab目录挂载到宿主机/usr/local/gitlab-test/etc目录下，若宿主机内此目录不存在将会自动创建，其他两个挂载同这个一样
--restart always  容器自启动
--privileged=true  让容器获取宿主机root权限
--name gitlab-test  设置容器名称为gitlab-test
gitlab/gitlab-ce  镜像的名称，这里也可以写镜像ID
```

```
// 进入容器修改ip配置
docker exec -it gitlab-test /bin/bash

// 打开改文件添加三行更改ip地址
vi /etc/gitlab/gitlab.rb
external_url 'http://192.168.0.33'
gitlab_rails['gitlab_ssh_host'] = '192.168.0.33'
gitlab_rails['gitlab_shell_ssh_port'] = 9922
```
保存后运行 gitlab-ctl reconfigure 会生成新的gitlab.yml文件
但external_url加端口号会导致无法访问，可以直接跳过该步骤直接修改gitlab.yml文件

```
// 打开配置文件
vi /opt/gitlab/embedded/service/gitlab-rails/config/gitlab.yml

修改gitlab属性中的host和port，以及ssh_host
修改gitlb_shell属性中的ssh_port

保存后退出运行 gitlab-ctl restart 完成重启
```

## gitlab-runner docker
```
// 拉取镜像
docker pull gitlab/gitlab-runner:latest

// 启动容器
docker run -d --name gitlab-runner --restart always \
-v /srv/gitlab-runner/config:/etc/gitlab-runner \
-v /var/run/docker.sock:/var/run/docker.sock \
gitlab/gitlab-runner

// 注册命令
gitlab-runner register
```

* Gitlab Runner在执行pipeline的时候，每一次都会拉取一次镜像，注册后修改config.toml文件优先拉取本地镜像
```
vi /etc/gitlab-runner/config.toml
打开文件后在runners.docker添加 pull_policy = "if-not-present" 
```