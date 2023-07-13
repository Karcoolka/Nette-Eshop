<?php

namespace App\CoreModule\Presenters;

use App\Presenters\BasePresenter;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class AdministrationPresenter extends BasePresenter
{/**
     * Vytváří a vrací přihlašovací formulář pomocí továrny.
     * @return Form přihlašovací formulář
     */
    protected function createComponentLoginForm()
    {
        return $this->signInFactory->create(function () {
            $this->flashMessage('Byl jste úspěšně přihlášen.', self::MSG_SUCCESS);
            $this->redirect('Administration:');
        });
    }

    /**
     * Vytváří a vrací registrační formulář pomocí továrny.
     * @return Form registrační formulář
     */
    protected function createComponentRegisterForm()
    {
        return $this->signUpFactory->create(function (Form $form, ArrayHash $values) {
            $this->flashMessage('Byl jste úspěšně zaregistrován.', self::MSG_SUCCESS);
            $this->user->login($values->username, $values->password); // Přihlásíme se.
            $this->redirect('Administration:');
        });
    }
}