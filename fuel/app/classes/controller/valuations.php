<?php 

use \Firebase\JWT\JWT;

class Controller_Valuations extends Controller_Rest
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
             

            $input = $_POST;
            


                


    
            $valuations = new Model_Valuations();
            $valuations->value = $input['value'];
            $valuations->comentary = $input['comentary'];
            $valuations->id_place = $input['id_place'] ;
            $valuations->id_users = $dataJwtUser->id;
            $valuations->date = date('d-m-Y/h:i:s');
            

           
            
            
            
            if ($valuations->value == "" || $valuations->id_place == "" )
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Se necesita introducir todos los parametros',
                    'data' => []
                ));
            }
            elseif ($valuations->value < 1 || $valuations->value > 5)
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'La valoracion ha de estar entre 1 y 5',
                    'data' => []
                ));

            }
            else
            {

                $valuations->save();
                

                $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Lugar creado correctamente',
                    'data' => $valuations
                ));

                return $json;
            }
            
        } 
        catch (Exception $e) 
        {
           
               if($e->getCode() == 23000)
            {
                $json = $this->response(array(
                    'code' => 500,
                    'message' => $e->getMessage(),
                    'data' => []
                //'message' => $e->getMessage(),
                ));

                return $json;

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
    


    public function get_valuations()
    {
        try
        {
            $this->validateToken();
        }
        catch (Exception $e)
        {
            
        }

        $valuations = Model_Valuations::find('all', array(
            'where' => array(
                array('id_place', 2),
                
               
            )
        ));

        if(empty($valuations))
        {
            $json = $this->response(array(
                'code' => 200,
                'message' => 'No hay valoraciones que mostrar',
                'data' => ''

            ));

            return $json;

        }
        else
        {
            $valuationsFormated = [];
            foreach ($valuations as $key => $valuation) 
            {
                $valuationsFormated[] = $valuation; 
            }


            
            $json = $this->response(array(
                'code' => 200,
                'message' => 'Esta es la lista de valoraciones',
                'data' => $valuationsFormated

            ));

            return $json;

        }

       
        //return $this->response(Arr::reindex($users));

    }

    public function get_valuationsAverage()
    {


        try
            {
                $this->validateToken();
            }
            catch (Exception $e)
            {
                
            }
        $valuations = Model_Valuations::find('all', array(
            'where' => array(
                array('id_place', 2),
                
               
            )
        ));
        
        $rising = 0;

        $divide = 0;
        $valuationsFormated = [];
        foreach ($valuations as $key => $valuation)
                {
                    $valuationsFormated[] = $valuation; 
                    
                    
                }

        foreach ($valuationsFormated as $key => $valuation)
                {
                    
                    $rising += $valuationsFormated[$key]->value;

                    $divide += 1;
                    
                }




        $rising /= $divide;


        /*switch ($rising) {
            case 'value':
                # code...
                break;
            
            default:
                # code...
                break;
        }*/



       
        if(empty($valuations))
        {
             $json = $this->response(array(
            'code' => 200,
            'message' => 'No hay media disponible',
            'data' => ''

        ));

        return $json;


        }
        else{
             $json = $this->response(array(
            'code' => 200,
            'message' => 'Esta es la  valoracion media',
            'data' => [$rising]

        ));

        return $json;

        }

    }
    /*    function decodeToken()
    {

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
