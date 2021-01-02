<?php
session_start();
if (isset($_SESSION['username'])){
    echo ("欢迎");
    echo ($_SESSION["username"]."<br>");
    echo ("你的email是".$_SESSION["email"]."<br>");
    echo ("你的phone是".$_SESSION["phone"]."<br>");
    echo ("你的注册时间是".$_SESSION["time"]."<br>");
    echo ("<a href='delete.php'>注销账户</a>");
}
elseif(isset($_POST['submit'])){

    $conn=new mysqli("localhost","root","123456","userbase");
    $conn->query("set names utf8");
    
    $sql="select * from userinfor where username='".$_POST["name"]."' and password='".MD5($_POST["pass"])."'";
    //使用md5加密密码 在验证时也进行加密后比较
	$result=$conn->query($sql) or die($conn->error());
    //die函数输出一条信息并退出当前脚本
	if(mysqli_num_rows($result)>0){
        $info=mysqli_fetch_assoc($result);
	    //session_start();
        $_SESSION['username']=$info['username'];
        //echo ($_SESSION['username']);
        $_SESSION['email']=$info['email'];
        $_SESSION['phone']=$info['phone'];
        $_SESSION['time']=$info['time'];
        setcookie(session_name(),session_id(),time()+60,"/");//https://www.cnblogs.com/lijiageng/p/6900298.html
	    echo ("欢迎");
        echo ($info["username"]."<br>");
        echo ("你的email是".$info["email"]."<br>");
        echo ("你的phone是".$info["phone"]."<br>");
        echo ("你的注册时间是".$info["time"]."<br>");
        echo ("<a href='delete.php'>注销账户</a>");

    }
          //header("location:homepage.php");
          //使用header跳转页面 Location和":"之间无空格
          //header('Refresh: 10; url=http://www.baidu.com/');  10s后跳转。
          //header相关内容php.cn/php-weizijiaocheng-394656.html
 	else{
 		$info="用户名或密码错误，请重新输入";
 		echo ($info);
 	}
}
else{?>
    <head>
        <meta charset="UTF-8">
        <title> php表单</title>
        <style type="text/css">
            body {
                font-family: "Microsoft Yahei"
            }
            label,input{
                display:block;
                width:300px;
            }

            input#submit {
                border: none;
                background-color: #2F79BA;
                color: #fff;
                border-radius: 5px;
                padding: 10px 20px;
                margin-top:10px;
                cursor: pointer;
            }
            form{
                display: flex;
                flex-direction: column;
            }
            div{
                margin:5px auto;
                display: flex;
                flex-flow: inherit;
                width: 300px;
            }
            input{
                border:1px solid #888;
                padding: 7px;
            }

            p {
                font-size: .8rem;
                color: #BBBBBB;
                margin:0;
            }
        </style>
    </head>
        <form action="" method="post" id="form">

            <div>
                <label for="name">名称</label>
                <input type="text" id="name" name='name' value="<?php if(isset($_POST["name"])) echo $_POST["name"];?>"/>
            </div>
            <div>
                <label for="password">密码</label>
                <input type="password" id="password" name='pass' value="<?php if(isset($_POST["pass"])) echo $_POST["pass"];?>"/>
            </div>
            <div>
            	<?php if(isset($info)){ echo "<p style='color:red'>$info</p>";} ?>
            <input type="submit" id="submit" value="登录" name="submit" />
            </div>
        </form>
<?php
}
    ?>



