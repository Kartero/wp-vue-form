<?php
namespace App;

use WP_REST_Request;
use WP_REST_Response;
use WP_Error;

class FormApi
{
    /** @var ObjectValidator */
    private $objectValidator;

    public function __construct()
    {
        $this->objectValidator = new ObjectValidator();
        $this->registerPostAction();
    }

    /**
     * @return void
     */
    public function registerPostAction() : void
    {
        add_action( 'rest_api_init', function () {
            register_rest_route( 'vue-form/v1', '/register/', [
                'methods' => 'POST',
                'callback' => [$this, 'process']
            ]);
        });
    }

    /**
     * @param WP_REST_Request $request
     * 
     * @return WP_REST_Response
     */
    public function process(WP_REST_Request $request) : WP_REST_Response
    {
        $params = $request->get_json_params();
        $result = $this->objectValidator->validate($params);

        if (!$result->isValid()) {
            $errors = $result->getErrors();
            $status = 400;
        } else {
            $errors = [];
            $status = 200;
        }

        return new WP_REST_Response($errors, $status);
    }
}