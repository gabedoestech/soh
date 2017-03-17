<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Seal of Health</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>

        

        input[type=submit]:hover{
            opacity: 0.8;
        }

        ul {
            padding:0 ;
            margin: 25% auto;
            list-style-type: none;
        }   

        li{  
            display: block;          
            margin: 10px; 
                   
        }       

        .loginform input:not([type=submit]){
            padding: 5px;
            margin-right: 10px;
            border: 1px solid rgab(0,0,0,0.3);            
        }

        .loginform input[type=submit]{
            border: 1px;
            padding: 5px 15px;
            margin-right: 0px;
            margin-top: 20px;                       
        }

        section{
            text-align: center;
        }      

        

        </style>
    </head>
    <body>

    <section class="loginform">
    <form name="login" action="index_submit" method="get" accept-charset="utf-8">
        <ul>
            <li><label for="usermail">Email: </label>
            <input type="email" name="usermail" placeholder="yourname@email.com" required>
            </li>
            <li><label for="password">Password: </label>
            <input type="password" name="password" placeholder="password" required>
            </li>
            <li>
            <input type="submit" value="Login">
            </li>
        </ul>
    </form>
    </section>

    </body>
</html>
