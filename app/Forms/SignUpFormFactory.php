<?php

declare(strict_types=1);

namespace App\Forms;

use App\Model;
use Nette;
use Nette\Application\UI\Form;
use App\Model\UserManager;

/**
 * Továrna na registrační formulář.
 * @package App\Forms
 */
final class SignUpFormFactory
{
    use Nette\SmartObject;

    private const PASSWORD_MIN_LENGTH = 7;

    /** @var FormFactory Továrna na formuláře. */
    private $factory;

    /** @var UserManager Model pro správu uživatelů. */
    private UserManager $userManager;

    /**
     * Konstruktor s injektovanou továrnou na formuláře a modelem pro správu uživatelů.
     * @param FormFactory $factory automaticky injektovaná továrna na formuláře
     * @param UserManager $userManager automaticky injektovaný model pro správu uživatelů
     */
    public function __construct(FormFactory $factory, UserManager $userManager)
    {
        $this->factory = $factory;
        $this->userManager = $userManager;
    }

    /**
     * Vytváří a vrací registrační formulář.
     * @param callable $onSuccess specifická funkce, která se vykoná po úspěšném odeslání formuláře
     * @return Form registrační formulář
     */
    public function create(callable $onSuccess): Form
    {
        $form = $this->factory->create();
        $form->addText('username', 'Tvé jméno:')
            ->setRequired('Zadej prosím své jméno.');

        $form->addEmail('email', 'Tvůj e-mail:')
            ->setRequired('Zadej prosím svůj e-mail.');

        $form->addPassword('password', 'Zadej své heslo:')
            ->setOption('description', sprintf('at least %d characters', self::PASSWORD_MIN_LENGTH))
            ->setRequired('Zadej prosím své heslo.')
            ->addRule($form::MIN_LENGTH, null, self::PASSWORD_MIN_LENGTH);

        $form->addText('y', 'Zadejte aktuální rok (antispam)')->setOmitted()->setRequired()
            ->addRule(Form::EQUAL, 'Chybně vyplněný antispam.', date("Y"));

        $form->addSubmit('send', 'Registrovat se');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($onSuccess): void {
            try {
                // Zkusíme zaregistrovat nového uživatele.
                $this->userManager->add($values->username, $values->email, $values->password);
            } catch (Model\DuplicateNameException $e) {
                // Přidáme chybovou zprávu alespoň do formuláře.
                $form['username']->addError('Uživatelské jméno je už zabráno.');
                return;
            }
            $onSuccess();
        };

        return $form;
    }
}