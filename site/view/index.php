<html>
    <head>
        <title>注册示例页面</title>
    </head>
    <body>
        <p><label>学号:</label><input type="text" id='studentnumber'></p>
        <p><label>密码:</label><input type="password" id='password'></p>
        <p><label>确认密码:</label><input type="password"></p>
        <p><label>手机号:</label><input type="text" id='phonenumber'><button id='sendSMS'>短信验证</button></p>
        <p><label>短信验证码:</label><input type="text" id='SMScode'></p>
        <p><button id='register'>确认注册</button></p>
    </body>
    <script src="/static/js/jquery.js"></script>
    <script>
        $('#sendSMS').click(function(){
            $.post('/sendSMS',{
                studentnumber:$('#studentnumber').val(),
                password:$('#password').val(),
                phonenumber:$('#phonenumber').val()
            },function(data,status){
               
                var obj=data;
                if(obj['status']=='error'){
                    alert(obj['reason']);
                }else{
                    alert('验证码已发送到手机(默认2333)');
                }
            })
        });
        
        $('#register').click(function(){
            $.post('/register',{
                studentnumber:$('#studentnumber').val(),
                SMScode:$('#SMScode').val()
            },function(data,status){
                if(data['status']=='error'){
                    alert(data['reason']);
                }else{
                    alert('注册成功,用户信息如下'+data);
                }
            })
        });
    </script>
</html>
