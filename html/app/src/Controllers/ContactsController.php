<?php

namespace App\controllers;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Model;

class ContactsController
{
    public static function createContactOrReturnNull(string $email, string $phone, string $message = null): ?Contact
    {
        try {

            $contact = new Contact();

            $contact->email = $email;
            $contact->phone = $phone;
            $contact->message = $message;

            $contact->save();

            return $contact;

        } catch (\Exception $e) {

            return null;
        }
    }
}