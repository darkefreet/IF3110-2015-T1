<?php
    $id = $_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <script type = "text/javascript">
        function validateEmail(email) {
            var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            return re.test(email);
        }
        function validateForm(){
            var x = document.forms["q_form"]["name"].value;
            var y = document.forms["q_form"]["email"].value;
            var a = document.forms["q_form"]["content"].value;
            if(x==null || x==''){
                alert("Name must be filled");
                return false;
            }
            if(y==null || y==''){
                alert("Email must be filled");
                return false;
            }else if(!validateEmail(y)){
                alert("Email is not a valid email");
                return false;
            }
            if(a==null || a==''){
                alert("Content must be filled");
                return false;
            }
        }
    </script>
    <link rel ="stylesheet" type="text/css" href="Index.css">
    <title>Simple StackExchange</title>

</head>

<body>
<div id = "container">
    <div id  = "header">
        <span id  = "logo"> Simple StackExchange </span>
    </div>
    <div id = "content">
        <?php
            $username = 'root';
            $password = '';
            $database = 'stackex';
            mysql_connect('localhost', $username, $password);
            @mysql_select_db($database) or die("Unable to Select Database");
            $query = "SELECT * FROM questions WHERE ID=$id";
            $result = mysql_query($query);
            $topic = mysql_result($result,0,'topic');
            $content = mysql_result($result,0,'content');
            $author = mysql_result($result,0,'author');
            $vote = mysql_result($result,0,'vote');
            echo"<h3>$topic</h3>";
            echo "<div class = 'q_details'>";
                echo"<div class = 'a_left'>";
                echo"<span class = 'vote'>$vote<br>Votes</span>";
                echo"</div>";
                echo"<div class = 'a_mid'>";
                echo"<div class = 'a_content'>$content</div></div>";
            echo"<div class = 'details'>Asked by <span class = 'b_link'>$author </span>|<span class = 'y_link'> edit </span>| <span class = 'r_link'>delete</span><br></div>";
            echo "</div>";
            $query = "SELECT * FROM answers WHERE A_ID=$id";
            $result = mysql_query($query);
            $num = mysql_num_rows($result);
            $i = 0;
            echo"<h3>$num Answer</h3>";
            while($i<$num){
                $content = mysql_result($result, $i,"content");
                $email = mysql_result($result, $i,"email");
                $vote = mysql_result($result,$i,"vote");
                echo "<div class = 'q_or_a'>";
                    echo"<div class = 'a_left'>";
                    echo"<span class = 'vote'>$vote<br>Votes</span>";
                    echo"</div>";
                    echo"<div class = 'a_mid'>";
                    echo"<div class = 'a_content'>$content</div></div>";
                    echo"<div class = 'details'>Answered by <span class = 'b_link'>$email<br></div>";
                echo "</div>";
                $i++;
            }
            mysql_close();

            echo"<h1>Your Answer</h1>";
        ?>
        <form name ="q_form" action="adding_answer.php" onsubmit="return validateForm()" method = "post">
            <input type = "text" name = "name" placeholder = "Name"/>
            <input type = "text" name = "email" placeholder = "Email"/>
            <input type = "hidden" name = "A_ID" value = "<?php echo $id;?>">
            <textarea name = "content" placeholder = "Content"></textarea>
            <input class = "button" id="button_post" type = "submit" value="Post"/>
        </form>
    </div>
    <div id = "footer">

    </div>
</div>
<body>