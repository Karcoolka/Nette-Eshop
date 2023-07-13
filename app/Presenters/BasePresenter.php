<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Forms\FormFactory;
use Nette\Application\AbortException;
use Nette\Application\UI\Presenter;

abstract class BasePresenter extends Presenter
{
    const MSG_INFO = 'info';
    const MSG_SUCCESS = 'success';
    const MSG_ERROR = 'danger';

    /** @var FormFactory Továrna na formuláře. */
    protected FormFactory $formFactory;

    /**
     * Získává továrnu na formuláře pomocí DI.
     * @param FormFactory $formFactory automaticky injektovaná továrna na formuláře
     */
    public final function injectFormFactory(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    protected function startup()
    {
        parent::startup();
        if (!$this->getUser()->isAllowed($this->getName(), $this->getAction())) {
            $this->flashMessage('Nejsi přihlášený nebo nemáš dostatečná oprávnění.');
            $this->redirect(':Core:Administration:login');
        }
    }

    /** Před vykreslováním každé akce u všech presenterů předává společné proměné do celkového layoutu webu. */
    protected function beforeRender()
    {
        parent::beforeRender();
        $this->template->admin = $this->getUser()->isInRole('admin');
        $this->template->domain = $this->getHttpRequest()->getUrl()->getHost();      // Předá jméno domény do šablony.
        $this->template->formPath = __DIR__ . '/../templates/forms/form.latte'; // Předá cestu ke globální šabloně formulářů do šablony.
    }
}