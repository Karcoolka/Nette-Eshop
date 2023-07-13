<?php

namespace App\CoreModule\Presenters;

use App\Presenters\BasePresenter;
use Nette\Application\UI\Form;
use Nette\Mail\Message;
use Nette\Mail\SendException;
use Nette\Utils\ArrayHash;

class ContactPresenter extends BasePresenter
{
    /**
     * Vytváří a vrací kontaktní formulář.
     * @return Form kontaktní formulář
     */
    protected function createComponentContactForm()
    {
        $form = $this->formFactory->create();
        $form->getElementPrototype()->setAttribute('novalidate', true);
        $form->addEmail('email', 'Vaše emailová adresa')->setRequired();
        $form->addText('y', 'Zadejte aktuální rok')->setOmitted()->setRequired()
            ->addRule(Form::EQUAL, 'Chybně vyplněný antispam.', date("Y"));
        $form->addTextArea('message', 'Zpráva')->setRequired()
            ->addRule(Form::MIN_LENGTH, 'Zpráva musí být minimálně %d znaků dlouhá.', 10);
        $form->addSubmit('send', 'Odeslat');

        // Funkce se vykonaná při úspěšném odeslání kontaktního formuláře a odešle email.
        $form->onSuccess[] = function (Form $form, ArrayHash $values) {
            try {
                $mail = new Message;
                $mail->setFrom($values->email)
                    ->addTo($this->contactEmail)
                    ->setSubject('Email z webu')
                    ->setBody($values->message);
                $this->mailer->send($mail);
                $this->flashMessage('Email byl úspěšně odeslán.', self::MSG_SUCCESS);
                $this->redirect('this');
            } catch (SendException $e) {
                $this->flashMessage('Email se nepodařilo odeslat.', self::MSG_ERROR);
            }
        };

        return $form;
    }
}