<?php
/**
 * Created by PhpStorm.
 * User: mr tianlong
 * Email: 13343000479@163.com
 * phone: 13343000479 / 17342075152
 * Date: 2018/9/15
 * Time: 17:06
 */
?>

<script src="http://interview-assets.hello-tl.com/moment/moment/moment.js"></script>
用户名:<span><?=$_SESSION['username']?></span>
<br>
密码:<span><?=$_SESSION['password']?></span>
<br>
时间:<span></span>
<script>
    var time = moment().format('YYYY-MM-DD HH:mm:ss');
    document.getElementsByTagName('span')[2].innerHTML = time;
</script>
