<?php 

use \Firebase\JWT\JWT;

class Controller_Search extends Controller_Rest
{
    private $key = "juf3dhu3hufdchv3xui3ucxj";

   

                                    //Crear usuario
    public function post_create()
    {
        try {

            try
            {
                $headers = apache_request_headers();
                $token = $headers['Authorization'];
                $dataJwtUser = JWT::decode($token, $this->key, array('HS256'));

        
      

                $users = Model_Users::find('all', array(
                    'where' => array(
                        array('id', $dataJwtUser->id),
                        array('name', $dataJwtUser->name),
                        array('password', $dataJwtUser->password)
               
                    )
                 ));

            }    
            catch (Exception $e)
            {
                $json = $this->response(array(
                    'code' => 500,
                    'message' => $e->getMessage(),
                    'data' => []
                ));
                return $json;
               
            }
            if ( ! isset($_POST['id_maps']) ) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Error en las credenciales, prueba otra vez',
                    'data' => []
                ));

                return $json;
            }
             

            $input = $_POST;
            $places = Model_Places::find('all', array(
            'where' => array(
                array('id_maps', $input['id_maps']),
                
               
                )
            )); 

            foreach ($places as $key => $place) 
            {
            $idPlace = $place->id;
            $namePlace = $place->name;
            }

            


                


    
            $search = new Model_Search();
           
            $search->id_place = $idPlace ;
            $search->id_user = $dataJwtUser->id;
            $search->date = date('d-m-Y/h:i:s');
            $search->place = $namePlace ;
            $search->search_count = 1;
            

           
            
            
            
            if ($search->place == "" || $search->id_place == "" ||  $search->id_user == "" )
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Se necesita introducir todos los parametros',
                    'data' => []
                ));
            }
            
            else
            {

                $search->save();
                

                $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Busqueda hecha correctamente',
                    'data' => $search
                ));

                return $json;
            }
            
        } 
        catch (Exception $e) 
        {
           
               if($e->getCode() == 23000)
            {
                $input = $_POST;

                $this->searchs($input['id_maps']);


            }
            else
            {

                $json = $this->response(array(
                    'code' => 500,
               // 'message' => $e->getCode()
                    'message' => $e->getMessage(),
                    'data' => []
                ));

                return $json;

            }

            

            
        }        
    }




                                    //Mostrar usuarios
    



    public function get_search()
    {

        try
            {
                $headers = apache_request_headers();
                $token = $headers['Authorization'];
                $dataJwtUser = JWT::decode($token, $this->key, array('HS256'));

        
      

                $users = Model_Users::find('all', array(
                    'where' => array(
                        array('id', $dataJwtUser->id),
                        array('name', $dataJwtUser->name),
                        array('password', $dataJwtUser->password)
               
                    )
                 ));

            }    
            catch (Exception $e)
            {
                $json = $this->response(array(
                    'code' => 500,
                    'message' => $e->getMessage(),
                    'data' => []
                ));
                return $json;
               
            }
       

        


        $searchs= Model_Search::find('all', array(
            'where' => array(
                array('id_user', $dataJwtUser->id),
                
               
            ),
            'order_by' => array('search_count' => 'desc')
        ));


        if(empty($searchs))
        {
            $json = $this->response(array(
                'code' => 200,
                'message' => 'No hay busquedas que mostrar',
                'data' => ''

            ));

            return $json;

        }
        else
        {
            $searchFormated = [];
            foreach ($searchs as $key => $search) 
            {
                $searchFormated[] = $search; 

            }
          


            
            $json = $this->response(array(
                'code' => 200,
                'message' => 'Esta es la lista de busquedas',
                'data' => $searchFormated

            ));

            return $json;

        }

       
        //return $this->response(Arr::reindex($users));

    }

    private function searchs($search)
    {
        try
            {
                $headers = apache_request_headers();
                $token = $headers['Authorization'];
                $dataJwtUser = JWT::decode($token, $this->key, array('HS256'));

        
      

                $users = Model_Users::find('all', array(
                    'where' => array(
                        array('id', $dataJwtUser->id),
                        array('name', $dataJwtUser->name),
                        array('password', $dataJwtUser->password)
               
                    )
                 ));

            }    
            catch (Exception $e)
            {
                $json = $this->response(array(
                    'code' => 500,
                    'message' => $e->getMessage(),
                    'data' => []
                ));
                return $json;
               
            }
             

            
            $places = Model_Places::find('all', array(
            'where' => array(
                array('id_maps', $search),
                
               
                )
            )); 

            foreach ($places as $key => $place) 
            {
            $idPlace = $place->id;
            
            }








            $search = Model_Search::find('all', array(
                'where' => array(
                
                    array('id_place', $idPlace), 
                    array('id_user', $dataJwtUser->id), 
                
               
                )
             ));
            foreach ($search as $key => $val) 
                {
                $val->search_count = $val->search_count + 1;

            
                }
                
                $val->save();


        


        
                $json = $this->response(array(
                'code' => 200,
                'message' => 'Este es el lugar',
                'data' => $search

            ));

        return $json;
    }


   /*
        $jwt = apache_request_headers()['Authorization'];
        $token = JWT::decode($jwt, $this->key , array('HS256'));
        return $token;
        
    }

    function userNotRegistered($email)
    {

        $users = Model_Users::find('first', array(
            'where' => array(
                array('email', $email),
                array('is_registered', 0)
                )
            )); 

        if($users != null){
            return true;
        }else{
            return false;
        }
    }
    */

    function validateToken()
    {
        $headers = apache_request_headers();
        $token = $headers['Authorization'];
        $dataJwtUser = JWT::decode($token, $this->key, array('HS256'));
        
        //$dataJwtPassword = JWT::encode($dataJwtUser->password, $this->key);

        $users = Model_Users::find('all', array(
            'where' => array(
                array('id', $dataJwtUser->id),
                array('name', $dataJwtUser->name),
                array('password', $dataJwtUser->password)
               
            )
        ));

        if($users != null){
            return true;
        }else{
            return false;
        }
    }







    



       /*public function post_editProfile()
        {


    //nombre email y foto

        }*/

    }    
