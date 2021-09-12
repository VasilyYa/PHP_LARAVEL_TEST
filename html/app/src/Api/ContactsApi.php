<?php

namespace App\Api;

use App\Controllers\ContactsController;


class ContactsApi extends Api
{
    public string $apiName = 'contacts';

    protected function indexAction()
    {
        return $this->response(array('notice' => 'You can send data by POST request! GET has no actions !'), 200);
    }

    protected function viewAction()
    {
        return $this->response(array('notice' => 'You can send data by POST request! GET has no actions !'), 200);
    }

    protected function createAction()
    {
        //validate POST params:
        $email = $this->requestParams['email'] ?? null;
        $phone = $this->requestParams['phone'] ?? null;
        $message = $this->requestParams['message'] ?? null;
        if ($email === null) {
            return $this->response(array('result' => 'Failed', 'error' => 'Email is not valid'), 400);
        }
        if ($phone === null) {
            return $this->response(array('result' => 'Failed', 'error' => 'Phone is not valid'), 400);
        }

        //write to Database and make a response to client:
        if (ContactsController::createContactOrReturnNull($email, $phone, $message)) {

            return $this->response(array('result' => 'Ok', 'msg' => 'Data added to database'), 200);

        } else {

            return $this->response(array('result' => 'Failed', 'error' => 'Server error'), 500);
        }
    }

    protected function updateAction()
    {
        return $this->response(array('notice' => 'You can send data only by POST request! PUT is not allowed!'), 405);
    }

    protected function deleteAction()
    {
        return $this->response(array('notice' => 'You can send data only by POST request! DELETE is not allowed!'), 405);
    }
}