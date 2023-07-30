<?php

declare(strict_types=1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;

/**
 * Továrna na přihlašovací formulář.
 * @package App\Forms
 */
final class SignInFormFactory
{
    use Nette\SmartObject;

    /** @var FormFactory Továrna na formuláře. */
    private FormFactory $factory;

    /** @var User Uživatel. */
    private User $user;

    /**
     * Konstruktor s injektovanou továrnou na formuláře a uživatelem.
     * @param FormFactory $factory automaticky injektovaná továrna na formuláře
     * @param User        $user    automaticky injektovaný uživatel
     */
    public function __construct(FormFactory $factory, User $user)
    {
        $this->factory = $factory;
        $this->user = $user;
    }

    /**
     * Vytváří a vrací přihlašovací formulář.
     * @param callable $onSuccess specifická funkce, která se vykoná po úspěšném odeslání formuláře
     * @return Form přihlašovací formulář
     */
    public function create(callable $onSuccess): Form
    {
        $form = $this->factory->create();
        $form->addText('username', 'Jméno:')
            ->setRequired('Zadej prosím své uživatelské jméno.');

        $form->addPassword('password', 'Heslo:')
            ->setRequired('Zadej prosím své heslo.');

        $form->addCheckbox('remember', 'Zapamatovat si mě');

        $form->addSubmit('send', 'Sign in');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($onSuccess): void {
            try {
                // Zkusíme se přihlásit.
                $this->user->setExpiration($values->remember ? '14 days' : '20 minutes');
                $this->user->login($values->username, $values->password);
            } catch (Nette\Security\AuthenticationException $e) {
                // Přidáme chybovou zprávu alespoň do formuláře.
                $form->addError('Zadané přihlašovací jméno nebo heslo není správně.');
                return;
            }
            $onSuccess();
        };

        return $form;
    }
}