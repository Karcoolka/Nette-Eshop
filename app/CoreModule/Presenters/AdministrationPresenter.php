<?php

declare(strict_types=1);

namespace App\CoreModule\Presenters;

use App\Forms\SignInFormFactory;
use App\Forms\SignUpFormFactory;
use App\Presenters\BasePresenter;
use Nette\Application\AbortException;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

/**
 * Presenter pro vykreslování administrační sekce.
 * @package App\CoreModule\Presenters
 */
class AdministrationPresenter extends BasePresenter
{
    /** @var SignInFormFactory */
    private SignInFormFactory $signInFactory;

    /** @var SignUpFormFactory */
    private SignUpFormFactory $signUpFactory;

    /**
     * AdministrationPresenter constructor.
     * @param SignInFormFactory $signInFactory
     * @param SignUpFormFactory $signUpFactory
     */
    public function __construct(SignInFormFactory $signInFactory, SignUpFormFactory $signUpFactory)
    {
        parent::__construct();
        $this->signInFactory = $signInFactory;
        $this->signUpFactory = $signUpFactory;
    }

    /**
     * Před vykreslováním stránky pro přihlášení přesměruje do administrace, pokud je uživatel již přihlášen.
     * @throws AbortException Když dojde k přesměrování.
     */
    public function actionLogin()
    {
        if ($this->getUser()->isLoggedIn()) $this->redirect('Administration:');
    }

    /**
     * Odhlásí uživatele a přesměruje na přihlašovací stránku.
     * @throws AbortException Při přesměrování na přihlašovací stránku.
     */
    public function actionLogout()
    {
        $this->getUser()->logout();
        $this->redirect('login');
    }

    /** Předá jméno přihlášeného uživatele do šablony administrační stránky. */
    public function renderDefault()
    {
        
        if ($this->getUser()->isLoggedIn())
            $this->template->username = $this->user->identity->username;
    }

    /**
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