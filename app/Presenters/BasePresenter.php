<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Forms\FormFactory;
use Nette\Application\AbortException;
use Nette\Application\UI\Presenter;


/**
 * Základní presenter pro všechny ostatní presentery aplikace.
 * @package App\Presenters
 */
abstract class BasePresenter extends Presenter
{
    /** Zpráva typu informace. */
    const MSG_INFO = 'info';
    /** Zpráva typu úspěch. */
    const MSG_SUCCESS = 'success';
    /** Zpráva typy chyba. */
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

    /**
     * Na začátku každé akce u všech presenterů zkontroluje uživatelská oprávnění k této akci.
     * @throws AbortException Jestliže uživatel nemá oprávnění k dané akci a bude přesměrován.
     */
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