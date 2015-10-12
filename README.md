# zmail
一个简易的邮件发送服务，用于异步化邮件发送。

运行
--------
1) git clone https://github.com/shenzhe/zphp, 添加到include_path

2) 修改 init.d/mail_server里的PHP_BIN 和 SERVER_PATH两个配置

3)chmod +x init.d/mail_server //你也可以把mail_server加到系统的/etc/init.d 里，用chkconfig可设置开机启动

4) 修改 config/default/config.php里的 mail 邮件服务相关配置(smtp地址、用户名、密码等)

5) ./init.d/mail_server start   //运行mail服务，

6) 输入ps auxf|grep zmail|grep -v grep 查看服务进程是否启动

7) 修改client.php里的 目标邮箱地址， 执行 php client.php， 查收邮件


todo
-----------
1) 邮件发送失败重试

2) 邮件发送状态报表汇总

3) 后台管理
