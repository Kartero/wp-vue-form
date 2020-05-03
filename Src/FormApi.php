<?php
namespace App;

use WP_REST_Request;
use WP_REST_Response;

class FormApi
{
    /** @var ObjectValidator */
    private $objectValidator;

    /** @var FormDb */
    private $formDb;

    public function __construct()
    {
        $this->objectValidator = new ObjectValidator();
        $this->registerPostAction();
        $this->formDb = new FormDb();
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
            try {
                $this->insert($params);
                $errors = [];
                $status = 200;
            } catch (\Exception $e) {
                $errors = [$e->getMessage()];
                $status = 400;
            }
        }

        return new WP_REST_Response($errors, $status);
    }

    /**
     * @param array $params
     * 
     * @return void
     */
    private function insert($params) : void
    {
        $data = [
            'firstname' => $params[ObjectValidator::FIRST_NAME],
            'lastname' => $params[ObjectValidator::LAST_NAME],
            'email' => $params[ObjectValidator::EMAIL],
            'age' => (int) $params[ObjectValidator::AGE],
        ];
        $format = [
            '%s', '%s', '%s', '%d'
        ];
        $this->formDb->insert($data, $format);
    }
}