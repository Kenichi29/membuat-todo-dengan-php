<?php
    require 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-do-lists</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="main-section">
        <div class="add-section">
            <form action="app/add.php" method="POST" autocomplete="off">
                <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                    <input  type="text"
                        name="doing" 
                        style ="border-color: #ff6666"
                        placeholder="This field is required">
                    <button type= "submit">Add &nbsp; <span>&#43;</span></button>
                
                    <?php }else{ ?>
                    <input  type="text"
                        name="doing" 
                        placeholder="What do you need to do?">
                    <button type= "submit">Add &nbsp; <span>&#43;</span></button>
                <?php } ?>             
            </form>          
        </div>
        <?php
            $todos=$conn->query("SELECT * FROM todo ORDER BY id_doing DESC");
        ?>

        <div class="show-todo-section">
            <?php if($todos->rowCount() <= 0) { ?>
            <div class="todo-item">
                <div class="empty">
                    <img src="img/f.png" width="100%">
                    <img src="img/Ellipsis.gif" width="80px">
                </div>
            </div>
            <?php } ?>
            
            <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="todo-item">
                    <span id_doing="<?php echo $todo['id_doing']; ?>"
                        class="remove-to-do">x</span>
                        <?php if($todo['checked']) { ?>
                            <input  type="checkbox"
                                    class="check-box"
                                    data-todo-id_doing ="<?php echo $todo['id_doing']; ?>"
                                    checked>
                            <h2 class="checked"><?php echo $todo['doing'] ?></h2>
                        <?php }else { ?>  
                            <input  type="checkbox"
                                    data-todo-id_doing ="<?php echo $todo['id_doing']; ?>"
                                    class="check-box">
                            <h2><?php echo $todo['doing'] ?></h2>
                        <?php } ?>   
                        <br>
                        <small><?php echo $todo['date_time'] ?></small>
                </div>           
            <?php } ?>                        
        </div>
    </div>
    
    <script src="js/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.remove-to-do').click(function(){
                const id_doing = $(this).attr('id_doing');
                
                $.post("app/remove.php", 
                      {
                          id_doing: id_doing
                      },
                      (data)  => {
                         if(data){
                             $(this).parent().hide(600);
                         }
                      }
                );
            });

            $(".check-box").click(function(e){
                const id_doing = $(this).attr('data-todo-id_doing');
                
                $.post('app/check.php', 
                      {
                          id_doing: id_doing
                      },
                      (data) => {
                          if(data != 'error'){
                              const h2 = $(this).next();
                              if(data === '1'){
                                  h2.removeClass('checked');
                              }else {
                                  h2.addClass('checked');
                              }
                          }
                      }
                );
            });
        });
    </script>
</body>
</html>