<?php

namespace App\Api;

use App\Controllers\ContactsController;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;
use Symfony\Component\Validator\Constraints\Regex as RegexConstraint;
use Symfony\Component\Validator\Constraints\Length as LengthConstraint;
use Symfony\Component\Validator\Validation;


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

        $email = $this->requestParams['email'] ?? null;
        $phone = $this->requestParams['phone'] ?? null;
        $message = $this->requestParams['message'] ?? null;


        //validate post-params:
        $validator = Validation::createValidator();
        $emailConstraint = new EmailConstraint();
        $phoneConstraint = new RegexConstraint('/^\+?[0-9\(\)\-\s]{5,20}$/');
        $messageConstraint = new LengthConstraint(null, 0, 255);
        //email
        $errors = $validator->validate($email, $emailConstraint);
        if (0 !== count($errors)) {
            return $this->response(array('result' => 'Failed', 'error' => 'Email is not valid'), 400);
        }
        //phone
        $errors = $validator->validate($phone, $phoneConstraint);
        if (0 !== count($errors)) {
            return $this->response(array('result' => 'Failed', 'error' => 'Phone is not valid'), 400);
        }
        //message
        $errors = $validator->validate($message, $messageConstraint);
        if (0 !== count($errors)) {
            return $this->response(array('result' => 'Failed', 'error' => 'Message is too long (max 255 symbols)'), 400);
        }


        //write to Database:
        if (ContactsController::createContactOrReturnNull($email, $phone, $message)) {

            return $this->response(array('result' => 'Ok', 'notice' => 'Data added to database'), 200);

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