<?php

// CSRF対策
// Token発行してSessionに格納
// フォームからもTokenを発行、送信
// Check

namespace MyApp;

class Todo {
  private $_db;

  public function __construct() {
      $this->_createToken();
      
    try {
      $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
      $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }

      private function _createToken() {
    if (!isset($_SESSION['token'])) {
      $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
  }
    
  public function getAll() {
    $stmt = $this->_db->query("select * from todo_table order by id desc");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }
    
     public function post() {
            $this->_validateToken();
         
    if (!isset($_POST['mode'])) {
      throw new \Exception('mode not set!');
    }

    switch ($_POST['mode']) {
      case 'update':
        return $this->_update();
      case 'create':
        return $this->_create();
      case 'delete':
        return $this->_delete();
    }
  }

      private function _validateToken() {
    if (
      !isset($_SESSION['token']) ||
      !isset($_POST['token']) ||
      $_SESSION['token'] !== $_POST['token']
    ) {
      throw new \Exception('invalid token!');
    }
  }
    
 private function _update() {
    if (!isset($_POST['id'])) {
      throw new \Exception('[update] id not set!');
    }

    $this->_db->beginTransaction();

    $sql = sprintf("update todo_table set status = (status + 1) %% 2 where id = %d", $_POST['id']);
    $stmt = $this->_db->prepare($sql);
$stmt->execute();

    $sql = sprintf("select status from todo_table where id = %d", $_POST['id']);
    $stmt = $this->_db->query($sql);
    $status = $stmt->fetchColumn();

    $this->_db->commit();

    return [
      'status' => $status
    ];
  }

  private function _create() {
    if (!isset($_POST['task']) || $_POST['task'] === '') {
      throw new \Exception('[create]task not set!');
    }

    $sql = "insert into todo_table (task) values (:task)";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([':task' => $_POST['task']]);

    return [
      'id' => $this->_db->lastInsertId()
    ];
  }

    //mode... id のチェックをしつつ、id が無かったら例外を返す
  private function _delete() {
    if (!isset($_POST['id'])) {
      throw new \Exception('[delete] id not set!');
    }

    $sql = sprintf("delete from todo_table where id = %d", $_POST['id']);
    $stmt = $this->_db->prepare($sql);
    $stmt->execute();

    return [];
  }
}
