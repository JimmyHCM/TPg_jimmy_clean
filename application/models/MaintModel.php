<?php
use phpDocumentor\Reflection\Types\Null_;

class MaintModel extends CI_Model {

  function __construct () {
    parent::__construct ();
    $this->dblog = $this->load->database('tpglog',TRUE);
    $this->load->model('AppAuthModel');
  }

  function validateUser () 
  {
    ini_set('display_errors', 0);     // do not display errors
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $status = 'A';
    $privilegeLevel = 1;

    $this->db->select("userID, password");
    $this->db->where(array('username' => $username, 'status' => $status));
    $this->db->where('privilegeLevel >=', $privilegeLevel);
    $this->db->order_by("createdDate", "desc");
    $query = $this->db->get('backendUser');

    $affectedRows = $query -> num_rows();

    if ($affectedRows > 0){            
      foreach ($query->result() as $row) {
        if (password_verify($password, $row->password)) {
          $this->session->set_flashdata("success","You are logged in");

          $userID = $row->userID;
          $this->db->select("userID, username, createdDate, privilegeLevel");
          $this->db->where(array('userID' => $userID));
          $this->db->order_by("createdDate", "desc");
          $query2 = $this->db->get('backendUser', 1);
          
          $user = $query2->first_row();   

               //set session variables
          $_SESSION['user_logged'] = TRUE;
          $_SESSION['userID'] = $user->userID;
          $_SESSION['username'] = $user->username;
          $_SESSION['createdDate'] = $user->createdDate;
          $_SESSION['privilegeLevel']= $user->privilegeLevel;
          $_SESSION['ipAddress']= $this->input->ip_address();
          $_SESSION['browser']= $this->agent->browser();
          $_SESSION['browser_version']= $this->agent->version();
          $_SESSION['os']= $this->agent->platform();

               //write SQLlog if TRUE
          $log = array(
           'sqlDetails'  => TRUE,
           'oldData'     => '',
           'newData'     => '',
           'sqlAction'   => 'login successful',
         );

          $this->AppAuthModel->writeSQLlog($log);

          return TRUE;
        }
      }
    }
    return FALSE;
  }

  function addUser($status) 
  {
    ini_set('display_errors', 0);     // do not display errors
    $options = array(
            'memory_cost' => 1<<17, // 128 Mb
            'time_cost'   => 4,
            'threads'     => 3,
          );

    $data = array(
      'username'    => $_POST['username'],
      'email'       => $_POST['email'],
      'password'    => password_hash(md5($_POST['password']), PASSWORD_BCRYPT, $options),
      'createdDate' => mdate('%Y-%m-%d %H:%i:%s', now()),
      'status'      => $status
    );

    $query = $this->db->insert('backendUser', $data);
    return $query;
  }

}

?>