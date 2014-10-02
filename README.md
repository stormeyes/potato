potato
======
potato is a php web framework which has the python web framework style

###Overview
* Router
````
<?php
    require_once('framework/common/common.php');
    $app=new application();
    $app->route=array(
          '/'=>'index->index',
          '/test'=>'index->test',
          '/article/$id'=>'article->view',
          '/article/$operation/$id'=>'article->modify'
     );
    $app->run($_SERVER['REQUEST_URI']);
````

* Controller
````
   class article extends BASE_CTL{
        function view($id){
            $articleModel=article::loadModel('user');
            $article=$articleModel->getByid($id);
            $article->loadview('view.php',$article);
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
            return $this->get('id=1');
        }
    }
````

###Install
* Download the sourcecode
* configure your nginx server conf,there is a sample configure file following:
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
* Make sure you have restart the nginx after you change the nginx configure file,and you can visit http://localhost,then you should see welcome message,else you should check your configure again;

###Developing
This project is under active developing
