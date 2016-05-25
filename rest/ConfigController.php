<?php

use \RestServer\RestException;

class ConfigController
{
    /**
     * Returns a JSON string object to the browser when hitting the root of the domain.
     *
     * @url GET /
     */
    public function getConfig()
    {
        global $a;

        $token = $_SERVER['HTTP_AUTHORIZATION'];
        $auth = ($token != '') ? new Auth($token) : '';

        if ($auth && $auth->isValid()) {
            $tituloTranslated = 'titulo_'.$txt_lang;

                /*	PROVINCIAS	*/
                $provincias = $a->sav_provincias->select("tipo='".PROVINCIA_ID."'", 'nombre asc');
            if ($provincias && $provincias->nr() > 0) {
                $provinces = array();
                while ($provincias->fetch($provincia)) {
                    array_push($provinces, array($provincia->id => $provincia->nombre));
                }
                    //$superArray['provincias'] = $provinces;
            }

                /*	COMERCIALES	*/
                $comerciales = $a->user->select("(role = 'A' OR vip='1') and web_id='".WEB_ID."'", 'name asc');
            if ($comerciales && $comerciales->nr() > 0) {
                $comercialesAirzone = array();
                while ($comerciales->fetch($comercial)) {
                    array_push($comercialesAirzone, array($comercial->id => $comercial->name));
                }
                    //$superArray['comerciales'] = $comercialesAirzone;
            }

                /*	CLIENTES	*/
                $comerciales = $a->user->select("(role = 'A' OR vip='1') and web_id='".WEB_ID."'", 'name asc');
            if ($comerciales && $comerciales->nr() > 0) {
                $comercialesAirzone = array();
                while ($comerciales->fetch($comercial)) {
                    array_push($comercialesAirzone, array($comercial->id => $comercial->name));
                }
                    //$superArray['comerciales'] = $comercialesAirzone;
            }

                /*	PERFILES	*/
                //$superArray['perfiles'] = rLogic::priPerfil('','array');

                /*	TIPOS DE LLAMADAS	*/
                $tiposLlamadas = $a->calls_tipo->select('', 'id asc');
            if ($tiposLlamadas && $tiposLlamadas->nr() > 0) {
                $tipoLlamadasArray = array();
                while ($tiposLlamadas->fetch($tipoLlamadas)) {
                    array_push($tipoLlamadasArray, array($tipoLlamadas->id => $tipoLlamadas->titulo_es));
                }
                $superArray['callTipo'] = $tipoLlamadasArray;
            }

            return $superArray;
        } else {
            return $this->doErr('No valid token', '449');
        }
    }

    /**
     * Gets the user by id or current user.
     *
     * @url GET /webid
     */
    public function getWebID()
    {
        return array('id' => WEB_ID, 'url' => SITE_URL); // serializes object into JSON
    }

    /**
     * Throws an error.
     *
     * @url GET /error
     */
    public function throwError()
    {
        throw new RestException(401, 'Empty password not allowed');
    }

    private function doErr($message = 'No valid token', $statusCode = '50A')
    {
        return array('error' => array('code' => $statusCode, 'message' => $message));
    }
}
