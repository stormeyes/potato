potato
======
potato is a php RESTful framework which inspired by webpy django and flask

###Overview
* Router
````
<?php
    require_once('framework/common/common.php');
    $app=new application();
    $app->route=array(
          '/'=>'index->index',
          '/article/$id'=>'article->view'
     );
    $app->run($_SERVER['REQUEST_URI']);
````

* Controller
````
   class article extends BASE_CTL{
        function view($id){
            $articleModel=$this->loadModel('user');
            $article=$articleModel->getByid($id);
            $article->loadview($template='view.php',$params=$article);
        }
   }
````

* Model
````
    class article_model extends BASE_MDL{
        var $tablename='article';
        var $id;
        var $title;
        var $content;

        function getByid($id){
            return $this->select('id=1');
        }
    }
````

###Install
* Download the sourcecode
* configure your nginx server conf,there is a sample configure file following:
>php-lang itself cannot realize URLREWRITE,so if you use other web server,you just need to ensure all the request transmited to index.php to handle
````
server {
    listen       80;
    server_name  localhost;
    root /var/www/potato;
    index index.php;
      
    location / {
           try_files $uri $uri/ /index.php$is_args$args;
     }
         
          
    location ~ \.php$ {
           fastcgi_pass 127.0.0.1:9000;
           fastcgi_index index.php;
           fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
           include fastcgi_params;
    }
           
    location /static/ {
           root /var/www/potato/site/;
    }
          
    access_log  /var/log/nginx/potato.access.log;
    error_log   /var/log/nginx/potato.error.log;
}

````
* Make sure you have restart the nginx after you change the nginx configure file,and you can visit http://localhost,then you should see 404 massage made by potato,else you should check your configuration again;


###QuickStartup
* config  
To config the database connection,VIEW path and so on ,edit the $POTATO_PATH/framework/common/config.php
* router  
cd into the potato directory,then you should found index.php,which is the entry of the framework.
In potato,the URL and the controller will be save as associative array which will be receive by route method.
In the controller side,the request url match by the left side will fall into the method indexpage which in the index class
````
$app->route(array(
    '/'=>'index->indexpage'
))
````
Of cource,the GET params in the URL is easy to transmit to the controller
````
$app->route(array(
    '/article/$id'=>'article->view'
))
````

* controller  
It's time to see where to put our website logic in.You will found a folder called site,which is your website in.
cd into the site folder and you will see controller,model,static folder.  
I believe you are an experience web developer,so I will not explain the basic MVC concept.  
The controller file should be in controller folder and named with controllername.ctl.php and the class name should be the same as the controllername so that the potato framework can load the class.  
All the controllers should extends from BASE_CTL.  

* model  
Model layer is the most confuse part in the MVC,sometimes you will found the db class has done so well that you do not need to create model class anymore.  
Indeed,the db class has wrapped basic CURD operations as select(),insert(),update(),delete() method.In most of cases the model class just simply do nothing but return $this->select()/update()/detele()

###API
* sample-site  
If you download the sourcecode from github,you will find somecode in site folder.  
Yelp,that's the real website codes to tell you how to use this frmawork

* SQL injection  
Don't PANIC.  
The framwork itself has already do something to prevent SQL injection if only you extends from BASE_CTL.  
The BASE_CTL class's construct method will filter the $_POST and $_GET value to make them be safe

* json Improved  
The php json_encode and json_decode function has some problems when you deal with Chinese,and they don't show a pretty view.  
To solve this problem,we create jsonify function to replace json_encode,jsonify is suitable with all php version and work well with Chinese,what's more,it will give a better view in browser or something else

* error_handler  
Want to make a 403/404/500 view by yourself? error_hanlder function can help you.Just have a try on error_handler(404)!

* encrypt & generate salt  
It's important to have an reverible algorithm,and salt it's also the key point to built a reverible algorithm.  
Dont't worry,we have make something for you---encrypt function and generateSalt function
