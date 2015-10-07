
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Twitter</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    
    
</head>

<body>
    <nav class="navbar navbar-inverse" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Twitter</a>
        </div>
        <div>
            <ul class="nav navbar-nav">
             
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            
          
            <div class="col-lg-6">
                <?php echo validation_errors(); ?>
                <?php echo form_open('twitter/login'); ?>
                <!-- <form class="form-horizontal" role="form" action="<?php $_PHP_SELF ?>" method="POST"> -->
                       <div class="form-group">
                                 <label for="mail" class="col-sm-4">メールアドレス</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="mail" name="mail"
                                    placeholder="example@gmail.com">
                                </div>   
                            
                       </div>
                       <div class="form-group">
                          <label for="password" class="col-sm-4">パスワード</label>
                          <div class="col-sm-10">
                             <input type="password" class="form-control" id="password" name="password"
                                placeholder="123456">
                          </div>
                       </div>
                       
                    <br>
                       <div class="form-group">
                          <div class="col-sm-2">
                             <button type="submit" class="btn btn-default" name="login">ログイン</button>
                          </div>
                       </div>
                       <div class="form-group">
                          <div class="col-sm-offset-2 col-sm-10">                        
                                <label>
                                   <h4><a href="">ユーザー登録こちらから</a></h4>
                                </label>
                          </div>
                       </div>
                       
                <!-- </form>  -->
                <?php echo form_close(); ?>
                <div id="error"></div>
                
            </div>
        </div>
    </div>
</body>

</html>
