# TodoApp

---
**This application can do**

Manage tasks

1. Database operation
    1. Get and display tasks 
    1. Add tasks
    1. Delete tasks

2. Event processing
    1. Click by state change tasks 
    1. Click by delete tasks confirmation alert
    1. Submit by add tasks is null,space,newline confirmation alert

## Demo

![TodoApp_PHP.gif](https://github.com/KenichiMiyoshi/TodoApp_PHP/blob/media/TodoApp_PHP.gif "TodoApp_PHP")

## Dependency

PHP 7.2.8

MySQL 5.7.23

jQuery 2.1.4

## Setup

### (SQL)

```sql

mysql -u root

create database todo_db;
grant all on todo_db.* to todo_user@localhost identified by 'todo_pass';

use todo_db

create table todo_table (
  id int not null auto_increment primary key,
  task varchar(255),
  status tinyint(1) default 0
);

```

## To Be Added



## References

[PHPでTodo管理アプリを作ろう (全18回) - プログラミングならドットインストール](https://dotinstall.com/lessons/todo_app_php_v3)

- README

    - [わかりやすいREADME.mdを書く | SOTA](https://deeeet.com/writing/2014/07/31/readme/)

    - [READMEの良さそうな書き方・テンプレート【GitHub/Bitbucket】 - karaage. [からあげ]](https://karaage.hatenadiary.jp/entry/2018/01/19/073000)

    - [自作ソースコードに、MITライセンスを適用する３つのやり方 | オープンソース・ライセンスの談話室](https://www.catch.jp/oss-license/2013/09/27/mit_license/)

## Licence

This software is released under the MIT License, see LICENSE.txt.
