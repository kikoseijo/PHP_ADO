<?php

use \RestServer\RestException;

class SessionController
{
    /**
     * Returns a JSON string object to the browser when hitting the root of the domain
     *
     * @url GET /
     */
    public function blank()
    {
        return "Airzone - Intranet Rest Api";
    }

    /**
     * Logs in a user with the given username and password POSTed. Though true
     * REST doesn't believe in sessions, it is often desirable for an AJAX server.
     *
     * @url POST /login
     */
    public function login($data) {
        global $s,$a;
				
				if ($s->login($data->u,$data->p) > 0) {
					
					wLog('logLogin', $data->u . ' (HotMz) SUCCESS');
					
					$token = array();
					$token['id'] = $s->user->id;
					$token['email'] = $s->user->email;
					$wToken =  JWT::encode($token, JWT_SECRET_SERVER_KEY);
					$company = $a->company->get($s->user->company_id);
					$u = array(	'name' => $s->user->name,
								'position' => $s->user->position,
								'email' => $s->user->email,
								'phone' => $s->user->phone,
								'userlevel' => $s->user->role2,
								'company' => $company->name,
								'pais' => $company->pais,
								'address' => $company->address,
								'cphone' => $company->phone,
								'cif' => $company->cif,
								'provincia' => $company->provincia,
								'city' => $company->city,
								'website' => $company->website,
								'web_id' => $s->user->web_id,
								'token' => $wToken		);
					return array("success" => "Logged in " . $username, "user" => $u );
				} else {
					wLog('logLogin',$data->u . ' (HotMz) ERROR');
					return array("error" => "User name or password invalid" . $u .' - ' . $p );
				}
			
    }

    /**
     * Gets the user by id or current user
     *
     * @url GET /car/$id
     * @url GET /car/current
     */
    public function getCar($id = null)
    {
        // if ($id) {
        //     $user = User::load($id); // possible user loading method
        // } else {
        //     $user = $_SESSION['user'];
        // }

        return array("id" => $id, "name" => null); // serializes object into JSON
    }

    /**
     * Saves a user to the database
     *
     * @url POST /users
     * @url PUT /users/$id
     */
    public function saveUser($id = null, $data)
    {
        // ... validate $data properties such as $data->username, $data->firstName, etc.
        // $data->id = $id;
        // $user = User::saveUser($data); // saving the user to the database
        $user = array("id" => $id, "name" => null);
        return $user; // returning the updated or newly created user object
    }

    /**
     * Get Charts
     * 
     * @url GET /charts
     * @url GET /charts/$id
     * @url GET /charts/$id/$date
     * @url GET /charts/$id/$date/$interval/
     * @url GET /charts/$id/$date/$interval/$interval_months
     */
    public function getCharts($id=null, $date=null, $interval = 30, $interval_months = 12)
    {
        echo "$id, $date, $interval, $interval_months";
    }

    /**
     * Throws an error
     * 
     * @url GET /error
     */
    public function throwError() {
        throw new RestException(401, "Empty password not allowed");
    }
}